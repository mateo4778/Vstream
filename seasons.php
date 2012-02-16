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

$movie_array = array(); //Array generated for encoding

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
$episode_array=scandir($series."/".$array_of_dir[$x]);
$episode_array_length=sizeof($episode_array);
$y=1;

//Generate name check for the episode
$next=1;
while ($y<$episode_array_length){
				
if  ($episode_array[$y] != ".." && $episode_array[$y] != "metadata" && $episode_array[$y] != "." && $episode_array[$y] != "encode"){	
$movie_array[$next]=$episode_array[$y];
$movie_array_explode=explode(".",$movie_array[$next]);
$next=$next+1;
if ($movie_array_explode[1] != "mp4" )	{
if (!file_exists("$series/$array_of_dir[$x]/encode")){			
mkdir("$series/$array_of_dir[$x]/encode");
}
//print"<p>$series/$array_of_dir[$x]/encode</p>";  //encoding folder to be made
print "<center><p>$episode_array[$y] Has been downloaded but must be encoded. File should be MP4, but currently is: $movie_array_explode[1]</p></center>";
//print "<center><a href=\"encode.php?season=$array_of_dir[$x]&series=$series&ext=$movie_array_explode[1]&HD=SD\" $nice_button>Convert files in Season $array_of_dir[$x] in SD</a></center>";
//print "<center><a href=\"encode.php?season=$array_of_dir[$x]&series=$series&ext=$movie_array_explode[1]&HD=HD\" $nice_button>Convert files in Season $array_of_dir[$x] in HD</a></center>";
											}
					}			


$y=$y+1;
}																		
//print_r($episode_array);	
//print_r($movie_array);
$x = $x+1;
}
?>
</body>
</html>