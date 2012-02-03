<?php
function dlist($pretag,$posttag){
//$directory to be generated in an array
$dir = getcwd();
//scandir populates an array with all files in the $dir directory
$array_of_dir = scandir($dir);
//Get the size of the directory array for use in loop
$dir_array_size = sizeof($array_of_dir);

//clears blank lines in array - change to 1 or 0 to see why.
$x=2;
//Print Directory list with formatting
while ($x < ($dir_array_size) ){
print "$pretag$array_of_dir[$x]$posttag";
$x = $x+1;
}
}
?>