<?php
session_start();
session_destroy();

// tilbake til hovedsiden
header('Location: ../index.php');
?>
