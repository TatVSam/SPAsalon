<?php
session_start();
$_SESSION["date_is_set"] = true;

$_SESSION["DOB"] = $_POST['DOB'];
header("Location: index.php"); 

?>