<?php include "includes/password_protect.php";?>
<?php include "includes/abovecss.php";?>
<head>
<?php include "includes/css.php";?>

<?php include "includes/google.php";?>
</head>
<body>
<?php include "includes/menubar.php"; ?>

<?php 

//Note: Default API key is provided.  If you run into issues, you may need to apply for your own at www.thetvdb.com
$APIKEY="FBDD279D0ED6D517";

//Define several Variables and Grab Variables passed from Season.php
$seriesid=$_GET["id"];
$episode = $_GET["series"];
$episode_array=explode("/",$episode);
$series_name=$episode_array[1];

//Pull out Season number from 01 vs 10
if(substr($episode_array[2],-2,1) == "0"){
$season_number=substr($episode_array[2],-1);
}else { 
$season_number=$episode_array[2];
}

//Print Season Title or series banner if available
$season_title=explode("/",$episode);
$banner ="videos"."/".$season_title[1]."/".$season_title[1].".jpg";

if(file_exists($banner)){
print "<center><h2>Season $season_title[2]</h2></center>";
print "<center><img src=\"$banner\"></center><br>";
						}else	{
						print "<center><h2>$season_title[1] Season $season_title[2]</h2></center><br>";
								}
		
//$dir should be the folder holding video files
$dir    = "videos/".$series_name."/".$episode_array[2];
//scandir populates an array with all files in the $dir directory
$array_of_dir = scandir($dir);
//Get the size of the directory array for use in loop
$dir_array_size = sizeof($array_of_dir);
//clears blank lines(folders) in array - change to 1 or 0 to see why.
$x=2;

while ($x < ($dir_array_size-1) ){ //-1 is a hack to remove metadata folder


//Define episode number
	//Break apart episode grabbing out single digits
	if(substr($array_of_dir[$x],-6,1) == "0"){
	$episode_number = substr($array_of_dir[$x],-5,1);
	}else 	{ 
	$episode_number= substr($array_of_dir[$x],-6,2);
			}
//Define image path
		$local_image_path="videos/".$series_name."/".$episode_array[2]."/metadata/".$episode_number.".jpg";
//Check for local episode XML, grab if missing
		//Define path to local XML	
		$episode_xml="videos/".$series_name."/".$episode_array[2]."/metadata/".$episode_number.".xml";
		//print $episode_xml;
			if(!file_exists($episode_xml))	{
			//Define path to grab XML
			$file ="http://www.thetvdb.com/api/".$APIKEY."/series/".$seriesid."/default/".$season_number."/".$episode_number."/en.xml";
			//print "<p>$file</p>";
			$current = file($file);
			//print_r($current);
			// Write the contents back to the file
			file_put_contents($episode_xml, $current);
											}

//Data check for corrupt XML
$xmlcontent=file_get_contents($episode_xml);											
$pre_xml_check=explode(" ",$xmlcontent);
if ($pre_xml_check[2]=="encoding=\"UTF-8\"")	{												
	//Process Local XML files
		$xmlcontent=file_get_contents($episode_xml);
		$xml = new SimpleXMLElement($xmlcontent);
		$episode_name= $xml->Episode[0]->EpisodeName;
		$episode_overview= $xml->Episode[0]->Overview;
		$episode_rating= $xml->Episode[0]->Rating;
		$episode_id=$xml->Episode[0]->id;		
		
	//Check for local episode image
		//Define path to image
		$local_image_path="videos/".$series_name."/".$episode_array[2]."/metadata/".$episode_number.".jpg";
		//print $local_image_path."<br>";
		if(!file_exists($local_image_path))	{
		$episode_image_remote= $xml->Episode[0]->filename;
		$remote_image_path="http://thetvdb.com/banners/".$episode_image_remote;
		$image_data = file_get_contents($remote_image_path);
		// Write the contents back to the file
		file_put_contents($local_image_path, $image_data);
											}
											//Print data to page
									print "<div class=\"container\"><div class=\"row\"><h2>Episode ".$episode_number." - ".$episode_name."</h2>";
									print "<dl class=\"tabs marg\"><dd><a href=\"#simple$x\" class=\"active\">Episode</a></dd>";
									print "<dd><a href=\"#simple".$x."1\">Overview</a></dd></dl>";
									//Note: X is printed in line to generate unique names for each display tab
									
									print "<ul class=\"tabs-content\">";
									print "<li class=\"active\" id=\"simple".$x."Tab\"><p><a href="."player"."."."php?filename=".$episode."/".$array_of_dir[$x]."&preview=$local_image_path&episode=$episode_number><img src=$local_image_path></a><br><p></li>";
									print "<li id=\"simple".$x."1Tab\"><p>".$episode_overview."</p></li></ul></div></div><br>";
												}else{
											$episode_name=$array_of_dir[$x];
											$episode_overview="Sorry but an error occured gathering information for this episode from thetvdb.com  Please try again shortly by refreshing this page";
											unlink($episode_xml);
											unlink($local_image_path);
											//Print data to page
											print "<div class=\"container\"><div class=\"row\"><div class=\"eight columns contained textbox centered\"><a href="."player"."."."php?filename=".$episode."/".$array_of_dir[$x]."&preview=$local_image_path".$nice_button.">"."Episode".$episode_number.  " - ".$episode_name."</a><br>";
											print "<p>$episode_overview</p><br></div></div></div><br><br>";
													}
					
	$x=$x+1;
								}						
?>
</body>
</html>