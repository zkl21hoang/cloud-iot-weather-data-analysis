// Wifi
#include <WiFi.h>
#include <HTTPClient.h>

// Wireless Password if not use 3G/4G/5G Connection
const char* ssid = "Coldspot";
const char* password = "socoldthatitsfroze";

// Post File
const char* serverName = "http://[IP_Address]/post.php";

// API Key
String apiKeyValue = "Po1kwuq2tIun";
// Sensor location
String sensorLocation = "";

// BME280 setup
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>
#define SEALEVELPRESSURE_HPA (1013.25)

Adafruit_BME280 bme;

unsigned long delayTime;
unsigned long lastTime = 0;

unsigned long timerDelay = 5000;
// Rain sensor setup
#define rainAnalog 35
#define rainDigital 34

//MQ135
#define MQ135_THRESHOLD_1 1000 // Fresh Air threshold
String rain = "";
String air_quality = "";
void setup() {
  Serial.begin(115200);

  // wifi
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  
  // BME280
  Serial.println(F("BME280 test"));

  bool status;

  // default settings
  // (you can also pass in a Wire library object like &Wire2)
  status = bme.begin(0x76);  
  if (!status) {
    Serial.println("Could not find a valid BME280 sensor, check wiring!");
    while (1);
  }

  Serial.println("-- Default Test --");
  delayTime = 1000;

  Serial.println();

  // rain
  pinMode(rainDigital,INPUT);
}


void loop() { 
  // BME
  printValues();
  delay(delayTime);

  // rain
  int rainAnalogVal = analogRead(rainAnalog);
  int rainDigitalVal = digitalRead(rainDigital);

  Serial.print(rainAnalogVal);
  Serial.print("\t");

  if(rainDigitalVal == 0){
   Serial.println("Rain");
   rain = "Rain";
  }
  else{
   Serial.println("No Rain");
   rain = "No Rain";
  }

  delay(200);

  // MQ135
  int MQ135_data = analogRead(A0);
  if(MQ135_data < MQ135_THRESHOLD_1){
    Serial.print("Fresh Air: ");
    air_quality = "Fresh Air";
  } else {
    Serial.print("Poor Air: ");
    air_quality = "Poor Air";
  }
  Serial.print(MQ135_data);
  Serial.println(" PPM");

    //Send an HTTP POST request every 10 minutes
  if ((millis() - lastTime) > timerDelay) {
    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
      HTTPClient http;

      // Your Domain name with URL path or IP address with path
      http.begin(serverName);

      // Specify content-type header
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      // Prepare your HTTP POST request data
      String httpRequestData = "api_key=" + apiKeyValue
                            + "&location=" + sensorLocation 
                            + "&temperature=" + String(bme.readTemperature())
                            + "&humidity=" + String(bme.readHumidity()) 
                            + "&pressure=" + String(bme.readPressure()/100.0F) 
                            + "&altitude=" + String(bme.readAltitude(SEALEVELPRESSURE_HPA))
                            + "&co2_ppm=" + String(MQ135_data) 
                            + "&rain=" + rain
                            + "&air_quality=" + air_quality
                            + "";
      Serial.print("httpRequestData: ");
      Serial.println(httpRequestData);

      // Send HTTP POST request
      int httpResponseCode = http.POST(httpRequestData);

      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }
    lastTime = millis();
  }
}

void printValues() {
  Serial.print("Temperature = ");
  Serial.print(bme.readTemperature());
  Serial.println(" *C");
  
  // Convert temperature to Fahrenheit
  /*Serial.print("Temperature = ");
  Serial.print(1.8 * bme.readTemperature() + 32);
  Serial.println(" *F");*/
  
  Serial.print("Pressure = ");
  Serial.print(bme.readPressure() / 100.0F);
  Serial.println(" hPa");

  Serial.print("Approx. Altitude = ");
  Serial.print(bme.readAltitude(SEALEVELPRESSURE_HPA));
  Serial.println(" m");

  Serial.print("Humidity = ");
  Serial.print(bme.readHumidity());
  Serial.println(" %");

  Serial.println();
}
