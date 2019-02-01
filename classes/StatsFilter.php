<?php

class StatsFilter {
    private $filterArray;

    function __construct($filterArray) {
      $this->filterArray = $filterArray;
    }

    function filterArray($var)
    {
      return in_array($var, $this->filterArray);
    }

    function matchArray($arrayToFilter) {
      return array_filter($arrayToFilter, array($this, "filterArray"), ARRAY_FILTER_USE_KEY );
    }

    function matchDataSet($data){
      $temp = [];
      foreach ($data as $entry) {
        array_push($temp, $this->matchArray($entry));
      }
      return $temp;
    }

    function filterOut($arrayToFilter, $type){
      if($type == "human"){
        return array_filter($arrayToFilter, function($var) {
          return($var["status"] == "human");
        });
      } elseif($type == "zombie"){
        return array_filter($arrayToFilter, function($var) {
          return is_numeric(strpos($var["status"], "zombie"));
        });
      } elseif($type == "deceased"){
        return array_filter($arrayToFilter, function($var) {
          return($var["status"] == "deceased");
        });
      }
    }
}

?>
