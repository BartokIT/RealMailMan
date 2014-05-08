<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Gestione Posta in Uscita</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<script src="<?= _i("modernizr.js","2.6.2") ?>"></script>		
		<link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>	
    </head>
    <body>
<!-- HEADER -->
<?php
    include("presentation/clpservice/header.php");
?>
<!-- CONTENT -->
	        <div id="content"  class="year-list"> <!-- [content] -->
	            <h2>Anni in archivio</h2>
	            <ul>		
		        <?php
						$is_current_year = false;
						$print_year ="";
						foreach ( $p['years'] as $year)
						{
						   $print_year .= '<li><a class="year_list" href="' . _l("default","distinte","view_distinte") . '&amp;year=' . $year->year . '">' . $year->year	 . '</a></li>';
							if ($p['current_year'] ==  $year->year)
							{
								$is_current_year = true;
							}
						}
						
						if (!$is_current_year)
						{
								$print_year =  '<li><a class="year_list" href="' . _l("default","distinte","view_distinte") . '&amp;year=' . $p['current_year'] . '">' . $p['current_year']	 . '</a></li>' . $print_year;			
						}
						echo $print_year;			
		        ?>
		        </ul>
	        </div> <!-- [/content] --> 	        
<?php include("presentation/clpservice/footer.php"); ?>
    </body>
</html>
