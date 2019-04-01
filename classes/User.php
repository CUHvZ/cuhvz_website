<?php
include('password.php');
// include('Database.php');
class User extends Password{

    private $_db;
    private $id;

    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }

	private function get_user_hash($username){

		try {
      // 'SELECT * FROM users WHERE (username = :username OR email = :username ) AND activated="Yes";'
			$stmt = $this->_db->prepare('SELECT * FROM users WHERE (username = :username OR email = :username );');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function get_user_username($id){
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
		    $_SESSION['name'] = $row['first_name'];
		    $_SESSION['username'] = $row['username'];
		    $_SESSION['email'] = $row['email'];
		    $_SESSION['id'] = $row['id'];
        $this->id = $row['id'];
		    return true;
		}
    return false;
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
      // error_log("checking if admin for id ".$_SESSION['id']." : ".$row["admin"], 0);
			return $row["admin"];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

  public function is_activated(){
    $database = new Database();
    $userID = $_SESSION['id'];
    if(!$userID)
      $userID = $this->id;
    //$data = $database->executeQueryFetchAll("select activated from users where id=".$_SESSION['id']);
    $data = $database->getUserData($userID);
    //error_log( print_r($data, TRUE) );
    return $data["activated"];
	}

  public function activateAccount(){
  	$database = new Database();
    $userID = $_SESSION['id'];
    if(!$userID)
      $userID = $this->id;
  	$result = $database->update("user_stats", "activated = true", "id = $userID");
  	$database->delete("tokens", "user_id = $userID AND token_type = 'ACTIVATION'");
  	return $result;
  }

	// this will add a user that is signed in to the event
	public function join_event($event){
		$user_hex = substr(md5(uniqid(rand(),'')),0,5);
		try{
			$stmt = $this->_db->prepare('INSERT INTO '.$event.' (user_id,username, user_hex) VALUES (:user_id, :username, :user_hex)');
			$stmt->execute(array(
				':user_id' => $_SESSION['id'],
				':username' => $_SESSION['username'],
				':user_hex' => $user_hex ));
			return true;
		}catch(PDOException $e) {
			$errorMessage = $e->getMessage();
			if (!strpos($errorMessage, 'Duplicate entry')) { // this will throw out the duplicate error
			    echo '<p class="bg-danger" style="margin: 0;">'.$errorMessage.'</p>';
			    echo "<p class='bg-danger' style='margin: 0;'> &#10003; <strong>Something went wrong tring to sign up for $event!</strong> <br> Try logging out and logging back in. Contact the mod team if this problem continues.</p>";
			}
		    return false;
		}
	}

	// this will remove a user that is signed from an event
	public function leave_event($event){
		if(!$this->is_in_event($event)){
			return false;
		}
		try{
			$stmt = $this->_db->prepare('DELETE FROM '.$event.' WHERE user_id=:user_id');
			$stmt->execute(array(
				':user_id' => $_SESSION['id'] ));
			return true;
		}catch(PDOException $e) {
			echo '<p class="bg-danger" style="margin: 0;">'.$e->getMessage().'</p>';
		    return false;
		}
	}

	public function is_in_event($event){
		try {
			$stmt = $this->_db->prepare('SELECT COUNT(*) FROM '.$event.' WHERE user_id=:id;');
			$stmt->execute(array('id' => $_SESSION['id'] ));
			$row = $stmt->fetch();
			return $row[0];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function get_game_stats(){
		try {
			$stmt = $this->_db->prepare("SELECT * FROM ".$_SESSION["weeklong"]." WHERE user_id=:id;");
			$stmt->execute(array('id' => $_SESSION['id']));
			$row = $stmt->fetch();
			$game_stats = array("user_hex"=>$row["user_hex"], "status"=>$row["status"], "kill_count"=>$row["kill_count"], "starve_date"=>$row["starve_date"]);
			return $game_stats;
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function kys(){
		try {
			$stmt = $this->_db->prepare("UPDATE ".$_SESSION["weeklong"]." SET status='zombie(suicide)' WHERE user_id=:id;");
			$stmt->execute(array('id' => $_SESSION['id']));
			$current_time = new DateTime(date('Y-m-d H:i:s'));
	    	$starve_date = date_add($current_time, date_interval_create_from_date_string('2 days'));
	    	$new_starve = $starve_date->format('Y-m-d H:i:s');
	    	$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET starve_date=:new_starve WHERE user_id=:id;");
    		$stmt->execute(array(
    			':new_starve' => $new_starve,
    			':id' => $_SESSION['id']));
			return true;
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		    return false;
		}
	}

  public function make_activation_email(){
    $row = $this->get_user_hash($username);
    $to = $row["email"];
    $id = $row["id"];
    $activasion = $row["activated"];
    $subject = "CU Boulder HvZ Registration Confirmation";
    $body = "<p>Thank you for registering to play Humans vs Zombies at CU Boulder.</p>
    <p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
    <p>- CU BOULDER HVZ TEAM</p>";

    $mail = new Mail();
    $mail->setFrom(SITEEMAIL);
    $mail->addAddress($to);
    $mail->subject($subject);
    $mail->body($body);
    return $mail;
  }
}


?>
