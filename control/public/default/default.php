<?php
/**
* $action variabile che contiene il nome dell'area corrente
*
*/

	add_to_debug("Azione",  $action);
	switch ($action)
	{
		case "login":
		    $user = @$_REQUEST["user"];	
		    $password = @$_REQUEST["passwd"];		    
    		$user_detail = get_user_credential($user);
    		if (empty($user_detail))
    			return new ReturnedPage("default.php");                		
    		else if (strcmp($user_detail["password"],sha1($user . $password)) == 0)
    		{
				$_SESSION["user_detail"]=array("name"=>$user_detail["name"]);
				return new ReturnedArea("clpservice","default");
			}
		else    			
    			return new ReturnedPage("default.php");            
		    break;	
		default:
		case "":
			/* Show the list of the years*/
			return new ReturnedPage("default.php");
			break;

	}


?>
