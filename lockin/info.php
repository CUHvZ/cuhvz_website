<!DOCTYPE html>
<html lang="en">
<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
$title = 'CU HvZ | ';
?>
<head>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/layout/header.php'); ?>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php'; ?>

<?php

$detail_directory = $_SERVER['DOCUMENT_ROOT'].'/lockin/details';
$lockinName = $_GET["name"];
?>

<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">
      <div class="content lightslide-box">
        <div class="white">
          <?php
            include $detail_directory.'/'.$lockinName.'/title.php';
            echo "<p>";
            include $detail_directory.'/'.$lockinName.'/details.php';
            echo "</p>";
          ?>
        </div>
  </div> <!-- end row -->

 </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<br><br>

<?php
// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>


</body>
</html>
