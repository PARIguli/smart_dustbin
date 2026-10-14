# Smart Dustbin

A semester project for the **Advanced Database** course, developed by a team of three students.

Smart Dustbin is an IoT-based waste-monitoring system that uses an Arduino and a sensor to detect the garbage level inside a dustbin. When the dustbin becomes full or empty, the system sends an SMS notification through the **Twilio API**, helping the responsible person know when the dustbin needs attention.

The project also includes an administrative dashboard where an admin can monitor the dustbin remotely and view a live animation representing its current status and garbage level.

## Features

- Detects the garbage level inside a dustbin using a sensor.
- Uses Arduino hardware for real-time monitoring.
- Sends SMS notifications using the Twilio API.
- Notifies the responsible person when the dustbin is full or empty.
- Provides an admin dashboard for monitoring.
- Displays a live visual animation of the dustbin status.
- Combines hardware monitoring with a web-based management system.

## How It Works

1. The sensor measures the amount of garbage inside the dustbin.
2. The Arduino processes the sensor readings.
3. The system determines whether the dustbin is full, empty, or at another monitored level.
4. The current status is sent to the project application.
5. The admin can view the dustbin status from the dashboard.
6. When an important status change occurs, an SMS notification is sent through Twilio.

## Technologies Used

- **Arduino** – Hardware controller
- **Garbage-level sensor** – Detects the level of waste
- **PHP** – Backend and web application logic
- **C++** – Arduino programming
- **Twilio API** – SMS notifications
- **HTML, CSS, and JavaScript** – Dashboard interface and animation
- **Database** – Stores monitoring and system data

## Setup

### 1. Clone the repository

```bash
git clone https://github.com/PARIguli/smart_dustbin.git
cd smart_dustbin
```

### 2. Configure the application

Configure the database connection and application settings in the relevant PHP configuration files.

### 3. Configure Twilio

Add the required Twilio credentials to the project configuration:

- Twilio Account SID
- Twilio Auth Token
- Twilio phone number
- Recipient phone number

For security, do not commit API credentials or other secrets to the repository.

### 4. Connect the hardware

- Upload the Arduino/C++ code to the Arduino board.
- Connect the sensor according to the circuit design.
- Ensure the Arduino can communicate with the application.
- Start the web application and open the admin dashboard.

## Team Members

This semester project was developed by:

- **Parigul Ziad**
- **Guljan Rashid**
- **Fajir**

## Academic Context

This project was completed as a **semester project for the Advanced Database course**. It demonstrates how hardware sensors, a database-backed web application, an admin dashboard, and an SMS service can work together to create a smart waste-management solution.

## Future Improvements

- Add support for multiple dustbins and locations.
- Add graphical reports and historical garbage-level data.
- Add email and mobile-app notifications.
- Improve real-time communication between the Arduino and dashboard.
- Add automatic collection scheduling.
- Deploy the dashboard to a cloud server.

## License

This project was created for educational purposes as part of a semester project.
