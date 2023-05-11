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
			<h1>login</h1>
			<form method="post" action="auth/authenticate.php">
				<label for="username">Username:</label><br>
				<input type="text" id="username" name="username" required><br>

				<label for="password">Password:</label><br>
				<input type="password" id="password" name="password" required><br><br>

				<input type="submit" value="Login">
			</form><br>
			<a href="register.php">no account?</a><br>
			<footer>
                <small>&copy; 2023 Piggame. No Rights Reserved.</small>
            </footer>
		</div>
	</div> 
</body>
</html>