#include <WiFi.h>
#include <WebServer.h>
#include <HTTPClient.h>
#include "time.h"

// Pin definitions
#define PIR_PIN    13
#define LED_PIN    2
#define BUZZER_PIN 5

// PIR variables
int pirState = LOW;
int val = 0;
bool sensorEnabled = true;

// Motion filter variables
unsigned long motionStart = 0;
unsigned long lastTrigger = 0;

const unsigned long confirmTime = 3000;   // Motion must stay HIGH for 3 seconds
const unsigned long cooldownTime = 60000; // 1 minute cooldown

// WiFi credentials
const char* ssid     = "PLDTHOMEFIBRCE9aq";
const char* password = "PLDTWIFIzhuPe2";

// Server URLs
const char* motionServer = "http://192.168.1.19/Intrusion-Detection-System/motion.php";
const char* statusServer = "http://192.168.1.19/Intrusion-Detection-System/sensor_status.php";

// Time setup
const char* ntpServer = "pool.ntp.org";
const long  gmtOffset_sec = 8 * 3600;
const int   daylightOffset_sec = 0;

// Web server
WebServer server(80);

// Heartbeat variables
unsigned long lastStatusTime = 0;
const unsigned long statusInterval = 10000;


// Send motion alert
void sendMotionAlert(String motionStatus) {

  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http;

    http.begin(motionServer);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "motion=" + motionStatus + "&location=LivingRoom";

    http.POST(postData);
    http.end();

    Serial.println("📡 Motion alert sent: " + motionStatus);
  }
}


// Send sensor status
void sendStatus(String sensor, String status) {

  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http;

    http.begin(statusServer);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "sensor=" + sensor + "&status=" + status;

    int httpResponseCode = http.POST(postData);

    http.end();

    if (httpResponseCode > 0) {
      Serial.println("📡 Status sent: " + status);
    } else {
      Serial.println("⚠️ Failed to send status");
    }
  }
}


// Web control handler
void handleSetState() {

  if (server.hasArg("state")) {

    String state = server.arg("state");

    if (state == "on") {

      sensorEnabled = true;

      sendStatus("PIR_LivingRoom", "online");

      Serial.println("🟢 Sensor ENABLED");

    } 
    else {

      sensorEnabled = false;

      sendStatus("PIR_LivingRoom", "offline");

      Serial.println("🔴 Sensor DISABLED");

      digitalWrite(LED_PIN, LOW);
      digitalWrite(BUZZER_PIN, LOW);
    }

    server.send(200, "text/plain", "OK");

  } else {

    server.send(400, "text/plain", "Missing state parameter");

  }
}


void setup() {

  pinMode(PIR_PIN, INPUT);
  pinMode(LED_PIN, OUTPUT);
  pinMode(BUZZER_PIN, OUTPUT);

  digitalWrite(LED_PIN, LOW);
  digitalWrite(BUZZER_PIN, LOW);

  Serial.begin(115200);
  Serial.println("Booting ESP32...");

  // Connect WiFi
  WiFi.begin(ssid, password);

  Serial.print("Connecting to WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\n✅ Connected!");
  Serial.println(WiFi.localIP());

  // NTP Time
  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);

  // Web server
  server.on("/set", handleSetState);
  server.begin();

  Serial.println("🌐 Web Server Started");

  // PIR stabilization
  Serial.println("⏳ PIR Stabilizing...");
  delay(30000);
}


void loop() {

  server.handleClient();

  unsigned long currentTime = millis();

  // Heartbeat status update
  if (sensorEnabled && (currentTime - lastStatusTime >= statusInterval)) {

    sendStatus("PIR_LivingRoom", "online");

    lastStatusTime = currentTime;
  }

  if (!sensorEnabled) return;

  val = digitalRead(PIR_PIN);

  // Motion start
  if (val == HIGH) {

    if (motionStart == 0) {
      motionStart = millis();
    }

    // Confirm motion
    if ((millis() - motionStart > confirmTime) &&
        (millis() - lastTrigger > cooldownTime)) {

      Serial.println("⚠️ Confirmed Motion Detected!");

      sendMotionAlert("detected");

      digitalWrite(LED_PIN, HIGH);
      digitalWrite(BUZZER_PIN, HIGH);

      delay(5000);

      digitalWrite(LED_PIN, LOW);
      digitalWrite(BUZZER_PIN, LOW);

      lastTrigger = millis();
      motionStart = 0;
    }

  } 
  else {

    motionStart = 0;

  }

  delay(200);
}