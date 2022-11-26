# IoT - Cloud Project: Weather Observation System - Multi Node Cluster Architecture

#### By integrating the Cloud services and features (AWS) with the IoT system, our team have developed the IoT intelligent system which automatically collect the weather data, store them in RDS database hosted on AWS Cloud, and visualized by the developed PHP Web Application. 
#### Our team developed three IoT nodes that can collect six different types of weather records and automatically analyze them to provide the current state of air quality via the web application. The web application will process and visualize the weather records as well as the current state of air quality in real-time for the client through the interface of web application. 
#### There are 10 types of record that will be visualized and provided for the client through web application including:
+ ID
+ Location
+ Temperature
+ Humidity
+ Pressure
+ Altitude
+ CO2 PPM
+ Rain
+ Air quality
+ Timestamp

#### Client can use the download function included in the web application to export the spreadsheet type of these records for the data visualization process.
For the data visualization part, our team decided to use the data visualization software (PowerBI) to conduct this process.

+ AWS services: Amazon EC2, Amazon RDS, Amazon IAM, Amazon IoT
+ Server: IoT - Web Application Server, IoT - Intermediary Server, AWS RDS – (SQL Server, SQL Backup Server)
+ IoT hardware: 3 Weather Nodes (Sensors to collect data, and deliver to Cloud Database by Wireless ESP),
+ Master Node (Raspberry) is connected with AWS Cloud through AWS IoT.
+ Connection: Wireless Connection, Restful API
+ Security: ACLs, IAM, Security Group (Cloud)
+ Data Visualization Software: PowerBI

Cloud Architecture:
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/project-cloud-architecture.png)

Security Layer applied to each component of the architecture:
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/project-cloud-architecture-2.png)

Interface of Web Application:
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/web-app-1.png)

![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/web-app-2.png)

Data Visualization (PowerBI):
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/data-visualization.png)
Comparison between Ba Dinh District and Nam Tu Liem District
