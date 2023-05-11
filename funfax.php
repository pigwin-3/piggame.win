<?php
// plan:

// how long will facts be run
// SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'TimeBetweenFacts'
// get current fact
// SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'CurentFact'

//how long till a fact can be reused
// SELECT `setting-value` FROM `settings` WHERE `setting-name` = 'CanReuseAfter'

// when was the fact first used
// SELECT `last-used` FROM `facts` WHERE `id`=1
// find out if its bean used for longer than the "TimeBetweenFacts"

// if it has not bean used longer than "TimeBetweenFacts" it will continue being used
// SELECT `fact` FROM `facts` WHERE `id` = 1
// echo fact


// if it has it will select another fact where the fact has not gone over its reuseabliety
// SELECT id, fact, `last-used` FROM facts WHERE `last-used` < '2023-05-11 00:00:00' ORDER BY RAND() LIMIT 1;
// timestamp = current timestamp - CanReuseAfter (CanReuseAfter is in seconds)
// echo fact
// UPDATE `settings` SET `setting-value` = '2' WHERE `settings`.`setting-name` = 'CurentFact';
?>