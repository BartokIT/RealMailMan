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
			$city = $_REQUEST["city"];
			if ( strlen($city) > 2)
			{
				$cities = get_cities($city);
			}
			else
			{
				$cities = array();
			}
			
			return new ReturnedAjax("json",$cities);
			break;
	}


?>
