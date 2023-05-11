<?php
require 'config.php';

$currentTime = date('Y-m-d H:i:s');
echo "currentTime: " . $currentTime;
// plan:

// hvor lang tid vil en fakta kjøre
$queryTimeBetweenFacts = "SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'TimeBetweenFacts'";
$resultTimeBetweenFacts = mysqli_query($con, $queryTimeBetweenFacts);
$rowTimeBetweenFacts = mysqli_fetch_assoc($resultTimeBetweenFacts);
$TimeBetweenFacts = $rowTimeBetweenFacts['setting-value'];

echo '<br>TimeBetweenFacts: ';
echo $TimeBetweenFacts;

//hvor lang tid kan en fakta kan bli brukt på nytt
$queryCanReuseAfter = "SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'CanReuseAfter'";
$resultCanReuseAfter = mysqli_query($con, $queryCanReuseAfter);
$rowCanReuseAfter = mysqli_fetch_assoc($resultCanReuseAfter);
$CanReuseAfter = $rowCanReuseAfter['setting-value'];

echo '<br>CanReuseAfter: ';
echo $CanReuseAfter;

//hvilken fakta er i bruk nå
$queryCurentFact = "SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'CurentFact'";
$resultCurentFact = mysqli_query($con, $queryCurentFact);
$rowCurentFact = mysqli_fetch_assoc($resultCurentFact);
$CurentFact = $rowCurentFact['setting-value'];

echo '<br>CurentFact: ';
echo $CurentFact;

$queryLastUsed = "SELECT `last-used` FROM `facts` WHERE `id` = $CurentFact";
$resultLastUsed = mysqli_query($con, $queryLastUsed);

if ($resultLastUsed) {
    $rowLastUsed = mysqli_fetch_assoc($resultLastUsed);
    $lastUsed = $rowLastUsed['last-used'];

    echo '<br>lastUsed: ';
    echo $lastUsed;
} else {
    echo "Could not get fact";
}

// last used + TimeBetweenFacts > $currentTime

$stopUsage = date("Y-m-d H:i:s", (strtotime(date($lastUsed)) + $TimeBetweenFacts));
echo '<br>stopUsage: ';
echo $stopUsage;

echo '<br>stuff: ';
if ($stopUsage > $currentTime){
    // forset å bruke samme fakta
    echo "smol";
} else {
    echo "big";
    // skaff nytt fakta
}


// if it has it will select another fact where the fact has not gone over its reuseabliety
// SELECT id, fact, `last-used` FROM facts WHERE `last-used` < '2023-05-11 00:00:00' ORDER BY RAND() LIMIT 1;
// timestamp = current timestamp - CanReuseAfter (CanReuseAfter is in seconds)
// echo fact
// UPDATE `settings` SET `setting-value` = '2' WHERE `settings`.`setting-name` = 'CurentFact';
?>