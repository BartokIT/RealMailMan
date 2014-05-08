<?php
/**
* $action variabile che contiene il nome dell'area corrente
*
*/

	add_to_debug("Azione",  $action);
	switch ($action)
	{
		case "dettaglio_distinta":
				$id_distinta=$_REQUEST["distinta"];				
				$data_distinta=$_REQUEST["time"];
				$result=get_distinta($id_distinta,$data_distinta);
				$data_distinta=date("d/m/Y",$data_distinta);

				if ($result == NULL)
				{
					return new ReturnedArea("clpservice","default");
				}
				$year=date("Y");	
        		if (isset($_SESSION["latest_year_viewed"]))
        		{
        		    $year = $_SESSION["latest_year_viewed"];
        		}		
				if (strcmp($result["type"],"R") == 0)				
				{

				    /* strip spaces, substitution with other*/
				    array_map(function($element){
        		       $element->prot =  str_replace(array("+",".",",","-",";")," ",$element->prot);
        		       if ($element->AR == "1")
                            $element->AR = "X";
          		       else
              		       $element->AR = "";
              		   if ($element->peso == 0)
              		       $element->peso = "";
              		   else
                  		    $element->peso = $element->peso . " gr";
        		       return $element;
				    },$result["rows"]);
				    return new ReturnedPage("raccomandate.php", array("rows"=>$result["rows"],"date"=>$data_distinta,"id"=>$id_distinta,"latest_year_viewed"=>$year));	
				}
				else if (strcmp($result["type"],"P") == 0)
			    {
			    
					return new ReturnedPage("prioritaria.php",array("rows"=>$result["rows"],"date"=>$data_distinta,"id"=>$id_distinta,"latest_year_viewed"=>$year));	
				}
				else if (strcmp($result["type"],"O") == 0)
					return new ReturnedPage("ordinaria.php",array("rows"=>$result["rows"],"date"=>$data_distinta,"id"=>$id_distinta,"latest_year_viewed"=>$year));
					break;	
		case "nuova_distinta":
				
				if (isset($_REQUEST["tipo"]) && isset($_REQUEST["data"]))
				{
					$type = $_REQUEST["tipo"];
					$_SESSION["date"]=$_REQUEST["data"];
					if (strcmp($type,"R") == 0)
						return new ReturnedArea("clpservice","default","nuova/raccomandata");
					else if (strcmp($type,"P") == 0)
						return new ReturnedArea("clpservice","default","nuova/prioritaria");
				}
				else
				{
					return new ReturnedPage("nuova_distinta.php");
				}
		default:
		case "":
			$year= @$_REQUEST["year"];
			if (is_numeric($year))
			{
				$_SESSION["latest_year_viewed"]=$year;
				$parameters = array("distinte"=>get_distinte($year),"year"=>$year);
				return new ReturnedPage("distinte.php",$parameters);
			}
			else
				return new ReturnedArea("clpservice","default");
	}


?>
