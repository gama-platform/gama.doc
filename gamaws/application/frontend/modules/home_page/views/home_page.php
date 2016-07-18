<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<!-- *****************************************************************************************************************
     HEADER
***************************************************************************************************************** -->

<div data-pop="pop-in" id="popup">
    <div class="popupcontent">
        <div class="cornercut-holder">
            <div id="posCornercut" class="item active corners-topleft-circle circle-bg-ft_mul_domain"></div>
            <div class="corners">
                <div id="arcTop" class="arc-top"></div>

                <div id="popupclose" class="">
                    <img src="<?php echo gama_assets_url()?>/img/gama_rotate.svg">
                </div>

                <div class="text tab-content">
                    <div class="gama-text-tab gama-text-topleft tab-pane fade">
                        <div class="gama-heading">Several applications domains</div>
                        <div class="gama-text-popup">
                            GAMA has been developed with a very general approach, and can be used for many applications domains.
                            Some <strong>additional plugins</strong> had been developed to fit with particular needs.
                            <div class="gama-text-padding"></div>
                            Example of domains where GAMA is mostly present :
                            <ul>
                                <li>Transport</li>
                                <li>Urban growth</li>
                                <li>Epidemiology</li>
                                <li>Environment</li>
                            </ul>
                            Some <strong>training sessions</strong> about topics such as "urban management", "epidemiology" are also provided by the
                            team.
                            Since GAMA is an open-source software that continues to grow, if you have any particular needs of
                            improvement, feel free to <strong>share it to its active community</strong> !
                        </div>
                        <img class="gama-text-img" src="<?php echo gama_assets_url(); ?>/img/data_driven_models3.png">
                    </div>

                    <div class="gama-text-tab gama-text-topright tab-pane fade">
                        <div class="gama-heading">High level and intuitive language</div>
                        <div class="gama-text-popup">
                            <p>Thanks to its high-level and intuitive language, GAMA has been developed to be used by non-computer
                                scientists. You can declare your species, giving them some special behaviors, create them in your world, and
                                display them in <strong>less than 10 minutes</strong>.</p>

                            <p>GAML is the language used in GAMA, coded in Java. It is an agent-based language, that provides you the
                                possibility to build your model with <strong>several paradigms of modeling</strong>.
                                <br>
                                Once your model is ready, some features allows you to <strong>explore and calibrate</strong> it, using the parameters you
                                defined as input of your simulation.</p>

                            <p>We provides you a continual support through the <strong>active mailing list</strong> where the team will answer your
                                questions. Besides, you can learn GAML on your own, following the <strong>step by step tutorial</strong>, or <strong>personal learning
                                    path</strong> in order reach the point you are interested in.</p>
                        </div>
                        <img class="gama-text-img" src="<?php echo gama_assets_url(); ?>/img/high_level_language2.png">
                    </div>

                    <div class="gama-text-tab gama-text-bottomleft tab-pane fade">

                        <div class="gama-heading">GIS and Data-Driven models</div>
                        <div class="gama-text-popup">
                            <p>GAMA (GIS Agent-based Modeling Architecture) provides you, since its creation, the possibility to load easily
                                GIS (Geographic Information System).</p>
                            <p>You can import a <strong>large number of data</strong>, such as text, files, CSV, shapefile, OSM (<strong>open street map data</strong>), grid,
                                images, SVG, but also 3D files, such as 3DS or OBJ, with their texture.</p>
                            <p>Some advanced features provides you the possibility to <strong>connect GAMA to databases</strong>, and also to use
                                powerful statistical tools such as R.</p>
                            <p>GAMA has been used in <strong>large-scale projects</strong>, using a great number of agents (up to millions of agents).</p>
                        </div>
                        <img class="gama-text-img" src="<?php echo gama_assets_url(); ?>/img/multiple_application_domains3.png">
                    </div>

                    <div class="gama-text-tab gama-text-bottomright tab-pane fade">
                        <div class="gama-heading">Declarative user interface</div>
                        <div class="gama-text-popup">
                            <p>GAMA provides you the possibility to have multiple displays for the same model. You can add as much visual
                                representations as you want for the same model, in order to highlight a certain aspect of your simulation. Add
                                easily new visual aspects to your agents.</p>
                            <p>Advanced <strong>3D displays</strong> are provided : you can control lights, cameras, and also adding textures to your 3D
                                objects. In an other hand, dedicated statements allows you to define easily <strong>charts</strong>, such as series, histogram, or
                                pies.</p>
                            <p>During the simulations, some advanced features are available to <strong>inspect the population of your agents</strong>. To
                                make your model more interactive, you can add easily some user-controlled action panels, or mouse events.</p>
                        </div>
                        <img class="gama-text-img" src="<?php echo gama_assets_url(); ?>/img/declarative_UI2.png">
                    </div>
                </div>
                <div id="arcBottom" class="arc-bottom"></div>
            </div>

        </div>
    </div>
