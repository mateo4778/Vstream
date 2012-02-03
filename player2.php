<?php include "includes/password_protect.php";?>
<?php include "includes/abovecss.php";?>
<html>
<link rel="stylesheet" type="text/css" href="stylesheets/movie.css" />
<head>

	<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<title>Vstream Movie Server 1.0</title>
	
	<meta charset="utf-8" />
	
	<!--Zurb Foundation Start-->
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />
  
	<!-- Included CSS Files -->	

		<!--Include just this style sheet for basic designs witout Zurb Foundation-->
	<link rel="stylesheet" href="stylesheets/basic.css">
	<link rel="stylesheet" href="stylesheets/menubar.css">

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="stylesheets/ie.css">
	<![endif]-->
		
	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- Included JS Files -->
	<script src="javascripts/foundation.js"></script>
	<script src="javascripts/app.js"></script>

<?php //Define color of button used in site - Try replacing blue with red/white/black
	$nice_button=" class=\"nice radius blue button\"";?>
	
<?php include"includes/google.php"; ?>
	</head>


<body>
<?php include "includes/menubar.php"; ?>
<center><h1>Movie Player</h1>
<?php 	$filename = $_GET["filename"]; 
		$preview = $_GET["preview"];
		$episode= $_GET["episode"];
		
?>
<?php
//Break up filename for data
$explode_filename=explode("/",$filename);
$season_folder=$explode_filename[0]."/".$explode_filename[1]."/".$explode_filename[2]."/";
//Build array of directory
$all_files=scandir($season_folder);
//print_r($all_files);
//Find position relative to place holder folders
$episode_position=$episode;

//Define next and previous expisodes as array positions
$next_ep_number=$episode_position+2;

$previous_ep_number=$episode_position;


//file location of next and previous episodes
$next_ep=$season_folder.$all_files[$next_ep_number];
//print $next_ep;
print "<center><table><tr>";
$previous_ep=$season_folder.$all_files[$previous_ep_number];
//Print $previous_ep;

//print $previous_ep;
if (file_exists($previous_ep)&&$all_files[$previous_ep_number]!=".."){
Print "<a href=\"player2.php?filename=".$previous_ep."&preview=".$season_folder."metadata/".($episode-1).".jpg&episode=".($episode-1)."\"$nice_button> << Back</a>";
}
//print next episode
if (file_exists($next_ep)&&$all_files[$next_ep_number]!="metadata"){
Print "<a href=\"player2.php?filename=".$next_ep."&preview=".$season_folder."metadata/".($episode+1).".jpg&episode=".($episode+1)."\"$nice_button> Next >></a>";
}
print "</tr></table></center>";
?>
<div id="mediaplayer">Unsupported Browser</div>
<script type="text/javascript">
  jwplayer("mediaplayer").setup({
    flashplayer: "jwplayer/player.swf",
    <?php 
	$filename = $_GET["filename"] ;
	$preview=$_GET["preview"] ;
	print "file: '". $filename ."',";
	?>
	provider: "http",

	width: 480,
    height: 270
	});
</script>
<a href="player.php?filename=<?php echo $filename ?>&preview=<?php echo $preview ?>&episode=<?php echo $episode ?>"<?php echo $nice_button?>>Back to HTML 5</a><br><br><br>
</center>
</html>
