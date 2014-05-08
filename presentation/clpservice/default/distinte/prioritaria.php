<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Posta prioritaria -  Elenco n. <?php echo $p["id"] . " del  " . $p["date"];  ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<script src="<?= _i("modernizr.js","2.6.2") ?>"></script>
        <link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>				
    </head>
    <body>
    <!-- HEADER -->
    <?php
        require("presentation/clpservice/header.php");
    ?>
	<div id="content" class="ordinaria-view">
	    <h2>Conto di Credito Ordinario n. 1127</h2>
	    <p class="list-specs">Elenco n. <?php echo $p["id"] . " del  " . $p["date"]; ?></p>	
	    <p class="list-header"> Elenco pieghi <strong>Posta prioritaria</strong> consegnati all'ufficio postale di Latina Centro</p>	
	    <table class="list" border="1"  cellspacing="0" width="700">
         <thead>
			<tr>
				<th class="quantity"  scope="col">Numero<br/>pieghi</th>
				<th class="prot"  scope="col">Prot.<br/>numero</th>
				<th class="type"  scope="col">CATEGORIA<br/>(Lettere, Inviti, Stampe, ecc.)</th>
			</tr>
	   </thead>
	   <tbody>
		<?php
			foreach ($p["rows"] as $row)
			{
				echo '<tr><td class="quantity">' . $row->pieghi .'</td><td class="prot"> '. $row->prot .'</td><td class="type">'.$row->documento .'</td></tr>';
			}
		?>
		</tbody>
		</table>
        <a id="back" href="<?php echo _l("default","distinte") . "&amp;year=" . $p["latest_year_viewed"];?>">Indietro</a>					
	</div>
    <?php include("presentation/clpservice/footer.php"); ?>	
    </body>
</html>
