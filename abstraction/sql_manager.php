<?php

function execute_sql_file($id_sql_connection, $database_name,$sql_file)
{
	$select_result = mysql_select_db($database_name,$id_sql_connection);
	$install_path = dirname($_SERVER['SCRIPT_FILENAME']) . "/";

	if ($select_result == FALSE)
	{
		return FALSE;
	}
	else
	{
		$file_array= file($install_path . $sql_file);

		if ($file_array == FALSE)
		{
			//echo $install_path . $sql_file;
			return FALSE;
		}
		else
		{
			$no_problem = TRUE;
			$sql_string_commands = "";

			//scorro le righe per vedere quelle che iniziano con un commento

			foreach($file_array as $row)
			{
				$trim_row = trim($row);

				//se inizia con un commento le ignoro altrimenti le inserisco in un array
				if (!preg_match("/^--.*/", $trim_row))
				{
					$sql_string_commands .= " " . $trim_row;
				}
			}


			//splitto i vari comandi sql che sono divisi da un ";"
			$sql_commands = explode(";",$sql_string_commands);

			foreach ($sql_commands as $sql_query)
			{
				//echo $sql_query . "<br/>";
				//echo htmlspecialchars($content);

				$create_tables_result = mysql_query($sql_query);

				if (!$create_tables_result)
				{
					switch( mysql_errno())
					{
						//ERRORI GRAVI
						default: //errore sconosciuto
							echo mysql_error() . " " . mysql_errno() ." <br/>";
						case 1005: //errore di impossibilità creazione tabella - GRAVE
							$no_problem = $no_problem && FALSE;
							echo mysql_error() . " " . mysql_errno() ." <br/>";
							break;

							//ERRORI NON GRAVI
						case 1065: //query vuota
						case 1062: //chiave già esistente	
						case 1050: //tabella già esistente
					}
				}
					
			}

			return $no_problem;
		}
	}
}


function get_user_credential($user)
{
	global $db;
	$user=$db->escape($user);
	$row = $db->get_row("SELECT u.name,u.access_password FROM users u  WHERE u.id='$user'");
	
	if ($row == NULL)
	    return array();
	else
	    return array("name"=>$row->name, "password"=>$row->access_password, "groups"=>array());
}

function get_years()
{
	global $db;
	$years = $db->get_results("SELECT DISTINCT EXTRACT(YEAR FROM Data_distinta) As year FROM distinte d ORDER BY year DESC");

	if ($years == NULL)
		return array();
	else
		return $years;
}

function get_next_distinta_id($year)
{
	global $db;
	$year = $db->get_var("SELECT MAX(d.Id_Distinta) As year FROM distinte d WHERE  EXTRACT(YEAR FROM d.Data_distinta) = $year");
	
	if ($year == NULL)
		return 1;
	else
		return ($year*1 + 1);
}

function get_distinte($year)
{
	global $db;
	$year = $db->escape($year);
	$results = $db->get_results("SELECT dist, data,id, tipo, prot, racc, destinatario FROM (
(SELECT d.ID_Distinta as dist,d.Data_Distinta as data, p.Id_posta_Prioritaria as id, d.Tipo_Distinta as tipo, p.Protocollo_Prioritaria as prot, NULL as racc, NULL as destinatario  FROM prioritaria p, distinte d WHERE EXTRACT(YEAR FROM d.Data_distinta) = $year  AND p.Ext_id_Distinta = d.Id_Distinta AND d.Data_Distinta = p.Ext_Data_distinta) 
 UNION 
(SELECT d.ID_Distinta as dist, d.Data_Distinta as data, o.Id_posta_ordinaria as id, d.Tipo_Distinta as tipo,o.Protocollo_ordinaria as prot, NULL as racc, NULL as destinatario FROM ordinaria o, distinte d WHERE EXTRACT(YEAR FROM d.Data_distinta) = $year AND o.Ext_id_Distinta = d.Id_Distinta AND d.Data_Distinta = o.Ext_Data_distinta)
UNION
(SELECT d.ID_Distinta as dist, d.Data_Distinta as data, r.ID_racc as id, d.Tipo_Distinta as tipo, r.Prot as prot, r.Racc_num as racc, r.Destinatario as destinatario FROM raccomandate r, distinte d WHERE EXTRACT(YEAR FROM d.Data_distinta) = $year AND r.Ext_id_dist = d.Id_Distinta AND d.Data_Distinta = r.Ext_Data_distinta)
) results ORDER BY data ASC, dist ASC");
	

	if ($results == NULL)
		return array();
	else
		return $results;
	
}

function get_cities($prefix,$country = "IT")
{
	global $db;
	$prefix = $db->escape($prefix);
	$results = $db->get_results("SELECT place_name as name,admin_name1 as region, admin_name2 as province, admin_code2 as prov_code, postal_code as postal_code FROM postal_codes WHERE place_name LIKE '$prefix%' ORDER BY place_name ASC, postal_code ASC LIMIT 50");
	
	if ($results == NULL)
		return array();
	else
		return $results;	
}

