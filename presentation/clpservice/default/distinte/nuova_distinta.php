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
		<script src="<?= _i("jquery-ui.js","1.10.3")?>"></script>
		<script src="<?= _i("jquery.ui.datepicker-it.js","1.10.3")?>"></script>
        <link type="text/css" rel="stylesheet" href="<?= _i("main.css") ?>"/>		
		<link href="resources/css/ui-lightness/jquery-ui-1.10.3.css" rel="stylesheet" type="text/css" />
	    <script>
	         $(function(){
            	 $( "#datepicker" ).datepicker({minDate: 0});
        	});
	    </script>			 		
    </head>
    <body>
    <!-- HEADER -->
    <?php
        require("presentation/clpservice/header.php");
    ?>
	<div id="content" class="new_distinct">
     <h2>Nuova distinta</h2>	     
	     <form action="<?php echo  INDEX;?>" method="get">
	         <table id="form">
	         <tr>
	            <td class="label">
	             <?php
		            foreach (_l_a("default","distinte","nuova_distinta") as $key=>$value)
		            {
			            echo '<input type="hidden" name="' . $key . '" value="' . $value .'"/>';
		            }
	             ?>
	                 <label>Data distinta</label> 
	             </td>
	             <td>  
		         <input id="datepicker" type="text" name="data" value="<?php echo date("d/m/Y");?>" size="10" maxlength="10" >
		         </td>
	         </tr>
	         <tr>
		          <td class="label">
    		          <label>Tipo distinta</label>
		          </td>
		          <td>
		              <select name='tipo'>
			            <option selected value="P">Prioritaria</option>
			            <option value="R">Raccomandata</option>
		             </select>
		          </td>		
	         </tr>	  
	         <tr>
		          <td colspan="2">		                       
	                <input class="button" type='submit' value="Conferma" />
	             </td>
	         </tr>	             
	         </table>
	     </form>
	</div>
    <?php include("presentation/clpservice/footer.php"); ?>	
    </body>
</html>
