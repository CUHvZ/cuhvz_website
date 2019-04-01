<?php
class Code{

  public static $SUPPLY = 1;
  public static $POINTS = 2;
  public static $MISSION = 3;
  public static $REVIVE = 4;

  private $name, $locationID, $hex, $effect, $sideEffect, $singleUse, $numUses, $expiration, $used, $userID, $codeID, $timeUsed;

  function __construct($name, $hex, $effect, $sideEffect=""){
    $this->name = $name;
    $this->hex = $hex;
    $this->effect = $effect;
    $this->sideEffect = $sideEffect;
  }

  public function getName() {
    return $this->name;
  }

  public function getLocationID() {
    return $this->locationID;
  }

  public function getHex() {
    return $this->hex;
  }

  public function getEffect() {
    return $this->effect;
  }

  public function getSideEffect() {
    return $this->sideEffect;
  }

  public function getSingleUse() {
    return $this->singleUse;
  }

  public function getNumUses() {
    return $this->numUses;
  }

  public function getExpiration() {
    return $this->expiration;
  }

  public function getUsed() {
    return $this->used;
  }

  public function getUserID() {
    return $this->userID;
  }

  public function getCodeID() {
    return $this->codeID;
  }

  public function getTimeUsed() {
    return $this->timeUsed;
  }

  public function setCode($data) {
  }

  public function getQuerry() {
  }
}
?>
