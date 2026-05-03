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

Step 3: Setup ESP32 / Arduino

1. Open Arduino IDE.
2. Install ESP32 board package.
3. Open the provided ".ino" file.
4. Enter your Wi-Fi name and password.
5. Update the server URL.

Example:

http.begin("http://your-ip-address/project/insert.php");

Step 4: Upload Code

1. Connect ESP32 to your computer.
2. Select the correct COM port.
3. Click Upload.

Step 5: Run the System

1. Power on the ESP32.
2. Wait for Wi-Fi connection.
3. Move in front of the PIR sensor.
4. Check the dashboard for alerts/logs.

Notes

- If using online hosting, replace localhost URL with your domain.
- Ensure ESP32 and server are connected properly.
- Sensor placement affects accuracy.
