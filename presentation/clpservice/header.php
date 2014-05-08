        <!--[if lt IE 7]>
            <p class="chromeframe">State usando un browser <strong>datato</strong>. Per cortesia <a href="http://browsehappy.com/">aggiornate il vostro browser</a> o <a href="http://www.google.com/chromeframe/?redirect=true">attivate Google Chrome Frame</a> per rendere la vostra migliore la vostra esperienza di navigazione.</p>
        <![endif]-->
    <div id="container">
        <div id="inside"> <!-- [inside] -->
	        <div id="header"><!-- [header] -->
                <div class="content">
                    <div id="h_main"><a href="<?php echo _l("default","default") ?>"><img src="resources/css/logo-def.png" alt="Logo del Conservatorio di Latina" /></a></div>
                </div>
				<?php
					if (strcmp($p["site_view"],"public") != 0)
					{
				?>
				<div class="menu">
					<ul>
						<li id="home_menu"><a href="<?= _l("default","default") ?>">Home</a></li>
						<li><a href="<?= _l("default","distinte","nuova_distinta") ?>">Nuova distinta</a></li>
						<li class="logout"><a href="<?= _l("default","default","logout") ?>">Logout (<?= $p["user"]->name  ?>)</a></li>
						<li class="clr" style="display:none">&nbsp;</li>
					</ul>
				</div>
				<?php
				}
				?>				
            </div><!-- [/header] -->

