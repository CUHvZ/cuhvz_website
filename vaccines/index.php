
<html>
<body>

<?php

$rand_num = round(rand());
if (($rand_num % 6) == 0)
{
	print "What is the average airspeed velocity of an unladen swallow?";
}
elseif (($rand_num % 6) == 1)
{
	print "What is the Answer to the Ultimate Question of Life, the Universe, and Everything?";
}
elseif (($rand_num % 6) == 2)
{
	print "Who shot J.R.?";
}
elseif (($rand_num % 6) == 3)
{
	print "First think of the person who lives in disguise<br>Who deals in secrets and tells naught but lies.<br>Next, tell me what's always the last thing to mend,<br>The middle of middle and end of the end?<br>And finally give me the sound often heard,<br>During the search for a hard-to-find word.<br>Now string them together and answer me this,<br>Which creature would you be unwilling to kiss?<br>";
}
elseif (($rand_num % 6) == 4)
{
	print "Shall we play a game?";
}
elseif (($rand_num % 6) == 5)
{
	print "Who ya gonna call?";
}
else
{
	print "Did you really think I was going to make it easy to get the vaccines?<br>";
}
?>

<form action="vaccines.php" method="post">
	<input type="text" name="answer">

<input type="submit">
</form>

</body>
</html>