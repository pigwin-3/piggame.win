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
                $fact = filter_input(INPUT_POST, 'fact', FILTER_SANITIZE_STRING);
                $suggestion_id = filter_input(INPUT_POST, 'suggestion_id', FILTER_SANITIZE_NUMBER_INT);
                
                // opdater fakta
                $stmt = $con->prepare('UPDATE `facts` SET `fact` = ? WHERE `id` = ?');
                $stmt->bind_param('si', $fact, $suggestion_id);
                $stmt->execute();
                echo "edited fact $suggestion_id";
            }
            ?>
            </h3>
            <?php
            $stmt = $con->prepare('SELECT `id`, `fact`, `last-used` FROM `facts` WHERE 1');
            $stmt->execute();
            $stmt->bind_result($id, $fact, $lastused);
            
            echo '<table>';
            echo '<tr>';
            echo '<td>ID </td>';
            echo '<td>last used </td>';
            echo '<td>facts </td>';
            echo '</tr>';
            
            while ($stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $lastused . '</td>';
                echo '<td>';
                echo '<form action="" method="post">';
                echo '<textarea name="fact" rows="4" cols="50">' . $fact . '</textarea>';
                echo '<input type="hidden" name="suggestion_id" value="' . $id . '">';
                echo '<input type="submit" value="edit">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</table>';
            
            $stmt->close();
            ?>
		</div>
	</div> 
</body>

</html>