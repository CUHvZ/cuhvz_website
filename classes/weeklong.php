<?php
class Weeklong{

    private $_db;

    function __construct($db){
    	$this->_db = $db;
    }

    public function is_set(){
    	return isset($_SESSION["weeklong"]) && isset($_SESSION["weeklong_dates"]) && isset($_SESSION["start_date"]) && isset($_SESSION["end_date"]);
    }

    // this will set the $_SESSION variables for the active ecent
    public function set_active_variables(){
    	try {
			$stmt = $this->_db->prepare('SELECT * FROM weeklongs WHERE active>0 LIMIT 1');
			$stmt->execute(array());
			$row = $stmt->fetch();
			$_SESSION["weeklong"] = $row["name"];
			$_SESSION["title"] = $row["title"];
			//$_SESSION["active"] = $row["active"];
			$_SESSION["weeklong_dates"] = $row["display_dates"];
			$_SESSION["start_date"] = $row["start_date"];
			$_SESSION["end_date"] = $row["end_date"];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
    }

	// This will return true if the event with id=$id is active
	public function is_active($id){
		try {
			$stmt = $this->_db->prepare("SELECT active FROM weeklongs WHERE id=:id;");
			$stmt->execute(array('id' => $id));
			$row = $stmt->fetch();
			return $row["active"];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function get_details($name){
		$path = $_SERVER['DOCUMENT_ROOT']."/weeklong/".$name."/details.txt";
		$fullDetails = explode(" ", file_get_contents($path));
		return implode(" ", $fullDetails);
	}

	// This will return true if the there is an active game
	public function active_event(){
		try {
			$stmt = $this->_db->prepare("SELECT active FROM weeklongs WHERE active>0 LIMIT 1;");
			$stmt->execute(array());
			$row = $stmt->fetch();
			return $row["active"];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	// returns ordered array of week long events
	public function get_weeklongs(){
		try {
			$stmt = $this->_db->prepare("SELECT * FROM weeklongs ORDER BY start_date DESC;");
			$stmt->execute();
			return $stmt->fetchAll();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	// returns specific array of variable for a week long event given the name of the weeklong
	public function get_weeklong($name){
		try {
			$stmt = $this->_db->prepare("SELECT * FROM weeklongs where name=:name;");
			$stmt->execute(array(':name' => $name));
			return $stmt->fetch();

		} catch(PDOException $e) {
		    return false;
		}
	}

	public function check_starve_dates(){
		// Check for deceased zombies
		$current_time = new DateTime(date('Y-m-d H:i:s'));
		try {
		    $stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET status='deceased' WHERE starve_date <= :current_time");
		    $stmt->execute(array(':current_time' => $current_time->format('Y-m-d H:i:s')));
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().' check_starve_dates</p>';
		}

		// Check for zombies without starve dates
		$starve_date = date_add($current_time, date_interval_create_from_date_string('2 days'));
		try {
		    $stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET starve_date=:starve_date WHERE (status='zombie' AND starve_date IS NULL);");
		    $stmt->execute(array(':starve_date' => $starve_date->format('Y-m-d H:i:s')));
		} catch(PDOException $e) {
		    echo '<p class="bg-danger" style="margin: 0;">'.$e->getMessage().'</p>';
		} 
	}

	// returns the username of a user given their user hex
	public function findVictim($hex)
	{
	  try {
	    $stmt = $this->_db->prepare("SELECT username FROM ".$_SESSION['weeklong']." WHERE user_hex=:hex;");
	    $stmt->execute(array(':hex' => $hex));
	    $row = $stmt->fetch();
	    if(!empty($row)){
	      return $row["username"];
	    }
	    return 0;

	  } catch(PDOException $e) {
	      echo '<p class="bg-danger">'.$e->getMessage().'</p>';
	  }
	}

	public function regKill($victim, $hex)
	{
		try {
		    $stmt = $this->_db->prepare("SELECT status FROM ".$_SESSION['weeklong']." WHERE (username=:victim AND user_hex=:hex);");
		    $stmt->execute(array(
		    	':victim' => $victim,
		    	':hex' => $hex ));
		    $row = $stmt->fetch();
		    $status = $row["status"];
		    if($status == "human" || $status == "zombie(suicide)"){
		    	$status_change = "zombie";
		    }else if($status == "vaccine"){
		    	$status_change = "used_vaccine";
		    }else{
		        echo "<p class='bg-danger'>The system does not recognize this person as a human. Check with an admin if this seems to be incorrect.</p>";
		        return FALSE;
		    }
	    	try{
	    		$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET status=:status_change WHERE username=:victim;");
	    		$stmt->execute(array(
	    			':victim' => $victim,
	    			':status_change' => $status_change));
	    		return true;
	    	}catch(PDOException $e){
	    		echo '<p class="bg-danger">'.$e->getMessage().' regKill1</p>';
	    	}
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().' regKill2</p>';
		}
	}

	public function updateStarve($victim, $zombieFeedto, $zombieFeeder)
	{
	    date_default_timezone_set('America/Denver');
	    
	    $current_time = new DateTime(date('Y-m-d H:i:s'));
	    $starve_date = date_add($current_time, date_interval_create_from_date_string('2 days'));
	    $new_starve = $starve_date->format('Y-m-d H:i:s');
	    
	    // STARVE TIMER FOR ZOMBIE
	    try{
    		$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET starve_date=:new_starve WHERE username IN('" . implode("','", array_map('trim', $zombieFeedto)) ."');");
    		$stmt->execute(array(':new_starve' => $new_starve));
    	}catch(PDOException $e){
    		echo '<p class="bg-danger">'.$e->getMessage().' update1</p>';
    		return false;
    	}

	    try{
    		$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET kill_count=kill_count+1 WHERE username=:zombieFeeder;");
    		$stmt->execute(array(':zombieFeeder' => $zombieFeeder));
    	}catch(PDOException $e){
    		echo '<p class="bg-danger">'.$e->getMessage().' update2</p>';
    		return false;
    	}
	    
	    // STARVE TIMER FOR HUMAN-NOW-ZOMBIE
	    try{
    		$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET starve_date=:new_starve WHERE username=:victim;");
    		$stmt->execute(array(
    			':new_starve' => $new_starve,
    			':victim' => $victim));
    	}catch(PDOException $e){
    		echo '<p class="bg-danger">'.$e->getMessage().' update3</p>';
    		return false;
    	}
	    return TRUE;
	}

	public function cure_zombie($zombie){
		try{
    		$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET status='human' WHERE username=:zombie;");
    		$stmt->execute(array(
    			':zombie' => $zombie));
    		return true;
    	}catch(PDOException $e){
    		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    		return false;
    	}
	}

	// returns array of all players in the week long
	public function get_players(){
		try{
	        $stmt = $this->_db->prepare("SELECT * FROM ".$_SESSION['weeklong'].";");
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
	        echo '<p class="bg-danger">'.$e->getMessage().' get_players</p>';
	    }
	}

	// returns array of humans in the week long
	public function get_humans(){
		try{
	        $stmt = $this->_db->prepare("SELECT * FROM ".$_SESSION['weeklong']." WHERE status='human';");
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
	        echo '<p class="bg-danger">'.$e->getMessage().' get_humans</p>';
	    }
	}

	// returns array of humans in the week long
	public function get_humans_from($name){
		try{
	        $stmt = $this->_db->prepare("SELECT * FROM ".$name." WHERE status='human';");
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
	        return false;
	    }
	}

	// returns array of zombies in the week long
	public function get_zombies(){
		try{
	        $stmt = $this->_db->prepare("SELECT username, kill_count, starve_date, status FROM ".$_SESSION['weeklong']." WHERE (status='zombie' OR status='zombie(suicide)' OR status='zombie(OZ)') ORDER BY starve_date;");
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
	        echo '<p class="bg-danger">'.$e->getMessage().' get_zombies</p>';
	    }
	}

	// returns array of zombies in the week long
	public function get_zombies_from($weeklong){
		try{
	        $stmt = $this->_db->prepare("SELECT username, kill_count, starve_date, status FROM ".$weeklong." WHERE (status='zombie' OR status='zombie(suicide)' OR status='zombie(OZ)') ORDER BY starve_date;");
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
	        return false;
	    }
	}

	// returns array of deceased plaers in the week long
	public function get_deceased(){
		try{
	        $stmt = $this->_db->prepare("SELECT username, kill_count, starve_date FROM ".$_SESSION['weeklong']." WHERE status='deceased' ORDER BY starve_date;");
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
	        echo '<p class="bg-danger">'.$e->getMessage().' get_deceased</p>';
	    }
	}

	// returns array of deceased plaers in the week long
	public function get_deceased_from($weeklong){
		try{
	        $stmt = $this->_db->prepare("SELECT username, kill_count, starve_date FROM ".$weeklong." WHERE status='deceased' ORDER BY starve_date;");
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
	        return false;
	    }
	}

	public function event_status(){
		try{
    		$stmt = $this->_db->prepare("SELECT active FROM weeklongs WHERE name=:name;");
    		$stmt->execute(array(
    			':name' => $_SESSION["weeklong"]));
    		$row = $stmt->fetch();
    		return $row[0];
    	}catch(PDOException $e){
    		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    		return false;
    	}
	}

	public function check_event_time(){
		$current_time = new DateTime(date('Y-m-d H:i:s'));
		$start_date = new DateTime($_SESSION["start_date"]);
		$end_date = new DateTime($_SESSION["end_date"]);
		$event_status = $this->event_status();
		if($event_status == 1){
			if($start_date < $current_time){
				// The event has started
				$this->start_game();
				try{
		    		$stmt = $this->_db->prepare("UPDATE weeklongs SET active='2' WHERE name=:name;");
		    		$stmt->execute(array(
		    			':name' => $_SESSION["weeklong"]));
		    		return true;
		    	}catch(PDOException $e){
		    		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		    		return false;
		    	}
			}else{
				// The event is being displayed but play has not yet started
			}
		}else if($event_status == 2){
			if($end_date < $current_time){
				// The event has ended so set active to 0
				try{
		    		$stmt = $this->_db->prepare("UPDATE weeklongs SET active='0' WHERE name=:name;");
		    		$stmt->execute(array(
		    			':name' => $_SESSION["weeklong"]));
		    	}catch(PDOException $e){
		    		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		    		return false;
		    	}
			}else{
				// The event is active and players can play
			}
		}
	}

	private function reset_all_players(){
		try{
    		$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET status='human', starve_date=NULL, kill_count=0;");
    		$stmt->execute();
    	}catch(PDOException $e){
    		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    		return false;
    	}
	}

	private function set_OZ($user_id){
		$start_date = new DateTime($_SESSION["start_date"]);
	    $starve_date = date_add($start_date, date_interval_create_from_date_string('2 days'));
	    $new_starve = $starve_date->format('Y-m-d H:i:s');
		try{
    		$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET status='zombie(OZ)', starve_date=:new_starve WHERE user_id=:user_id;");
    		$stmt->execute(array(
    			':user_id' => $user_id,
    			':new_starve' => $new_starve));
    	}catch(PDOException $e){
    		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    		return false;
    	}
	}

	private function start_game(){
		$this->reset_all_players();
		$humans = $this->get_humans();
		$num_players = sizeof($humans);
    	$num_OZ = ceil($num_players*0.02);
	    for($i=0; $i<$num_OZ; $i++){
	        $OZ_index = random_int(0,$num_players-1);
	        //echo $OZ_index."\n";
	        //echo "OZ: ".$humans[$OZ_index]["user_id"]." username: ".$data[$OZ_index]["username"]."\n";
	        $this->set_OZ($humans[$OZ_index]["user_id"]);
	    }
	}

	// select count(*) from weeklongS18 where status='zombie(OZ)';

}


?>
