<?php
/**
* Funzione per inizializzare l'area e la site view
*/

function inizializza()
{
	return new ReturnedArea("public","default");
}

define("INDEX", basename($_SERVER['SCRIPT_FILENAME']));
define("PRODUCTION",true);
include("support.php");
setlocale(LC_COLLATE, 'C');	

//$stringa = 'Iñtër  nâtiônàl\'izætiøn Haendel and also Hàndel dell\'orto';
$table_prefix = "idx_";			
$new = new Flusso("clp","nodo_principale");
		
$nome_file = $new->elaborates();
//echo sha1("postinopostino");
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
?>
