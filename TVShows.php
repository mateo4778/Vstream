
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
//generate required folders
$add_dir1="videos/$array_of_dir[$x]/01";
if (!file_exists($add_dir1)){
mkdir($add_dir1);
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
													}else	{
			Print "<p>Bad file - It's a trap!</p>";
			$overview="Sorry, A problem occured while trying to access thetvdb.com  As a result the one time collection of information for this series could not occur.  Please try again in a few minutes";
			unlink($series_xml);
															}
	//print "$array_of_dir[$x]".$pre_xml_check[2];	

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
		
//print information on to page	?>
	<div class="container">
		<div class="row textbox">
			<?php if($language=="en"){ ?>
				<div class="six columns">
				<a href="seasons.php?series=videos/<?php echo$array_of_dir[$x]?>&id=<?php echo$seriesid?>&xml_check=<?php echo$language?>" class="nice radius blue button"><?php echo$seriesname?></a> <br>
				<img src="<?php echo $postername?>" class='margin' width="auto">
				</div>
				<div class="six columns">
				<p class="neg"><?php echo $overview?></p>
				
				
				
				<!--PUT JQUERY SHOW HIDE HERE-->
				
				
				
				</div>
		</div>
	</div><br>
						<?php		}
				else{ ?>
					<a href="seasons.php?series=videos/<?php echo$array_of_dir[$x]?>&id=<?php echo$seriesid?>&xml_check=<?php echo$language?>" class="nice radius blue button"><?php echo$array_of_dir[$x]?></a> <br>
					<img src="images/lue_banner.jpg" class='margin' width="auto">
					<p><?php echo$overview?></p>
			</div>
		</div>
	</div><br>
							<?php	}
								?>
									
			
<?php
$x = $x+1;	
} 
?>
</body>
</html>
