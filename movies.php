<?php include "includes/password_protect.php";?>
<?php include "includes/abovecss.php";?>
<head>
<?php include "includes/css.php";?>

	<?php include"includes/google.php"; ?>
</head>
<Body>

<?php include "includes/menubar.php"; ?>
<center><h1>Movies</h1></center>
<?php
//$dir to be printed
$dir    = "movies";
//scandir populates an array with all files in the $dir directory
$array_of_dir = scandir($dir);
//Get the size of the directory array for use in loop
$dir_array_size = sizeof($array_of_dir);
//clears blank lines(folders) in array - change to 1 or 0 to see why.
$x=2;

?><div class="container"><?php
while ($x < ($dir_array_size) )	{

//Break file into parts to check extention
$movie_array=explode(".",$array_of_dir[$x]);
If($array_of_dir[$x] =="metadata"){
$ext_check="nul";
}else{
$ext_check=$movie_array[1];
	}
//extention check
If($ext_check=="mp4"){
$file = "movies/metadata/".$movie_array[0].".xml";
	If(!file_exists($file))	{
	//Define path to grab XML
	$xmlurl="http://www.imdbapi.com/?i=&t=$movie_array[0]";
	// Write XML into variable (JSON)
	$current = file_get_contents($xmlurl);
	
	// Write the contents back to the file
	file_put_contents($file, $current);

							}
							
	//If local copy of XML exists, display data						
	If(file_exists($file))	{
				$json = file_get_contents($file);
				$obj = json_decode($json);
				$plot = $obj->{'Plot'};
				$poster = $obj->{'Poster'};
				$id = $obj->{'ID'};
				$title = $obj->{'Title'};
				$postername= "movies/metadata/".$id.".jpg";

							}
				
	//If No Local copy of the bannar, Go get it
	If(!file_exists($postername))	{
	
		$putimage =$postername;
		file_put_contents($putimage, file_get_contents($poster));?>
		<a href="<?php echo "player.php?filename=movies/$array_of_dir[$x]"?>">
		<div class="contained textbox2 centered">
		<img class="size" src="<?php echo $postername?>"><br>
		<center><br><?php echo $array_of_dir[$x]?></center>
		</div></a><?php
		
	}else{?>
		<a href="<?php echo "player.php?filename=movies/$array_of_dir[$x]"?>">
		<div class="contained textbox2 centered">
		<img class="size" src="<?php echo $postername?>"><br>
		<center><br><?php echo $title?></center>
		</div></a><?php
	}	
							}
							
$x = $x+1;
								}?></div>