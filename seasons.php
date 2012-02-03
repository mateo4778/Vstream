<?php include "includes/password_protect.php";?>
<?php include "includes/abovecss.php";?>
<head>
<?php include "includes/css.php";?>

	<?php include"includes/google.php"; ?>
</head>

<Body>
<?php include "includes/menubar.php"; ?>
<?php
$seriesid = $_GET["id"];
$series = $_GET["series"] ;
$xml_check = $_GET["xml_check"] ;
//scandir populates an array with all files in the $dir directory
$array_of_dir = scandir($series);
//Get the size of the directory array for use in loop
$dir_array_size = sizeof($array_of_dir);
$x=2; //clears blank lines in array - change to 1 or 0 to see why.

//Print Season Title or series banner if available
$season_title=explode("/",$series);
$banner = "$series/$season_title[1]".".jpg";
if(file_exists($banner)){
print "<center><img src=$series/$season_title[1]".".jpg"."></center>";
						}else	{
						print "<h1>$season_title[1]</h1>";
								}
//Print directory with links

while ($x < $dir_array_size-2){
$add_dir2="$series/$array_of_dir[$x]/metadata/";
if (!file_exists($add_dir2)){
mkdir($add_dir2);
//print "Metadata Folder Added for".$array_of_dir[$x];
							}				
if(($array_of_dir[$x]!="series.xml" && $array_of_dir[$x]!=$season_title[1].".jpg"))	{
//filename passes file location to episodes page
print "<center><br> <a href="."episode"."."."php?series=".$series."/".$array_of_dir[$x]."&id=".$seriesid."&xml_check=".$xml_check.$nice_button.">"."Season ".$array_of_dir[$x]."</a></center>";
					
																				}
$x = $x+1;
}
?>
</body>
</html>