# IoT - Cloud Project: Weather Observation System - Multi IoT-node architecture

Our team created the IoT intelligent system by integrating Cloud services and features (AWS) with the IoT system, which automatically collects weather data from each IoT node, stores it in an RDS database hosted on AWS Cloud, and visualizes it using the developed PHP Web Application. By applying the multi-sensors to one IoT-node architecture, our team developed multiple IoT nodes that can collect six different types of weather records and automatically analyze them to provide the current condition of air quality via the web application. The web application will process and visualize the weather records as well as the current condition of air quality in real-time for the client through the interface of the web application. For the data analysis and visualization part, our team decided to use the data visualization software (PowerBI) to visualize and deeply analyze the collected weather records.
#### 
There are 10 types of record that will be visualized and provided for the client through web application including:
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

#### Hardware & Software:
+ AWS services: Amazon EC2, Amazon RDS, Amazon IAM, Amazon IoT
+ Server: IoT - Web Application Server, IoT - Intermediary Server
+ Database Server: AWS Relational Database Service (AWS RDS) - SQL Server, SQL Backup Server
+ IoT hardware: 3 Weather Nodes (Sensors to collect data, and deliver to relational database hosted in AWS cloud through wireless connection)
+ Master Node (Raspberry) is connected with AWS Cloud through AWS IoT
+ Connection: Wireless Connection, Restful API
+ Security: AWS Security Group, AWS Identity & Access Management (AWS IAM)
+ Data Visualization Software: PowerBI

#### Cloud Architecture:
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/project-cloud-architecture.png)

#### IoT Weather Observation Nodes:
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/IoT-weather-observation-nodes.jpg)

#### Security Layer applied to each component of the architecture:
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/project-cloud-architecture-2.png)

#### Interface of Web Application:
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/web-app-1.png)

![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/web-app-2.png)

#### Data Visualization (PowerBI):
![alt text](https://github.com/zkl21hoang/cloud-iot-weather-data-analysis/blob/main/images/data-visualization.png)
Data visualization and comparison between two districts
