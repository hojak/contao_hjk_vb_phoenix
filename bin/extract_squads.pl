#! /usr/bin/perl
# extrahiert aus den Links zum Ergebnisdienst Staffel-ID und Namen
#
# Input: Gespeicherter HTML-Code einer Basisseite des WVV mit Links auf den Ergebnisdienst der einzelnen Staffeln
#        z.B. https://www.volleyball.nrw/spielwesen/ergebnisdienst/frauen/ für die aktuellen Staffeln der Damen-Wettbewerbe
#
# Output: CSV-Datei, die als Eingabe zum Import der Staffeln im Contao-Backen verwendet werden kann.
#
# Hinweis: 
# Bei den Jugend-Staffeln gibt es teilweise doppelte Einträge. Wenn alle Jugend-Staffeln importiert werden sollen,
# empfielt es sich, zunächst alle Staffeln in eine Datei zusammen zu führen und anschließend Doppelte Einträge zu entfernen.
# Eine solche Liste wird meist vor Beginn einer Saison unter /data diesem Repository hinzugefügt.

$year = 2021;

$input = join "", <>;

while ( $input =~ m#<a href="([^"]*)">([^<]*)</a>#g ) {
	$name = $2;

	if ( $1 =~ m#ergebnisdienst/detail/liga/([0-9]+)# ) {
		print "$1;$year;$name;\n"; 	
	}
}
