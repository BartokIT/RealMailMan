<?php

    function _i($file,$ver="",$type="")
    {
        $ver_st = strcmp($ver,"") ? "&amp;ver=" . $ver : "";
        if (PRODUCTION)
            $type_st = "&amp;type=min";
        else
            $type_st = strcmp($type,"") ? "&amp;type=" . $type : "";
        return INDEX ."?include=" . $file . $ver_st . $type_st;
    }

    function _l($area="default",$subarea="default", $action="")
    {
        $sub_area_st = strcmp($subarea,"default") ? "&amp;subarea=" . $subarea : "&amp;subarea=default";
		$action_st = strcmp($action,"") ? "&amp;action=" . $action : "";
        return INDEX ."?area=" . $area . $sub_area_st . $action_st ;
    }
    
	function _l_a($area="default",$subarea="default", $action="")
    {
		$js_link = array("index"=>INDEX,"area"=>$area);
        if (strcmp($subarea,"default") != 0) $js_link["subarea"]=$subarea;
		if (strcmp($action,"") != 0) $js_link["action"]=$action;
		
        return $js_link;
    }
	
    function _i_script($files)
    {
		$string = INDEX . "?i=0";
		$i=0;
		foreach ($files as $filespec)
		{
			$ver_st = strcmp(@$filespec["ver"],"") ? ",'ver':'" . $filespec["ver"] ."'" : "";
			if (PRODUCTION)
				$type_st = ",'type':'min'	";
			else
				$type_st = strcmp(@$filespec["type"],"") ? ",'type'='" . $filespec["type"] . "'": "";
				
			$string .= "&amp;include[$i]={'name':'" . $filespec["file"] ."'" . $ver_st . $type_st ."}";
			$i++;
		}
		        
        return "<script src=\"$string\"></script>";
    }
	
	function _to_string_file($file)
	{
		$parameter = get_file_data($file,array("title"=>"title"),"b");
		$body=""; //return string
		ob_start();
		include $file;
		$body = ob_get_contents();
		ob_end_clean();
		$parameter["body"]=$body;
		return $parameter;
	}

	function parse_resources()
	{
			//imposto della aggiunte
		if (isset($_REQUEST["include"]))
		{
			if (is_array($_REQUEST["include"]))
			{
				foreach($_REQUEST["include"] as $file_spec)
				{
					//var_dump($file_spec);
					$file = json_decode(str_replace("'","\"",$file_spec),true);
					
					//var_dump($file);
					$file_info = pathinfo($file["name"]);
					$filename=$filename_backup= "resources/"  . $file_info["extension"] . "/". substr($file_info["filename"],0,100);
					
					//valuto la correttezza dei parametri inseriti
					$ver=@$file["ver"] ? $file["ver"]  : "";
					$filename .=  (0 + $ver) > 0 ? "-" . $ver  : "";
					
					$type=@$file["type"] ? @$file["type"] : "";
					$filename .= !strcmp($type,"min") ? ( (0 + $ver) > 0 ? "." .  $type : "-" .  $type ): "";

					$filename .= "." .$file_info["extension"];
					$filename_backup .= "." .$file_info["extension"];
					if ($file_info["extension"] == "js")
						 header("Content-Type: text/javascript");
					else if ($file_info["extension"] == "css")
						header("Content-Type: text/css");
					//includo le risorse richieste
					if (file_exists($filename))
					{
						$fp = fopen($filename, 'rb');
						//echo file_get_contents( $filename);
						fpassthru($fp);
						fclose($fp);
					} 
					else  if (file_exists($filename_backup))
					{
						$fp = fopen($filename_backup, 'rb');
						//echo file_get_contents($filename_backup);
						fpassthru($fp);
						fclose($fp);
					}
					echo "\n";
				}
				die();
			}
			
			//estraggo le informazioni del path dal file richiesto
			$file_info = pathinfo($_REQUEST["include"]);
			$filename=$filename_backup= "resources/"  . $file_info["extension"] . "/". substr($file_info["dirname"] . "/" . $file_info["filename"],0,100);
			//valuto la correttezza dei parametri inseriti
			$ver=@$_REQUEST["ver"] ? $_REQUEST["ver"]  : "";
			$filename .=  (0 + $ver) > 0 ? "-" . $ver  : "";
			$type=@$_REQUEST["type"] ? @$_REQUEST["type"] : "";
			$filename .= !strcmp($type,"min") ? "." .  $type : "";

			$filename .= "." .$file_info["extension"];
			$filename_backup .= "." .$file_info["extension"];
			if ($file_info["extension"] == "js")
				 header("Content-Type: text/javascript");
			else if ($file_info["extension"] == "css")
				header("Content-Type: text/css");
			//includo le risorse richieste
			if (file_exists($filename))
			{
				$fp = fopen($filename, 'rb');
				//echo file_get_contents( $filename);
				fpassthru($fp);
				fclose($fp);
			}
			else  if (file_exists($filename_backup))
			{
				$fp = fopen($filename_backup, 'rb');
				//echo file_get_contents($filename_backup);
				fpassthru($fp);
				fclose($fp);
			}
			die();  
		}
	}
	
	/**
 * Retrieve metadata from a file.
 *
 * Searches for metadata in the first 8kiB of a file, such as a plugin or theme.
 * Each piece of metadata must be on its own line. Fields can not span multiple
 * lines, the value will get cut at the end of the first line.
 *
 * If the file data is not within that first 8kiB, then the author should correct
 * their plugin file and move the data headers to the top.
 *
 * @see http://codex.wordpress.org/File_Header
 *
 * @since 2.9.0
 * @param string $file Path to the file
 * @param array $default_headers List of headers, in the format array('HeaderKey' => 'Header Name')
 * @param string $context If specified adds filter hook "extra_{$context}_headers"
 */
function get_file_data( $file, $default_headers, $context = '' ) {
	// We don't need to write to the file, so just open for reading.
	$fp = fopen( $file, 'r' );

	// Pull only the first 8kiB of the file in.
	$file_data = fread( $fp, 8192 );

	// PHP will close file handle, but we are good citizens.
	fclose( $fp );

	// Make sure we catch CR-only line endings.
	$file_data = str_replace( "\r", "\n", $file_data );
	$all_headers = $default_headers;
	

	foreach ( $all_headers as $field => $regex ) {
		if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )		
			$all_headers[ $field ] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
		else
			$all_headers[ $field ] = '';
	}

	return $all_headers;
}

define("NONCE_SALT","mail_manager");
function get_nonce_value($action,$itemtype="")
{
    $nonce = $itemtype . date("Ymd") . md5($action . $itemtype . session_id() . time() . NONCE_SALT);
    
	//Search for another nonces of the same type
	$found=false;
	if (isset($_SESSION["nonces"]))
	foreach ($_SESSION["nonces"] as $stored_nonce)
	{
		if (strpos($stored_nonce, $itemtype . date("Ymd")) === 0)
		{
			$nonce=$stored_nonce;
			$found=true;
			break;
		}
	}
	
	if (!$found)
	{
		//echo "Not found";
		if (!isset($_SESSION["nonces"]))
			$_SESSION["nonces"]=array();
		
		$_SESSION["nonces"][]=$nonce;    
	}	
		return $nonce;
	
}

function verify_nonce($nonce_to_test)
{
    if (in_array($nonce_to_test,$_SESSION["nonces"]))
    {
		$nonce_key = array_search($nonce_to_test,$_SESSION["nonces"]);
		unset($_SESSION["nonces"][$nonce_key]); //verify another method to remove a key
		
		return true;
    }
    else
	return false;
}

?>