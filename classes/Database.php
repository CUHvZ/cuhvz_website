<?php

if (!defined('DBHOST')) {
	define('DBHOST','localhost');
}
if (!defined('DBUSER')) {
	define('DBUSER','cuhvmiwg');
}
if (!defined('DBPASS')) {
	define('DBPASS','Yummybrainz!2');
}
if (!defined('DBNAME')) {
	define('DBNAME','cuhvmiwg_hvz');
}

class Database {

	private $db;
	private $showErrors;

	function __construct(){
		try {
			//create PDO connection
			$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch(PDOException $e) {
			//show error
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		    exit;
		}
		$this->db = $db;
		$this->showErrors = true;
	}

	public function suppressErrors(){
		$this->showErrors = false;
	}

	public function showErrors(){
		$this->showErrors = true;
	}

	public function getUserData($userID){
		$query = "SELECT user_stats.*, users.* FROM user_stats INNER JOIN users ON user_stats.id = users.id where users.id = $userID;";
		$data = self::executeQueryFetch($query);
		return $data;
	}

	public function getUserDataByEmail($userEmail){
		$query = "SELECT user_stats.*, users.* FROM user_stats INNER JOIN users ON user_stats.id = users.id where users.email = '$userEmail';";
		$data = self::executeQueryFetch($query);
		return $data;
	}

	public function joinWithUsers($table, $key, $condition=null){
		$query = "SELECT $table.*, users.* FROM $table INNER JOIN users ON $table.$key=users.id";
		if($condition != null){
			$query = $query." where ".$condition;
		}
		$data = self::executeQueryFetchAll($query);
    // if only one result, return result instead of array
    if(sizeof($data) == 1)
      return $data[0];
		return $data;
	}

	public function insert($table, $fields, $values){
		//$fields = implode(", ",$fieldsArray);
		//$values = implode(", ",$valuesArray);
    $query = "INSERT INTO $table ($fields) VALUES ($values);";
		// error_log($query, 0);
		return self::executeQuery($query);
  }

  public function update($table, $set, $condition){
    $query = "UPDATE $table SET $set WHERE $condition;";
		// error_log($query, 0);
		return self::executeQuery($query);
  }

  public function delete($table, $condition){
    $query = "DELETE FROM $table WHERE $condition";
		return self::executeQuery($query);
  }

	public function createWeeklong($semester, $title, $displayDates, $startDate, $endDate){
		$createWeeklongEntryQuery = "INSERT INTO weeklongs (name, title, display_dates, start_date, end_date) VALUES
		('weeklong".$semester."', '$title', '$displayDates', '$startDate', '$endDate');";

		$createWeeklongTableQuery = "CREATE TABLE IF NOT EXISTS weeklong".$semester." (
		  user_id int(11) NOT NULL,
		  status varchar(255) NOT NULL DEFAULT 'human',
		  username varchar(255) NOT NULL,
		  status_type varchar(255),
		  user_hex varchar(5) NOT NULL,
		  points int(5) DEFAULT '0',
		  kill_count varchar(5) NOT NULL DEFAULT 0,
		  starve_date timestamp NULL DEFAULT NULL,
		  time_joined timestamp DEFAULT CURRENT_TIMESTAMP,
		  registered boolean DEFAULT false,
		  starve_timer int(20) DEFAULT NULL,
		  waiver boolean DEFAULT false,
		  bandanna boolean DEFAULT false,
		  PRIMARY KEY (user_id),
		  UNIQUE KEY user_id ( user_id )
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;";

		$createWeeklongCodesTableQuery = "CREATE TABLE if not exists weeklong".$semester."_codes (
			id int(11) NOT NULL AUTO_INCREMENT ,
			name varchar(30) NOT NULL ,
			hex varchar(30) NOT NULL ,
			effect varchar(30) NOT NULL ,
			side_effect varchar(50),
			location_id varchar(255),
			single_use boolean DEFAULT True ,
			num_uses int(11) DEFAULT 1 ,
			expiration varchar(255),
			PRIMARY KEY ( id ) ,
			UNIQUE KEY id ( id ) );";

			$this->executeQuery($createWeeklongEntryQuery);
			$this->executeQuery($createWeeklongTableQuery);
			$this->executeQuery($createWeeklongCodesTableQuery);
	}

