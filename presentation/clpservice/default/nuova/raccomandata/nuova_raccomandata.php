<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Nuova raccomandata</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<script src="<?= _i("jquery.js","1.10.2") ?>"></script>
		<script src="<?= _i("jquery-ui.js","1.10.3")?>"></script>
		<script src="<?= _i("bootstrap-tokenfield.js") ?>"></script>
		<script src="<?= _i("jquery.maskedinput.js") ?>"></script>
		<script src="<?= _i("jquery.ba-bbq.js")?>"></script>
		<script src="<?= _i("jquery.cookie.js")?>"></script>
		<script src="<?= _i("nuova_raccomandata.js") ?>"></script>
		<link href="resources/css/ui-lightness/jquery-ui-1.10.3.css" rel="stylesheet" type="text/css" />
        <link type="text/css" rel="stylesheet" href="<?= _i("bootstrap-tokenfield.css") ?>"/>        		
        <link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>		
    <body>
    <!-- HEADER -->
    <?php
        require("presentation/clpservice/header.php");
    ?>
	<div id="content"  class="raccomandata-view raccomandata-new">
	    <h2>Conto di Credito Ordinario n. 1127</h2>
	    <p class="list-specs">Elenco del <?php echo   $p["date"]; ?></p>
	    <p class="list-header"> Elenco pieghi <strong>Raccomandate e Assicurate</strong> consegnate all'ufficio postale di Latina Centro</p>

		<form id="rows_form" action="<?php echo INDEX; ?>" method="post">		
		<?php
				foreach ( _l_a("default","nuova/raccomandata","insert") as $key=>$value )
				{
					echo '<input type="hidden" name="' . $key . '" value="' . $value .'"/>';
				}
				echo '<input type="hidden" name="nonce" value="' . get_nonce_value("default/nuova/raccomandata","R") .'"/>';
				echo '<input type="hidden" name="year" value="' . $p["latest_year_viewed"] .'"/>';
		?>
	    <table id="raccomandata_table" class="list">
			<thead>
				<tr>
					<th class="counter" >Numero<br/>d'ordine</th>
					<th class="protocol">Prot.<br/>numero</th>
					<th class="receiver" scope="col">Destinatario</th>
					<th class="city" >Citt&agrave;</th>
					<th class="province">Provincia</th>
					<th class="postal_code">CAP</th>
					<th class="num_racc">Raccomandata<br/>numero</th>
					<th class="ar">A.R.</th>
					<th class="weight">Peso</th>
					<th class="delete"></th>
				</tr>
			</thead>
			<tbody>
			<!--	<tr>
					<td class="counter">1</td>
					<td class="protocol"><input type='text' name="prot[]" value=""/></td>
					<td class="receiver"  scope="col"><input type='text' name="destinatario[]" value=""/></td>
					<td class="city" ><input type='text' name="citta[]" value=""/></td>
					<td class="province" ><input type='text' name="provincia[]" value=""/></td>
					<td class="postal_code" ><input type='text' name="cap[]" value=""/></td>
					<td class="num_racc"><input type='text' name="numracc[]" value=""/></td>
					<td class="ar"><input type='checkbox' name="ar[0]" value="on"/></td>
					<td class="weight"><input type='text' name="peso[]" value=""/></td>
					<td class="delete"><a href="#" /><img src="resources/css/del_row.png" alt="Cancella riga"/></a></td>					
				</tr>
			-->
			</tbody>
		</table>
		<p><a id="add_row" href="#">Aggiungi riga...</a></p>
		<input id="confirm_rows"  name='azione' type='submit' value='Inserisci' />		
		<a style="display:none" id="deconfirm_rows" href="#">Annulla</a>		
		<a id="back" href="<?php echo _l("default","nuova/raccomandata","back") . "&amp;nonce=" . get_nonce_value("default/nuova/raccomandata","R") . "&amp;year=" . $p["latest_year_viewed"];?>">Indietro</a>	
		</form>
	</div>
    <?php include("presentation/clpservice/footer.php"); ?>	
    </body>
</html>
