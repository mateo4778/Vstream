
<?php include "includes/abovecss.php";?>
<head>
 

<?php include "includes/css.php";?>

	<?php include"includes/google.php"; ?>
</head>
<Body>

<?php include "includes/menubar.php"; ?>
<center><h1>TV Shows</h1></center>

<div id="TV-series-list">
                        <input class="search" placeholder="Search" />
 
						 <ul class="list">
<?php
//$dir should be the folder holding video files, relative to this page
$dir    = 'videos';
//scandir populates an array with all files in the $dir directory
$array_of_dir = scandir($dir);
//Get the size of the directory array for use in loop
$dir_array_size = sizeof($array_of_dir);
//clears blank lines(folders) in array - change to 1 or 0 to see why.
$x=2;
//dir passes the directory selected to seasons.php
while ($x < ($dir_array_size) ){

//Check for local series .xml file.  
$series_xml="videos/$array_of_dir[$x]/series.xml";
if (!file_exists($series_xml)) {
    //Define path to grab XML
	$xmlurl="http://www.thetvdb.com/api/GetSeries.php?seriesname=$array_of_dir[$x]";
	$current = file_get_contents($xmlurl);
	// Write the contents back to the file
	file_put_contents($series_xml, $current);
								}

	

	//Process Local XML files
	$xmlcontent=file_get_contents($series_xml);
	$pre_xml_check=explode(" ",$xmlcontent);
	if ($pre_xml_check[2]=="encoding=\"UTF-8\"")	{
			//Print "<p>OK to Load File!</p>";
		$xml = new SimpleXMLElement($xmlcontent);
		$seriesname= $xml->Series[0]->SeriesName;
		$seriesid= $xml->Series[0]->seriesid;
		$overview= $xml->Series[0]->Overview;
		$language= $xml->Series[0]->language;	
			//Check for local banner
	$postername="videos/$array_of_dir[$x]/$array_of_dir[$x].jpg";
	If(!file_exists($postername))	{
		//If No Local copy of the bannar, Go get it
		//banner location
		$putimage =$postername;
		$remote_poster=$xml->Series[0]->banner;
		$getimage = file_get_contents("http://thetvdb.com/banners/".$remote_poster);
		file_put_contents($putimage,$getimage);
									}
													}else	{
			//Print "<p>Bad file - It's a trap!</p>";
			$overview="Sorry, A problem occured while trying to access thetvdb.com  As a result the one time collection of information for this series could not occur.  Please try again in a few minutes";
			$seriesname=$array_of_dir[$x];
			unlink($series_xml);
															}
	//print "$array_of_dir[$x]".$pre_xml_check[2];	

		
//print information on to page	?>
	<div class="container">
	
			<?php if($language=="en"){ ?>
				<dl class="tabs marg">
					<dd><a href="#simple<?php echo $x;?>" class="active"><span class="name"><?php echo $seriesname?></span></a></dd>
					<dd><a href="#simple<?php echo $x."1";?>">Overview</a></dd>
				</dl>

				<ul class="tabs-content">
					
					<li class="active" id="simple<?php echo $x."Tab";?>"><p><a href="seasons.php?series=videos/<?php echo$array_of_dir[$x]?>&id=<?php echo$seriesid?>&xml_check=<?php echo$language?>"><img src="<?php echo $postername?>" width="auto"></a><p></li>
					<li id="simple<?php echo $x."1Tab";?>"><p class="description"><?php echo$overview?></p></li>
				</ul>
	
	
	</div>
						<?php		}
				else{ ?>
					<a href="seasons.php?series=videos/<?php echo$array_of_dir[$x]?>&id=<?php echo$seriesid?>&xml_check=<?php echo$language?>" class="nice radius blue button"><span class="name"><?php echo$array_of_dir[$x]?></span></a> <br>
					<img src="images/lue_banner.jpg" class='margin' width="auto">
	</div><br>
							<?php	}
								?>
									
			
<?php
$x = $x+1;	
} 
?>
</ul>
</div>
    <script type="text/javascript">
            
        /* 
        * Series Name/Description
        */
        
        var options = {
    	    valueNames: [ 'name', 'description']
        };

        var featureList = new List('TV-series-list', options);
        

    </script>
</body>
</html>
