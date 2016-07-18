<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
$assets_url = base_url("assets/gamaws");
$ihover_url = base_url("assets/ihover");
$wiki_url = base_url("gm_wiki");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- meta keywords specific to the page -->
        <?php echo $metatag;?>
        <base href="<?php echo base_url()?>">
        <!-- page title specific to the page -->
        <title>{title}</title>
        <!-- bootstrap style sheet -->
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/gamaws.css"/>

        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/bootstrap.min.css"/>
        <!--<link type="text/css" rel="stylesheet" href="<?php /*echo $assets_url*/?>/css/style.css"/>-->
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/font-awesome.min.css"/>
        <!-- MATERIAL THEME -->
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/ripples.min.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/roboto.min.css"/>
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/css/bootstrap-material-design.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/snackbar.min.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/nouislider.min.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/animate.min.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/eden.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/icons.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $ihover_url?>/src/ihover.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/normalize.css"/>

        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/css/styles.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/fonts/Lato/latofonts.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $assets_url?>/fonts/Lato/latostyle.css"/>
        <link type="text/css" rel="stylesheet" href=" http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $wiki_url?>/vis/vis.css"/>

        <!-- js file -->
        <script type="text/javascript" src="<?php echo $assets_url?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/gamaws.js"></script>

        <!-- MATERIAL THEME -->
        <script type="text/javascript" src="<?php echo $assets_url?>/js/ripples.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/js/material.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/snackbar.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/nouislider.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/jcanvas.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/raphael-min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/polyfills.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/modernizr-2.6.2.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/wheelnav.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/fixto.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/animatescroll.js"></script>
        <script type="text/javascript" src="<?php echo $assets_url?>/js/tab-history.js"></script>
        <script type="text/javascript" src="<?php echo $wiki_url?>/nodesDatabase_mode.js"></script>
        <script type="text/javascript" src="<?php echo $wiki_url?>/vis/vis.js"></script>



        <link href="https://cdn.rawgit.com/FezVrasta/dropdown.js/master/jquery.dropdown.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php echo (isset($_styles)?$_styles:""); ?>
        <?php echo (isset($_scripts)?$_scripts:""); ?>
    </head>
    <body>
        <!--messages-->
        <?php echo $messages;?>
        <!--header-->
        <header>
            <?php echo $header;?>
        </header>
        <!--messages-->
        <?php echo $messages;?>
        <!--content-->
        <?php echo $content;?>
        <!--footer-->
        <footer>
            <?php echo $footer;?>
        </footer>

        <!--scrolltotop-->
        <?php echo $scrolltotop;?>

        <!--backtotop-->
        <p id="back-top">
            <a href="#top" onclick="return backtotop();"><em>Back to top</em><span></span> </a>
        </p>


        <script>
            $(function () {
                $.material.init();
            });
        </script>
    </body>
</html>