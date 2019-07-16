<?php
session_start();
$_SESSION["id"] = "";
$_SESSION["name"] = "";
$_SESSION["username"] = "";
$_SESSION["email"] = "";
$_SESSION["role"] = "";
session_destroy();

header("Location: login.php?status=Logged out!");

?>