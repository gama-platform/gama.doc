<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    $assets_url = base_url("assets/gamaws");
    $current_url = base_url("");
    $i = 0;
    $j = 0;
?>


<!-- *****************************************************************************************************************
     NAVIGATION
***************************************************************************************************************** -->
<!-- Navigation -->

<!--<li class="dropdown">
                    <a href=""
                        class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="hidden-sm">Communication <span class="caret"></span></div>
                        <span class="glyphicon glyphicon-plus visible-sm" title="Communication"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="<?php /*echo base_url('communication');*/?>">
                                How to cite GAMA
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="<?php /*echo base_url('communication');*/?>">
                                Publications
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="<?php /*echo base_url('communication');*/?>">
                                Videos, Slides
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="<?php /*echo base_url('event');*/?>">
                                Events and Activities
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                    </ul>
                </li>
                <li>
                            <a href="<?php /*echo base_url('event');*/?>">
                                <div class="hidden-sm">Documentation</div>
                                <span class="glyphicon glyphicon-plus visible-sm" title="Documentation"></span>
                            </a>
                        </li>
                        -->

<!-- Navbar
================================================== -->

<nav id="gama-nav" class="navbar navbar-gama navbar-fixed-top navbar-centered" role="navigation">
    <div class="container">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                        <span>
                            <img src="<?php echo $assets_url?>/img/logo_xs_border_117.png" class="visible-xs visible-sm visible-md" alt="">
                        </span>
                </button>
                <a class="navbar-brand" href="">
                    <img src="<?php echo $assets_url?>/img/logo_gama_50.png" class="hidden-xs hidden-sm" alt="">
                </a>
                <a class="navbar-brand visible-xs visible-sm" href="">GAMA</a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul id="gama-nav-ul" class="nav navbar-nav">

                    <?php foreach($rows as $row) {
                        ?>
                        <li class="dropdown">
                            <a href="<?php echo $row->link ?>">
                                <span title="<?php echo $row->title ?>"> <?php echo $row->title ?> </span>
                             <!--   <span class="caret"></span>-->
                            </a>
                            <ul id="dropdown-menu-id" class="dropdown-menu" role="menu">
                                <?php
                                    $subrows = $controller->getSubMenu($row->id);
                                    foreach($subrows as $subrow) {
                                        if(strcasecmp(trim($subrow->title), "issues")){
                                        ?>
                                            <li><a href="<?php echo $subrow->link ?>">  <?php echo $subrow->title ?> </a></li>
                                        <?php
                                } else{
                                            ?>
                                            <li><a target="_blank" href="https://github.com/gama-platform/gama/issues">  <?php echo $subrow->title ?> </a></li>
                                            <?php
                                        }  }?>
                            </ul>
                        </li>
                        <?php
                    }?>

                    <li class="navbar-form">
                        <div class="form-group" role="search">
                            <div class="input-group">
                                <div align="center" id="loading">
                                    <p><img src="<?php echo gama_assets_url()?>/img/ajax-loader.gif" /></p>
                                </div>
                                <input id="gama-search" class="form-control" type="search" placeholder="search here" onkeyup="autocomplet()"/>
                                <span class="input-group-btn">
                                  <button class="btn btn-fab btn-fab-mini" onclick="location.href='search'">
                                      <i class="fa fa-search nav-search-icon"></i>
                                  </button>
                                </span>
                            </div>
                        </div>
                    </li>
                    <ul id="search-result-dropdown-2" class="search-result-style-2">
                    </ul>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!--<script>
    //Add Hover effect to menus
    jQuery('ul.nav li.dropdown').hover(function() {
        jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
    }, function() {
        jQuery(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
    });
</script>-->

<script>

    /*$(document).ready(function () {
        $("ul.nav li.dropdown").on("click", function () {
            if($(this).find( ".dropdown-menu").css("display") == "none")
                $(this).find( ".dropdown-menu").css({ "display": "inline-block" });
            else{
                $(this).find( ".dropdown-menu").css({ "display": "none" });
            }
        });
    });*/

    $(document).ready(function () {
        $("ul.nav li.dropdown").on("mouseenter", function () {
            $(this).find( ".dropdown-menu").css({ "display": "inline-block" });
            //$(this).find( ".dropdown-menu").slideDown("slow",function(){ $(this).css("display","inline-block"); });
        }).on("mouseleave", function () {
            $(this).find( ".dropdown-menu").css({ "display": "none" });
            //$(this).find( ".dropdown-menu").slideUp("slow",function(){ $(this).css("display","none"); });
        });
    });

    function autocomplet() {
        var min_length = 0; // min caracters to display the autocomplete
        var keyword = $('#gama-search').val();
        if (keyword.length > min_length) {
            jQuery.ajax({
                url: '<?php echo base_url("/wg_gama_search/gama_search_ctl/getKeywordList");?>',
                type: 'POST',
                data: {keyword:keyword},
                success:function(data){
                    $('#search-result-dropdown-2').show();
                    $('#search-result-dropdown-2').html(data);
                }
            });
        } else {
            $('#search-result-dropdown-2').hide();
        }
    }

    // set_item : this function will be executed when we select an item
    function setItem(item, id) {
        // change input value
        $('#gama-search').val(item);
        // hide proposition list
        $('#search-result-dropdown-2').hide();

        var keyword_id = id;
        jQuery.ajax({
            url: '<?php echo base_url("/wg_gama_search/gama_search_ctl/getWebpageList");?>',
            type: 'POST',
            data: {keyword_id:keyword_id},
            success:function(data){
                $('#search-result-dropdown-2').show();
                $('#search-result-dropdown-2').html(data);
            }
        });
    }

    $(document).mouseup(function (e)
    {
        var container = $('#search-result-dropdown-2');

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.hide();
        }
    });
</script>


