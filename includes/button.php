<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$cmd= "ruby tvdb_scraper.rb videos";

if (isset($_POST['action'])){
	switch($_POST['action']){
		case ('Execute'):

			if ((isset($_POST['cmd'])))
				$cmd = $_POST['cmd'];


			exec($cmd,$output, $return);
			if (isset($_POST['verbose'])){
				echo "return code $return data as follows<br/>";
				foreach ($output AS $key=>$value){
					echo "$value</br>";
				}
			}
			else{
				echo "return code $return process complete<br/>";
			}

			break;
		case ('Reset'):
		default:
			break;
	}
}


?>


<form <?=(isset($_POST['action'])) ? 'style="border-top: black solid 2px"':''?> method="post" action="button.php">
	<p>
		<label>Run Command:</label>&nbsp;&nbsp;<?=$cmd?>
	</p>
	<fieldset>
		<legend>
			Command to be run (leave as is for simplest use)
		</legend>
		<p>
			<label>
				Command
			</label>
			<input style="width: 90%;" type="input" name="cmd" value="<?=$cmd?>" />
		</p>
	
	</fieldset>

	<p>
		<label>
			Show all work:
		</label>
		<input type="checkbox" name="verbose" value="1" />
	</p>
	<p>
		<input type="submit" name="action" value ="Execute" />
		<input type="submit" name="action" value ="Reset" />
	</p>
	
</form>