
/*
  Web client

 This sketch connects to a website (http://www.google.com)
 using a WiFi shield.

 This example is written for a network using WPA encryption. For
 WEP or WPA, change the Wifi.begin() call accordingly.

 This example is written for a network using WPA encryption. For
 WEP or WPA, change the Wifi.begin() call accordingly.

 Circuit:
 * WiFi shield attached

 created 13 July 2010
 by dlf (Metodo2 srl)
 modified 31 May 2012
 by Tom Igoe
 */


#include <SPI.h>
#include <WiFi.h>

char ssid[] = "AKa9"; //  your network SSID (name)
char pass[] = "yuvraj0987";    // your network password (use for WPA, or use as key for WEP)
int keyIndex = 0;            // your network key Index number (needed only for WEP)
String readString;
// defines pins numbers
const int trigPin = 10;
const int echoPin = 9 ;

// defines variables
long duration;
long distance;
long binHeight = 23; // will be different for each dustbin needs caliberation
int status = WL_IDLE_STATUS;
// if you don't want to use DNS (and reduce your sketch size)
// use the numeric IP instead of the name for the server:
//IPAddress server(74,125,232,128);  // numeric IP for Google (no DNS)
char server[] = "www.mithramedia.co.in";    // name address for Google (using DNS)

// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):
WiFiClient client;
//int fill = 9;
int volume;
String fill = "&fill=";
String dustbinID= "dustbinID=1";
String postDataString="";

void setup() {
  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
pinMode(echoPin, INPUT); // Sets the echoPin as an Input
  //Initialize serial and wait for port to open:
  Serial.begin(9600);
  digitalWrite(trigPin, LOW);
delayMicroseconds(2);

// Sets the trigPin on HIGH state for 10 micro seconds
digitalWrite(trigPin, HIGH);
delayMicroseconds(10);
digitalWrite(trigPin, LOW);

// Reads the echoPin, returns the sound wave travel time in microseconds
duration = pulseIn(echoPin, HIGH);

// Calculating the distance
distance= duration*0.034/2;

// Prints the distance on the Serial Monitor
Serial.print("Distance: ");
Serial.println(distance);
volume = (100*distance/binHeight);
volume = 100-volume;
       Serial.println(volume);

delayMicroseconds(2000);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }

  // check for the presence of the shield:
  if (WiFi.status() == WL_NO_SHIELD) {
    Serial.println("WiFi shield not present");
    // don't continue:
    while (true);
  }

  String fv = WiFi.firmwareVersion();
  if (fv != "1.1.0") {
    Serial.println("Please upgrade the firmware");
  }

  // attempt to connect to Wifi network:
  while (status != WL_CONNECTED) {
    Serial.print("Attempting to connect to SSID: ");
    Serial.println(ssid);
    // Connect to WPA/WPA2 network. Change this line if using open or WEP network:
    status = WiFi.begin(ssid, pass);

    // wait 10 seconds for connection:
    delay(10000);
  }
  Serial.println("Connected to wifi");
  printWifiStatus();
// Clears the trigPin

  Serial.println("\nStarting connection to server...");
  // if you get a connection, report back via serial:
   postDataString = dustbinID + fill+ volume;
       Serial.println(postDataString);

 if (client.connect(server, 80)) {
    Serial.println("connecting...");

    // EDIT: The POST 'URL' to the location of your insert_mysql.php on your web-host
    client.println("POST /hackathon/getdustbindata.php HTTP/1.1");

    // EDIT: 'Host' to match your domain
    client.println("Host: www.mithramedia.co.in");
    client.println("User-Agent: Arduino/1.0");
    client.println("Connection: close");
    client.println("Content-Type: application/x-www-form-urlencoded;");
    client.print("Content-Length: ");
    client.println(postDataString.length());
    client.println();
    client.println(postDataString); 
  } 
  else {
    // If you couldn't make a connection:
    Serial.println("Connection failed");
    Serial.println("Disconnecting.");
    client.stop();
}  
client.stop(); //stop client
  Serial.println("client disconnected.");
  Serial.println("Data from server captured in readString:");
  Serial.println();
  Serial.print(readString);
}

void loop() {
  // if there are incoming bytes available
  // from the server, read them and print them:
//  while (client.available()) {
//    char c = client.read();
//    Serial.write(c);
//  }
//
//  // if the server's disconnected, stop the client:
//  if (!client.connected()) {
//    Serial.println();
//    Serial.println("disconnecting from server.");
//    client.stop();
//
//  }
}

void calculateFill(){
  digitalWrite(trigPin, LOW);
delayMicroseconds(2);

// Sets the trigPin on HIGH state for 10 micro seconds
digitalWrite(trigPin, HIGH);
delayMicroseconds(10);
digitalWrite(trigPin, LOW);

// Reads the echoPin, returns the sound wave travel time in microseconds
duration = pulseIn(echoPin, HIGH);

// Calculating the distance
distance= duration*0.034/2;

// Prints the distance on the Serial Monitor
Serial.print("Distance: ");
Serial.println(distance);
volume = 100-100*(distance/binHeight);
delayMicroseconds(2000);
sendDataToServer();
   
  }

  void sendDataToServer(){

Serial.println("\nStarting connection to server...");
  // if you get a connection, report back via serial:
   postDataString = dustbinID + fill+ volume;
 if (client.connect(server, 80)) {
    Serial.println("connecting...");

    // EDIT: The POST 'URL' to the location of your insert_mysql.php on your web-host
    client.println("POST /hackathon/getdustbindata.php HTTP/1.1");

    // EDIT: 'Host' to match your domain
    client.println("Host: www.mithramedia.co.in");
    client.println("User-Agent: Arduino/1.0");
    client.println("Connection: close");
    client.println("Content-Type: application/x-www-form-urlencoded;");
    client.print("Content-Length: ");
    client.println(postDataString.length());
    client.println();
    client.println(postDataString); 
  } 
  else {
    // If you couldn't make a connection:
    Serial.println("Connection failed");
    Serial.println("Disconnecting.");
    client.stop();
}  
client.stop(); //stop client
  Serial.println("client disconnected.");
  Serial.println("Data from server captured in readString:");
  Serial.println();
  Serial.print(readString);

   // calculateFill();
    }
void printWifiStatus() {
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength:
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}





