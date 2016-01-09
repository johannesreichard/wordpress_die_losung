# Die Losung plugin für Wordpress

Current version: `1.0.0`

## first things first
This plugin only shows german content. Therefor the documentation is in german.

Dieses Plugin zeigt ausschließlich inhalte in Deutscher Sprache, daher ist die Dokumentation in 
deutsch gehalten.

## Lizenzen
Das Plugin und der Source Code sind unter der MIT Lizenz veröffentlich (siehe LICENCE). Die 
Rechte an den gezeigten Inhalten liegen Bei der Deutschen Bibelgesellschaft und der Brüder-Unität.
Laut ihrer Webseite erhebt die Brüder-Unität bei nichtkommerzieller Nutzung keine Lizensgebühren,
Stand 09.01.2016 siehe [www.losung.de](http://losung.de). Dies kann sich jederzeit ändern, daher
überprüfen Sie die bitte selbst ob Sie berechtigt die Inhalte auf Ihrer seite einzubinden.


## Plugin\Widget einrichten
Nach der Installation des Plugins muss es aktiviert werden. Dies kann direkt im Anschlussdialog
der Installation gemacht werden oder nachtraglich auf der Plugin Seite. Das Plugin beinhaltet
ein Widget, dass in eine Widget Area der Seite eingebaut werden muss (siehe Design -> Widgets).

Das Plugin hat keine Möglichkeiten zur Konfiguration. Es läd selbstständig die aktuellen Daten
in ihr Upload Verzeichniss herunter und speichert alles unter 'losung'. Bei Problemen oder Fehlern
öffnen Sie bitte ein github Issue oder kontaktieren Sie den Author direkt.

## Entwicklung

Die Entwicklung gestaltet sich recht einfach. Man benötigt lediglich Grundkenntnisse in der
Benutzung von [Docker](https://docs.docker.com/linux/) um die Entwicklungsumgebung zu starten.
Danach kann man einen Testblog einrichten und direkt loslegen.

### dependencies
- docker
- docker-compose

## start dev environment

    docker-compose up


Author: Johannes Reichard <mail@johannesreichard.de>
