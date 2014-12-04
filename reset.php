<!DOCTYPE HTML>
<html>
	<head>
		<link rel = 'stylesheet' type = 'text/css' href ='css/reset.css'>
		<meta charset="utf-8">
	</head>
	<body>
<?php 
if(isset($_POST["uname"])){
	include "setup.php";
	$_connection = mysqli_connect($_host,$_uName,$_pwd, $_db) or die("Failed to connect to MySQL: " . mysqli_connect_error()); #Connect 
	mysqli_query($_connection,"DROP DATABASE IF EXISTS $_db"); #Drop old db
	$_connection->close();
	unset($_connection);
	
	
	$_connection = mysqli_connect($_host,$_uName,$_pwd, $_db) or die("Failed to connect to MySQL: " . mysqli_connect_error()); #Connect  
	//create admin user
	$stmt = $_connection->prepare("INSERT INTO user  (name, email, password) VALUES (?,?,?)");
	$pwd =  User::generatePassword($_POST['password']);
	$stmt->bind_param('sss', $_POST['uname'], $_POST['email'], $pwd);
	$stmt->execute();
	//create main menu
	$stmt = $_connection->prepare("INSERT INTO menu  (name) VALUES (?)");
	$stmt->bind_param('s', 'main');
	$stmt->execute();
	//homepage
	$stmt = $_connection->prepare("INSERT INTO page  (name, address) VALUES (?, ?)");
	$stmt->bind_param('ss', 'Home', $_home);
	$stmt->execute();
	$_connection->close();
}else{
	include "setup.php";
?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "post">
			<p>
				Setting up the cms. Please start by providing information for admin user. You will be able to add additional information later.
			</p>
			<p>
				<b>Operation will flush old database of its contents.</b>
			</p>
			<input name = "uname" type="text" placeholder="Username" required>
			<input name = "password" type="password" placeholder="password" required>
			<input name = "email" type="email" placeholder="email" required>
			<input type="submit">
		</form>
<?php } ?>
	</body>
</html>