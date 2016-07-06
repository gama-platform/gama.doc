<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$assets_url = base_url("assets/gamaws");
?>

<div class="header-panel shadow-z-2">
    <div class="container">
        <div class="row">
            <div class=" col-xs-3 col-xs-offset-2">
                <h3>GAMA Tutorials</h3>
            </div>


        </div>
    </div>
</div>

<div class="container">
    <div class="col-md-12 sidebar">
        <div id="gama-sidebar-tg" class="mini-submenu col-md-1">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>

        <div id="gama-sidebar" class="list-group col-md-4">
            <div class="panel-group padding-panel" id="accordion">
                <span href="#" class="panel panel-default list-group-item  btn-material-light-blue">
                    <span class="pull-right" id="slide-submenu">
                        <i title="hide this menu" class="fa fa-times"></i>
                    </span>
                </span>

                <div class="panel panel-default">
                    <div class="btn-group btn-group-justified btn-group-raised">
                        <div class="btn-group padded-table">
                            <div class="sidebar-padded-table">
                                <div class="sidebar-tc-fluid">
                                    <a href="#servive" data-toggle="tab" class="btn btn-material-blue text-left">
                                        <i>Git repository</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="btn-group btn-group-justified btn-group-raised">
                        <div class="btn-group padded-table">
                            <div class="sidebar-padded-table">
                                <div class="sidebar-tc-fluid">
                                    <a href="#servive" data-toggle="tab" class="btn btn-material-blue text-left">
                                        <i>Git wiki</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="btn-group btn-group-justified btn-group-raised">
                        <div class="btn-group padded-table">
                            <div class="sidebar-padded-table">
                                <div class="sidebar-tc-fluid">
                                    <a href="#servive" data-toggle="tab" class="btn btn-material-blue text-left">
                                        <i>Report issue</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="btn-group btn-group-justified btn-group-raised">
                        <div class="btn-group padded-table">
                            <div class="sidebar-padded-table">
                                <div class="sidebar-tc-fluid">
                                    <a href="#google-forum-dev" data-toggle="tab" class="btn btn-material-blue text-left">
                                        <i>Mailing list</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade" id="google-forum-dev">
                <div class="container well page col-md-8" style="position:relative">
                    <iframe id="forum_embed"
                            src="javascript:void(0)"
                            scrolling="no"
                            frameborder="0"
                            style="position: relative; top:0px;width:100%;height:120vh;">
                    </iframe>

                    <script type="text/javascript">
                        document.getElementById("forum_embed").src =
                            "https://groups.google.com/forum/embed/?place=forum/gama-dev" +
                            "&showsearch=true&showpopout=true&parenturl=" +
                            encodeURIComponent(window.location.href);
                    </script>
                </div>
            </div>
            <div class="tab-pane fade active in" id="service">
                <div class="container well page col-md-8 active scroll-area active" data-spy="scroll" data-offset="0">
                    <div class="section">
                        <h3 id="section-1">Section 1
                        </h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu sem tempor, varius quam at, luctus
                            dui.
                            Mauris magna metus, dapibus nec turpis vel, semper malesuada ante. Vestibulum id metus ac nisl
                            bibendum
                            scelerisque non non purus. Suspendisse varius nibh non aliquet sagittis. In tincidunt orci sit amet
                            elementum vestibulum. Vivamus fermentum in arcu in aliquam. Quisque aliquam porta odio in fringilla.
                            Vivamus nisl leo, blandit at bibendum eu, tristique eget risus. Integer aliquet quam ut elit
                            suscipit,
                            id interdum neque porttitor. Integer faucibus ligula.</p>

                        <p>Vestibulum quis quam ut magna consequat faucibus. Pellentesque eget nisi a mi suscipit tincidunt. Ut
                            tempus dictum risus. Pellentesque viverra sagittis quam at mattis. Suspendisse potenti. Aliquam sit
                            amet
                            gravida nibh, facilisis gravida odio. Phasellus auctor velit at lacus blandit, commodo iaculis justo
                            viverra. Etiam vitae est arcu. Mauris vel congue dolor. Aliquam eget mi mi. Fusce quam tortor,
                            commodo
                            ac dui quis, bibendum viverra erat. Maecenas mattis lectus enim, quis tincidunt dui molestie
                            euismod.
                            Curabitur et diam tristique, accumsan nunc eu, hendrerit tellus.</p>
                    </div>
                    <hr>
                    <div class="section">
                        <h3 id="section-2">Section 2
                        </h3>
                        <p>Nullam hendrerit justo non leo aliquet imperdiet. Etiam in sagittis lectus. Suspendisse ultrices
                            placerat
                            accumsan. Mauris quis dapibus orci. In dapibus velit blandit pharetra tincidunt. Quisque non sapien
                            nec
                            lacus condimentum facilisis ut iaculis enim. Sed viverra interdum bibendum. Donec ac sollicitudin
                            dolor.
                            Sed fringilla vitae lacus at rutrum. Phasellus congue vestibulum ligula sed consequat.</p>

                        <p>Vestibulum consectetur scelerisque lacus, ac fermentum lorem convallis sed. Nam odio tortor, dictum
                            quis
                            malesuada at, pellentesque vitae orci. Vivamus elementum, felis eu auctor lobortis, diam velit
                            egestas
                            lacus, quis fermentum metus ante quis urna. Sed at facilisis libero. Cum sociis natoque penatibus et
                            magnis dis parturient montes, nascetur ridiculus mus. Vestibulum bibendum blandit dolor. Nunc orci
                            dolor, molestie nec nibh in, hendrerit tincidunt ante. Vivamus sem augue, hendrerit non sapien in,
                            mollis ornare augue.</p>
                    </div>
                    <hr>
                    <div class="section">
                        <h3 id="section-3">Section 3
                        </h3>
                        <p>Integer pulvinar leo id risus pellentesque vestibulum. Sed diam libero, sodales eget sapien vel,
                            porttitor bibendum enim. Donec sed nibh vitae lorem porttitor blandit in nec ante. Pellentesque
                            vitae
                            metus ipsum. Phasellus sed nunc ac sem malesuada condimentum. Etiam in aliquam lectus. Nam vel
                            sapien
                            diam. Donec pharetra id arcu eget blandit. Proin imperdiet mattis augue in porttitor. Quisque tempus
                            enim id lobortis feugiat. Suspendisse tincidunt risus quis dolor fringilla blandit. Ut sed sapien at
                            purus lacinia porttitor. Nullam iaculis, felis a pretium ornare, dolor nisl semper tortor, vel
                            sagittis
                            lacus est consequat eros. Sed id pretium nisl. Curabitur dolor nisl, laoreet vitae aliquam id,
                            tincidunt
                            sit amet mauris.</p>

                        <p>Phasellus vitae suscipit justo. Mauris pharetra feugiat ante id lacinia. Etiam faucibus mauris id
                            tempor
                            egestas. Duis luctus turpis at accumsan tincidunt. Phasellus risus risus, volutpat vel tellus ac,
                            tincidunt fringilla massa. Etiam hendrerit dolor eget ante rutrum adipiscing. Cras interdum ipsum
                            mattis, tempus mauris vel, semper ipsum. Duis sed dolor ut enim lobortis pellentesque ultricies ac
                            ligula. Pellentesque convallis elit nisi, id vulputate ipsum ullamcorper ut. Cras ac pulvinar purus,
                            ac
                            viverra est. Suspendisse potenti. Integer pellentesque neque et elementum tempus. Curabitur bibendum
                            in
                            ligula ut rhoncus.</p>

                        <p>Quisque pharetra velit id velit iaculis pretium. Nullam a justo sed ligula porta semper eu quis enim.
                            Pellentesque pellentesque, metus at facilisis hendrerit, lectus velit facilisis leo, quis volutpat
                            turpis arcu quis enim. Nulla viverra lorem elementum interdum ultricies. Suspendisse accumsan quam
                            nec
                            ante mollis tempus. Morbi vel accumsan diam, eget convallis tellus. Suspendisse potenti.</p>
                    </div>
                    <hr>
                    <h3>Section 4</h3>

                    <p>Nam eget purus nec est consectetur vehicula. Nullam ultrices nisl risus, in viverra libero egestas sit
                        amet.
                        Etiam porttitor dolor non eros pulvinar malesuada. Vestibulum sit amet est mollis nulla tempus
                        aliquet.</p>

                    <div class="section">
                        <h4 id="section-4dot1">Section 4.1
                        </h4>
                        <p>In mauris nunc, convallis eget pretium eu, bibendum non leo. Proin suscipit purus adipiscing dolor
                            gravida, in fermentum sapien blandit. Praesent pellentesque ligula dui, in gravida turpis vehicula
                            ac.
                            Pellentesque hendrerit nunc ut luctus hendrerit. Aliquam nec tincidunt urna. Ut interdum nec odio
                            non
                            interdum. Curabitur ligula justo, dapibus non ligula tristique, dapibus tristique nulla. Aliquam
                            pulvinar dapibus eros, rutrum pretium urna iaculis ut. Nam est est, tempus id egestas et, viverra in
                            dui. Aliquam gravida orci tortor, sed congue justo ornare vel. Cras in quam consectetur eros varius
                            scelerisque. Ut vel fermentum purus. Nullam interdum blandit turpis, id pellentesque massa feugiat
                            at.
                            Ut sed lectus lectus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                            cubilia
                            Curae; Nulla rutrum, ante quis convallis ultricies, magna quam rhoncus erat, in lacinia libero magna
                            a
                            ipsum.</p>

                        <p>Nam eget purus nec est consectetur vehicula. Nullam ultrices nisl risus, in viverra libero egestas
                            sit
                            amet. Etiam porttitor dolor non eros pulvinar malesuada. Vestibulum sit amet est mollis nulla tempus
                            aliquet. Praesent luctus hendrerit arcu non laoreet. Morbi consequat placerat magna, ac ornare odio
                            sagittis sed. Donec vitae ullamcorper purus. Vivamus non metus ac justo porta volutpat.</p>
                    </div>
                    <div class="section">
                        <h4 id="section-4dot2">Section 4.2
                        </h4>
                        <p>Pellentesque viverra, velit eu blandit viverra, justo nulla vestibulum nisl, at egestas ligula augue
                            non
                            ipsum. Aliquam non posuere metus, sed luctus erat. Vivamus malesuada libero quis sem elementum
                            condimentum. Vestibulum interdum, turpis nec venenatis fringilla, odio elit hendrerit dui, a commodo
                            metus tortor a eros. Suspendisse egestas neque vitae laoreet pellentesque. Donec accumsan, elit quis
                            rhoncus fringilla, quam leo feugiat velit, nec hendrerit purus diam aliquet neque. Pellentesque
                            imperdiet sed erat eu varius.</p>

                        <p>Morbi sed fermentum ipsum. Morbi a orci vulputate tortor ornare blandit a quis orci. Donec aliquam
                            sodales gravida. In ut ullamcorper nisi, ac pretium velit. Vestibulum vitae lectus volutpat,
                            consequat
                            lorem sit amet, pulvinar tellus. In tincidunt vel leo eget pulvinar. Curabitur a eros non lacus
                            malesuada aliquam. Praesent et tempus odio. Integer a quam nunc. In hac habitasse platea dictumst.
                            Aliquam porta nibh nulla, et mattis turpis placerat eget. Pellentesque dui diam, pellentesque vel
                            gravida id, accumsan eu magna. Sed a semper arcu, ut dignissim leo.</p>
                    </div>
                    <div class="section">
                        <h4 id="section-4dot3">Section 4.3
                        </h4>
                        <p>Fusce enim arcu, interdum vel metus dignissim, venenatis feugiat purus. Nulla posuere orci ut leo
                            sodales, sed cursus dolor ornare. Cum sociis natoque penatibus et magnis dis parturient montes,
                            nascetur
                            ridiculus mus. Etiam sit amet quam orci. Nulla sollicitudin lectus eget posuere venenatis. Sed
                            vestibulum elementum sagittis. Quisque tristique tortor quis feugiat sollicitudin. Ut pellentesque
                            luctus vulputate. Ut at odio ac erat blandit vehicula ut eget urna. In hac habitasse platea
                            dictumst.
                            Nullam ut iaculis nibh, eget eleifend elit.</p>

                        <p>Sed vitae lobortis diam, id molestie magna. Aliquam consequat ipsum quis est dictum ultrices. Aenean
                            nibh
                            velit, fringilla in diam id, blandit hendrerit lacus. Donec vehicula rutrum tellus eget fermentum.
                            Pellentesque ac erat et arcu ornare tincidunt. Aliquam erat volutpat. Vivamus lobortis urna quis
                            gravida
                            semper. In condimentum, est a faucibus luctus, mi dolor cursus mi, id vehicula arcu risus a nibh.
                            Pellentesque blandit sapien lacus, vel vehicula nunc feugiat sit amet.</p>
                    </div>
                    <hr>
                    <div class="section">
                        <h3 id="section-5">Section 5
                        </h3>
                        <p>Nam eget purus nec est consectetur vehicula. Nullam ultrices nisl risus, in viverra libero egestas
                            sit
                            amet. Etiam porttitor dolor non eros pulvinar malesuada. Vestibulum sit amet est mollis nulla tempus
                            aliquet. Praesent luctus hendrerit arcu non laoreet. Morbi consequat placerat magna, ac ornare odio
                            sagittis sed. Donec vitae ullamcorper purus. Vivamus non metus ac justo porta volutpat.</p>

                        <p>Vivamus mattis accumsan erat, vel convallis risus pretium nec. Integer nunc nulla, viverra ut sem
                            non,
                            scelerisque vehicula arcu. Fusce bibendum convallis augue sit amet lobortis. Cras porta urna turpis,
                            sodales lobortis purus adipiscing id. Maecenas ullamcorper, turpis suscipit pellentesque fringilla,
                            massa lacus pulvinar mi, nec dignissim velit arcu eget purus. Nam at dapibus tellus, eget euismod
                            nisl.
                            Ut eget venenatis sapien. Vivamus vulputate varius mauris, vel varius nisl facilisis ac. Nulla
                            aliquet
                            justo a nibh ornare, eu congue neque rutrum.</p>

                        <p>Suspendisse a orci facilisis, dignissim tortor vitae, ultrices mi. Vestibulum a iaculis lacus.
                            Phasellus
                            vitae convallis ligula, nec volutpat tellus. Vivamus scelerisque mollis nisl, nec vehicula elit
                            egestas
                            a. Sed luctus metus id mi gravida, faucibus convallis neque pretium. Maecenas quis sapien ut leo
                            fringilla tempor vitae sit amet leo. Donec imperdiet tempus placerat. Pellentesque pulvinar ultrices
                            nunc sed ultrices. Morbi vel mi pretium, fermentum lacus et, viverra tellus. Phasellus sodales
                            libero
                            nec dui convallis, sit amet fermentum sapien auctor. Vestibulum ante ipsum primis in faucibus orci
                            luctus et ultrices posuere cubilia Curae; Sed eu elementum nibh, quis varius libero.</p>

                        <p>Morbi sed fermentum ipsum. Morbi a orci vulputate tortor ornare blandit a quis orci. Donec aliquam
                            sodales gravida. In ut ullamcorper nisi, ac pretium velit. Vestibulum vitae lectus volutpat,
                            consequat
                            lorem sit amet, pulvinar tellus. In tincidunt vel leo eget pulvinar. Curabitur a eros non lacus
                            malesuada aliquam. Praesent et tempus odio. Integer a quam nunc. In hac habitasse platea dictumst.
                            Aliquam porta nibh nulla, et mattis turpis placerat eget. Pellentesque dui diam, pellentesque vel
                            gravida id, accumsan eu magna. Sed a semper arcu, ut dignissim leo.</p>

                        <p>Sed vitae lobortis diam, id molestie magna. Aliquam consequat ipsum quis est dictum ultrices. Aenean
                            nibh
                            velit, fringilla in diam id, blandit hendrerit lacus. Donec vehicula rutrum tellus eget fermentum.
                            Pellentesque ac erat et arcu ornare tincidunt. Aliquam erat volutpat. Vivamus lobortis urna quis
                            gravida
                            semper. In condimentum, est a faucibus luctus, mi dolor cursus mi, id vehicula arcu risus a nibh.
                            Pellentesque blandit sapien lacus, vel vehicula nunc feugiat sit amet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<nav id="scroll-nav" class="navbar navbar-fixed-bottom scrollbar-gama" role="navigation">
    <div class="container-fluid">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse collapse" id="scrollbarCollapse">
            <ul class="nav navbar-nav">
                <li class="active" title="Section 1" ><a href="#section-1" class="fa fa-2x fa-circle" title="Section 1"></a></li>
                <li ><a href="#section-2" class="fa fa-2x fa-circle" title="Section 2"></a></li>
                <li ><a href="#section-3" class="fa fa-2x fa-circle" title="Section 3"></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle fa fa-2x fa-arrow-up" data-toggle="dropdown" title="Section 4">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#section-4dot1" title="Section 4.1" class="fa fa-2x fa-circle"></a></li>
                        <li><a href="#section-4dot2" title="Section 4.2" class="fa fa-2x fa-circle"></a></li>
                        <li><a href="#section-4dot3" title="Section 4.3" class="fa fa-2x fa-circle"></a></li>
                    </ul>
                </li>
                <li><a title="Section 5" href="#section-5" class="fa fa-2x fa-circle"></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><h4 id="info" class="wy-text-strike">current section :: top :: </h4></li>
            </ul>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#scrollbarCollapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
</nav>