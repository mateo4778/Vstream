<?php include "includes/password_protect.php";?>
<?php include "includes/abovecss.php";?>
<head>

<script src="/video-js/video.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="/video-js/video-js.css" type="text/css" media="screen" title="Video JS" charset="utf-8">
<!-- VideoJS Optional Skins -->
<link rel="stylesheet" href="/video-js/skins/vim.css" >
<script type="text/javascript" charset="utf-8">
    // Add VideoJS to all video tags on the page when the DOM is ready
    VideoJS.setupAllWhenReady();
</script>

<?php include "includes/css.php";?>

</head>

<body>
<?php include "includes/menubar.php"; ?>
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
Print "<a href=\"player.php?filename=".$previous_ep."&preview=".$season_folder."metadata/".($episode-1).".jpg&episode=".($episode-1)."\"$nice_button> << Back</a>";
}
//print next episode
if (file_exists($next_ep)&&$all_files[$next_ep_number]!="metadata"){
Print "<a href=\"player.php?filename=".$next_ep."&preview=".$season_folder."metadata/".($episode+1).".jpg&episode=".($episode+1)."\"$nice_button> Next >></a>";
}
print "</tr></table></center>";
?>
<!-- Begin VideoJS -->
<center>
 
  <div class="video-js-box vim-css">
    <video class="video-js" width="480" height="270" controls preload>
      <source src="<?php echo $filename;?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
        <!-- Image Fallback. Typically the same as the poster image. -->
        <img src="<?php echo $preview ?>" width="480" height="270" alt="Poster Image" title="No video playback capabilities." />
      </object>
    </video>
  </div>
  <br>
  <a href="player2.php?filename=<?php echo $filename ?>&preview=<?php echo $preview ?>&episode=<?php echo $episode ?>"<?php echo $nice_button?>>Try our Javascript Player instead!</a><br><br><br>
</center>
<!-- End VideoJS -->

</html>