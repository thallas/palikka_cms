<?php 
session_start();
include "setup.php";
if(isset($_SESSION['user']))
	User::destroySession();	
header("Location: ".$GLOBALS['home']);
?>