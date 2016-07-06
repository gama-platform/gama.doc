<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$current_url= base_url("tutorials");
?>

<div data-pop="pop-in" id="learningpath-box">
    <div id="popupcontent" >
    </div>
</div>


<!--main-->
<div class="container gama-content-header-margin">
    <div class="row">
        <div class="col-md-12" >
            <!--left-->
            <div id="gamaSidebarPadding" class="" >
                <span id="slideSubmenuToggle" class="mini-submenu col-md-1">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </span>

                <div id="gamaSidebarExpander" class="list-group well-gama-sidebar col-md-4 pull-left" >
                    <div class="panel-group padding-panel" >
                        <div>
                            <ul id="gamaSidebarTab" class="nav nav-pills">
                                <li class="active"><a href="#menuContent"><i class="fa fa-sidebar fa-bars"></i></a></li>
                                <li id="li-tab-graph"><a href="#menuLearnPath"><i id="i-tab-graph" class="fa icon-custom-graph"></i></a></li>
                                <li id="li-tab-search"><a href="#menuSearch"><i class="fa fa-sidebar fa-search"></i></a></li>
                            </ul>
                            <span id="slide-submenu-outline" href="#" class="panel panel-default list-group-item sidebar-btn-hidden">
                                <span class="pull-right" id="slide-submenu">
                                    <i title="hide this menu" class="ion-close-circled"></i>
                                </span>
                            </span>
                        </div>
                        <div class="tab-content left-sidebar-content" >
                            <div id="menuContent" class="tab-pane fade in active">
                                <!--begin menu-->
                                <div id="gamaSidebarExpander" class="list-group" >
                                    <div class="panel-group padding-panel" id="accordion" >
                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified ">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <a href="<?php echo base_url('getting_started');?>"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left">
                                                                <i>Get Started</i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <span href="#LearnGAMLStepByStep"
                                                                  data-toggle="tab"
                                                                  class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-left text-left gama-chapter">
                                                                <i>GAMA step by step</i>
                                                            </span>
                                                        </div>

                                                        <div class="sidebar-tc-fixed">
                                                            <a class="btn  btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-right dropdown-toggle"
                                                               data-toggle="collapse" data-parent="#accordion" data-target="#collapseGamaStepbyStep">
                                                                <span class="fa fa-caret-down"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="collapseGamaStepbyStep" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <!--Nav Bar -->

                                                    <div class="bs-docs-sidebar" id="aaccordionGamaStepbyStep">
                                                        <?php foreach($gama_step_by_step as $row) {
                                                            ?>
                                                            <div class="panel">

                                                                <div class="gama-scroll-title">

                                                                    <a type="button"
                                                                       class="sidebar-expand-icon"
                                                                       data-container="body"
                                                                       data-toggle="popover"
                                                                       data-placement="right"
                                                                       tabindex="0"
                                                                       data-trigger="hover"
                                                                       data-html="true"
                                                                       data-content="<?php /*echo $controller->getSubMenuAsString($row->id) */?>">
                                                                        <span class="fa fa-circle-o"/>
                                                                    </a>

                                                                    <span href="#<?php echo $row->alias ?>"
                                                                      data-toggle="tab"
                                                                      data-target="#<?php echo $row->alias ?>">
                                                                        <a class="accordion-toggle"
                                                                           data-toggle="collapse"
                                                                           data-parent="#aaccordionGamaStepbyStep"
                                                                           href="#<?php echo $row->id ?>">
                                                                            <?php echo $row->title?>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                                <div id="<?php echo $row->id ?>" class="panel-collapse collapse gama-subsection-collapse">
                                                                    <div class="gama-subsection">
                                                                        <ul class="nav nav-stacked">
                                                                            <?php
                                                                            $sections = $controller->getSubMenu($row->id);
                                                                            foreach($sections as $section) {
                                                                                ?>
                                                                                <li>
                                                                                    <a href="#<?php echo $section->alias ?>"
                                                                                       data-toggle="tab"
                                                                                       data-target="#<?php echo $section->alias ?>"><?php echo $section->title?>
                                                                                    </a>

                                                                                </li>
                                                                                <?php
                                                                            }?>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <span href="#Recipes"
                                                                  data-toggle="tab"
                                                                  class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-left text-left gama-chapter">
                                                                <i>Recipes</i>
                                                            </span>
                                                        </div>

                                                        <div class="sidebar-tc-fixed">
                                                            <a class="btn  btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-right dropdown-toggle"
                                                               data-toggle="collapse" data-parent="#accordion" data-target="#collapseRecipes">
                                                                <span class="fa fa-caret-down"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="collapseRecipes" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <!--Nav Bar -->
                                                    <div class="bs-docs-sidebar" id="accordionRecipes">
                                                        <?php foreach($recipes as $row) {
                                                            ?>
                                                            <div class="panel">
                                                                <div class="gama-scroll-title">

                                                                    <a type="button"
                                                                       class="sidebar-expand-icon"
                                                                       data-container="body"
                                                                       data-toggle="popover"
                                                                       data-placement="right"
                                                                       tabindex="0"
                                                                       data-trigger="hover"
                                                                       data-html="true"
                                                                       data-content="<?php /*echo $controller->getSubMenuAsString($row->id) */?>">
                                                                        <span class="fa fa-circle-o"/>
                                                                    </a>

                                                                    <span href="#<?php echo $row->alias ?>"
                                                                          data-toggle="tab"
                                                                          data-target="#<?php echo $row->alias ?>">
                                                                        <a class="accordion-toggle"
                                                                           data-toggle="collapse"
                                                                           data-parent="#accordionRecipes"
                                                                           href="#<?php echo $row->id ?>">
                                                                            <?php echo $row->title?></a>
                                                                    </span>
                                                                </div>
                                                                <div id="<?php echo $row->id ?>" class="panel-collapse collapse gama-subsection-collapse">
                                                                    <div class="gama-subsection">
                                                                        <ul class="nav nav-stacked">
                                                                            <?php
                                                                            $sections = $controller->getSubMenu($row->id);
                                                                            foreach($sections as $section) {
                                                                                ?>
                                                                                <li>

                                                                                    <a href="#<?php echo $section->alias ?>"
                                                                                       data-toggle="tab"
                                                                                       data-target="#<?php echo $section->alias ?>"><?php echo $section->title?>
                                                                                    </a>

                                                                                </li>
                                                                                <?php
                                                                            }?>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <span href="#ThematicTutorials"
                                                                  data-toggle="tab"
                                                                  class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-left text-left gama-chapter">
                                                                <i>Tutorials</i>
                                                            </span>
                                                        </div>

                                                        <div class="sidebar-tc-fixed">
                                                            <a class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-right dropdown-toggle" data-toggle="collapse"
                                                               data-parent="#accordion" data-target="#collapseThematicTutorials">
                                                                <span class="caret"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="collapseThematicTutorials" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <!--Nav Bar -->
                                                    <div class="bs-docs-sidebar" id="accordionThematicTutorials">
                                                        <?php foreach($thematic_tutorials as $row) {
                                                            ?>
                                                            <div class="panel">
                                                                <div class="gama-scroll-title">
                                                                    <a type="button"
                                                                       class="sidebar-expand-icon"
                                                                       data-container="body"
                                                                       data-toggle="popover"
                                                                       data-placement="right"
                                                                       tabindex="0"
                                                                       data-trigger="hover"
                                                                       data-html="true"
                                                                       data-content="<?php /*echo $controller->getSubMenuAsString($row->id) */?>">
                                                                        <span class="fa fa-circle-o"/>
                                                                    </a>
                                                                    <span href="#<?php echo $row->alias ?>"
                                                                          data-toggle="tab"
                                                                          data-target="#<?php echo $row->alias ?>">
                                                                        <a class="accordion-toggle"
                                                                           data-toggle="collapse"
                                                                           data-parent="#accordionThematicTutorials"
                                                                           href="#<?php echo $row->id ?>">
                                                                            <?php echo $row->title?></a>
                                                                    </span>
                                                                </div>
                                                                <div id="<?php echo $row->id ?>" class="panel-collapse collapse gama-subsection-collapse">
                                                                    <div class="gama-subsection">
                                                                        <ul class="nav nav-stacked">
                                                                            <?php
                                                                            $sections = $controller->getSubMenu($row->id);
                                                                            foreach($sections as $section) {
                                                                                ?>
                                                                                <li>

                                                                                    <a href="#<?php echo $section->alias ?>"
                                                                                       data-toggle="tab"
                                                                                       data-target="#<?php echo $section->alias ?>"><?php echo $section->title?>
                                                                                    </a>

                                                                                </li>
                                                                                <?php
                                                                            }?>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end menu-->
                            </div>
                            <div id="menuLearnPath" class="tab-pane fade">
                                <div id="learning-path" class="timeline-wrapper panel-search-result-auto">
                                    <!--<div class="post">
                                        <div class="post-inner"> Programming basis
                                        </div>
                                    </div>
                                    <div class="post">
                                        <div class="post-inner"> Global species
                                        </div>
                                    </div>
                                    <div class="post">
                                        <div class="post-inner"> Regular species
                                        </div>
                                    </div>-->
                                </div>

                                <div class="panel panel-default panel-affix sidebar-radius-pull">
                                    <div class="btn-group btn-group-justified  ">
                                        <div class="btn-group padded-table">
                                            <div class="sidebar-padded-table">
                                                <div class="sidebar-tc-fluid">
                                                    <a href="javascript:toggleOverlay();"
                                                       class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left">
                                                        <i>Choose an other learning path</i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="menuSearch" class="tab-pane fade">
                                <div class="panel-search-result-auto">
                                    <div align="center" id="loading">
                                        <p><img src="<?php echo gama_assets_url()?>/img/ajax-loader.gif" /></p>
                                    </div>
                                    <div>
                                        <ul id="search-result">
                                        </ul>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/left-->

            <!--right-->
            <div id="gamaRightSideContent" class="tab-content well-gama-sidebar col-md-8 gama-text pull-right">
                <?php foreach($gama_step_by_step as $row) {
                    ?>
                    <div class="tab-pane fade " id="<?php echo $row->alias ?>">

                    </div>
                    <?php
                    $sections = $controller->getSubMenu($row->id);
                    foreach($sections as $section)
                    {?>
                        <div class="tab-pane fade " id="<?php echo $section->alias ?>">

                        </div>
                        <?php
                    }?>
                    <?php
                }?>
                <?php foreach($recipes as $row) {
                    ?>
                    <div class="tab-pane fade " id="<?php echo $row->alias ?>">

                    </div>
                    <?php
                    $sections = $controller->getSubMenu($row->id);
                    foreach($sections as $section)
                    {?>
                        <div class="tab-pane fade " id="<?php echo $section->alias ?>">

                        </div>
                        <?php
                    }?>
                    <?php
                }?>
                <?php foreach($thematic_tutorials as $row) {
                    ?>
                    <div class="tab-pane fade " id="<?php echo $row->alias ?>">

                    </div>

                    <?php
                    $sections = $controller->getSubMenu($row->id);
                    foreach($sections as $section)
                    {?>
                        <div class="tab-pane fade " id="<?php echo $section->alias ?>">

                        </div>
                        <?php
                    }?>
                    <?php
                }?>

                <div class="tab-pane fade " id="home">
                </div>

                <div class="tab-pane fade " id="LearnGAMLStepByStep">
                    <?php
                    $file_url = "/Tutorials/LearnGAMLStepByStep.md";
                    $text = file_get_contents(gama_wiki_url() . $file_url);
                    echo MarkdownExtra::defaultTransform($text);
                    ?>
                </div>
                <div class="tab-pane fade " id="Recipes">
                    <?php
                    $file_url = "/Tutorials/Recipes.md";
                    $text = file_get_contents(gama_wiki_url() . $file_url);
                    echo MarkdownExtra::defaultTransform($text);
                    ?>
                </div>
                <div class="tab-pane fade " id="ThematicTutorials">
                    <?php
                    $file_url = "/Tutorials/ThematicTutorials.md";
                    $text = file_get_contents(gama_wiki_url() . $file_url);
                    echo MarkdownExtra::defaultTransform($text);
                    ?>
                </div>
            </div>

            <!--/right-->
        </div>
    </div><!--/row-->
</div><!--/container-->

<div class="fake-footer"></div>


<div id="learningpath-overlay"></div>


<script>

    var xhr;
    function autoSearchToWebpage() {
        var webpage = document.location.hash.split("#")[1];
        if(webpage) {
            if(xhr && xhr.readyState != 4){
                xhr.abort();
            }
            jQuery.ajax({
                url: '<?php echo base_url("/wg_gama_search/gama_search_ctl/getAutomaticWebpageList");?>',
                type: 'POST',
                data: {webpage: webpage},
                success: function (data) {
                    if(!data){
                        data = "<div align='center'>sorry, nothing found in this page</div>";
                    }
                    $('#search-result').show();
                    $('#search-result').html(data);
                }
            });
        }
    }

    function autoSearch() {
        var webpage = document.location.hash.split("#")[1];
        if(webpage) {
            jQuery.ajax({
                url: '<?php echo base_url("/wg_gama_search/gama_search_ctl/getAutomaticKeywordList");?>',
                type: 'POST',
                data: {webpage: webpage},
                success: function (data) {
                    if(!data){
                        data = "<div align='center'>sorry, nothing found in this page</div>";
                    }
                    $('#search-result').show();
                    $('#search-result').html(data);
                }
            });
        }
    }

    // set_item : this function will be executed when we select an item
    function pickItem(item, id) {
        // hide proposition list
        $('#search-result').hide();

        var keyword_id = id;
        jQuery.ajax({
            url: '<?php echo base_url("/wg_gama_search/gama_search_ctl/getWebpageList");?>',
            type: 'POST',
            data: {keyword_id:keyword_id},
            success:function(data){
                $('#search-result').show();
                $('#search-result').html(data);
            }
        });

    }

    /*jQuery('#li-tab-search a').click(function () {
        //autoSearch();
        autoSearchToWebpage();
    });*/

    jQuery('#li-tab-search a').click(function () {
        //autoSearch();
        var anchor = getActiveKeywordElement();
        //console.log(anchor);
        autoSearchToWebpage(anchor);
    });


    // auto search onScroll
    $(window).on('scroll',function(){
        if($('#li-tab-search').hasClass('active')){
            $('#gamaRightSideContent').find('.active').find('.gama-keyword-style').each(function(){
                //console.log($(this).attr('id'));
                if($(this).inView()) {
                    //console.log("hoho " + $(this).prev().attr('id'));
                    autoSearchToWebpage($(this).attr('id'));
                    return false;
                }
            });
        }
    });



</script>