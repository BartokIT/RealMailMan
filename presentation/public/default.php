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
	        <div id="content"  class="login"> <!-- [content] -->
	            <h2>Login</h2>
                    <div class="card signin-card clearfix">
                        <img class="profile-img" src="resources/css/avatar_login.png" alt="">
                        <p class="profile-name"></p>
                        <form novalidate="" method="post" action="<?php echo  INDEX;?>" id="gaia_loginform">
                            <?php
	                            foreach (_l_a("default","default","login") as $key=>$value)
	                            {
		                            echo '<input type="hidden" name="' . $key . '" value="' . $value .'"/>';
	                            }
               	            ?>
                            <label class="hidden-label" for="Email">Email</label>
                            <input id="user" name="user" type="email" placeholder="Utente" value="" spellcheck="false" class="">
                            <label class="hidden-label" for="Passwd">Password</label>
                            <input id="passwd" name="passwd" type="password" placeholder="Password" class="">
                            <input id="signIn" name="signIn" class="rc-button rc-button-submit" type="submit" value="Accedi">
                          </form>
                    </div>	            
	        </div> <!-- [/content] --> 		        
<?php include("presentation/clpservice/footer.php"); ?>
    </body>
</html>
