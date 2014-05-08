<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Nuova prioritaria</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<script src="<?= _i("jquery.js","1.10.2") ?>"></script>
		<script src="<?= _i("jquery-ui.js","1.10.3")?>"></script>
		<script src="<?= _i("bootstrap-tokenfield.js") ?>"></script>					
		<script src="<?= _i("nuova_prioritaria.js") ?>"></script>
		<script src="<?= _i("jquery.maskedinput.js") ?>"></script>
		<script src="<?= _i("jquery.ba-bbq.js")?>"></script>
		<script src="<?= _i("jquery.cookie.js")?>"></script>			
		<link href="<?= _i("ui-lightness/jquery-ui.css","1.10.3")?>" rel="stylesheet" type="text/css" />
		<link href="resources/css/ui-lightness/jquery-ui-1.10.3.css" rel="stylesheet" type="text/css" />
		<link type="text/css" rel="stylesheet" href="<?= _i("bootstrap-tokenfield.css") ?>"/>		
		<link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>
		
    </head>
    <body>
    <!-- HEADER -->
    <?php
        require("presentation/clpservice/header.php");
    ?>
	<div id="content" class="ordinaria-view ordinaria-new">
		<h2> Conto di Credito Ordinario n. 1127</h2>
		<p class="list-specs">Elenco del <?php echo   $p["date"]; ?></p>	
		<p class="list-header"> Elenco pieghi <strong>Posta prioritaria</strong> consegnati all'ufficio postale di Latina Centro</p>	
		    <!--<p class="testo_normalesx"><strong>Conto di Credito Ordinario n. 1127</strong></P>
		    <p align='right' class='testo_normaledx'>Elenco n.<?php echo $p["distinta"] . " del  " . $p['data_dist'] ?></p>	-->
		    
		    <form id="rows_form" action="<?php echo INDEX; ?>" method="post">
		    
		    <?php
		    foreach (_l_a("default","nuova/prioritaria","insert") as $key=>$value)
		    {
			    echo '<input type="hidden" name="' . $key . '" value="' . $value .'"/>';
		    }
		    echo '<input type="hidden" name="nonce" value="' . get_nonce_value("default/nuova/prioritaria","P") .'"/>';
			echo '<input type="hidden" name="year" value="' . $p["latest_year_viewed"] .'"/>';
		    ?>
		<table id="prioritaria_table" class="list" border="1"  cellspacing="0" width="700">
		<thead>
		    <tr>
			    <th class="quantity"  scope="col">Numero<br/>pieghi</th>
			    <th class="prot"  scope="col">Prot.<br/>numero</th>
			    <th class="type"  scope="col">CATEGORIA<br/>(Lettere, Inviti, Stampe, ecc.)</th>
			    <th class="delete"></th>	                
		    </tr>
		</thead>
		<tbody>
			<!--
			<tr>
				<td class="quantity"><input type="text" name="pieghi[]" value=""/></td>					
				<td class="prot"><input class="prot_input" type="text" name="prot[]" value=""/></td>
				<td class="type"><input class="type-input" type='text' name="categoria[]" value="" /></td>
				<td class="delete"><a href="#" /><img src="resources/css/del_row.png" alt="Cancella riga"/></a></td>		
			</tr>
			-->
		</tbody>
		</table>
		<p><a id="add_row" href="#">Aggiungi riga...</a></p>
	    <input id="confirm_rows"  name='azione' type="submit" value="Inserisci" />		
	    <a style="display:none" id="deconfirm_rows" href="#">Annulla</a>		
	    <a id="back" href="<?php echo _l("default","nuova/prioritaria","back") . "&amp;nonce=" . get_nonce_value("default/nuova/prioritaria","P") . "&amp;year=" . $p["latest_year_viewed"]; ?>">Indietro</a>	
		</form>
	</div>
    <?php include("presentation/clpservice/footer.php"); ?>	
    </body>
</html>
	
    </body>
</html>
