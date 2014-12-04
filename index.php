<!DOCTYPE HTML>
<html>
	<head>
		<link rel = 'stylesheet' type = 'text/css' href ='css/base.css'>
		<meta charset="utf-8">
	</head>
	<body>
<?php
include "setup.php";
$_connection = mysqli_connect($_host,$_uName,$_pwd, $_db) or die("Failed to connect to MySQL: " . mysqli_connect_error()); #Connect 
	?>
		<nav>
			<div id = "links">
				<a href = "/home">Home</a>
				<a href = "/projects">Projects</a>
				<a href = "/archive">Archive</a>
				<a href = "/about">About</a>
			</div>
<?php if(isset($user)) echo "<div id = 'loggedin'>Welcome, ".$user->getName()."! <a href='".$GLOBALS["home"]."/logout.php'>Log out</a></div>"; ?>
		</nav>
		<div id = "content">
<?php 
Article::printNewest($_connection); ?>
		</div>
<?php 
Article::newArticle($_connection);
$_connection->close();
?>
	</body>
</html>