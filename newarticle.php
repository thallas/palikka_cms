<?php 
include "setup.php";
$_connection = mysqli_connect($_host,$_uName,$_pwd, $_db) or die("Failed to connect to MySQL: " . mysqli_connect_error()); #Connect  
if((isset($_SESSION['user']) && User::userExistsByName($_SESSION['user'], $_connection))){
	$stmt = $_connection->prepare("INSERT INTO article (title, content) VALUES (?,?)");
	$stmt->bind_param('ss', $_POST['title'], $_POST['text']);
	$stmt->execute();
}
$_connection->close();
header("Location: ".$GLOBALS['home']);
?>