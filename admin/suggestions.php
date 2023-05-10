<?php
session_start();
// se om brukeren er logget in om brukeren ikke er det vidresend brukeren til hovedsiden
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../');
	exit;
}

require '../config.php';
// skaffer informasjon om databasen fra en ekstern fil
$stmt = $con->prepare('SELECT `perm` FROM `accounts` WHERE `id` = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($perm);
$stmt->fetch();
$stmt->close();
// om perm er lavere en 1 gå tiøbake til hovedsiden
if($perm <= 0) {
    header('Location: ../');
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>deg</title>
	<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<div class="banner">
			<img src="../piggy-banner.gif" alt="Piggy Website" width="650" height="100">
		</div>
		<div>
            <h1>sugestions</h1>
            <h3>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
                if (isset($_POST['approve'])) {
                    $suggestionId = $_POST['suggestion_id'];

                    $stmt = $con->prepare('INSERT INTO `facts` (`fact`) SELECT `fact` FROM `sugestions` WHERE `sugestion-id` = ?');
                    $stmt->bind_param('i', $suggestionId);
                    $stmt->execute();
                    $stmt->close();

                    $stmt2 = $con->prepare('UPDATE `sugestions` SET `approved`="1" WHERE `sugestion-id` = ?');
                    $stmt2->bind_param('i', $suggestionId);
                    $stmt2->execute();
                    $stmt2->close();
                    
                    echo 'Suggestion ID: ' . $suggestionId . ' has been approved!';
                    echo '<br>';
                } elseif (isset($_POST['deny'])) {
                    $suggestionId = $_POST['suggestion_id'];

                    $stmt = $con->prepare('UPDATE `sugestions` SET `approved`="-1" WHERE `sugestion-id` = ?');
                    $stmt->bind_param('i', $suggestionId);
                    $stmt->execute();
                    $stmt->close();
                    
                    echo 'Suggestion ID: ' . $suggestionId . ' has been denied.';
                    echo '<br>';
                }
            }
            ?>
            </h3>

            <?php
            $stmt = $con->prepare('SELECT `sugestion-id`, `sugested_by`, `fact`, `submition-time` FROM `sugestions` WHERE `approved` = 0');
            $stmt->execute();
            $stmt->bind_result($sugestionId, $sugestedBy, $fact, $submitionTime);
            
            while ($stmt->fetch()) {
                // vis foreslagende
                echo '<p>Suggested By: ' . $sugestedBy . '</p>';
                echo '<p>Fact: ' . $fact . '</p>';
                echo '<p>Submission Time: ' . $submitionTime . '</p>';

                echo '<form action="" method="post">';
                echo '<input type="hidden" name="suggestion_id" value="' . $sugestionId . '">';
                echo '<input type="submit" name="approve" value="Approve">';
                echo '<input type="submit" name="deny" value="Deny">';
                echo '</form>';

                echo '<br>';
            }
            
            $stmt->close();
            ?>
		</div>
	</div> 
</body>

</html>