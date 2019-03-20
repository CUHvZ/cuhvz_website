<?php
class Token {

  private $userID, $value, $type;

  public static $ACTIVATE = 'ACTIVATION';
  public static $PASS_RESET = 'PASS_RESET';

	function __construct($userID, $type){
		$this->userID = $userID;
    $this->type = $type;
    $this->value = $token = md5(uniqid(rand(),true));
	}

  public function setType($type){
    $this->type = $type;
  }

  public function getID(){
    return $this->userID;
  }

  public function getType(){
    return $this->type;
  }

  public function getValue(){
    return $this->value;
  }

  public function getQuery(){
    $userID = $this->userID;
    $value = $this->value;
    $type = $this->type;
    return "INSERT INTO tokens (user_id, token, token_type, expiration) VALUES ($userID, '$value', '$type', NOW() + INTERVAL 1 DAY);";
  }

  public function toString(){
    $userID = $this->userID;
    $value = $this->value;
    $type = $this->type;
    return "$userID, $value, $type";
  }
}
?>
