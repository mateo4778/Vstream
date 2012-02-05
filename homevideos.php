<?php include "includes/password_protect.php";?>
<?php include "includes/abovecss.php";?>
<head>
<?php include "includes/css.php";?>

	<?php include"includes/google.php"; ?>
</head>
<Body>
<?php include "includes/menubar.php"; ?>
<center><h1>Home Videos</h1></center>
<?php
//$dir should be the folder holding video files, relative to this page
$dir    = 'homevideos';
//scandir populates an array with all files in the $dir directory
$array_of_dir = scandir($dir);
//Get the size of the directory array for use in loop
$dir_array_size = sizeof($array_of_dir);
//clears blank lines(folders) in array - change to 1 or 0 to see why.
$x=2;
//dir passes the directory selected to seasons.php
while ($x < ($dir_array_size) )	{
print "<a href=\"player.php?filename=homevideos/$array_of_dir[$x]\" class=\"nice radius blue button\">$array_of_dir[$x]</a> <br>";
$x=$x+1;
								}

?>