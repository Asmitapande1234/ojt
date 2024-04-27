<?php
/**
 * Grundeinstellungen für WordPress
 *
 * Diese Datei wird zur Erstellung der wp-config.php verwendet.
 * Du musst aber dafür nicht das Installationsskript verwenden.
 * Stattdessen kannst du auch diese Datei als „wp-config.php“ mit
 * deinen Zugangsdaten für die Datenbank abspeichern.
 *
 * Diese Datei beinhaltet diese Einstellungen:
 *
 * * Datenbank-Zugangsdaten,
 * * Tabellenpräfix,
 * * Sicherheitsschlüssel
 * * und ABSPATH.
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Datenbank-Einstellungen - Diese Zugangsdaten bekommst du von deinem Webhoster. ** //
/**
 * Ersetze datenbankname_hier_einfuegen
 * mit dem Namen der Datenbank, die du verwenden möchtest.
 */
define( 'DB_NAME', 'website' );

/**
 * Ersetze benutzername_hier_einfuegen
 * mit deinem Datenbank-Benutzernamen.
 */
define( 'DB_USER', 'root' );

/**
 * Ersetze passwort_hier_einfuegen mit deinem Datenbank-Passwort.
 */
define( 'DB_PASSWORD', '' );

/**
 * Ersetze localhost mit der Datenbank-Serveradresse.
 */
define( 'DB_HOST', 'localhost' );

/**
 * Der Datenbankzeichensatz, der beim Erstellen der
 * Datenbanktabellen verwendet werden soll
 */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Der Collate-Type sollte nicht geändert werden.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden untenstehenden Platzhaltertext in eine beliebige,
 * möglichst einmalig genutzte Zeichenkette.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle Schlüssel generieren lassen.
 *
 * Du kannst die Schlüssel jederzeit wieder ändern, alle angemeldeten
 * Benutzer müssen sich danach erneut anmelden.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'w x2B4.kQ FZos(rW%C$D`m!,//r4th^p],x(*mvqi1uD#%-l:#*W&k9B`/=]IYS' );
define( 'SECURE_AUTH_KEY',  'ABo=tZ)rGi?Z[y`fi}.-F(n];]80V?IRu9YG{Qw2Y,dawoLJvTi3}Y5-64(zNW)N' );
define( 'LOGGED_IN_KEY',    'K{K|&.umRs:2jM:e6?G=y=@/jNz>HbYKo~^ueAuJId1@lI46{}NKwP(WB32NH1|E' );
define( 'NONCE_KEY',        '3W,~6hXgs(0|V=}5Nc{Nk*7J:)k (<z5xqe6#08:LWPy_r:gr8f m sz|q9p9ea&' );
define( 'AUTH_SALT',        '=j<NjnVb.)+{7A(sM)Dv1J2LW|uBqC%DrZLuj3YtzGP;<69y*IF|):+QUN {/@>/' );
define( 'SECURE_AUTH_SALT', '9:#x?9ySS.wQo]{gF/B|0+37L/XB&X=>lP@E-=2Fl6t}@_m~3n9XmXPN&p$R)co5' );
define( 'LOGGED_IN_SALT',   '6-n={)%NywB/HBBN<k%,d3[e%W~`hfS8B>.MK7^fDh<6e u<x8a;/kMpDE8%n4i2' );
define( 'NONCE_SALT',       '!a7Ep(,=<6;QlAY;z#xk9+u/3+5T<4,^+Tz/.A`_io%Tq]Ssc]3(OOQJOr>i{ID*' );

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 * Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 * verschiedene WordPress-Installationen betreiben.
 * Bitte verwende nur Zahlen, Buchstaben und Unterstriche!
 */
$table_prefix = 'wp_';

/**
 * Für Entwickler: Der WordPress-Debug-Modus.
 *
 * Setze den Wert auf „true“, um bei der Entwicklung Warnungen und Fehler-Meldungen angezeigt zu bekommen.
 * Plugin- und Theme-Entwicklern wird nachdrücklich empfohlen, WP_DEBUG
 * in ihrer Entwicklungsumgebung zu verwenden.
 *
 * Besuche den Codex, um mehr Informationen über andere Konstanten zu finden,
 * die zum Debuggen genutzt werden können.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Füge individuelle Werte zwischen dieser Zeile und der „Schluss mit dem Bearbeiten“ Zeile ein. */



/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß. */
/* That's all, stop editing! Happy publishing. */

/** Der absolute Pfad zum WordPress-Verzeichnis. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Definiert WordPress-Variablen und fügt Dateien ein.  */
require_once ABSPATH . 'wp-settings.php';
