<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>


<!-- *****************************************************************************************************************
     HEADER
***************************************************************************************************************** -->

<div class="container gama-content-header-margin" style="min-height: 700px;">
    <div class="row">
        <div class="col-sm-12 col-lg-10 col-lg-offset-1">
            <div class="col-sm-4">

                <!-- normal -->
                <div class="ih-item circle smaller-circle circle-triangle-bottom colored effect11 active"><a data-toggle="tab"
                                                                                              href="#home">
                        <div class="img circle-bg-getgama"></div>
                        <div class="info">
                            <h3 class="gama-body-2">Get GAMA</h3>
                        </div>
                    </a></div>
                <!-- end normal -->

            </div>
            <div class="col-sm-4">

                <!-- colored -->
                <div class="ih-item circle smaller-circle circle-triangle-bottom colored effect11">
                    <a data-toggle="tab" href="#menu1">
                        <div class="img circle-bg-playvideo"></div>
                        <div class="info">
                            <h3 class="gama-body-2">GAMA in 10 minutes</h3>
                        </div>
                    </a>

                </div>
                <!-- end colored -->

            </div>
            <div class="col-sm-4">

                <!-- colored -->
                <div class="ih-item circle smaller-circle colored effect11"><a data-toggle="tab" href="#menu2">
                        <div class="img circle-bg-learn_intelli"></div>
                        <div class="info">
                            <h3 class="gama-body-2">What's next</h3>
                        </div>
                    </a></div>
                <!-- end colored -->

            </div>
        </div>
    </div>
    <div class="gama-hr"></div>
    <div class="row">
        <div class="tab-content gama-text" style="line-height: 200%">
            <div id="home" class="tab-pane fade col-md-10 col-md-offset-1">
                <div class="gama-heading" style="text-align: center">Get GAMA</div>
                <br>
                <?php
                $Parsedown = new ParsedownExtra();
                $file_url = "/GetStarted/InstallationGetStarted.md";
                $markdown = file_get_contents(gama_wiki_url() . $file_url);
                echo $Parsedown->text($markdown);
                ?>


                <div class="row">
                    <div id="" class="list-group col-md-8 col-md-offset-2">
                        <div class="panel-group padding-panel" id="accordion">
                            <div class="panel panel-default panel-affix">
                                <div class="btn-group btn-group-justified ">
                                    <div class="btn-group padded-table">
                                        <div class="sidebar-padded-table">
                                            <div class="sidebar-tc-fluid">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   data-target="#collapseMacOSXOldSchoolInstall"
                                                   class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left">
                                                    <i>On MacOSX (Lion, Mountain Lion, Mavericks)</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseMacOSXOldSchoolInstall" class="panel-collapse collapse">
                                    <div class="panel-body-without-scroll">
                                        <?php
                                        $Parsedown = new ParsedownExtra();
                                        $file_url = "/GetStarted/MacOSGetStarted.md";
                                        $markdown = file_get_contents(gama_wiki_url() . $file_url);
                                        echo $Parsedown->text($markdown);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default panel-affix">
                                <div class="btn-group btn-group-justified ">
                                    <div class="btn-group padded-table">
                                        <div class="sidebar-padded-table">
                                            <div class="sidebar-tc-fluid">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   data-target="#collapseMacOSXYosimiteInstall"
                                                   class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left">
                                                    <i>On MacOSX (Yosemite, El Capitan)</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseMacOSXYosimiteInstall" class="panel-collapse collapse">
                                    <div class="panel-body-without-scroll">
                                        <?php
                                        $Parsedown = new ParsedownExtra();
                                        $file_url = "/GetStarted/MacOSNewGetStarted.md";
                                        $markdown = file_get_contents(gama_wiki_url() . $file_url);
                                        echo $Parsedown->text($markdown);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default panel-affix">
                                <div class="btn-group btn-group-justified ">
                                    <div class="btn-group padded-table">
                                        <div class="sidebar-padded-table">
                                            <div class="sidebar-tc-fluid">
                                                <a data-toggle="collapse"
                                                   data-parent="#accordion" data-target="#collapseWindowsInstall"
                                                   class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left">
                                                    <i>On Windows 64 bits</i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div id="collapseWindowsInstall" class="panel-collapse collapse">
                                    <div class="panel-body-without-scroll">
                                        <?php
                                        $Parsedown = new ParsedownExtra();
                                        $file_url = "/GetStarted/WindowsGetStarted.md";
                                        $markdown = file_get_contents(gama_wiki_url() . $file_url);
                                        echo $Parsedown->text($markdown);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default panel-affix">
                                <div class="btn-group btn-group-justified ">
                                    <div class="btn-group padded-table">
                                        <div class="sidebar-padded-table">
                                            <div class="sidebar-tc-fluid">
                                                <a data-toggle="collapse"
                                                   data-parent="#accordion" data-target="#collapseLinuxInstall"
                                                   class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left">
                                                    <i>On Linux</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseLinuxInstall" class="panel-collapse collapse">
                                    <div class="panel-body-without-scroll">
                                        <?php
                                        $Parsedown = new ParsedownExtra();
                                        $file_url = "/GetStarted/LinuxGetStarted.md";
                                        $markdown = file_get_contents(gama_wiki_url() . $file_url);
                                        echo $Parsedown->text($markdown);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                If you have any problem during the installation, please read the <a href="http://vps226121.ovh.net/references#Troubleshooting"> troubleshooting</a> page.
                <br>
            </div>
            <div id="menu1" class="tab-pane fade col-md-10 col-md-offset-1">
                <div class="gama-heading" style="text-align: center">GAMA in 10 minutes</div>
                <br>
                <div class="gama-text">
                    This 10 minutes tutorial will show you how to use the platform, how to write an easy model and
                    how to run it.
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="vid">
                            <iframe width="560" height="315" src="//www.youtube.com/embed/YGHw1LSzd-E"
                                    allowfullscreen="">

                            </iframe>
                        </div>
                        <!--./vid -->
                    </div>
                    <!--.col -->
                </div>
            </div>
            <div id="menu2" class="tab-pane fade col-md-10 col-md-offset-1">
                <div class="gama-heading" style="text-align: center">What’s next ?</div>
                <br>
                <div class="gama-text">
                    <div class = "section">
                        <?php
                        $Parsedown = new ParsedownExtra();
                        $file_url = "/Tutorials/WhatsNext.md";
                        if($file_url){
                            $markdown = file_get_contents(gama_wiki_url() . $file_url);
                            echo $Parsedown->text($markdown);
                        }
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">

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
                                                    <a href="<?php base_url() ?>references#PlatformDocumentation"
                                                       class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow get-started-radius-pull what-next-align text-left">

                                                        <span class="get-started-what-next-btn"><img class="get-started-what-next-img" src="<?php echo gama_assets_url()?>/img/gama_rotate_blue_small.svg"> Platform documentation</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-group padding-panel" id="accordion">
                                <div class="panel panel-default panel-affix">
                                    <div class="btn-group btn-group-justified  get-started-radius-pull">
                                        <div class="btn-group padded-table">
                                            <div class="sidebar-padded-table">
                                                <div class="sidebar-tc-fluid">
                                                    <a href="<?php base_url() ?>tutorials#LearnGAMLStepByStep"
                                                       class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow get-started-radius-pull what-next-align text-left">

                                                        <span class="get-started-what-next-btn"><img class="get-started-what-next-img" src="<?php echo gama_assets_url()?>/img/gama_rotate_blue_small.svg"> Learn GAMA step by step</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-group padding-panel" id="accordion">
                                <div class="panel panel-default panel-affix">
                                    <div class="btn-group btn-group-justified get-started-radius-pull">
                                        <div class="btn-group padded-table ">
                                            <div class="sidebar-padded-table">
                                                <div class="sidebar-tc-fluid">
                                                    <a href="https://groups.google.com/forum/#!forum/gama-platform" target="_blank"
                                                       class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow get-started-radius-pull what-next-align text-left">

                                                        <span class="get-started-what-next-btn"><img class="get-started-what-next-img" src="<?php echo gama_assets_url()?>/img/gama_rotate_blue_small.svg"> Join the mailing list</span>
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
</div>
<div class="fake-footer"></div>