</div>


<div class="container">
     <div class="col-md-12 col-md-offset-0">
         <div class="intro-header">
             <p class="intro-header-header">GAMA, <small class="intro-header-small">modeling made easy</small></p>
             <div class="intro-logo-padding">
                 <img class="col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-4" src="<?php echo gama_assets_url()?>/img/logo_small.png"/>
             </div>
             <p class="intro-header-clear"/>
             <div id="container col-md-12">
                 <p class="intro-header-logo-text-1 col-md-10 col-md-offset-1">
                     GAMA <small class="intro-header-logo-text-2">PLATFORM</small>
                 </p>
             </div>
             <p class="intro-header-clear"/>
             <h5 class="intro-header-text ul-dashed">
                 GAMA is a modeling and simulation development environment for building spatially explicit agent-based
                 simulations.
                 <ul class="dash">
                     <li><strong>Multiple application domains :</strong> Use GAMA for whatever application domain you want.</li>
                     <li><strong>High-level and Intuitive Agent-based language :</strong> Write your models easily using GAML, a high-level and intuitive agent-based language.</li>
                     <li><strong>GIS and Data-Driven models :</strong> Instantiate agents from any dataset, including GIS data, and execute
                         large-scale simulations (up to millions of agents).</li>
                     <li><strong>Declarative user interface :</strong> Declare interfaces supporting deep inspections on agents, user-controlled
                         action panels, multi-layer 2D/3D displays & agent aspects.</li>
                 </ul>
                 Its latest version, <strong>1.7</strong>, can be freely <a href="http://vps226121.ovh.net/download#GAMA17"> downloaded </a> or <a href="https://github.com/gama-platform/gama/"> built from source</a>, and comes pre-loaded with several
                 models, tutorials and a complete on-line documentation.
             </h5>
         </div>
     </div>

    <div class="col-md-12">
        <div class="row ">
            <div class="pull-right">
                <ul class="list-inline">
                    <li>
                        <a href="<?php echo base_url('getting_started');?>"
                           class="btn btn-lg intro-btn-getting-started">
                            <!--<i class="fa fa-5x fa-rotate-left fa-rotate-180 fa-fw intro-header-icon"></i>-->
                            <img src="<?php echo gama_assets_url()?>/img/gama_rotate_blue.svg">
                            <span class="intro-header-btn">Get Started</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- *****************************************************************************************************************
 MIDDLE CONTENT
 ***************************************************************************************************************** -->

<!-- Right to left-->
<div class="container">

    <div class="col-md-12">


        <div style="height: 50px" "></div>

        <div class="row" id="gama-feature">

            <div class="col-md-4 col-lg-5 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                <!-- normal -->
                <div class="ih-item circle colored effect11"><a href='javascript:callPopup("1")'>
                    <div class="img circle-bg-ft_mul_domain"></div>
                    <div class="info circle-bg-ft_mul_domain-hover">
                        <div class="img "></div>
                    </div></a>
                </div>
                <!-- end normal -->

            </div>

            <div class="col-md-4 col-lg-offset-1 col-md-offset-2 col-sm-offset-2">

                <!-- colored -->
                <div class="ih-item circle colored effect11"><a href='javascript:callPopup("2")'>
                        <div class="img circle-bg-ft_gaml"></div>
                        <div class="info circle-bg-ft_gaml-hover">
                            <div class="img "></div>
                        </div></a></div>
                <!-- end colored -->

            </div>
            <div style="height: 130px" class="hidden-sm hidden-xs"></div>
            <div style="height: 130px" class="hidden-sm hidden-xs"></div>
            <div style="height: 130px" class="hidden-sm hidden-xs"></div>
            <div class="col-md-4 col-lg-5 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">

                <!-- normal -->
                <div class="ih-item circle colored effect11"><a href='javascript:callPopup("3")'>
                        <div class="img circle-bg-ft_complex_data"></div>
                        <div class="info circle-bg-ft_complex_data-hover">
                            <div class="img "></div>
                        </div></a></div>
                <!-- end normal -->

            </div>

            <div class="col-md-4 col-lg-offset-1 col-md-offset-2 col-sm-offset-2">

                <!-- colored -->
                <div class="ih-item circle colored effect11"><a href='javascript:callPopup("4")'>
                        <div class="img circle-bg-ft_multi_display"></div>
                        <div class="info circle-bg-ft_multi_display-hover">
                            <div class="img "></div>
                        </div></a>
                </div>
                <!-- end colored -->
            </div>
        </div>
        <div style="height: 50px" "></div>
    </div>
