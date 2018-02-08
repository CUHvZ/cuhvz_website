<?php
include('password.php');
class User extends Password{

    private $_db;

    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }

	private function get_user_hash($username){

		try {
			$stmt = $this->_db->prepare('SELECT password, id FROM users WHERE (username = :username OR email = :username ) AND activated="Yes";');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	private function get_user_username($id){
		try {
			$stmt = $this->_db->prepare('SELECT username FROM users WHERE id=:id;');
			$stmt->execute(array('id' => $id));
			$row = $stmt->fetch();
			return $row["username"];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function login($username,$password){

		$row = $this->get_user_hash($username);
		$username = $this->get_user_username($row['id']);
		if($this->password_verify($password,$row['password']) == 1){
		    $_SESSION['loggedin'] = true;
		    $_SESSION['username'] = $username;
		    $_SESSION['id'] = $row['id'];
		    return true;
		}
	}

	public function logout(){
		session_destroy();
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

	// This will return true if the user is an admin
	public function is_admin(){
		try {
			$stmt = $this->_db->prepare('SELECT admin FROM users WHERE id=:id;');
			$stmt->execute(array('id' => $_SESSION['id']));
			$row = $stmt->fetch();
			return $row["admin"];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

}


?>
