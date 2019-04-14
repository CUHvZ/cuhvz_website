<?php

class StarveDate{

  private $dateString;

  function __construct($dateString){
  	$this->dateString = $dateString;
  }

  public function getStarveTimer(){
    $starveDate = new DateTime(date($this->dateString));
    $currentTime = new DateTime(date('Y-m-d H:i:s'));
    if($starveDate < $currentTime){
      return "0:0";
    }else{
      $timeLeft = $currentTime->diff($starveDate);
      $hours = $timeLeft->format('%H')+($timeLeft->format('%a')*24);
      return $hours.$timeLeft->format(':%I');
    }
  }
}
?>
