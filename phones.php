<?php

// DATABASE CONNECTION INFORMATION
$host = "server122.web-hosting.com";
$user = "cuhvmiwg";
$passwd = "Yummybrainz!2";
$dbname = "cuhvmiwg_hvz";
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die ("could not connect to server");

function phones($cxn)
{	
	$phones = getPhones($cxn);
	if(!$phones)
	{
		echo "EPIC FAIL";
	}
	else
	{
		echo $phones;
	}
}

function getPhones($cxn,$mail_type)
{
	$query_phone = "SELECT * FROM weeklongF17";
	$result_phone = mysqli_query($cxn,$query_phone) or die ("could not execute query_phone");

	if(!empty($result_phone))
	{
		$phoneList = "";
		while ($row_phone = mysqli_fetch_array($result_phone))
		{
			$phoneList = $phoneList . "<tr>";
			$phoneList = $phoneList . "<td>" . $row_phone['username'] . "</td>";
			$phoneList = $phoneList . "<td>" . $row_phone['phone'] . "</td>";
			$phoneList = $phoneList . "</tr>";
		}
		$phoneList = $phoneList;
		
		return $phoneList;
	}
	else
	{
		return FALSE;
	}
}
echo "<table>";
$output = phones($cxn);
echo "</table>";

?>