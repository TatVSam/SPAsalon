<?php
session_start();

$_SESSION["DOB"] = $_POST['DOB'];
header("Location: index_2.php"); 

?>