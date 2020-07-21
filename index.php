<?php

include_once "scribe.php";

$scribeClient = new ScribeClient("https://skryba.razniewski.eu/", "admin", "admin");
$records = $scribeClient->getRecordsInDay("2020-07-02");

echo "02-07-2020:<br>";
// Returns all records in specific day
foreach ($records as &$value) {
    // date_parse can parse this date easily
    $parsedDate = date_parse($value[2]);
    $niceDate = $parsedDate["day"] . "-" . $parsedDate["month"] . "-" . $parsedDate["year"];
    
    echo "RFIDID: " . $value[0] . " USER: " . $value[1] . " TIME: " . $value[2] . "<br>";
}


echo "<br><br>FROM: 01-06-2020 to 30-06-2020:<br>";
// Returns all records in specific period
$records = $scribeClient->getRecordsInPeriod("2020-06-01", "2020-06-30");
foreach ($records as &$value) {
    echo "RFIDID: " . $value[0] . " USER: " . $value[1] . " TIME: " . date_parse($value[2]) . "<br>";
}

// Download backup and saves to file backup.sqlite
$backup = $scribeClient->getBackup();
file_put_contents("backup.sqlite", $backup);
?>
