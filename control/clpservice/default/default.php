<?php
/**
* $action variabile che contiene il nome dell'area corrente
*
*/

	add_to_debug("Azione",  $action);
	switch ($action)
	{
		default:
		case "":
			/* Show the list of the years*/
			$parameters=array("years"=>get_years(), "current_year"=>date("Y"));
			return new ReturnedPage("default.php",$parameters);		
			break;
	}


?>
