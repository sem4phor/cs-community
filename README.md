# Kurzzusammenfassung

Diese Bachelorarbeit befasst sich mit dem Entwurf und der Entwicklung einer Webanwendung zur Verbesserung der Mitspielersuche in dem Online First Person Shooter Counter Strike: Global Offensive (Release 01. Nov. 2016).

Die Anwendung ersetzt die bestehende Komponente der Mitspielersuche dabei nicht, sondern bietet eine alternative Möglichkeit seine Mitspieler vor Spielbeginn auf selbst ausgewählten Kriterien basierend auszusuchen. 
Aus der kompetitiven Eigenschaft des Wettkampfmodus von Counter Strike resultieren hohe Ansprüche an die eigenen Teammitglieder.
Diese Ansprüche zu erfüllen, ohne dass die Nutzung dieser externen Anwendung eine Hürde darstellt, ist Ziel dieser Webanwendung.

Die Umsetzung basiert auf dem MVC-Framework CakePHP und der Schnittstelle mit der SteamWebAPI. Dabei werden Websockets verwendet, um zentrale Ereignisse in Echtzeit an betroffene Benutzer weiterzugeben. 
Das Konzept der Anwendung lässt sich leicht auf andere Spiele der Plattform Steam übertragen.

Da die Nutzung primär aus dem Spiel heraus erfolgt, sind hohe Anforderungen an die Übersichtlichkeit und Benutzbarkeit der Webanwendung gestellt.
Die Bachelorarbeit ist vor Allem für Personen interessant, die sich für Webbasierte Anwendungen mit Echtzeitfeatures interessieren.

## Installationsanleitung und Überblick über die Dateistruktur

Installation
Diese Installationsanleitung ist auf das Betriebssystem Windows ausgelegt.
Voraussetzungen sind:

1. ein Webserver mit installiertem PHP 7
2. eine MySQL-Datenbank
3. Webbrowser

Zur Entwicklung der Anwendung wurde XAMPP unter Windows 10 mit dem Firefox Webbrowser benutzt.
Die Nutzung von Ratchet Websockets erfordert es die PHP-Extension zeroMQ zu installieren. 
Dazu können entweder die Schritte auf der Homepage (http://zeromq.org/intro:get-the-software) befolgt werden, oder die Datei php_zmq.dll in den php/ext Ordner des Webservers kopiert werden und die Zeile extension=php_zmq.dll der php.ini Datei beigefügt werden.
Alternativ ist der komplette PHP Ordner php_xampp im Ordner PHP zu finden, der bei der Entwicklung verwendet wurde.
Das mitgelieferte Verzeichnis cs-community muss auf dem Webserver so abgelegt werden, dass es von außen zugreifbar ist. 
In XAMPP wäre das der Ordner htdocs.

Als nächstes muss das SQL-Skript, welches im Ordner SQL liegt ausgeführt werden. 
Dadurch wird die Datenbank cs-community mit den nötigen Tabellen inklusive einiger Testdaten erstellt.
Um die Datenbankverbindung mit CakePHP herzustellen ist folgendes zu unternehmen: Im Ordner cs-community/config befindet sich die Datei app.php. 
Dort muss unter dem Abschnitt Datasources in Zeile 232 und 233 der Benutzername und das Passwort für die Datenbank den eigenen Einstellungen entsprechend eingetragen werden.
Zuletzt ist es nötig den Websocketserver zu starten. 

Dazu muss über die Kommandozeile das Script push-server.php im Ordner cs-community/bin gestartet werden. (php Pfad/Zur/Datei/push-server.php)
Nun ist die Anwendung fertig aufgesetzt und kann aufgerufen werden. (Beispiel: http://localhost/cs-community)
Um sich in der Anwendung anmelden zu können ist ein Steamaccount erforderlich. 

Dieser lässt sich kostenlos auf der Seite https://store.steampowered.com/join/?l=german erstellen. 
Um das Feature des Lobbybeitritts zu nutzen muss das Spiel Counter Strike: Global Offensive installiert sein, welches käuflich erworben werden muss. 
Das Prinzip der Mitspielersuche lässt sich aber auch ohne den Besitz des Spiels erkennen.

## Überblick über die Dateistruktur:

1. Der Ordner PHP enthält die Erweiterung ZeroMQ und den gesamten php Ordner, der zur Entwicklung der Anwendung genutzt wurde.
2. Der Ordner SQL enthält das Datenbankskript zur Erstellung der notwendigen Tabellen und Daten.
3. Der Ordner cs-community enthält den kompletten Quellcode.

## Die wichtigsten Dateien des Quellcodes sind an folgenden Orten zu finden:

1. Skript zum Starten des Websocketservers: bin/push-server.php
2. Skript zum Konfigurieren der Datenbankanbindung: config/app.php
3. Src/Controller: Die Controller Klassen und Komponenten
4. Src/Model/Table: Die Umsetzung der Datenbanktabellen in CakePHP
5. Src/Template: Die Templates für die Views. Die home-Seite befindet sich im Lobbies Unterordner
6. Webroot: Enthält CSS und JavaScript Code, sowie Bilder. Die Datei js/update-index.js enthält den Verbindungsaufbau vom Client zum Websocketserver und ist für das Abonnieren von Topics zuständig.

## Dokumentation

Die Dokumentation des PHP Quellcodes ist im Ordner cs-communtiy/doc zu finden. Um sie zu öffnen muss beispielsweise die Datei index.html im Browserfenster geöffnet werden.
JavaScript, Templatefiles und CSS ist jeweils inline kommentiert.
Hintergrundbild der Webseite:

http://cdn.edgecast.steamstatic.com/steam/apps/730/page_bg_generated_v6b.jpg?t=1479515605