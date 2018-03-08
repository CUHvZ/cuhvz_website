<?php
/*
//$to = "jobr3255@colorado.edu";
$to = "golfinjosh@yahoo.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: @noreply" . "\r\n" .
"CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers);
*/
/*
$to = "golfinjosh@yahoo.com";
$subject = "HTML email";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);*/

?>

<html> 
	<head> 
	<title>Ajax at work</title> 

	<script language="javascript">
		<?php
			require "test.js";
		?>

		function getData2(dataSource, divID) 
		{ 
			var XMLHttpRequestObject = false; 

			if (window.XMLHttpRequest) {
				XMLHttpRequestObject = new XMLHttpRequest();
			} else if (window.ActiveXObject) {
				XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
			}

			if(XMLHttpRequestObject) {
				var obj = document.getElementById(divID); 
				XMLHttpRequestObject.open("GET", dataSource); 

				XMLHttpRequestObject.onreadystatechange = function() 
				{ 
					if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) { 
						var data = XMLHttpRequestObject.responseText;
						obj.innerHTML = data;
					} 
				} 

				XMLHttpRequestObject.send(null); 
			}
		}
		window.onload = evt => { 
			getData2('test.txt', 'targetDiv'); 
			getData('test2.txt', 'other'); 
		};
	</script>
	</head> 

	<body>
		<div id="targetDiv">DIV 1</div> 
		<br><br><br>
		<div id="other">DIV 2</div> 

	</body> 
</html>