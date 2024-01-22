// librerias
#include "DHT.h"
#include "DHT_U.h"
#include <ESP8266WiFi.h>
#include "MQ7.h"
#include <SoftwareSerial.h> //incluimos SoftwareSerial
#include <TinyGPS.h>        //incluimos TinyGPS

// CONEXION
// Cambiar SSID y Password por los de su red
const char *ssid = "";     // SSID
const char *password = ""; // Password
const char *host = "";     // IP serveur - Server IP
const int port = ;         // Port serveur - Server Port
const int watchdog = ;     // Fréquence du watchdog - Watchdog frequency
unsigned long previousMillis = millis();

// TEMP Y HUM
//  #define DHTTYPE DHT11
DHT dht(D1, DHT11);
float h, t;
// #define dht_dpin 5 //D1

// Humedad Tierra
const int sensorHumedadTierra = 16; // D0

// GPS
TinyGPS gps;                      // Declaramos el objeto gps
SoftwareSerial serialgps(D5, D6); // Declaramos el pin 4 Tx y 3 Rx

// Declaramos la variables para la obtención de datos
unsigned long chars;
unsigned short sentences, failed_checksum;

// GAS
#define A_PIN 0
#define VOLTAGE 5
// init MQ7 device
MQ7 mq7(A_PIN, VOLTAGE);

#define buzzerPin D2

// ALGUNOS PINES
void setup()
{
  serialgps.begin(9600); // Iniciamos el puerto serie del gps
  Serial.begin(9600);
  while (!Serial)
  {
    ; // wait for serial connection
  }

  // WIFI
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  // //PINES por si acaso
  // pinMode(tempHum,OUTPUT);
  // pinMode(gas,OUTPUT);
  // pinMode(humTierra,OUTPUT);

  // TEMP_HUM
  dht.begin();

  // GAS
  Serial.println(""); // blank new line
  Serial.println("Calibrating MQ7");
  mq7.calibrate(); // calculates R0
  Serial.println("Calibration done!");
}

void loop()
{

  int estado;

  // TEMP_HUM

  h = dht.readHumidity();
  t = dht.readTemperature();
  Serial.print("Humedad = ");
  Serial.print(h);
  Serial.print("%  ");
  Serial.print("Temperatura = ");
  Serial.print(t);
  Serial.println("°C  ");

  // GAS
  float ppmValue = mq7.readPpm(); // Lee el valor de ppm
  Serial.print("PPM = ");
  Serial.println(ppmValue);
  // Verifica si el valor de ppm es mayor a 10
  if (ppmValue > 12)
  {
    Serial.println("Fire detected!");
    tone(buzzerPin, 5000); // Generar un tono de 1000 Hz en el zumbador

    // Puedes agregar aquí cualquier acción adicional que desees realizar
  }
  else
  {
    noTone(buzzerPin);
  }

  Serial.println(""); // blank new line
  delay(1000);

  // GPS
  float latitude, longitude;
  latitude = 25.649824;
  longitude = -100.288934;
  while (serialgps.available())
  {
    int c = serialgps.read();
    if (gps.encode(c))
    {
      gps.f_get_position(&latitude, &longitude);
      Serial.print("Latitud/Longitud: ");
      Serial.print(latitude, 5);
      Serial.print(", ");
      Serial.println(longitude, 5);
      Serial.print("Satelites: ");
      Serial.println(gps.satellites());
      Serial.println();
      delay(5000);
      gps.stats(&chars, &sentences, &failed_checksum);
    }
  }
  if (latitude == 25.649824 && longitude == -100.288934)
  {
    Serial.println("No se detecto GPS");
  }
  Serial.print("Latitud: ");
  Serial.print(latitude);
  Serial.print("Longitud ");
  Serial.println(longitude);

  // HUMEDAD TIERRA

  int humedadTierra = digitalRead(sensorHumedadTierra); // Lee el valor digital
  Serial.print(",");
  Serial.print(humedadTierra);
  Serial.print(",");
  // Realiza acciones basadas en el valor leído
  if (humedadTierra == HIGH)
  {
    // El sensor no detecta humedad
    // Realiza acciones correspondientes
    // delay(500);
    Serial.print("Humedad Baja"); // HUMEDAD BAJA
  }
  else
  {
    // El sensor  detecta humedad
    // Realiza acciones correspondientes
    // delay(500);
    Serial.print("Humedad Alta"); // HUMEDAD ALTA
  }

  // ESTADOS

  // Riesgo Bajos
  // Riesgo Alto
  if (ppmValue >= 12)
  {
    estado = 2; // rojo;
  }
  else if (t <= 25 && h > 60 && ppmValue >= 100 && humedadTierra == LOW)
  {
    estado = 6; // morado
  }
  else if (t <= 25 && h >= 60 || ppmValue < 12 && humedadTierra == LOW)
  {
    estado = 0; // estado verde fuerte
  }
  else if (t <= 25 && h >= 40)
  {
    estado = 1; // verde claro
  }
  else if (t <= 25 && h >= 40 && h <= 60 && humedadTierra == HIGH && ppmValue < 100)
  {
    estado = 5; //  azul
  }
  // Riesgo Moderado
  else if (t > 25 && t <= 30 && h >= 40 && h < 60 && ppmValue < 100 && humedadTierra == LOW)
  {
    estado = 3; // amarillo
  }
  else if (t > 25 && t <= 30 && h < 40)
  {
    estado = 4; //  naranja
  }
  else if (t <= 25 && h < 40 && humedadTierra == HIGH)
  {
    estado = 7; // celeste
  }

  else
  {
    estado = 10; // Estado desconocido negro
  }
  Serial.print("ESTADOOOO");
  Serial.println(estado);

  // CONEXION A LA BASE DE DATOS
  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis > watchdog)
  {
    previousMillis = currentMillis;
    WiFiClient client;

    if (!client.connect(host, port))
    {
      Serial.println("Fallo al conectar");
      return;
    }

    String url = "/IOT_PROJECT/ECO_GUARDIAN_BASE_DE_DATOS/index.php?temp=";
    url += t;
    url += "&hum=";
    url += h;
    url += "&hum_tierra=";
    url += humedadTierra;
    url += "&gas=";
    url += ppmValue;
    url += "&lat=";
    url += latitude;
    url += "&longi=";
    url += longitude;
    url += "&estado=";
    url += estado;

    // Enviamos petición al servidor
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n" +
                 "Connection: close\r\n\r\n");
    unsigned long timeout = millis();
    while (client.available() == 0)
    {
      if (millis() - timeout > 5000)
      {
        Serial.println(">>> Client Timeout !");
        client.stop();
        return;
      }
    }

    // Leemos la respuesta del servidor
    while (client.available())
    {
      String line = client.readStringUntil('\r');
      Serial.print(line);
    }
  }
  delay(800);
}
