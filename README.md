# IoT - Cloud Project: Weather Data Analysis - Multi Node Cluster Architecture

By integrating the Cloud services and features (AWS) with the IoT system, we have developed the IoT intelligent system which automatically collect the weather data, store them in RDS database hosted on AWS Cloud, and visualized by developed PHP Web Application. 
The developed IoT node can collect 6 seperate types of weather record and automatically analyze to provide the condition of air quality through developed PHP web application. After that, the web application will visualize the weather records as well as the condition of air quality for the client through the interface of web application. 
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
\nClient can use the download function through the web application to download the spreadsheet type of these records for the data visualization.
For the data visualization part, our team decided to use the data visualization software (PowerBI) to conduct this process.


AWS services: Amazon EC2, Amazon RDS, Amazon IAM, Amazon IoT
Server: IoT - Web Application Server, IoT - Intermediary Server, AWS RDS – (SQL Server, SQL Backup Server)
IoT hardware: 3 Weather Nodes (Sensors to collect data, and deliver to Cloud Database by Wireless ESP),
Master Node (Raspberry) is connected with AWS Cloud through AWS IoT.
Connection: Wireless Connection, Restful API
Security: ACLs, IAM, Security Group (Cloud)
Data Visualization Software: PowerBI
