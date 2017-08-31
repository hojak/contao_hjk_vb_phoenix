#! /usr/bin/perl
# extrahiert aus den Links zum Ergebnisdienst Stallel-ID und Namen

$input = join "", <>;

while ( $input =~ m#<a href="([^"]*)">([^<]*)</a>#g ) {
	$name = $2;

	if ( $1 =~ m#ergebnisdienst/detail/liga/([0-9]+)# ) {
		print "$1;2017;$name;\n"; 	
	}
}
