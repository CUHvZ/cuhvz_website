<?php

class StarveDate{

  private $dateString;

  function __construct($dateString){
  	$this->dateString = $dateString;
  }

  public function getStarveTimer($eventStartDateString = null){
    $starveDate = new DateTime(date($this->dateString));
    $currentTime = new DateTime(date('Y-m-d H:i:s'));
      if($eventStartDateString != null){
    $eventStartDate = new DateTime(date($eventStartDateString));
      if($eventStartDate > $currentTime){
        return "--:--";
      }
    }
    if($starveDate < $currentTime){
      return "--:--";
    }else{
      $timeLeft = $currentTime->diff($starveDate);
      $hours = $timeLeft->format('%H')+($timeLeft->format('%a')*24);
      return $hours.$timeLeft->format(':%I');
    }
  }

  public function addHours($hours){
    $starveDate = new DateTime(date($this->dateString));
    $currentTime = new DateTime(date('Y-m-d H:i:s'));
    $maxStarveDate = date_add($currentTime, date_interval_create_from_date_string("48 hours"));
    $starveDate = date_add($starveDate, date_interval_create_from_date_string("$hours hours"));
    if($starveDate > $maxStarveDate)
      $starveDate = $maxStarveDate;
    return $starveDate->format('Y-m-d H:i:s');
  }
}
?>
