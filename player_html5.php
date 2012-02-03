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
</center>
</html>
