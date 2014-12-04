<!DOCTYPE HTML>
<html>
	<head>
		<link rel = 'stylesheet' type = 'text/css' href ='css/reset.css'>
		<meta charset="utf-8">
	</head>
	<body>
<?php 
include "setup.php";
if(isset($_SESSION['user']))
	header("Location: $_home");
if(isset($_POST["uname"])){
	$_connection = mysqli_connect($_host,$_uName,$_pwd, $_db) or die("Failed to connect to MySQL: " . mysqli_connect_error()); #Connect 
	$usr = User::createUser($_POST["uname"], $_connection );
	if($usr) 
		if($usr->generateSession($_POST["password"], $_connection))
			header("Location:". $GLOBALS['home']);
	$_connection->close();
	unset($_connection);
	
}else{
?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "post">
			<input name = "uname" type="text" placeholder="Username" required>
			<input name = "password" type="password" placeholder="password" required>
			<input type="submit" value="Log in">
		</form>
<?php } ?>
	</body>
</html>