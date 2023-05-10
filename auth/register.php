<?php
require '../config.php';

// Sjekker om dataene ble sendt
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	exit('Vennligst fyll ut registreringsskjemaet!');
}

// Sjekker om registreringsverdiene er tomme
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	exit('Vennligst fyll ut registreringsskjemaet!');
}

// Sjekker om e-postadressen er gyldig
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('E-postadressen er ikke gyldig!');
}

// Sjekker om brukernavnet er gyldig
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Brukernavnet er ikke gyldig!');
}

// Sjekker om passordene matcher
if ($_POST["password"] != $_POST["password2"]) {
    exit('Passordene stemmer ikke overens!');
}

// Sjekker om passordet har riktig lengde
if (strlen($_POST['password']) > 64 || strlen($_POST['password']) < 5) {
	exit('Passordet må være mellom 5 og 64 tegn langt!');
}

// Sjekker om brukernavnet allerede eksisterer
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		echo 'Brukernavnet eksisterer allerede, vennligst velg et annet!';
	} else {
		// Oppretter en ny konto
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
            // Hasher passordet før det lagres i databasen
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$uniqid = uniqid(true);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
			echo 'Du har blitt registrert, du kan nå logge inn!';
			// gjør slik at denne går videre til loginsiden etterhvert!
			//header('Location: ../loginsiden.php');
        } else {
            echo 'Noe gikk galt!';
        }
	}
	$stmt->close();
} else {
	echo 'Noe gikk galt!';
}
$con->close();
?>
