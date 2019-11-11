<?php
// md5(uniqid(rand(),true));
for($i = 0; $i < 24; $i++){
	$signNum = $i + 1;
	$hex = substr(md5(uniqid(rand(),'')),0,5);
	$hex = strtoupper($hex);
	error_log("$signNum:          $hex", 0);
}

?>
