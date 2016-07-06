<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$assets_url = base_url("assets/gamaws");
$wiki_url = base_url("gama.wiki");
$current_url= base_url("tutorials");
?>


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
                        <ul id="gamaSidebarTab" class="nav nav-pills sidebar-tab-gama">
                            <li class="active"><a data-toggle="tab" href="#menuContent"><i class="fa fa-bars"></i></a></li>
                            <li><a data-toggle="tab" href="#menuLearnPath"><i class="fa fa-code-fork"></i></a></li>
                            <li><a data-toggle="tab" href="#menuSearch"><i class="fa fa-search"></i></a></li>
                        </ul>
                        <span id="slide-submenu-outline" href="#" class="panel panel-default list-group-item sidebar-btn-material-gamacolor">
                            <span class="pull-right" id="slide-submenu">
                                <i title="hide this menu" class="ion-close-circled"></i>
                            </span>
                        </span>
                        <div class="tab-content left-sidebar-content" >
                            <div id="menuContent" class="tab-pane fade in active" >
                                <!--begin menu-->
                                <div id="gamaSidebarExpander" class="list-group" >
                                    <div class="panel-group padding-panel" id="accordion" >
                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified btn-group-raised ">
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
                                            <div class="btn-group btn-group-justified btn-group-raised">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <a href="#learn_gama_step" data-toggle="tab"
                                                               class="btn btn-material-blue active sidebar-btn-material-gamacolor-yellow sidebar-radius-left text-left">
                                                                <i>GAMA step by step</i>
                                                            </a>
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
                                                    <nav class="bs-docs-sidebar">
                                                        <ul id="sidebar" class="nav nav-stacked">
                                                            <li>
                                                                <a href="<?php echo $current_url?>#GroupA" data-target="#GroupA">Group A</a>
                                                                <ul class="nav nav-stacked">
                                                                    <li><a href="<?php echo $current_url?>#GroupASub1" data-target="#GroupASub1">Sub-Group 1</a></li>
                                                                    <li><a href="<?php echo $current_url?>#GroupASub2" data-target="#GroupASub2">Sub-Group 2</a></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo $current_url?>#GroupB" data-target="#GroupB">Group B</a>
                                                                <ul class="nav nav-stacked">
                                                                    <li><a href="<?php echo $current_url?>#GroupBSub1" data-target="#GroupBSub1">Sub-Group 1</a></li>
                                                                    <li><a href="<?php echo $current_url?>#GroupBSub2" data-target="#GroupBSub2">Sub-Group 2</a></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo $current_url?>#GroupASub1" data-target="#GroupC">Group C</a>
                                                                <ul class="nav nav-stacked">
                                                                    <li><a href="<?php echo $current_url?>#GroupCSub1" data-target="#GroupCSub1">Sub-Group 1</a></li>
                                                                    <li><a href="<?php echo $current_url?>#GroupCSub2" data-target="#GroupCSub2">Sub-Group 2</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-affix sidebar-radius-pull">
                                            <div class="btn-group btn-group-justified btn-group-raised">
                                                <div class="btn-group padded-table">
                                                    <div class="sidebar-padded-table">
                                                        <div class="sidebar-tc-fluid">
                                                            <a href="#thematic_tutorials" data-toggle="tab"
                                                               class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-left text-left">
                                                                <i>Thematic Tutorials</i>
                                                            </a>
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
                                                    <nav class="bs-docs-sidebar">
                                                        <ul id="sidebar" class="nav nav-stacked" >
                                                            <li>
                                                                <a href="<?php echo $current_url?>#GroupA" data-target="#GroupA">Group A</a>
                                                                <ul class="nav nav-stacked">
                                                                    <li><a href="<?php echo $current_url?>#GroupASub1" data-target="#GroupASub1">Sub-Group 1</a></li>
                                                                    <li><a href="<?php echo $current_url?>#GroupASub2" data-target="#GroupASub2">Sub-Group 2</a></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo $current_url?>#GroupB" data-target="#GroupB">Group B</a>
                                                                <ul class="nav nav-stacked">
                                                                    <li><a href="<?php echo $current_url?>#GroupBSub1" data-target="#GroupBSub1">Sub-Group 1</a></li>
                                                                    <li><a href="<?php echo $current_url?>#GroupBSub2" data-target="#GroupBSub2">Sub-Group 2</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end menu-->
                            </div>
                            <div id="menuLearnPath" class="tab-pane fade">

                                <div class="timeline-wrapper">
                                    <div class="post">
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
                                    </div>
                                </div>

                                <div class="panel panel-default panel-affix sidebar-radius-pull">
                                    <div class="btn-group btn-group-justified btn-group-raised ">
                                        <div class="btn-group padded-table">
                                            <div class="sidebar-padded-table">
                                                <div class="sidebar-tc-fluid">
                                                    <a href="#getStarted" data-toggle="tab"
                                                       class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left">
                                                        <i>Get Started 2</i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="menuSearch" class="tab-pane fade">

                                <div class="panel panel-default panel-affix sidebar-radius-pull">
                                    <div class="btn-group btn-group-justified btn-group-raised">
                                        <div class="btn-group padded-table">
                                            <div class="sidebar-padded-table">
                                                <div class="sidebar-tc-fluid">
                                                    <a href="#getStarted" data-toggle="tab"
                                                       class="btn btn-material-blue sidebar-btn-material-gamacolor-yellow sidebar-radius-pull text-left">
                                                        <i>Get Started</i>
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
            <!--/left-->



            <!--right-->
            <div id="gamaRightSideContent" class="tab-content well-gama-sidebar col-md-8 gama-text pull-right">
                <div class="tab-pane" id="thematic_tutorials">
                    <div class = "section">
                        <h4 id = "GroupWelcome">Welcome<small></small>
                        </h4>

                        <?php
                        $Parsedown = new Parsedown();
                        $test = "/Event__MIMSCOP2012";
                        $markdown = file_get_contents($wiki_url . $test . '.md');
                        echo $Parsedown->text($markdown);
                        ?>
                    </div>
                </div>
                <div class="tab-pane active" id="learn_gama_step">
                    <div class = "section">
                        <h4 id = "GroupWelcome">Welcome<small></small>
                        </h4>

                        <?php
                        $Parsedown = new Parsedown();
                        $test = "/G__Launching";
                        $markdown = file_get_contents($wiki_url . $test . '.md');
                        echo $Parsedown->text($markdown);
                        ?>
                    </div>
                    <div class = "section">
                        <h4 id = "GroupA">iOS<small><a href = "#">
                                    &times; Remove this section</a></small>
                        </h4>

                        <?php
                        $Parsedown = new Parsedown();
                        $test = "/G__Overview";
                        $markdown = file_get_contents($wiki_url . $test . '.md');
                        echo $Parsedown->text($markdown);
                        ?>
                    </div>

                    <div class = "section">
                        <h4 id = "GroupASub1">SVN<small></small></h4>
                        <?php
                        $Parsedown = new Parsedown();
                        $test = "/G__BuiltInSpecies";
                        $markdown = file_get_contents($wiki_url . $test . '.md');
                        echo $Parsedown->text($markdown);
                        ?>
                    </div>

                    <div class = "section">
                        <h4 id = "GroupASub2">jMeter<small><a href = "#">
                                    &times; Remove this section</a></small>
                        </h4>

                        <?php
                        $Parsedown = new Parsedown();
                        $test = "/G__CallingR";
                        $markdown = file_get_contents($wiki_url . $test . '.md');
                        echo $Parsedown->text($markdown);
                        ?>
                    </div>

                    <div class = "section">
                        <h4 id = "GroupB">EJB</h4>

                        <?php
                        $Parsedown = new Parsedown();
                        $test = "/G__AgentBuiltInSpecies";
                        $markdown = file_get_contents($wiki_url . $test . '.md');
                        echo $Parsedown->text($markdown);
                        ?>
                    </div>

                    <div class = "section">
                        <h4 id = "GroupBSub1">Spring</h4>

                        <?php
                        $Parsedown = new Parsedown();
                        $test = "/G__ArcBallCamera";
                        $markdown = file_get_contents($wiki_url . $test . '.md');
                        echo $Parsedown->text($markdown);
                        ?>
                    </div>
                </div>
            </div>

            <!--/right-->
        </div>
    </div><!--/row-->
</div><!--/container-->

<div class="fake-footer"></div>

<!--<script>
   $(document).ready(function () {
        $('#gamaSidebarPadding').fixTo('.fake-footer', {
            top: 100,
            zIndex: 1000
        });
        $( window ).trigger('scroll');
    })
</script>

<script>
    $('body').scrollspy({
        target: '.bs-docs-sidebar',
        offset: 140
    });
</script>


<script>
    $('.sidebar-btn-material-gamacolor-yellow').click(function() {
        $('.sidebar-btn-material-gamacolor-yellow').removeClass('active');
        $(this).addClass('active');
    });
</script>

<script>
    $('#sidebar > li a').click(function() {
        $(this).parent().find('ul').toggle();
    });
</script>

<script>
    $('.sidebar-btn-material-gamacolor-yellow').click( function(){
        var tabs_offset = $('#gamaRightSideContent').offset();
        scrollTo(this.left, tabs_offset.top);
    });
</script>

<script>
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
    }

    $('.nav-tabs a').on('shown', function (e) {
        window.location.hash = e.target.hash;
    })
</script>-->