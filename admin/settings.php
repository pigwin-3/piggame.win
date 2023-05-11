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
	<title>settings</title>
	<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<div class="banner">
			<img src="../piggy-banner.gif" alt="Piggy Website" width="650" height="100">
		</div>
		<div>
            <h1>settings</h1>
            <a href="index.php">back</a>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // henter post daten
                $submittedSettings = $_POST;

                // fjerener tomme submits (noe det mest sansynelig aldri komer til å skje)
                unset($submittedSettings['submit']);

                // går gjennom alle instilinger og opdaterer den
                foreach ($submittedSettings as $settingName => $settingValue) {
                    $stmt = $con->prepare('UPDATE `settings` SET `setting-value` = ? WHERE `setting-name` = ?');
                    $stmt->bind_param('ss', $settingValue, $settingName);
                    $stmt->execute();
                    $stmt->close();
                }

                // si i fra om at instilingene er lagret
                echo '<p>Settings saved</p>';
            }
            ?>

            <form action="" method="post">
                <?php
                $stmt = $con->prepare('SELECT `setting-name`, `setting-value` FROM `settings` WHERE 1');
                $stmt->execute();
                $stmt->bind_result($settingName, $settingValue);
                
                while ($stmt->fetch()) {
                    echo '<p>' . $settingName . '</p>';
                    echo '<input type="number" name="' . $settingName . '" id="' . $settingName . '" value="' . $settingValue . '" maxlength="9"><br>';
                }
                
                $stmt->close();
                ?>
                <br>
                <input type="submit" value="save">
            </form>
		</div>
	</div> 
</body>

</html>