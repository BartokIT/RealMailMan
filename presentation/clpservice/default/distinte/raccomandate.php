<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Posta raccomandata - Elenco n. <?php echo $p["id"] . " del  " . $p["date"]; ?></title>
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
<!-- CONTENT -->
	<div id="content" class="raccomandata-view">
	    <h2>Conto di Credito Ordinario n. 1127</h2>
	    <p class="list-specs">Elenco n. <?php echo $p["id"] . " del  " . $p["date"]; ?></p>	
	    <p class="list-header"> Elenco pieghi <strong>Raccomandate e Assicurate</strong> consegnate all'ufficio postale di Latina Centro</p>
	    <table class="list" border="1"  cellspacing="0" width="800">
             <thead>
                    <tr>
			            <th class="counter" scope="col" >Numero<br/>d'ordine</th>
			            <th class="protocol"  scope="col">Prot.<br/>numero</th>
			            <th class="receiver"  scope="col">Destinatario</th>
			            <th class="destination"  scope="col">Destinazione</th>
			            <th class="num_racc"  scope="col">Raccomandata<br/>numero</th>
			            <th class="ar"  scope="col">A.R.</th>
			            <th class="weight"  scope="col">Peso</th>
        			</tr>
	       </thead>
	       <tbody>
		    <?php
			    foreach ($p["rows"] as $row)
			    {
				    echo '<tr><td class="counter">' . $row->progressivo .'</td><td class="protocol" > '. $row->prot .'</td><td class="receiver">'.$row->destinatario .'</td><td  class="destination">'. $row->CAP . " - " .$row->citta   .'</td><td class="num_racc">'.$row->racc.'</td><td class="ar">'.$row->AR.'</td><td class="weight">'. $row->peso .'</td></tr>';
			    }
		    ?>
		    </tbody>
		    </table>
	        <a id="back" href="<?php echo _l("default","distinte") . "&amp;year=" . $p["latest_year_viewed"];?>">Indietro</a>			    
	</div>

<?php include("presentation/clpservice/footer.php"); ?>	
    </body>
</html>
