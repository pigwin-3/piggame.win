<?php
require 'config.php';

$currentTime = date('Y-m-d H:i:s');

// hvor lang tid vil en fakta kjøre
$queryTimeBetweenFacts = "SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'TimeBetweenFacts'";
$resultTimeBetweenFacts = mysqli_query($con, $queryTimeBetweenFacts);
$rowTimeBetweenFacts = mysqli_fetch_assoc($resultTimeBetweenFacts);
$TimeBetweenFacts = $rowTimeBetweenFacts['setting-value'];

//hvor lang tid kan en fakta kan bli brukt på nytt
$queryCanReuseAfter = "SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'CanReuseAfter'";
$resultCanReuseAfter = mysqli_query($con, $queryCanReuseAfter);
$rowCanReuseAfter = mysqli_fetch_assoc($resultCanReuseAfter);
$CanReuseAfter = $rowCanReuseAfter['setting-value'];

//hvilken fakta er i bruk nå
$queryCurentFact = "SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'CurentFact'";
$resultCurentFact = mysqli_query($con, $queryCurentFact);
$rowCurentFact = mysqli_fetch_assoc($resultCurentFact);
$CurentFact = $rowCurentFact['setting-value'];

$queryLastUsed = "SELECT `last-used` FROM `facts` WHERE `id` = $CurentFact";
$resultLastUsed = mysqli_query($con, $queryLastUsed);

if ($resultLastUsed) {
    $rowLastUsed = mysqli_fetch_assoc($resultLastUsed);
    $lastUsed = $rowLastUsed['last-used'];
} else {
    echo "Could not get fact";
    exit;
}

// last used + TimeBetweenFacts > $currentTime

$stopUsage = date("Y-m-d H:i:s", (strtotime(date($lastUsed)) + $TimeBetweenFacts));

$secTillNext = (strtotime($stopUsage) - strtotime($currentTime));

if ($secTillNext >= 1){
    // forset å bruke samme fakta
    $queryFact = "SELECT `fact` FROM `facts` WHERE `id` = $CurentFact";
    $resultFact = mysqli_query($con, $queryFact);

    $rowFact = mysqli_fetch_assoc($resultFact);
    $fact = $rowFact['fact'];
    echo $fact;
} else {
    // skaff nytt fakta
    $useable = date("Y-m-d H:i:s", (strtotime($currentTime) - $CanReuseAfter));
    $queryFact = "SELECT id, fact FROM facts WHERE `last-used` < '$useable' ORDER BY RAND() LIMIT 1";
    $resultFact = mysqli_query($con, $queryFact);

    $rowFact = mysqli_fetch_assoc($resultFact);
    $fact = $rowFact['fact'];
    $id = $rowFact['id'];
    echo $fact;
    // UPDATE `facts` SET `last-used`=current_timestamp() WHERE `id` = 3
    $queryTimeUpdate = "UPDATE `facts` SET `last-used`=current_timestamp() WHERE `id` = $id";
    mysqli_query($con, $queryTimeUpdate);

    $queryIdUpdate = "UPDATE `settings` SET `setting-value` = '$id' WHERE `settings`.`setting-name` = 'CurentFact'";
    mysqli_query($con, $queryIdUpdate);
}

//echo '<br>'.  (strtotime($stopUsage) - strtotime($currentTime)) . ' seconds';

?>