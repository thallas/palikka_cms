<script src="ckeditor/ckeditor.js"></script>

<?php
	/**
	 * @author Touko Hallasmaa hallasmaa.touko@gmail.com>
	 * @copyright 2014 Touko Hallasmaa
	 * @license
	 */
	include "init.php";
	 
	
	class Article{
		private $_id; #unique
		private $_title;
		private $_content;
	
		public function __construct() {
		
		}
		public function __destruct() {
		
		}
		
		public static function newArticle($_connection, $adminOnly = true){
			if(!$adminOnly || (isset($_SESSION['user']) && User::userExistsByName($_SESSION['user'], $_connection))){
				echo "<div id='newarticle'><form action='".$GLOBALS["home"]."/newarticle.php' method = 'post'>
						<h3>Write an article</h3>
						<input name = 'title' type='text' placeholder='Title' required>
							<textarea name='text' id='text' rows='10' cols='80'>
						</textarea>
						<script>
							CKEDITOR.replace( 'text' );
						</script>
						<input type='submit'>
					</form></div>
				";
			}
		}
		
		public static function printNewest($_connection, $startFrom = 0, $amount = 10){
			$stmt = $_connection->prepare("SELECT title, content, added FROM article ORDER BY added DESC LIMIT ?,?");
			$stmt->bind_param('dd', $startFrom, $amount);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				echo "<div class='article'><h3>".$row["title"]."</h3>".$row["content"]."<div id='date'>".$row["added"]."</div></div>";
			}
		}
	}
	
	class Tag{
		
		public function __construct() {
		
		}
		public function __destruct() {
		
		}
	}
	
	class Page{
		private $_id;
		private $_name;
		private $_address;
	}
	
	class User{
		private $_userName;
		private $_email;
		private $_joinDate; #Null if user not validated
		
		public function __construct($userName, $_connection) {
			$stmt = $_connection->prepare("SELECT * FROM user WHERE name = ?");
			$this->_userName 	= $userName;
		}
		
		public function __destruct() {
		
		}
		
		public function getId(){
			return $this->_id;
		}
		
		public function getName(){
			return $this->_userName;
		}
		
		public static function createUser($userName, $_connection){
			$instance = new self($userName, $_connection );
			$stmt = $_connection->prepare("SELECT * FROM user WHERE name = ?");
			$stmt->bind_param('s', $userName);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				$instance->_email = $row['email'];
				return $instance;
			}
			echo "Username doesn't exist in the database.";
			return false;
		}
		
		public static function generatePassword($input, $rounds = 10){
			$crypt_options = array(
			  'cost' => $rounds
			);
			return password_hash($input, PASSWORD_BCRYPT, $crypt_options);
		}
		
		public function generateSession($pwd, $_connection){
			if($this->validate($pwd, $_connection)){
				$_SESSION['user'] = $this->_userName;
				return true;
			}else{
				echo "Wrong username or password.";
				return false;
			}
		}
		
		public static function destroySession($_connection){
			unset($_SESSION['user']);
		}
		
		private function validate($pwd, $_connection){
			$stmt = $_connection->prepare("SELECT password FROM user WHERE name = ?");
			$stmt->bind_param('s', $this->_userName);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				if(password_verify($pwd, $row['password'])) {
					return true;
				}
			}
			return false;
		}
		public static function userExistsByName($name, $_connection){
			$stmt = $_connection->prepare("SELECT name FROM user WHERE name = ?");
			$stmt->bind_param('s', $name);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				return true;
			}
			return false;
		}
	}
?>