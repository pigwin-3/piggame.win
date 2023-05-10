<?php
// Må legge til sjekk for om kontoen er aktivert eller ikke

session_start();
require '../config.php';

// Sjekker om dataene er tilstede
if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please fill both the username and password fields!');
}

// Henter data fra databasen
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    // Sjekker om det er flere rader med data
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        // Kontoen eksisterer, nå verifiserer vi passordet
        if (password_verify($_POST['password'], $password)) {
            // Passordet er riktig
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: ../index.php');
        } else {
            // Feil passord
            echo 'Incorrect username and/or password!';
        }
    } else {
        // Ingen treff i databasen
        echo 'Incorrect username and/or password!';
    }

    $stmt->close();
}
?>
