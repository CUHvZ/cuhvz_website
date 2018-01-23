
<html>
<body>

<form action="emailer.php" method="post">

	Send to:
	<select name="mail_type">
		<option value="human">Confirmed Humans</option>
		<option value="notConfirm">Not Confirmed Players</option>
		<option value="zombie">Zombies</option>
		<option value="deceased">Deceased Zombies</option>
	</select>

	<br><br>

<!-- Subject: <textarea rows="1" cols="50" type="text" name="subject"></textarea><br><br>

Message: <textarea rows="10" cols="50" type="text" name="message_text"></textarea><br><br>

<b>Use &lt;br&gt;&lt;br&gt; for a full carriage return instead of the "Enter" key twice!</b> -->
<br><br>
<input type="submit">
</form>

</body>
</html>