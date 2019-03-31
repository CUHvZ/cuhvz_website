<?php

function addOrdinal($num){
  $num = intval($num);
  if($num == 1)
    return $num."st";
  else if($num == 2)
    return $num."nd";
  else if($num == 3)
    return $num."rd";
  else
    return $num."th";
}

function formatWeeklongDates($startDate){
  $monthNames = array(
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  );
  $startDate = new DateTime($startDate);
  $firstDay = $startDate->format('d');
  $firstDay = addOrdinal($firstDay);
  $firstMonth = $monthNames[intval($startDate->format('m'))];
  $year = $startDate->format('Y');

  $endDate = date_add($startDate, date_interval_create_from_date_string('4 days'));
  $endDay = $endDate->format('d');
  $endDay = addOrdinal($endDay);
  $endMonth = $monthNames[intval($endDate->format('m'))];
  if($firstMonth == $endMonth)
    return "$firstMonth $firstDay - $endDay, $year";
  else
    return "$firstMonth $firstDay - $endMonth $endDay, $year";
}

function createWeeklong($semester, $title, $displayDates, $startDate, $endDate){
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

    $db = new Database();
    $db->executeQuery($createWeeklongEntryQuery);
    $db->executeQuery($createWeeklongTableQuery);
    $db->executeQuery($createWeeklongCodesTableQuery);
}

if(isset($_POST['submit'])){
  if(isset($_POST['create_weeklong'])){
    $semester = $_POST["weeklong_name"];
    $title = $_POST["weeklong_title"];
    //error_log($_POST["date"], 0);
    $date = new DateTime($_POST["date"]);
    $start_date = $date->format('Y-m-d')." 09:00:00";
    $endDate = date_add($date, date_interval_create_from_date_string('4 days'));
    $end_date = $endDate->format('Y-m-d')." 17:00:00";

    $display_dates = formatWeeklongDates($_POST["date"]);

    // drop table weeklongs; source scripts/sql/old_tables/weeklongs.sql;
    // drop table weeklongs; source scripts/sql/weeklongsNew.sql;

    createWeeklong($semester, $title, $display_dates, $start_date, $end_date);
  }
}

?>

<div>
  <div>
    <form role="form" method="post">
      Create a new weeklong
      <br/>
      <span style="float: left;">
        <label>Semester identifier</label><br/>
        <input type="text" name="weeklong_name" placeholder="ex. F18">
      </span>
      <span style="float: left;">
        <label>Title</label><br/>
        <input type="text" name="weeklong_title" placeholder="cool name">
      </span>
      <span style="float: left;">
        <label>Date</label><br/>
        <input class="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
      </span>
      <input type="hidden" name="tab" value="Weeklong">
      <input type="hidden" name="create_weeklong">
      <span style="float: left;">
        <br/>
        <input type="submit" name="submit" value="Create" class="btn btn-primary btn-block btn-lg button-primary">
      </span>
    </form>
  </div>
</div>