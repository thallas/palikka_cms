<?php
	include "init.php";
	
	$_connection = mysqli_connect($_host,$_uName,$_pwd) or die("Failed to connect to MySQL: " . mysqli_connect_error()); #Connect 
	
	mysqli_query($_connection,"SET character_set_results=utf8"); 
    mb_language('uni'); 
    mb_internal_encoding('UTF-8');
	
	mysqli_query($_connection,"CREATE DATABASE IF NOT EXISTS $_db DEFAULT CHARACTER SET utf8 COLLATE utf8_swedish_ci"); #Create database to select afterwards
	mysqli_select_db($_connection,$_db);
    mysqli_query($_connection,"set names 'utf8'");
	
	//Creating necessary tables for cms
	mysqli_query($_connection,"CREATE TABLE IF NOT EXISTS 'user' (
	'id' int(11) NOT NULL AUTO_INCREMENT,
	'name' varchar(32) COLLATE utf8_swedish_ci NOT NULL,
	'email' varchar(64) COLLATE utf8_swedish_ci NOT NULL,
	'password' varchar(128) COLLATE utf8_swedish_ci NOT NULL,
	PRIMARY KEY ('id')
	)");
	
	mysqli_query($_connection,"CREATE TABLE IF NOT EXISTS 'page' (
	'id' int(11) NOT NULL AUTO_INCREMENT,
	'name' varchar(32) COLLATE utf8_swedish_ci NOT NULL,
	'address' varchar(128) COLLATE utf8_swedish_ci NOT NULL,
	PRIMARY KEY ('id')
	)");
	
	mysqli_query($_connection,"CREATE TABLE IF NOT EXISTS 'menu' (
	'id' int(11) NOT NULL AUTO_INCREMENT,
	'name' varchar(32) COLLATE utf8_swedish_ci NOT NULL,
	PRIMARY KEY ('id')
	)");
	
	mysqli_query($_connection,"CREATE TABLE IF NOT EXISTS 'pagemenuref' (
	'idpage' int(11) NOT NULL,
	'idmenu' int(11) NOT NULL,
	PRIMARY KEY ('idpage', 'idmenu')
	)");
	
	mysqli_query($_connection,"CREATE TABLE IF NOT EXISTS 'article' (
	'id' int(11) NOT NULL AUTO_INCREMENT,
	'title' varchar(32) COLLATE utf8_swedish_ci NOT NULL,
	'content' text COLLATE utf8_swedish_ci NOT NULL,
	'commenting' int(1) NOT NULL DEFAULT '0',
	'added' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY ('id')
	)");
	
	mysqli_query($_connection,"CREATE TABLE IF NOT EXISTS 'tag' (
	'id' int(11) NOT NULL AUTO_INCREMENT,
	'name' varchar(32) COLLATE utf8_swedish_ci NOT NULL,
	PRIMARY KEY ('id')
	)");
	
	mysqli_query($_connection,"CREATE TABLE IF NOT EXISTS 'articletagref' (
	'idarticle' int(11) NOT NULL,
	'idtag' int(11) NOT NULL,
	PRIMARY KEY ('idarticle', 'idtag')
	)");
	
	mysqli_query($_connection,"CREATE TABLE IF NOT EXISTS 'authoarticleref' (
	'idarticle' int(11) NOT NULL,
	'idauthor' int(11) NOT NULL,
	PRIMARY KEY ('idauthor', 'idtag')
	)");
	
	include "base_classes.php";
	
	//create user if logged in
	session_start();
	if(isset($_SESSION['user']))
		$user = User::createUser($_SESSION['user'], $_connection);
	$_connection->close();
?>