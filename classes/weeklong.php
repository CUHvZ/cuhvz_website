<?php
class Weeklong{

    private $_db;

    function __construct($db){
    	$this->_db = $db;
    }

    public function set_variables(){
    	try {
			$stmt = $this->_db->prepare('SELECT * FROM current_weeklong LIMIT 1');
			$stmt->execute(array());
			$row = $stmt->fetch();
			$_SESSION["weeklong"] = $row["name"];
			$_SESSION["weeklong_dates"] = $row["display_dates"];
			$_SESSION["start_date"] = $row["start_date"];
			$_SESSION["end_date"] = $row["end_date"];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
    }

	// This will return true if the user is an admin
	public function is_active(){
		try {
			$stmt = $this->_db->prepare("SELECT active FROM current_weeklong LIMIT 1;");
			$stmt->execute(array());
			$row = $stmt->fetch();
			return $row["active"];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

}


?>
