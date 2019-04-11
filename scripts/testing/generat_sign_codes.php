<?php
// md5(uniqid(rand(),true));
for($i = 0; $i < 20; $i++){
	error_log(($i+1).": ".substr(md5(uniqid(rand(),'')),0,5), 0);
}

?>
