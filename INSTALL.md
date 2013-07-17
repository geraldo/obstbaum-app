Installationsanleitung
===================

1. Installieren Sie die neueste Version von Wordpress auf ihren Server, zB. http://localhost/obst 

2. Installieren Sie folgende Wordpress Plugins:
 * 404 Redirection
 * Add Meta Tags
 * Ajax Edit Comments
 * Akismet
 * Comment Images
 * Contact Form 7
 * Contact Form DB
 * GD Star Rating
 * Google XML Sitemaps
 * Nav Menu Roles
 * User Avatar
 * WordPress Database Backup
 * WP-Cycle

3. Installieren Sie das [Wordpress Template](https://github.com/geraldo/obstbaum-app/tree/master/obst)  von GitHub als Wordpress Theme.

4. Passen Sie folgenden Pfad in Zeile 9 von map.php an Ihre Installation an:
`include('/var/www/vhosts/linzwiki.at/obst/wp-load.php');`
Sie müssen dabei `/var/www/vhosts/linzwiki.at/obst/` durch einen absoluten Pfad auf Ihr Wordpress Verzeichnis ersetzen.

5. Importieren Sie die Bäume mithilfe des [Import Templates](https://github.com/geraldo/obstbaum-app/blob/master/obst/import-template.php) von GitHub nach Wordpress. Sie müssen dazu den Pfad in Zeile 9 auf Ihre Installation anpassen:
`include_once("/var/www/vhosts/linzwiki.at/obst/static/parse/proj4php/proj4php.php");`

6. Testen Sie die Installation und dokumentieren Sie mögliche Fehler in den [Issues auf GitHub](https://github.com/geraldo/obstbaum-app/issues)