</div>
<div style="height: 50px" "></div>
<!-- end Right to left-->



<div id="overlay"></div>

<script type="text/javascript">
    // Initialize Variables
    var closePopup = document.getElementById("popupclose");
    var overlay = document.getElementById("overlay");
    var popup = document.getElementById("popup");
    // Close Popup Event
    overlay.onclick = function() {
        overlay.className = '';
        popup.className = '';
        $('body').removeClass('disable-scrolling');
        $('body').removeClass('no-after');
        $('body').enableScroll();
        var gama_feature_offset = $('#gama-feature').offset();
        scrollTo(gama_feature_offset.left, gama_feature_offset.top);
    };
    // Close Popup Event
    closePopup.onclick = function() {
        overlay.className = '';
        popup.className = '';
        $('body').removeClass('disable-scrolling');
        $('body').removeClass('no-after');
        $('body').enableScroll();
        var gama_feature_offset = $('#gama-feature').offset();
        scrollTo(gama_feature_offset.left, gama_feature_offset.top);
    };

</script>

<script type="text/javascript">
    // Show Overlay and Popup
    //var gama_assets_url = "<?php echo gama_assets_url(); ?>";
    function callPopup($position) {
        overlay.className = 'show';
        popup.className = 'show';
        $( window ).resize(function(){
            if( $( window ).width() >= 992 ){
                $(".gama-text-tab").removeClass("in active");
                if($position == 1){
                    //$(".gama-text-img").attr("src", gama_assets_url + "/img/multiple_application_domains2.png");
                    $(".gama-text-topleft").addClass("in active");
                    $("#popupclose").removeClass().addClass("popupclose-topright");
                    $('#posCornercut').removeClass().addClass('corners-topleft-circle').addClass('circle-bg-ft_mul_domain-icon');
                    $('#arcTop').removeClass().addClass('arc-top hidden-after');
                    $('#arcBottom').removeClass().addClass('arc-bottom hidden-after hidden-before');

                }
                if($position == 2){
                    //$(".gama-text-img").attr("src", gama_assets_url + "/img/high_level_language2.png");
                    $(".gama-text-topright").addClass("in active");
                    $("#popupclose").removeClass().addClass("popupclose-topleft");
                    $('#posCornercut').removeClass().addClass('corners-topright-circle').addClass('circle-bg-ft_gaml-icon');
                    $('#arcTop').removeClass().addClass('arc-top hidden-before');
                    $('#arcBottom').removeClass().addClass('arc-bottom hidden-after hidden-before');
                }
                if($position == 3){
                    //$(".gama-text-img").attr("src", gama_assets_url + "/img/data_driven_models2.png");
                    $(".gama-text-bottomleft").addClass("in active");
                    $("#popupclose").removeClass().addClass("popupclose-bottomright");
                    $('#posCornercut').removeClass().addClass('corners-bottomleft-circle').addClass('circle-bg-ft_complex_data-icon');
                    $('#arcTop').removeClass().addClass('arc-top hidden-before hidden-after');
                    $('#arcBottom').removeClass().addClass('arc-bottom hidden-after');
                }
                if($position == 4){
                    //$(".gama-text-img").attr("src", gama_assets_url + "/img/declarative_UI2.png");
                    $(".gama-text-bottomright").addClass("in active");
                    $("#popupclose").removeClass().addClass("popupclose-bottomleft");
                    $('#posCornercut').removeClass().addClass('corners-bottomright-circle').addClass('circle-bg-ft_multi_display-icon');
                    $('#arcTop').removeClass().addClass('arc-top hidden-before hidden-after');
                    $('#arcBottom').removeClass().addClass('arc-bottom hidden-before');
                }

                //var offsets = document.getElementById('popup').getBoundingClientRect();
                scrollTo(0, 0);
                if(popup.className == 'show') {
                    $('body').addClass('disable-scrolling');
                    $('body').addClass('no-after');
                    $('body').disableScroll();
                }
            }
        });
        $( window ).resize();    // Trigger window resize to check on load


    }

    $.fn.disableScroll = function() {
        window.oldScrollPos = $(window).scrollTop();

        $(window).on('scroll.scrolldisabler',function ( event ) {
            $(window).scrollTop( window.oldScrollPos );
            event.preventDefault();
        });
    };

    $.fn.enableScroll = function() {
        $(window).off('scroll.scrolldisabler');
    };
</script>