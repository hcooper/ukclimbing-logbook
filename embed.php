<?php

//////////////////////////////////////////////////////////
//
// embed.php
// outputs the UKC logbook in a form suitable for embedding
//
//////////////////////////////////////////////////////////

//Include table handling class
include 'tableExtractor.class.php';
$tx = new tableExtractor;

$_GET['id'] = "76394"; //HARD CODE HACK

// Make sure an ID number if supplied
if (!isset($_GET['id'])) {
	echo "<strong>You need to supply an UKC user ID number, or hardcode one.</strong>";
	exit(1);
}

//Set source data URL
$url="http://www.ukclimbing.com/logbook/showlog.html?id=".$_GET['id'];

//Parse table structure
$tx->source = file_get_contents($url);
$tx->anchorWithin = true;
$tx->anchor = 'Climb name';
$tableArray = $tx->extractTable();

/* [1] Array outline
[1] "Climb name"
[2] "Grade"
[3] "Style"
[4] "Partner(s)"
[5] "Notes"
[6] "Date"
[7] "Crag name"
*/


// Limit it to  the last 10 (11-2) climbs
$i=2;
while($i<=11) {

	// Correct the reative link URL to point to ukclimbing.com
	$tableArray[$i][1] = str_replace("c.php", "http://www.ukclimbing.com/logbook/c.php", $tableArray[$i][1]);
	$tableArray[$i][7] = str_replace("crag.php", "http://www.ukclimbing.com/logbook/crag.php", $tableArray[$i][7]);

	// Print Climb name and Crag Name
	echo "<li class=\"cat-item\">".$tableArray[$i][1]." - ".$tableArray[$i][7]."</li>";
	$i++;
}

// Print the "more" link
echo "<li><a href=\"".$url."\">more...</a></li>";


/* DEBUG
echo "<br><br>############################<br><br>";
var_dump($tableArray);
*/

?>
