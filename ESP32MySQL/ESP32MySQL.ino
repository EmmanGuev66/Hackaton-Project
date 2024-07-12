#include <WiFi.h>
#include <HTTPClient.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>

// Definir los pines I2C para la pantalla OLED
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 32
#define OLED_RESET -1
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

const char* ssid = "HackatonUTNA";  // SSID
const char* password = "HackatonUTNA";  // Password
const char* host = "http://10.10.39.51";  // URL del servidor

float totalConsumo = 0;  // Variable para almacenar el consumo total

void setup(void) {
  Serial.begin(9600);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi conectado");
  Serial.println("Dirección IP: ");
  Serial.println(WiFi.localIP());

  // Inicializar la pantalla OLED
  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {  // Dirección I2C de la pantalla OLED
    Serial.println(F("No se encuentra la pantalla OLED"));
    for (;;);
  }

  display.display();
  delay(2000);
  display.clearDisplay();
}

void loop() {
  int analogValue = analogRead(36);  // Pin analógico 36
  Serial.print("Lectura analógica = ");
  Serial.println(analogValue);

  // Convertir el valor analógico en un valor de consumo (suponiendo que 1023 equivale a 1 m³)
  float consumo = analogValue / 1023.0;
  totalConsumo += consumo;  // Sumar el consumo al total

  // Mostrar el consumo en la pantalla OLED
  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);
  display.setCursor(0, 0);
  display.print("Consumo:");
  display.setCursor(0, 10);
  display.print(totalConsumo, 3);  // Mostrar 3 decimales
  display.print(" m3");
  display.display();

  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    String url = String(host) + "/monitoreo/data.php";  // Cambia esto por el endpoint adecuado
    http.begin(client, url);

    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "NumeroCasa=1&Calle=Principal&Colonia=Centro&CodigoPostal=12345&Propietario=Juan Perez";
    postData += "&FechaRegistro=2024-07-12&ConsumoAguaMensual=" + String(totalConsumo);
    postData += "&UltimaLectura=" + String(consumo) + "&FechaUltimaLectura=2024-07-12";

    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Respuesta del servidor: " + response);
    } else {
      Serial.print("Error en la solicitud POST. Código de respuesta HTTP: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("No conectado a la red WiFi");
  }

  delay(5000);  // Envía los datos cada 5 segundos
}