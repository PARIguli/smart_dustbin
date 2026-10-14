 #include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

#define SIG_PIN D5
#define BUZZER_PIN D6

const char* ssid = "bebasi";
const char* password = "hp123456";
const char* serverName = "http://192.168.137.1/smart_dustbin/insert.php";

void setup() {
  Serial.begin(115200);
  Serial.println("🚀 SMART DUSTBIN SYSTEM STARTED");
  
  pinMode(SIG_PIN, OUTPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, LOW);

  // Connect to WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\n✅ WiFi Connected! IP: " + WiFi.localIP().toString());
}

void loop() {
  // Measure distance
  pinMode(SIG_PIN, OUTPUT);
  digitalWrite(SIG_PIN, LOW);
  delayMicroseconds(2);
  digitalWrite(SIG_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(SIG_PIN, LOW);

  pinMode(SIG_PIN, INPUT);
  long duration = pulseIn(SIG_PIN, HIGH, 30000);
  int distance = duration * 0.034 / 2;

  Serial.print("Distance: ");
  Serial.print(distance);
  Serial.print(" cm | ");

  bool dustbinFull = false;

  // Smart Dustbin Logic
  if (distance > 0 && distance <= 10) {
    Serial.println("🚨 DUSTBIN FULL!");
    digitalWrite(BUZZER_PIN, HIGH);
    delay(2000);
    digitalWrite(BUZZER_PIN, LOW);
    dustbinFull = true;
  } 
  else if (distance > 10 && distance <= 20) {
    Serial.println("⚠️ Getting full");
    digitalWrite(BUZZER_PIN, LOW);
  }
  else if (distance > 20) {
    Serial.println("✅ Empty");
    digitalWrite(BUZZER_PIN, LOW);
  }
  else {
    Serial.println("❌ Sensor error");
    digitalWrite(BUZZER_PIN, LOW);
  }

  // Send to PHP if connected to WiFi
  if (WiFi.status() == WL_CONNECTED && distance > 0) {
    sendToDatabase(distance, dustbinFull);
  } else {
    Serial.println("❌ WiFi disconnected");
  }

  delay(10000); // Wait 10 seconds between readings
}

void sendToDatabase(int distance, bool isFull) {
  WiFiClient client;
  HTTPClient http;

  String serverPath = String(serverName) + "?distance=" + String(distance);
  
  Serial.print("📡 Sending to server: ");
  Serial.println(serverPath);
  
  http.begin(client, serverPath);
  int httpResponseCode = http.GET();

  if (httpResponseCode > 0) {
    Serial.print("✅ Data sent! HTTP: ");
    Serial.println(httpResponseCode);
    
    String response = http.getString();
    Serial.println("Server: " + response);
    
    // Check if SMS was sent
    if (response.indexOf("SMS Alert Sent") > 0) {
      Serial.println("📱 SMS notification sent to your phone!");
    }
  } else {
    Serial.print("❌ Failed to send. Error: ");
    Serial.println(httpResponseCode);
  }
  
  http.end();
}