<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$assets_url = base_url("assets/gamaws");
$wiki_url = base_url("gama.wiki");
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
                                <li class="active"><a data-toggle="tab" href="#menuContent"><i class="fa fa-sidebar fa-bars"></i></a></li>
                                <li id="li-tab-graph"><a data-toggle="tab" href="#menuLearnPath"><i id="i-tab-graph" class="fa icon-custom-graph"></i></a></li>
                                <li id="li-tab-search"><a data-toggle="tab" href="#menuSearch"><i class="fa fa-sidebar fa-search"></i></a></li>
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
                                <div id="gamaSidebarExpander2" class="list-group" >
                                    <div class="panel-group padding-panel" id="accordion" >
                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified ">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <span href="#Projects" data-toggle="tab"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left gama-chapter">
                                                                <i>Projects</i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified ">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <span href="#UserForum" data-toggle="tab"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left gama-chapter active">
                                                                <i>User forum</i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified ">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <span href="#TrainingSession" data-toggle="tab"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left gama-chapter">
                                                                <i>Training</i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified ">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <a target="_blank" href="https://github.com/gama-platform/gama/issues"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left gama-chapter">
                                                                <i>Report issues</i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified ">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <span href="#Contribute" data-toggle="tab"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left gama-chapter">
                                                                <i>Contribute</i>
                                                            </span>
                                                        </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/left-->

            <!--right-->
            <div id="gamaRightSideContent" class="tab-content well-gama-sidebar col-md-8 gama-text pull-right">

                <div class="tab-pane " id="Projects">
                    <?php
                    $Parsedown = new ParsedownExtra();
                    $file_url = "/Community/Projects.md";
                    $markdown = file_get_contents(gama_wiki_url() . $file_url);
                    echo $Parsedown->text($markdown);
                    ?>
                </div>
                <div class="tab-pane fade" id="TrainingSession">
                    <?php
                    $Parsedown = new ParsedownExtra();
                    $file_url = "/Community/TrainingSession.md";
                    $markdown = file_get_contents(gama_wiki_url() . $file_url);
                    echo $Parsedown->text($markdown);
                    ?>
                </div>

<!--                <div class="tab-pane fade" id="Issues">-->
<!--                    --><?php
//                    $Parsedown = new ParsedownExtra();
//                    $file_url = "/Community/TrainingSession.md";
//                    $markdown = file_get_contents(gama_wiki_url() . $file_url);
//                    echo $Parsedown->text($markdown);
//                    ?>
<!--                </div>-->

                <div class="tab-pane fade in active" id="UserForum">
                    <div class="container well page col-md-12 col-sm-12 col-xs-12" style="position:relative">
                        <iframe id="forum_embed"
                                src="javascript:void(0)"
                                scrolling="no"
                                frameborder="0"
                                style="position: relative; top:0px;width:100%;height:120vh;">
                        </iframe>

                        <script type="text/javascript">
                            document.getElementById("forum_embed").src =
                                "https://groups.google.com/forum/embed/?place=forum/gama-platform" +
                                "&showsearch=true&showpopout=true&parenturl=" +
                                encodeURIComponent(window.location.href);
                        </script>
                    </div>
                </div>

                <div class="tab-pane fade" id="Contribute">
                    <!--<div class="container well page col-md-12 col-sm-12 col-xs-12" style="position:relative">
                        <iframe id="forum_embed_2"
                                src="javascript:void(0)"
                                scrolling="no"
                                frameborder="0"
                                style="position: relative; top:0px;width:100%;height:120vh;">
                        </iframe>

                        <script type="text/javascript">
                            document.getElementById("forum_embed_2").src =
                                "https://groups.google.com/forum/embed/?place=forum/gama-dev" +
                                "&showsearch=true&showpopout=true&parenturl=" +
                                encodeURIComponent(window.location.href);
                        </script>
                    </div>-->

                    <?php
                    $Parsedown = new ParsedownExtra();
                    $file_url = "/Community/Contribute.md";
                    $markdown = file_get_contents(gama_wiki_url() . $file_url);
                    echo $Parsedown->text($markdown);
                    ?>
                </div>


            </div>



            <!--/right-->
        </div>
    </div><!--/row-->
</div><!--/container-->

<div class="fake-footer"></div>
<div id="learningpath-overlay"></div>