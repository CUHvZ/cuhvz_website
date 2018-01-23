<?php

// DATABASE CONNECTION INFORMATION
$host = "server122.web-hosting.com";
$user = "cuhvmiwg";
$passwd = "Yummybrainz!2";
$dbname = "cuhvmiwg_hvz";
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die ("could not connect to server");

function emailer($cxn)
{
	$mail_type = $_POST["mail_type"];
	$subject = $_POST["subject"];
	$message_text = $_POST["message_text"];
	
	$bcc = getEmails($cxn,$mail_type);
	if(!$bcc)
	{
		return FALSE;
	}
	else
	{
		echo $bcc;
	}
}

function getEmails($cxn,$mail_type)
{
	if($mail_type == "notConfirm")
	{
		$query_email = "SELECT * FROM weeklongF17 WHERE status='human' AND active!='yes'";
	}
	else
	{
		$query_email = "SELECT * FROM weeklongF17 WHERE status='$mail_type' AND active='yes'";
	}
	$result_email = mysqli_query($cxn,$query_email) or die ("could not execute query_email");

	if(!empty($result_email))
	{
		$mailList = "<html><body>";
		$count = 1;
		while ($row_rng = mysqli_fetch_array($result_email))
		{
			$mailList = $mailList . $row_rng['email'];
			if($count == 40)
			{
				$mailList = $mailList . "<br><br>";
				$count = 1;
			}
			else
			{
				$mailList = $mailList . "; ";
				$count = $count + 1;
			}
		}
		$mailList = $mailList . "humansvszombies@colorado.edu; ";
		$mailList = $mailList . "</body></html>";
		
		return $mailList;
	}
	else
	{
		return FALSE;
	}
}

$output = emailer($cxn);
/*
if($output)
{
	echo "Email should be sent. Check humansvszombies@colorado.edu to confirm it went out. <br> <a href='emailer_form.php'>Back</a>";
}
else
{
	echo "Something went wrong; the email probably did not send. Check humansvszombies@colorado.edu to confirm. <br><a href='emailer_form.php'>Back</a>";
}
*/

?>