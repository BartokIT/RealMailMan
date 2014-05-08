<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Elenco distinte</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<script src="<?= _i("modernizr.js","2.6.2") ?>"></script>
		<script src="<?= _i("jquery.js","1.10.2") ?>"></script>		
		<script src="<?= _i("jquery.table-filter.min.js") ?>"></script>
	    <script>
	         $(function(){
            	$(".list").addTableFilter({labelText: "Ricerca distinta: "});
        	});
	    </script>		
		<link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>
			
    </head>
    <body>
<!-- HEADER -->
<?php
		require("presentation/clpservice/header.php");
?>
<!-- CONTENT -->
	        <div id="content">
	            <p class="list-head">Elenco delle distinte prodotte durante l'anno solare <strong><?= $p['year'] ?></strong></p>
                <table class="list" border="1"  cellspacing="0" width="800">
                 <thead>
                    <tr>
                        <th class="counter" scope="col" width ="70">
                            Numero<br>progressivo
                        </th>
                        <th scope="col" width="80">
                            Data
                        </th>
                        <th scope="col" width="80">
                            Tipo
                        </th>				
                        <th scope="col" width="610">
                            Descrizione
                        </th>
                    </tr>
	           </thead>
	           <tbody>
		        <?php
			        $last_dist = -1;
			        $distinte=array();
			        // Loop through all the records and group by distinta
			        foreach ( $p['distinte'] as $riga_distinta)
			        {				
				        if (!array_key_exists($riga_distinta->dist,$distinte))
				        {
					        $distinte[$riga_distinta->dist]= array("date"=>$riga_distinta->data,
															        "type"=>$riga_distinta->tipo,
															        "values"=>array(),
															        "destinations"=>array());
				        }
				        if (strcmp($riga_distinta->tipo,'R') == 0)
					    {
					        $distinte[$riga_distinta->dist]["values"][]="n. " . $riga_distinta->racc . " prot. " . $riga_distinta->prot;
					        $distinte[$riga_distinta->dist]["destinations"][]=$riga_distinta->destinatario;
					        
					    }
				        else
					        $distinte[$riga_distinta->dist]["values"][]= $riga_distinta->prot;
			        }
			        
			        $last_num=0;
			        foreach ($distinte as $num=>$distinta)
			        {
				        $string = implode(", ",$distinta["values"]);
				        $time=strtotime($distinta["date"]);
				        $formatted_date = date("d/m/Y",$time);
				        $destination = implode(", ",$distinta["destinations"]);
				        if ( strcmp($distinta["type"],"R") !=0 )
				        {
					        $string = "Prot. " . $string;
					        if ( strcmp($distinta["type"],"P") == 0 )
						        $type_string = "Prioritaria";
					        else
						        $type_string = "Ordinaria";
				        }
				        else if ( strcmp($distinta["type"],"R") == 0 )
				        {
					        $type_string = "Raccomandata";
				        }
				        if ($last_num != ($num - 1))
						{
								for ($null_num = $last_num +1 ; $null_num < $num;$null_num++)
								{
										echo '<tr><td class="counter">'. $null_num .'</td><td  class="date" colspan="3"> ' . 'ANNULLATA'. '</td></tr>';				
								}
						}
				        echo '<tr><td class="counter"><a href="'. _l("default","distinte","dettaglio_distinta") .'&distinta=' . $num . '&time='.$time.'">' .$num .'</a></td><td  class="date"> '. $formatted_date .'</td><td  class="type">'.$type_string.'</td><td class="description">'. $string .'</td><td style="display:none">' . $destination. '</td></tr>';
				        $last_num = $num;
			        }
					
			        $last_num++;
			        if ( strcmp(date("Y"),$p["year"]) == 0 )
				        echo '<tr><td id="new-distinct" colspan="4"><a href="'. _l("default","distinte","nuova_distinta"). '"> Nuova distinta ... </td></tr>';
		        ?>
		        </tbody>
		        </table>
	        </div>
		<?php include("presentation/clpservice/footer.php"); ?>
    </body>
</html>
