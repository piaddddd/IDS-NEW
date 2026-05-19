Setup Instructions

Requirements

- XAMPP or web hosting with PHP/MySQL
- Arduino IDE
- ESP32 board package installed
- Wi-Fi connection
- PIR Motion Sensor
- ESP32 / Arduino board

Step 1: Setup the Website

1. Download or clone this repository.
2. Copy the PHP files into the "htdocs" folder (if using XAMPP).
3. Start Apache and MySQL in XAMPP.
4. Open phpMyAdmin.
5. Import the included SQL database file.

Step 2: Configure Database

1. Open the PHP config file.
2. Update database name, username, and password to:

$conn = new mysqli("localhost", "root", "", "app_db");

Step 3: Upload Code

1. Connect ESP32 to your computer.
2. Select the correct COM port.
3. Click Upload.

Step 4: Run the System

1. Power on the ESP32.
2. Wait for Wi-Fi connection.
3. Move in front of the PIR sensor.
4. Check the dashboard for alerts/logs.

Good morning @everyone 

Attention to all ! Please include this in your GitHub file.

- In the readme file.

Example

A-P - "admin@system.com" - "admin123"

U-P - "charlie.an@gmail.com" - "charlie12"

(origin - A-P = admin password and username )

(U-P - User username and Password )
