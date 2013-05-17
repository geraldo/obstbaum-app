obstbaum-app: Parser
====================

Diese PHP-Script parst eine CSV Datei im folgenden Format: 

_Fläche;BaumNr;Gattung;Art;Sorte;NameDeutsch;Höhe;Schirmdurchmesser;Stammumfang;Typ;XPos;YPos;Kategorie;Reifvon;Reifbis

Das Ergebnis wird als geojson Datei in folgendem Format gespeichert:

`var obstPoints = [
	[id, 'Name des Baumes', Längengrad, Breitengrad, 'Kategorie'],
]`

Die Koordinaten der Originaldaten sind im in Österreich gängigen Koordinatensystem GK M31 (EPSG 31255). Das Ausgangsformat sind Geographische Länge und Breite in Dezimalschreibweise. Zur Umrechnung wird die auf [proj4js](http://proj4js.org/) basierende PHP Bibliothek [proj4php](http://proj4php.sourceforge.net/) verwendet.

## Lizenz

obstbaum-app ist freie Software und steht unter der [GPL license](gpl-3.0.txt).
