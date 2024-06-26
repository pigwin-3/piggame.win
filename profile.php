<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

require 'config.php';
$stmt = $con->prepare('SELECT email, perm, created FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($email, $permistion, $created);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>you</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<div class="banner">
			<img src="piggy-banner.gif" alt="Piggy Website" width="650" height="100">
		</div>
		<div class="sidebar">
			<h3>Useless Sidebar</h3>
			<ul>
				<li><a href="index.php">home</a></li>
				<li><a href="fun-facts.php">fun facts</a></li>
				<li><a href="pig-movies.php">pig movies</a></li>
				<li><a href="link-3.php">Link 3</a></li>
				<li><a href="profile.php">profile</a></li>
			</ul>
			<div class="useless">
				<h3>Fun fact of every day:</h3>
				<p>Did you know that pigs can get sunburned? That's why some farmers in the Bahamas put sunscreen on their pigs to keep them from getting too crispy!.</p>
			</div>
            <!-- get a hits counter for this site to <a href="https://hits.seeyoufarm.com"><img src="https://hits.seeyoufarm.com/api/count/incr/badge.svg?url=https%3A%2F%2Fpiggame.win&count_bg=%2379C83D&title_bg=%23555555&icon=&icon_color=%23E7E7E7&title=hits&edge_flat=false"/></a> -->
		</div>
		<div class="content">
			<h1>profile</h1>
			<p>name: <?=$_SESSION['name']?></p>
			<p>email: <?=$email?></p>
			<p>permsitionlevel: <?=$permistion?></p>
			<p>created: <?=$created?> (yyyy/mm/dd)</p>
			<a href="auth/logout.php">log out</a>
			<br>
			<?php
			if($permistion >= 1) {
				echo '<a href="admin/">admin page</a>';
			}
			?>
			<br>
			<a href="suggest.php">suggest fun fact of the day</a>
			<footer>
                <small>&copy; 2023 Piggame. No Rights Reserved.</small>
            </footer>
		</div>
	</div> 
</body>
</html>