function get_distinta($id,$date)
{
	global $db;
	$id = $db->escape($id);
	$date = $db->escape($date);
	$date = date("Y-m-d",$date);
	$results=array();
	$results["type"] = $db->get_var("SELECT d.Tipo_Distinta as tipo FROM distinte d WHERE d.ID_Distinta = $id AND d.Data_Distinta = '$date'");
	
	if ($results == NULL)
		return NULL;
	
	if (strcmp($results["type"],"R") == 0)
	{
		$rows=$db->get_results("SELECT r.id_racc as id, r.Prot as prot, r.Racc_num as racc, r.Num_progressivo as progressivo, r.Destinatario as destinatario, r.CAP, r.Citta as citta, r.AR, r.Peso as peso
							FROM raccomandate r, distinte d
							WHERE d.ID_Distinta = $id AND d.Data_Distinta = '$date' AND r.Ext_id_dist = d.Id_Distinta AND d.Data_distinta = r.Ext_data_distinta ");
	}
	else if (strcmp($results["type"],"P") == 0)
	{
		$rows=$db->get_results("SELECT p.Num_pieghi as pieghi, p.Tipo_documento as documento, p.Id_posta_Prioritaria as id, p.Protocollo_Prioritaria as prot
							FROM prioritaria p, distinte d
							WHERE p.Ext_id_Distinta = d.Id_Distinta  AND d.Data_Distinta = p.Ext_Data_distinta AND d.ID_Distinta = $id AND d.Data_Distinta = '$date'");
	}
	else if (strcmp($results["type"],"O") == 0)
	{
		$rows=$db->get_results("SELECT o.Num_pieghi as pieghi, o.Tipo_documento as documento, o.Id_posta_ordinaria as id, o.Protocollo_Ordinaria as prot
							FROM ordinaria o, distinte d
							WHERE o.Ext_id_Distinta = d.Id_Distinta  AND d.Data_Distinta = o.Ext_Data_distinta AND d.ID_Distinta = $id AND d.Data_Distinta = '$date'");
	}

	
	if ($rows != null)
		$results["rows"] = $rows;
	else
		$results["rows"] = array();	
	
	return $results;	
}

function insert_new_prioritaria($id_distinta, $data_distinta, $rows)
{
	global $db;
	// Escape and assign the value.
	$id_distinta = $db->escape($id_distinta);
	//$time=strtotime($data_distinta);
	$data_distinta = date("Y-m-d",$data_distinta);	
	$data_distinta = $db->escape($data_distinta);	
	$result = $db->query("INSERT INTO distinte (Id_Distinta,Data_Distinta,Tipo_Distinta) VALUES ($id_distinta,'$data_distinta','P')");
	foreach($rows as $index=>$row)
	{	
		$prot = $db->escape($row["prot"]);
		$pieghi = $db->escape($row["pieghi"]);
		$categoria = $db->escape($row["categoria"]);
		$result = $db->query("INSERT INTO prioritaria (Protocollo_Prioritaria, Num_pieghi, Tipo_documento, Ext_id_Distinta, Ext_Data_distinta) VALUES "
		. " ( '$prot','$pieghi','$categoria', $id_distinta,'$data_distinta')");
		
		if ( !$result )
		{
			return false;
		}
	}
	
	return $result;
	/*$db->query("INSERT INTO Distinte (Id_Distinta,Data_Distinta,Tipo_Distinta) VALUES ($id,$date,'R')");*/
}

function insert_new_raccomandata($id_distinta, $data_distinta, $rows)
{
	global $db;
	// Escape and assign the value..
    //$title = $db->escape(“Justin’s and Amy’s Home Page”);
    // Insert in to the DB..
	$id_distinta = $db->escape($id_distinta);
	//$time=strtotime($data_distinta);
	$data_distinta = date("Y-m-d",$data_distinta);	
	$data_distinta = $db->escape($data_distinta);	
	$result = $db->query("INSERT INTO distinte (Id_Distinta,Data_Distinta,Tipo_Distinta) VALUES ($id_distinta,'$data_distinta','R')");
	foreach($rows as $index=>$row)
	{	
		$prot = $db->escape($row["prot"]);
		$destinatario = $db->escape($row["destinatario"]);
		$cap = $db->escape($row["cap"]);
		$citta = $db->escape($row["citta"]) . " (" . $db->escape($row["provincia"]).")";
		$ar = $db->escape($row["ar"]);
		$raccomandata = $db->escape($row["raccomandata"]);
		$peso = $db->escape($row["peso"]);
		$idx = $index + 1;
		$result = $db->query("INSERT INTO raccomandate (Num_progressivo,Prot, Destinatario, CAP, Citta, AR, Racc_num, Peso, Ext_id_dist, Ext_Data_distinta) VALUES "
		. " ( $idx,'$prot','$destinatario','$cap','$citta','$ar','$raccomandata','$peso',$id_distinta,'$data_distinta')");
		//$db->debug();
		if ( !$result )
			return false;
	}
	
	
	
	return $result;
	/*$db->query("INSERT INTO Distinte (Id_Distinta,Data_Distinta,Tipo_Distinta) VALUES ($id,$date,'R')");*/
}
?>
