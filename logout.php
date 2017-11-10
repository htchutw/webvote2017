<?php
//admin
session_start();
unset($_SESSION['authenticated']);
unset($_SESSION['SID']);
unset($_SESSION['SClass']);
$redir = "login.php";
header("Location: $redir");
?>
