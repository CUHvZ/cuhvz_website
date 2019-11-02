<?php
include "StatsFilter.php";
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
  			$_SESSION["weeklong_id"] = $row["id"];
  			$_SESSION["weeklong"] = $row["name"];
  			$_SESSION["title"] = $row["title"];
  			$_SESSION["started"] = $row["started"];
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
			$stmt = $this->_db->prepare("SELECT active FROM weeklongs WHERE id=:id; OR name=:id");
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
	public static function active_event(){
    $db = new Database();
    $query = "SELECT active FROM weeklongs WHERE active=1 LIMIT 1;";
    $data = $db->executeQueryFetch($query);
    if(isset($data["active"])){
      return true;
    }
    return false;
	}

	// returns ordered array of week long events
	public function get_weeklongs(){
		try {
			$stmt = $this->_db->prepare("SELECT * FROM weeklongs WHERE display=1;");
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
    		$stmt = $this->_db->prepare("UPDATE ".$_SESSION['weeklong']." SET kill_count=kill_count+1,points=points+5 WHERE username=:zombieFeeder;");
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
          $query = "SELECT $name.*, users.username FROM $name INNER JOIN users ON $name.user_id=users.id  WHERE status='human';";
	        $stmt = $this->_db->prepare($query);
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
        error_log($name." table not found. Loading humans from csv file...", 0);
        error_log($e, 0);
        $data = $this->get_stats_file($name);
        $filter = new StatsFilter(null);
        $filtered = $filter->filterOut($data, "human");
        return $filtered;
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
          $query = "SELECT $weeklong.*, users.username FROM $weeklong INNER JOIN users ON $weeklong.user_id=users.id  WHERE (status='zombie' OR status='zombie(suicide)' OR status='zombie(OZ)') ORDER BY starve_date;";
	        $stmt = $this->_db->prepare($query);
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
        error_log($weeklong." table not found. Loading zombies from csv file...", 0);
          $data = $this->get_stats_file($weeklong);
          $filter = new StatsFilter(array("username", "kill_count", "starve_date", "status", "points"));
          $temp = $filter->matchDataSet($data);
          $filtered = $filter->filterOut($temp, "zombie");
          return $filtered;
	    }
	}

	// returns array of deceased plaers in the week long
	public function get_deceased(){
		try{
	        $stmt = $this->_db->prepare("SELECT username, kill_count, starve_date, points FROM ".$_SESSION['weeklong']." WHERE status='deceased' ORDER BY starve_date;");
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
          $query = "SELECT $weeklong.*, users.username FROM $weeklong INNER JOIN users ON $weeklong.user_id=users.id  WHERE status='deceased' ORDER BY starve_date;";
	        $stmt = $this->_db->prepare($query);
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        return $data;
	    }catch(PDOException $e){
        error_log($weeklong." table not found. Loading deceased from csv file...", 0);
          $data = $this->get_stats_file($weeklong);
          $filter = new StatsFilter(array("username", "kill_count", "starve_date", "status", "points"));
          $temp = $filter->matchDataSet($data);
          $filtered = $filter->filterOut($temp, "deceased");
          return $filtered;
	    }
	}

  public function get_activity($weeklong){
    $data = null;
		try{
	        $stmt = $this->_db->prepare("SELECT * FROM ".$weeklong."_activity;");
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        $data;
	    }catch(PDOException $e){
        //error_log($e, 0);
        $data = [];
        $filename = $_SERVER['DOCUMENT_ROOT']."/weeklong/".$weeklong."/activity.csv";
        $file = fopen($filename,"r");
        $fields = fgetcsv($file);
        $counter = 0;
        if($file){
          while(!feof($file) && $counter < 1000)
            {
              $counter++;
              $array = fgetcsv($file);
              if(!empty($array)){
                array_push($data, array_combine($fields, $array));
              }
            }
        }
        fclose($file);
	    }
      return $data;
	}

  public function get_stats($weeklong){
    $data = null;
		try{
	        $stmt = $this->_db->prepare("SELECT * FROM ".$weeklong);
	        $stmt->execute();
	        $data = $stmt->fetchAll();
	        $data;
	    }catch(PDOException $e){
        $data = [];
        $filename = $_SERVER['DOCUMENT_ROOT']."/weeklong/".$weeklong."/stats.csv";
        $file = fopen($filename,"r");
        $fields = fgetcsv($file);
        $counter = 0;
        if($file){
          while(!feof($file) && $counter < 1000)
            {
              $counter++;
              $array = fgetcsv($file);
              if(!empty($array)){
                array_push($data, array_combine($fields, $array));
              }
            }
        }
        fclose($file);
	    }
      return $data;
	}

  public function get_stats_file($weeklong){
    $data = null;
    $data = [];
    $filename = $_SERVER['DOCUMENT_ROOT']."/weeklong/".$weeklong."/stats.csv";
    $file = fopen($filename,"r");
    $fields = fgetcsv($file);
    $counter = 0;
    if($file){
      while(!feof($file) && $counter < 1000)
        {
          $counter++;
          $array = fgetcsv($file);
          if(!empty($array)){
            array_push($data, array_combine($fields, $array));
          }
        }
    }
    fclose($file);
      return $data;
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

	public function check_starve_dates(){
		// Only check if game has started
    if(isset($_SESSION["started"]) && $_SESSION["started"]){
      $weeklongName = $_SESSION['weeklong'];
      $database = new Database();
      $now = (new DateTime(date('Y-m-d H:i:s')))->format('Y-m-d H:i:s');

      // kill starved humans that have no points
      $query = "UPDATE $weeklongName SET status='deceased', status_type='inactive' WHERE starve_date < '$now' AND points=0";
      $database->executeQuery($query);

      // turn starved humans into zombies
      $query = "UPDATE $weeklongName SET status='zombie', starve_date=('$now' + INTERVAL 1 DAY), status_type='starved' WHERE starve_date < '$now' AND status='human'";
      $database->executeQuery($query);

      // kill starved zombies
      $query = "UPDATE $weeklongName SET status='deceased' WHERE starve_date < '$now' AND status='zombie'";
      $database->executeQuery($query);

      // give any null starve timer a 24 timer
      $query = "UPDATE $weeklongName SET starve_date=('$now' + INTERVAL 1 DAY) WHERE starve_date IS NULL";
      $database->executeQuery($query);

      // make sure all starve timers are no more than 48 hours
      $query = "UPDATE $weeklongName SET starve_date=('$now' + INTERVAL 2 DAY) WHERE starve_date>('$now' + INTERVAL 2 DAY)";
      $database->executeQuery($query);
    }
	}

	public function check_event_time(){
		$current_time = new DateTime(date('Y-m-d H:i:s'));
		$start_date = new DateTime($_SESSION["start_date"]);
		$end_date = new DateTime($_SESSION["end_date"]);
    if($_SESSION["started"] == 0){
      if($start_date < $current_time){
        // The event has started
        $this->start_game();
      }else{
        // The event is being displayed but play has not yet started
      }
    }else{
      if($end_date < $current_time){
        // The event has ended
        error_log("ending weeklong.", 0);

        // ALTER TABLE weeklongs ADD COLUMN started boolean DEFAULT false;

        $db = new Database();
        $weeklongName = $_SESSION["weeklong"];
        $query = "UPDATE weeklongs SET active=0, started=0 where name='$weeklongName'";
        $db->executeQuery($query);
        $_SESSION["started"] = 0;
      }
    }
	}

	public function reset_all_players(){
    $db = new Database();
    $now = (new DateTime(date('Y-m-d H:i:s')))->format('Y-m-d H:i:s');
    $query = "UPDATE ".$_SESSION['weeklong']." SET status='human', status_type=NULL, starve_date=('$now' + INTERVAL 2 DAY), kill_count=0, points=0;";
    $db->executeQuery($query);
    // delete any used codes
    $query = "delete from ".$_SESSION['weeklong']."_used_codes;";
    $db->executeQuery($query);
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
    $name = $_SESSION["weeklong"];
    error_log("Starting $name weeklong game.", 0);

    $db = new Database();
    $query = "select * from $name where status='zombie' AND status_type='OZ';";
    $OZs = $db->executeQueryFetchAll($query);

		self::reset_all_players();
    $query = "select * from $name;";
    $players = $db->executeQueryFetchAll($query);
		$num_players = sizeof($players);
  	$num_OZ_needed = ceil($num_players*0.02);
    $num_OZ = sizeof($OZs);
    error_log("Number of players: $num_players, Num OZ needed $num_OZ_needed num OZ: $num_OZ", 0);
    $num_OZ_needed = $num_OZ_needed - $num_OZ;
    $zombieIDs = array();
    foreach($OZs as $zombie){
      array_push($zombieIDs, $zombie["user_id"]);
    }
    if($num_OZ_needed > 0){
      for($i=0; $i<$num_OZ_needed; $i++){
          $OZ_index = random_int(0,$num_players-1);
          $OZ_ID = $players[$OZ_index]["user_id"];
          array_push($zombieIDs, $OZ_ID);
      }
    }
    $now = new DateTime(date('Y-m-d H:i:s'));
    $starveDate = date_add($now, date_interval_create_from_date_string("48 hours"));
    $starveDate = $starveDate->format('Y-m-d H:i:s');
    foreach($zombieIDs as $zombie_id){

      // update weeklongF19 set status='zombie', status_type='OZ', points=50, starve_date=(2019-11-01 13:31:52 + INTERVAL 2 DAY) where user_id=1001
      $query = "update $name set status='zombie', status_type='OZ', points=50, starve_date='$starveDate' where user_id=$zombie_id";
      $error = $db->executeQuery($query);
      if(isset($error["error"]))
        error_log("could not make id $zombie_id into an OZ");
      else
        error_log("id $zombie_id is now an OZ");
    }
    $query = "update weeklongs set started=1 where name='$name'";
    $db->executeQuery($query);
    $_SESSION["started"] = 1;
	}

	// select count(*) from weeklongS18 where status='zombie(OZ)';
  // update weeklongs set end_date="2019-04-19 17:00:00" where id=4;
  // update weeklongs set start_date="2019-04-12 09:00:00" where id=4;
}


?>
