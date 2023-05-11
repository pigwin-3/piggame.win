<?php
session_start();

require 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>deg</title>
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
				<li><a href="#">home</a></li>
				<li><a href="fun-facts.html">fun facts</a></li>
				<li><a href="pig-movies.html">pig movies</a></li>
				<li><a href="link-3.html">Link 3</a></li>
			</ul>
			<div class="useless">
				<h3>Fun fact of every day:</h3>
				<p>Did you know that pigs can get sunburned? That's why some farmers in the Bahamas put sunscreen on their pigs to keep them from getting too crispy!.</p>
			</div>
            <!-- get a hits counter for this site to <a href="https://hits.seeyoufarm.com"><img src="https://hits.seeyoufarm.com/api/count/incr/badge.svg?url=https%3A%2F%2Fpiggame.win&count_bg=%2379C83D&title_bg=%23555555&icon=&icon_color=%23E7E7E7&title=hits&edge_flat=false"/></a> -->
		</div>
		<div class="content">
			<h1>suggest a new fun fact here:</h1>
            <form action="" method="post">
                <input type="text" name="fact" id="fact">
                <input type="submit" value="submit">
            </form>
            <?php
			if (isset($_SESSION['loggedin'])) {
				if( isset($_POST['fact']) ) {
					echo $_POST['fact'];
					echo "<br>";
					echo $_SESSION['id'];
					$stmt = $con->prepare("INSERT INTO `sugestions`(`sugested_by`, `fact`) VALUES (?,?)");

					// forebygger injection
					$fact = mysqli_real_escape_string($con, htmlspecialchars($_POST['fact']));

					// putter in parameterne inn i stmt
					$stmt->bind_param("ss", $_SESSION['id'], $fact);

					// kjører komandoen
					$stmt->execute();

					// Lukker koblingen til databasen
					$stmt->close();
					mysqli_close($con);
				}
			}
			else {
				echo "<h2>log in to sugest facts!</h2>";
			}
            ?>
		</div>
	</div> 
</body>

</html>