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
                                                            <span href="#GAMALATEST" data-toggle="tab"
                                                                  class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left gama-chapter">
                                                                <i>LATEST BUILDS</i>
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
                                                            <span href="#GAMA17" data-toggle="tab"
                                                                  class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left gama-chapter">
                                                                <i>VERSION 1.7</i>
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
                                                            <span href="#GAMA161" data-toggle="tab"
                                                                  class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left gama-chapter">
                                                                <i>VERSION 1.6.1</i>
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

                                <div class="tab-pane fade" id="GAMALATEST">
                    <div class="panel panel-default ">
                        <div class="panel-heading panel-download">
                            <h3 class="panel-title">Latest builds of Gama (from the current GIT)</h3>
                        </div>
                        <div class="panel-body-without-scroll">
                            <br>
                            <a href="https://github.com/gama-platform/gama/releases/tag/latest">Go to the continuous build page here.</a>
                            <br>
                            <br>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div id="gamaSidebarExpander" class="list-group">
                                    <div class="panel-group padding-panel" id="accordion">
                                        <div class="panel panel-default panel-affix">
                                            <div class="btn-group btn-group-justified  get-started-radius-pull">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <a href="<?php base_url() ?>getting_started"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow get-started-radius-pull what-next-align text-left">

                                                                <span class="get-started-what-next-btn"><img class="get-started-what-next-img" src="<?php echo gama_assets_url()?>/img/gama_rotate_blue_small.svg"> Get Started</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="GAMA17">
                    <div class="panel panel-default ">
                        <div class="panel-heading panel-download">
                            <h3 class="panel-title">Latest official release of GAMA : 1.7</h3>
                        </div>
                        <div class="panel-body-without-scroll">
                            <br>
                            <ul>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='https://github.com/gama-platform/gama/releases/download/v1.7/Gama1.7_Win_64.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for Windows 64 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='https://github.com/gama-platform/gama/releases/download/v1.7/Gama1.7_Win_32.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for Windows 32 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='https://github.com/gama-platform/gama/releases/download/v1.7/Gama1.7_Mac.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for OSX 64 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='https://github.com/gama-platform/gama/releases/download/v1.7/Gama1.7_Linux_64.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for Linux 64 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='https://github.com/gama-platform/gama/releases/download/v1.7/Gama1.7_Linux_32.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for Linux 32 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='http://51.255.46.42/gm_wiki/resources/pdf/docGAMAv17.pdf'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">PDF documentation of GAMA 1.7</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div id="gamaSidebarExpander" class="list-group">
                                    <div class="panel-group padding-panel" id="accordion">
                                        <div class="panel panel-default panel-affix">
                                            <div class="btn-group btn-group-justified  get-started-radius-pull">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <a href="<?php base_url() ?>getting_started"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow get-started-radius-pull what-next-align text-left">

                                                                <span class="get-started-what-next-btn"><img class="get-started-what-next-img" src="<?php echo gama_assets_url()?>/img/gama_rotate_blue_small.svg"> Get Started</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="GAMA161">
                    <div class="panel panel-default ">
                        <div class="panel-heading panel-download">
                            <h3 class="panel-title">GAMA 1.6.1</h3>
                        </div>
                        <div class="panel-body-without-scroll">
                            <br>
                            <ul>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='http://51.255.46.42/releases/gama1_6_1_win64.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for Windows 64 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='http://51.255.46.42/releases/gama1_6_1_win32.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for Windows 32 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='http://51.255.46.42/releases/gama1_6_1_osx64.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for OSX 64 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='http://51.255.46.42/releases/gama1_6_1_osx32.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for OSX 32 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='http://51.255.46.42/releases/gama1_6_1_linux64.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for Linux 64 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='http://51.255.46.42/releases/gama1_6_1_linux32.zip'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">GAMA for Linux 32 bits</span>
                                </li>
                                <br>
                                <li style="list-style: none">
                                    <button class="btn btn-fab btn-fab-mini" onclick="location.href='http://51.255.46.42/gm_wiki/resources/pdf/docGAMAv161.pdf'">
                                        <i class="fa fa-download nav-search-icon"></i>
                                    </button>
                                    <span style="padding-left: 20px">PDF documentation of GAMA 1.61</span>
                                </li>
                            </ul>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div id="gamaSidebarExpander" class="list-group">
                                    <div class="panel-group padding-panel" id="accordion">
                                        <div class="panel panel-default panel-affix">
                                            <div class="btn-group btn-group-justified  get-started-radius-pull">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <a href="<?php base_url() ?>getting_started"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow get-started-radius-pull what-next-align text-left">

                                                                <span class="get-started-what-next-btn"><img class="get-started-what-next-img" src="<?php echo gama_assets_url()?>/img/gama_rotate_blue_small.svg"> Get Started</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



            <!--/right-->
        </div>
    </div><!--/row-->
</div><!--/container-->

<div class="fake-footer"></div>
<div id="learningpath-overlay"></div>