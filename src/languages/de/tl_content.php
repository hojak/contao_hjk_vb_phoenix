<?php


/* labels in the type selection **/
$GLOBALS['TL_LANG']['CTE']['hjk_vbphoenix'] = "(HJK) Phoenix-Ergebnisdienst";
$GLOBALS['TL_LANG']['CTE']['hjk_vbphoenix_table'] = array ("Phoenix-Tabelle", "Tabelle" );
$GLOBALS['TL_LANG']['CTE']['hjk_vbphoenix_results'] = array ("Phoenix-Ergebnisse", "Ergebnisse");
$GLOBALS['TL_LANG']['CTE']['hjk_vbphoenix_schedule'] = array ( "Phoenix-Spielplan", "Spielplan");
$GLOBALS['TL_LANG']['CTE']['hjk_vbphoenix_preview'] = array ( "Phoenix-Vorschau", "Vorschau");


/** legends **/
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_table_legend'] = 'Einstellungen zur Anzuzeigenden Tabelle';
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_schedule_legend'] = 'Einstellungen zum Spielplan';
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_results_legend'] = 'Einstellungen zur Ergebnis-Anzeige';


/** field desctptions and option labels **/
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_squadron'] = array ('Staffel','Wählen Sie die Staffel, aus der Sie Daten anzeigen möchten. (Zuvor müssen einmalig die aktuellen Staffel-Daten eingetragen werden!)');
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_season'] = array ('Saison (Jahr)','Geben Sie das Start-Jahr der anzuzeigenden Saison ein.');
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_games_label'] = array ('Spielanzeige','Welche Spiele sollen angezeigt werden?');
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_games_options'] = array (
    'all'       => 'Alle Spiele',
    'team'      => 'Nur die Spiele des eigenen Teams',
    'team_home' => 'Nur die Heimspiele des eigenen Teams',
    'team_away' => 'Nur die Auswärtsspiele des eigenen Teams',
);
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_display_label'] = array ('Art der Darstellung','Wählen Sie die Art der Darstellung aus.');
$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_display_options'] = array (
    'phlist'     => 'Alles Spiele aufgelistet',
    'phtable'    => 'Tabellenform',
    'phgamedays' => 'nach Spieltagen unterteilt',
);

$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_team'] = array ('Team','Welches ist das eigene Team in der Staffel? (Zum Hervorheben oder zur Anzeige-Steuerung)');