	public function executeQueryFetchAll($query){
		// error_log($query, 0);
		try {
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$data = $stmt->fetchAll();
			return $data;
		} catch(PDOException $e) {
			if($this->showErrors){
				error_log("Error executing: $query", 0);
				error_log($e, 0);
			}
      return array("error" => $e);
		}
	}

	public function executeQueryFetch($query){
		try {
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$data = $stmt->fetch();
			return $data;
		} catch(PDOException $e) {
			if($this->showErrors){
				error_log("Error executing: $query", 0);
				error_log($e, 0);
			}
      return array("error" => $e);
		}
	}

	public function executeQuery($query){
		// error_log($query, 0);
		try {
			$stmt = $this->db->prepare($query);
			$stmt->execute();
		} catch(PDOException $e) {
			if($this->showErrors){
				error_log("Error executing: $query", 0);
				error_log($e, 0);
			}
      return array("error" => $e);
		}
	}

	public function executeQueryCount($query){
		// error_log($query, 0);
		try {
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$data = $stmt->fetch();
			return $data[0];
		} catch(PDOException $e) {
			if($this->showErrors){
				error_log("Error executing: $query", 0);
				error_log($e, 0);
			}
      return array("error" => $e);
		}
	}

	public function lastInsertId(){
		try {
			return $this->db->lastInsertId('id');
		} catch(PDOException $e) {
			if($this->showErrors){
				error_log($e, 0);
			}
      return array("error" => $e);
		}
	}

	public function isTokenExpired($tokenID){
		$query = "select * from tokens where id=$tokenID";
		$data = self::executeQueryFetch($query);
		$expire = $data["expiration"];
		$tokenExpired = time() > strtotime($expire);
		if($tokenExpired){
			error_log("token has expired so delete it", 0);
			self::delete("tokens", "id=$tokenID");
			return true;
		}
		return false;
	}

	public function deleteDuplicateTokens($userID, $tokenType){
		$query = "select * from tokens where user_id=$userID and token_type='$tokenType'";
		$data = self::executeQueryFetchAll($query);
		$count = sizeof($data);
		if($count == 1){
			$tokenID = $data[0]["id"];
			self::delete("tokens", "id=$tokenID");
		}else if($count > 1){
			// delete all tokens if multiple of same token exist
			foreach ($data as $entry) {
				$id = $entry["id"];
				self::delete("tokens", "id=$id");
			}
		}
	}
}


/*
private function buildConditions($conditions){
	$whereClause = " where";
	if(sizeof($data) == 1){
		foreach ($conditions as $key => $value) {
				return " where $key=$value";
		}
	}
}

private function buildMultipleConditions($conditions){
	$whereClause = " where";

	foreach ($conditions as $key => $value) {

	}
}
*/

// Putting this on hold
/*
class Condition {

  public static $AND = "AND";
  public static $OR = "OR";

	private $key, $value;
  private $prev = null, $next = null, $case = null;

	function __construct($key, $value){
		$this->key = $key;
    $this->value = $value;
	}

  public function __toString(){
    if($next != null){
      return ((string)$this).((string)$prev);
    }
    return "$this->key=$this->value";
  }

  public function and($conditional){
    if($next != null){

    }
    $this->next = $conditional;
    $conditional->prev = $this;
    $this->case = Condition::$AND;
  }

  public function or($conditional){
    $this->next = $conditional;
    $conditional->prev = $this;
    $this->case = Condition::$OR;
  }
}
*/
?>
