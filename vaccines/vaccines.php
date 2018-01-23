<?php

function processor()
{
	$answer = $_POST["answer"];
	$answer_lower = strtolower($answer);
	$answer_lower = str_replace(' ', '', $answer_lower);
	if ($answer_lower == "fadeaway")
	{
		print "OATBIEINMODFRHQTPCYIUXUYOICFPCTVEORXTKFWIEFNTBTXTZRSDSWNPOBFSHLTIBAZTNSYNOPVNETZWQXXXUJOV";
	}
	else
	{
		for($i = 0; $i < 89; $i++)
		{
			$rand_let = chr(rand(65,90));
			print $rand_let;
		}
	}
}

$output = processor();

?>