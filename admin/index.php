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
	<title>admin</title>
	<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<div class="banner">
			<img src="../piggy-banner.gif" alt="Piggy Website" width="650" height="100">
		</div>
		<div>
            <h1>admin page</h1>
            <a href="settings.php">instilinger</a><br>
            <a href="suggestions.php">fakta foreslåninger</a><br>
            <a href="facts.php">fakta</a>
		</div>
	</div> 
</body>

</html>