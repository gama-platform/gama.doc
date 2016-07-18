function backtotop() {
    jQuery('html, body').animate({scrollTop: 0}, 100);
    return false;
}

function getScrollingPosition() {
    var position = [0, 0];
    if (typeof window.pageYOffset != 'undefined') {
        position = [window.pageXOffset, window.pageYOffset];
    }
    else if (typeof document.documentElement.scrollTop != 'undefined' && document.documentElement.scrollTop > 0) {
        position = [document.documentElement.scrollLeft, document.documentElement.scrollTop];
    }
    else if (typeof document.body.scrollTop != 'undefined') {
        position = [document.body.scrollLeft, document.body.scrollTop];
    }
    return position;
}

jQuery(window).scroll(function () {
    var scrollpos = getScrollingPosition();
    if (scrollpos[1] > 150) {
        jQuery('#back-top').fadeIn('fast');
    } else {
        jQuery('#back-top').fadeOut('fast');
    }
});

$(function () {
    if($('#gamaSidebarPadding').css('float') == 'left'){
        $('#gamaSidebarExpander').removeClass('well-gama-sidebar col-md-4 pull-left');
        $('#gamaSidebarPadding').addClass('well-gama-sidebar col-md-4');
    }
    $('#slide-submenu').on('click', function () {
        if($('#gamaSidebarPadding').css('float') != 'left'){
            $('#gamaSidebarExpander').removeClass('col-md-4').addClass('col-md-1');
        }
        if($('#gamaSidebarPadding').css('float') == 'left'){
            $('#gamaSidebarExpander').removeClass('well-gama-sidebar col-md-4 pull-left');
            $('#gamaSidebarPadding').removeClass('col-md-4').addClass('well-gama-sidebar col-md-1');
        }
        $('#gamaRightSideContent').removeClass('col-md-8').addClass('col-md-11');
        $(this).closest('.list-group').toggle('slide', function () {
            $('#slideSubmenuToggle').fadeIn('fast');
        });
    });

    $('#slideSubmenuToggle').on('click', function () {

        if($('#gamaSidebarPadding').css('float') != 'left') {
            $('#gamaSidebarExpander').removeClass('col-md-1').addClass('col-md-4');
        }
        if($('#gamaSidebarPadding').css('float') == 'left'){
            $('#gamaSidebarExpander').removeClass('well-gama-sidebar col-md-4 pull-left');
            $('#gamaSidebarPadding').removeClass('col-md-1').addClass('well-gama-sidebar col-md-4');
        }
        $('#gamaRightSideContent').removeClass('col-md-11').addClass('col-md-8');
        $(this).next('.list-group').toggle('slide');
        $('#slideSubmenuToggle').hide();
    });
})

/*==================== ==================================*/


function isEmpty( el ){
    return !$.trim(el.html());
}

/*function loadTabContentAjax($mdpage){
    if(!isEmpty($('#gamaRightSideContent > #' + $mdpage))){
        return;
    }
    jQuery.ajax({
        url: '/wg_tab_content/tab_content_ctl/loadTabContent',
        type: 'POST',
        async:false,
        data: {mdpage: $mdpage},
        success: function (data) {
            if(!data){
                data = "<div align='center'>sorry, no data found here</div>";
            }
            $('#gamaRightSideContent > #' + $mdpage).html(data);
        }
    });
    resetMenuLearningPath();
}*/

var loadTabContentAjax = function($mdpage) {
    localStorage.setItem('activePage', $mdpage);

    if (!isEmpty($('#gamaRightSideContent > #' + $mdpage))) {
        return "undefined";
    }
    return $.ajax({
        url: '/wg_tab_content/tab_content_ctl/loadTabContent',
        type: 'POST',
        data: {mdpage: $mdpage}
    });

}




function successHandler($mdpage, $data) {
        //var activePage = localStorage.getItem('activePage');
        //findActive(activePage);
    //var activePage = localStorage.getItem('activePage');
    //findActive($mdpage);
    //alert(activePage);

    if($data.localeCompare("undefined") != 0){
        if (!$data) {
            $data = "<div align='center'>sorry, no data found here</div>";
        }
        $('#gamaRightSideContent > #' + $mdpage).html($data);
        resetMenuLearningPath();
    }
}

function resetMenuLearningPath(){
    var selectedTab = localStorage.getItem('selectedTab');
    $('#gamaSidebarTab a[href="' + selectedTab + '"]').tab('show');
    if(selectedTab == "#menuLearnPath"){
        $('.concept-graph').each(function(){
            $(this).addClass('outer-concept-graph');
        });
    }else{
        $('.concept-graph').each(function(){
            $(this).removeClass('outer-concept-graph');
        });
    }
}

$(document).ready(function () {
    var hash = document.location.hash;
    if (hash) {
        activeCurrentContent();
        var id = hash.split('#')[1].replace('#', '');
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
        });
    }
});

var activeCurrentContent = function(){
    var url = location.pathname;
    var hash= document.location.hash.split('#')[1];
    //alert(url);
    //alert(hash);
}

function removeActiveTabAllLevels() {
    $('.gama-chapter').removeClass('active');
    $('.gama-subsection > ul li').removeClass('active');
    $('.accordion-toggle').attr("aria-expanded","false").fadeIn(3000);
    $('.gama-scroll-title').next().removeClass('in');
    $('.gama-subsection-content > li').removeClass('active');
}

function removeActiveTabSubSection() {
    $('.gama-subsection > ul li').removeClass('active');
    $('.accordion-toggle').attr("aria-expanded","false").fadeIn(3000);
    $('.gama-scroll-title').next().removeClass('in');
    $('.gama-subsection-content > li').removeClass('active');
}

function removeActiveTabSubSectionContent() {
    //$('.accordion-toggle').attr("aria-expanded","false").fadeIn('slow');
    //$('.gama-scroll-title').next().removeClass('in');

    $('.gama-subsection-content').removeClass('in');
    $('.gama-subsection > ul li').removeClass('active');
    $('.gama-subsection > ul li a span').attr("aria-expanded","false");
    $('.gama-subsection-content > li').removeClass('active');
}

function removeOnlyActiveTabSubSectionContent() {
    //$('.accordion-toggle').attr("aria-expanded","false").fadeIn('slow');
    //$('.gama-scroll-title').next().removeClass('in');
    $('.gama-subsection > ul li').removeClass('active');
    $('.gama-subsection > ul li a span').attr("aria-expanded","false");
    $('.gama-subsection-content > a').removeClass('active');
    //$('.gama-scroll-title span a').attr("aria-expanded","false");
}

function removeAllActive() {
    $('.gama-scroll-title > span > a').attr("aria-expanded","false");
    $('.gama-chapter').removeClass('active');
    $('.gama-subsection > ul li').removeClass('active');
    $('.gama-subsection > ul li a span').attr("aria-expanded","false");
    $('.gama-subsection-content > a').removeClass('active');
}

/* active navbar item */
$(document).ready(function(){
    var current = location.pathname;
    if(!current.localeCompare('/')){
        return;
    }
    $('.navbar-gama #gama-nav-ul li a').each(function(){
        // if the current path is like this link, make it active
        if($(this).attr('href').indexOf(current) !== -1){
            if($(this).attr('href').indexOf('#') == -1){
                $(this).addClass('active');
            }else{
                $(this).closest('ul').closest('li').addClass('active');
            }
        }
    });
});


$(document).ready(function () {
    $('#gamaSidebarPadding').fixTo('.fake-footer', {
        top: 100,
        zIndex: 100
    });
    $( window ).trigger('scroll');
});

// prevent click on menu
$(document).ready(function () {
    $('.dropdown > a').click(function (e) {
        e.preventDefault();
    });
});

// active internal link from navbar dropdown menu
$(document).ready(function () {
    $('.dropdown-menu > li a').click(function (e) {
        // support click internal page
        $('a[href="' + $(this).attr('href') + '"]').tab('show');
        $(this).parent().removeClass('active');
        $(this).removeClass('active');

        // internal reference in active
        var hash = $(this).attr('href').split('#')[1];
        if (hash != "") {
            var link = "";
            $('.sidebar-tc-fluid > span').each(function() {
                link = $(this).attr('href').split('#')[1];
                if (link == hash) {
                    removeActiveTabAllLevels();
                    $(this).addClass('active');
                }
            });
        }
    });
});


// support click from external page
$(document).ready(function () {
    var hash = document.location.hash;
    if (hash) {
        $('.sidebar-tc-fluid span[href="' + document.location.toString() +'"]').tab('show') ;
        scrollTo(0, 0);
    }

    //external reference in active
    var hash = window.location.hash;
    if (hash != "") {
        var link = "";
        $('.sidebar-tc-fluid > span').each(function() {
            link ='#' + $(this).attr('href').split('#')[1];
            if (link == hash) {
                removeActiveTabAllLevels();
                $(this).addClass('active');
            }
        });
    }
});

$(document).ready(function () {
    $('.sidebar-tc-fluid span').click(function(e) {
        var id = $(e.target).attr("href").split('#')[1].replace('#', '');
        //loadTabContentAjax(id);
        var ownthis = $(this);
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
            $('span[href="' + ownthis.attr('href') + '"]').tab('show');
            removeActiveTabAllLevels();
            ownthis.addClass('active');
            scrollTo(0, 0);
        });
    });
});


$(document).ready(function () {
    $('.gama-scroll-title > span').click( function(e){
        var id = $(e.target).parent('span').attr("href").split('#')[1].replace('#', '');
        var ownthis = $(this);
        //loadTabContentAjax(id);
        //removeOnlyActiveTabSubSectionContent();
        //alert($(this).next());
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
            removeActiveTabSubSection();
            removeAllActive();
            ownthis.parents('.panel-collapse').first().prev().find('.gama-chapter').addClass('active');
            //$('span[data-target="' + $(this).attr('data-target') + '"]').tab('show');
            scrollTo(0, 0);
        });


    });
});

$(document).ready(function () {

    $('.gama-scroll-title > a').click( function(){

        if($(this).parent().next().hasClass('in')){
            $(this).parent().next().removeClass('in');
        }
        else{
            $(this).parent().next().addClass('in');
        }
    });
});

//for four levels
/*$(document).ready(function () {
 $('.gama-subsection > ul > li > a > span').click(function (e) {
 removeOnlyActiveTabSubSectionContent();

 removeAllActive();
 var parent =  $(this).parents('.gama-subsection-collapse').first().prev();
 parent.children('span').find(">:first-child").attr("aria-expanded","true");
 parent.parents('.panel-collapse').first().prev().find('.gama-chapter').addClass('active');
 //e.preventDefault();
 //removeActiveTabSubSectionContent();
 //$('a[href="' + $(this).attr('href') + '"]').tab('show');
 scrollTo(0, 0);
 });
 })*/

//for three levels
$(document).ready(function () {
    $('.gama-subsection > ul > li > a').not( ".sidebar-expand-icon-2").click(function (e) {
        removeOnlyActiveTabSubSectionContent();

        removeAllActive();
        var parent =  $(this).parents('.gama-subsection-collapse').first().prev();
        parent.children('span').find(">:first-child").attr("aria-expanded","true");
        parent.parents('.panel-collapse').first().prev().find('.gama-chapter').addClass('active');
        //e.preventDefault();
        //removeActiveTabSubSectionContent();
        //$('a[href="' + $(this).attr('href') + '"]').tab('show');
        scrollTo(0, 0);
    });
});

$(document).ready(function () {
    $('.gama-subsection-content > li a').click(function (e) {
        removeOnlyActiveTabSubSectionContent();

        //$('a[href="' + $(this).attr('href') + '"]').tab('show');

        removeAllActive();

        var parent =  $(this).parents('.gama-subsection-collapse').first().prev();
        parent.children('span').find(">:first-child").attr("aria-expanded","true");
        parent.parents('.panel-collapse').first().prev().find('.gama-chapter').addClass('active');
        $(this).parents('ul:first').closest('li').addClass('active');
        //$(this).parents('ul:first').closest('li').find("span").first().attr("aria-expanded","true");
        //alert( $(this).parents('ul:first').closest('li').find("span").first().attr("aria-expanded"));
        scrollTo(0, 0);
    });
});

$(document).ready(function () {
    $('.gama-subsection > ul > li > a.sidebar-expand-icon-2').click(function(){
        if($(this).siblings(".gama-subsection-content").hasClass('in')){
            $(this).siblings(".gama-subsection-content").removeClass('in');
        }
        else{
            $(this).siblings(".gama-subsection-content").addClass('in');
        }
    });
});

$(document).ready(function () {
    $('.gama-subsection > ul > li > a > span').click(function (e) {
        var id = $(e.target).parent('a').attr("href").split('#')[1].replace('#', '');
        //loadTabContentAjax(id);
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
        });
    });
});

$(document).ready(function () {
    $('.gama-subsection > ul > li > a').not( ".sidebar-expand-icon-2").click(function (e) {
        var id = $(e.target).attr("href").split('#')[1].replace('#', '');
        //loadTabContentAjax(id);
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
        });
    });
});

$(document).ready(function () {
    $('.gama-subsection-content > li a').not( ".sidebar-expand-icon-2").click(function (e) {
        var id = $(e.target).attr("href").split('#')[1].replace('#', '');
        //loadTabContentAjax(id);
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
        });
    });
});

// from external
$(document).ready(function () {


    var hash = document.location.hash;
    if (hash) {
        var id = hash.split('#')[1].replace('#', '');
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
            $('.gama-scroll-title span[href="#' + hash.split('#')[1] + '"]').tab('show');

            if(hash.split('#')[2]){
                $('html,body').animate({scrollTop: $("#" + hash.split('#')[2]).offset().top}, 0);
                hash = document.location.hash;
            }else{
                scrollTo(0, 0);
            }
        });

    }
});

$(document).ready(function () {

    var hash = document.location.hash;
    if (hash) {
        var id = hash.split('#')[1].replace('#', '');
        //loadTabContentAjax(id);
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
            $('.gama-subsection ul li a[data-target="#' + hash.split('#')[1] + '"]').tab('show');

            if(hash.split('#')[2]){
                $('html,body').animate({scrollTop: $("#" + hash.split('#')[2]).offset().top}, 0);
                hash = document.location.hash;
            }else{
                scrollTo(0, 0);
            }
        });
    }

    // should keep but not work
    $('.gama-subsection ul li a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
        if(hash.split('#')[2]){
            $('html,body').animate({scrollTop: $("#" + hash.split('#')[2]).offset().top}, 0);
            hash = document.location.hash;
        }else{
            scrollTo(0, 0);
        }
    });

});

$(document).ready(function () {
    var hash = document.location.hash;
    if (hash) {
        var id = hash.split('#')[1].replace('#', '');
        $.when(loadTabContentAjax(id)).then(function (data) {
            successHandler(id, data);
            $('.gama-subsection-content li a[data-target="#' + hash.split('#')[1] + '"]').tab('show');

            if(hash.split('#')[2]){
                $('html,body').animate({scrollTop: $("#" + hash.split('#')[2]).offset().top}, 0);
                hash = document.location.hash;
            }else{
                scrollTo(0, 0);
            }
        });
    }
    // should keep but not work
    $('.gama-subsection-content li a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
        if(hash.split('#')[2]){
            $('html,body').animate({scrollTop: $("#" + hash.split('#')[2]).offset().top}, 0);
            hash = document.location.hash;
        }else{
            scrollTo(0, 0);
        }
    });
});


//should keep it
$(document).ready(function () {
    //alert("hehe");

    var hash = document.location.hash;
    if (hash.split('#')[2]) {
        setTimeout(function () {
            $('html,body').animate({scrollTop: $("#" + hash.split('#')[2]).offset().top}, 0);
            hash = document.location.hash;
        }, 200);
    }
    setTimeout(function () {
        var activePage = localStorage.getItem('activePage');
        findActive(activePage);
    }, 200);
});

$(document).ready(function () {
    $('.gama-anchor').click(function (e) {
        e.preventDefault();
        $myurl = $(this).attr('href');
        if("/" + $myurl.split('#')[0].split("/").pop() !== location.pathname){
            location.href = $myurl;
        } else{
            if($myurl.split('#')[1]){
                var id = $myurl.split('#')[1].replace('#', '');
                $.when(loadTabContentAjax(id)).then(function (data) {
                    localStorage.setItem('activePage', $myurl.split('#')[1]);
                    successHandler(id, data);
                    gotoFirstAnchor($myurl);
                    gotoSecondAnchor($myurl);
                });
            }
        }
    });
});

$(document).ready(function () {
    $('#home').on('click', 'a', function (e) {
        if(!$(this).hasClass("internal-link-anchor")){
            var id = $(this).attr("href").split('#')[1].replace('#', '');
            var attr = $(this).attr('href');
            $.when(loadTabContentAjax(id)).then(function (data) {
                successHandler(id, data);
            }).then(function() {
                $('a[href="' + attr + '"]').tab('show');
            });
        } else{
            $myurl = $(this).attr('href');
            if($myurl.split('#')[1]){
                localStorage.setItem('activePage', $myurl.split('#')[1]);
            }
            if("/" + $myurl.split('#')[0].split("/").pop() == location.pathname){
                e.preventDefault();
                location.href = $myurl;
                if($myurl.split('#')[1]){
                    var id = $myurl.split('#')[1].replace('#', '');
                    //loadTabContentAjax(id);

                    $.when(loadTabContentAjax(id)).then(function (data) {
                        successHandler(id, data);
                        gotoFirstAnchor($myurl);
                        gotoSecondAnchor($myurl);
                    });
                }
            }
        }
        //scrollTo(0, 0);
    });
});

$(document).ready(function () {
    $('#gamaRightSideContent').on('click', 'a', function (e) {
        if(!$(this).hasClass("internal-link-anchor")){
            var id = $(this).attr("href").split('#')[1].replace('#', '');
            var attr = $(this).attr('href');
            $.when(loadTabContentAjax(id)).then(function (data) {
                successHandler(id, data);
            }).then(function() {
                $('a[href="' + attr + '"]').tab('show');
            });
        } else{
            $myurl = $(this).attr('href');
            if($myurl.split('#')[1]){
                localStorage.setItem('activePage', $myurl.split('#')[1]);
            }
            if("/" + $myurl.split('#')[0].split("/").pop() == location.pathname){
                e.preventDefault();
                location.href = $myurl;
                if($myurl.split('#')[1]){
                    var id = $myurl.split('#')[1].replace('#', '');
                    //loadTabContentAjax(id);

                    $.when(loadTabContentAjax(id)).then(function (data) {
                        successHandler(id, data);
                        gotoFirstAnchor($myurl);
                        gotoSecondAnchor($myurl);
                    });
                }
            }
        }
        //scrollTo(0, 0);
    });
});


function gotoLearningPath($obj , $myurl){
    $('.post a span').each(function(){
        $(this).removeClass('active');
    });

    $('.post a').each(function(){
        $(this).removeClass('active');
    });

    var id = "#" + $obj.id;
    $(id).addClass('active');
    $(id).children('span').addClass('active');

    gotoSearchResult($myurl);
}

//allow jump inside the document when searching
function gotoSearchResult($myurl){

    if("/" + $myurl.split('#')[0].split("/").pop() !== location.pathname){
        location.href = $myurl;
    } else{
        if($myurl.split('#')[1]){
            var id = $myurl.split('#')[1].replace('#', '');
            $.when(loadTabContentAjax(id)).then(function (data) {
                successHandler(id, data);
                gotoFirstAnchor($myurl);
                gotoSecondAnchor($myurl);
            });
        }
    }
}





$(document).ready(function() {
    $('span[data-toggle="tab"]').historyTabs();
    //$('span[data-toggle="tab"]').historyTabs();
    //$('a[data-toggle="tab"]').historyTabs();
    //$('.sidebar-tc-fluid').historyTabs();
});


$(document).ready(function() {
    $('#gamaSidebarTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

// store the currently selected tab in the hash value
    $("#gamaSidebarTab > li a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href");
        //window.location.hash = id;
        //alert(window.location.hash);
        localStorage.setItem('selectedTab', id);
    });

// on load of the page: switch to the currently selected tab
    //var hash = window.location.hash;
    //$('#gamaSidebarTab a[href="' + hash + '"]').tab('show');
    var selectedTab = localStorage.getItem('selectedTab');
    $('#gamaSidebarTab a[href="' + selectedTab + '"]').tab('show');
    if(selectedTab == "#menuLearnPath"){
        //gotoLearningConcept();

        var currPath = localStorage.getItem('currentPath').split(',');
        jQuery.ajax({
            url: '/wg_learning_path/learning_path_ctl/getConceptList',
            type: 'POST',
            data: {currentPath: currPath},
            success: function (data) {
                if(!data){
                    data = "<div align='center'>sorry, no learning path found here</div>";
                }
                $('#learning-path').show();
                $('#learning-path').html(data);
            }
        });

    }
});

$(document).ready(function() {
    $("#gamaSidebarTab > li a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href");
        if(id == "#menuLearnPath"){
            $('#i-tab-graph').removeClass('icon-custom-graph').addClass('icon-custom-graph-active');

            $('.concept-graph').each(function(){
                $(this).addClass('outer-concept-graph');
            });
        }else{
            $('#i-tab-graph').removeClass('icon-custom-graph-active').addClass('icon-custom-graph');

            $('.concept-graph').each(function(){
                $(this).removeClass('outer-concept-graph');
            });
        }
    });
});

$(document).ready(function() {
    $("#gamaSidebarTab > li a").mouseup(function () {
        setTimeout(function() {
            if($('#li-tab-graph').hasClass('active')){
                $('#i-tab-graph').removeClass('icon-custom-graph').addClass('icon-custom-graph-active');
            }else{
                $('#i-tab-graph').removeClass('icon-custom-graph-active').addClass('icon-custom-graph');
            }
        }, 10);
    });
});

$(document).ajaxStart(function(){
    $('#loading').show();
}).ajaxStop(function(){
    $('#loading').hide();
});


$.fn.inView = function(){
    var rect = this[0].getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
};

function getActiveKeywordElement(){
    var anchor = "";
    $('#gamaRightSideContent').find('.active').find('.gama-keyword-style').each(function(){
        if($(this).inView()) {
            anchor = $(this).attr('id').toString();
            return false;
        }
    });
    return anchor;
}

$(function () {
    $('[data-toggle="popover"]').popover()
})


$(document).ready( function() {
    $("#learningpath-overlay").on("click", function() {
        toggleOverlay();
    });
});

function toggleOverlay(){
    scrollTo(0, 0);
    $('#learningpath-overlay').css("opacity", "0.8");
    if($('#learningpath-overlay').css("display") == "block"){
        $('#learningpath-overlay').css("display", "none");
        $('#learningpath-box').css("display", "none");
        return;
    } else {
        $("#popupcontent").load("/gm_wiki/learningGraph_mod2.html");
        $('#learningpath-overlay').css("display", "block");
        $('#learningpath-box').css("display", "block");
        return;
    }
}

function toggleInOverlay(){
    scrollTo(0, 0);
    $('#learningpath-overlay').css("opacity", "0.8");
    if($('#learningpath-overlay').css("display") == "block"){
        $('#learningpath-overlay').css("display", "none");
        $('#learningpath-box').css("display", "none");
        return;
    }
}
/*
 $(document).ready( function(e) {
 var x = Math.floor((e.pageX-$("#myCanvas").offset().left) / 20);
 var y = Math.floor((e.pageY-$("#myCanvas").offset().top) / 20);
 ctx.fillStyle = "rgb(255,255,255)";
 ctx.fillRect(x*20, y*20, 20, 20);
 });*/

function gotoLearningConcept(){
    localStorage.setItem('currentPath', currentPath);
    jQuery.ajax({
        url: '/wg_learning_path/learning_path_ctl/getConceptList',
        type: 'POST',
        data: {currentPath: currentPath},
        success: function (data) {
            if(!data){
                data = "<div align='center'>sorry, no learning path found here</div>";
            }
            $('#learning-path').show();
            $('#learning-path').html(data);


            $('.post a').each(function(){
                if($(this).hasClass('active')){
                    $(this).click();
                }
            });
        }
    });
    toggleOverlay();
}



$(document).ready(function () {

    /*$(window).on('hashchange',function(){
     var activePage = localStorage.getItem('activePage');
     findActive(activePage);
     });
     */
    /*window.addEventListener('popstate', function(event) {
     var activePage = localStorage.getItem('activePage');
     findActive(activePage);
     });*/
    //var popped = ('state' in window.history), initialURL = location.href;
    $(window).on('popstate', function (e) {
        //if (!window.history.ready && !e.originalEvent.state)
        //    return; // workaround for popstate on load
        //alert("popstate");
        var activePage = localStorage.getItem('activePage');
        findActive(activePage);
    });

    /*$(window).bind('hashchange', function() {
     //alert("hashchange");
     var activePage = localStorage.getItem('activePage');
     findActive(activePage);
     });*/
});

function gotoSecondAnchor($myurl){
    setTimeout(function() {
        if($myurl.split('#')[2]){
            $('html,body').animate({scrollTop: $("#" + $myurl.split('#')[2]).offset().top}, 0);
            location.href = $myurl;
            $('#search-result-dropdown-2').hide();
        }
    }, 200);
}

function removeAllActiveWithout($mdpage) {

    var activeTab = $('.gama-scroll-title > span[href="#' + $mdpage + '"]');
    $('.gama-scroll-title > span > a').not(activeTab.find(">:first-child")).attr("aria-expanded","false");

    activeTab = $('.sidebar-tc-fluid span[href="#' + $mdpage +'"]') ;
    $('.gama-chapter').not(activeTab).removeClass('active');

    activeTab = $('.gama-subsection ul li a[data-target="#' + $mdpage + '"]');
    $('.gama-subsection > ul li').not(activeTab.parent()).removeClass('active');
    $('.gama-subsection > ul li a span').not(activeTab.find(">:first-child")).attr("aria-expanded","false");

    activeTab = $('.gama-subsection-content li a[data-target="#' + $mdpage + '"]');
    $('.gama-subsection-content > a').not(activeTab).removeClass('active');
}


function gotoFirstAnchor($myurl){
    window.location.replace($myurl.split('#')[0] + "#" + $myurl.split('#')[1]);

    $('.gama-scroll-title span[href="#' + $myurl.split('#')[1] + '"]').tab('show');
    removeAllActive();
    $('.gama-subsection ul li a[data-target="#' + $myurl.split('#')[1] + '"]').tab('show');
    removeAllActive();
    $('.gama-subsection-content li a[data-target="#' + $myurl.split('#')[1] + '"]').tab('show');
    removeAllActive();
    $('.sidebar-tc-fluid span[href="#' + $myurl.split('#')[1] +'"]').tab('show') ;
    removeAllActive();
    var activePage = localStorage.getItem('activePage');
    findActive(activePage);
}


function findActive($mdpage){
    //$('.gama-chapter').removeClass('active');
    //$('.gama-subsection > ul li').removeClass('active');
    //$('.accordion-toggle').attr("aria-expanded","false").fadeIn(3000);
    //$('.gama-scroll-title').next().removeClass('in');
    //$('.gama-subsection-content > li').removeClass('active');

    var activeTab = $('.gama-scroll-title > span[href="#' + $mdpage + '"]');
    if(activeTab.html() != null && typeof activeTab.html() != "undefined"){
        //if(activeTab.find(">:first-child").attr("aria-expanded") == "false"){
        removeAllActive();
        //alert(1 + activeTab.html());
        activeTab.find(">:first-child").attr("aria-expanded","true");
        $('.gama-scroll-title > span > a').css('height', 'auto');
        //$(">:first-child").not(activeTab.find(">:first-child")).attr("aria-expanded","false");
        activeTab.parents('.panel-collapse').first().prev().find('.gama-chapter').addClass('active');
        $(".gama-chapter").css('height', 'auto');
        $(".panel-collapse").first().prev().find('.gama-chapter').not(activeTab.parents('.panel-collapse').first().prev().find('.gama-chapter')).removeClass('active');


        $(".panel-collapse").first().not(activeTab.parents(".panel-collapse").first()).collapse("hide");
        //$('.gama-chapter').parents(".btn-group-justified").first().next().not(parent.parents('.panel-collapse').first().prev().find('.gama-chapter').parents(".btn-group-justified").first().next()).collapse("hide");

        if(!activeTab.parents(".panel-collapse").first().hasClass("in"))
            activeTab.parents(".panel-collapse").first().collapse("show");

        //}
    }

    if(activeTab.html() == null || typeof activeTab.html() == "undefined"){
        activeTab = $('.gama-subsection > ul > li > a[data-target="#' + $mdpage + '"]');
        if(activeTab.html() != null && typeof activeTab.html() != "undefined"){
            //alert(activeTab.parents('li').first().html());
            //if(!activeTab.parents('li').first().hasClass('active')){
                removeAllActive();
                //alert(2 + activeTab.html());
                activeTab.parents('li').first().addClass('active');
                $(".gama-subsection > ul > li").not(activeTab.parent()).removeClass('active');

                var parent =  activeTab.parents('.gama-subsection-collapse').first().prev();
                parent.children('span').find(">:first-child").attr("aria-expanded","true");
                //$('.gama-scroll-title > span > a').not(parent.children('span').find(">:first-child")).attr("aria-expanded","false");
                $('.gama-scroll-title > span > a').css('height', 'auto');

                if(!activeTab.parents('.gama-subsection-collapse').first().hasClass("in")){
                    activeTab.parents('.gama-subsection-collapse').first().addClass("in");
                }
                $(".gama-subsection-collapse").not(activeTab.parents('.gama-subsection-collapse').first()).removeClass('in');
                parent.parents('.panel-collapse').first().prev().find('.gama-chapter').addClass('active');
                $(".gama-chapter").css('height', 'auto');
                $('.gama-chapter').not(parent.parents('.panel-collapse').first().prev().find('.gama-chapter').first()).removeClass('active');
                //$('.gama-chapter').parents(".btn-group-justified").first().next().not(parent.parents('.panel-collapse').first().prev().find('.gama-chapter').parents(".btn-group-justified").first().next()).collapse("hide");

                $(".panel-collapse").not(parent.parents(".panel-collapse").first()).not(activeTab.parents('.gama-subsection-collapse').first()).collapse("hide");
                $(".gama-subsection-collapse").css('height', 'auto');

                if(!parent.parents(".panel-collapse").first().hasClass("in"))
                    parent.parents(".panel-collapse").first().collapse("show");
                //$(".panel-collapse").not(parent.parents(".panel-collapse").first()).collapse("hide");

            //}
        }
    }
    if(activeTab.html() == null || typeof activeTab.html() == "undefined"){
        activeTab = $('.gama-subsection-content li a[data-target="#' + $mdpage + '"]');
        if(activeTab.html() != null && typeof activeTab.html() != "undefined"){
            //if(!activeTab.parent().hasClass('active')){
                removeAllActive();
                //alert(3 + activeTab.html());
                activeTab.parent().addClass('active');

                var parent =  activeTab.parents('.gama-subsection-collapse').first().prev();
                parent.children('span').find(">:first-child").attr("aria-expanded","true");
                activeTab.parents('.gama-subsection-collapse').first().addClass("in");

                parent.parents('.panel-collapse').first().prev().find('.gama-chapter').addClass('active');
                parent.parents(".panel-collapse").first().collapse("show");

                activeTab.parents('ul:first').closest('li').addClass('active');
                //alert(3 + activeTab.parents('ul:first').html());
                activeTab.parents('ul:first').collapse("show");
            //}
        }
    }
    if(activeTab.html() == null || typeof activeTab.html() == "undefined"){
        activeTab = $('.sidebar-tc-fluid span[href="#' + $mdpage +'"]') ;
        if(activeTab.html() != null && typeof activeTab.html() != "undefined"){
            //if(!activeTab.hasClass('active')){
                removeAllActive();
                //alert(4 + activeTab.html());
                activeTab.addClass('active');
            //}
        }
    }

    //alert($('#' + $mdpage).html());
    if(activeTab.html() != null && typeof activeTab.html() != "undefined"){
        if(!$('#' + $mdpage).hasClass("active")){
            //alert($("'#" + $mdpage + "'").html());
            $('#' + $mdpage).addClass("active").addClass("in");
        }

        //alert(0 + activeTab.html());
        //return activeTab;
    }
}

$(document).ready(function () {
    //var popped = ('state' in window.history), initialURL = location.href;
    $(".dropdown-toggle").on('click', function (e) {
        //if (!window.history.ready && !e.originalEvent.state)
        //    return; // workaround for popstate on load
        $(".btn-group-justified").next().not($(this).parents(".btn-group-justified").next()).collapse("hide");
        //alert("hehe");
    });

});

/*$(document).ready(function() {
 $(".gama-subsection > ul > li a").on("shown.bs.tab", function (e) {
 var id = $(e.target).attr("href").split('#')[1].replace('#', '');
 loadTabContentAjax(id);
 });

 $('.gama-subsection-content > li > a').on('shown.bs.tab', function (e) {
 //window.location.hash = e.target.hash;
 var id = $(e.target).attr("href").split('#')[1].replace('#', '');
 loadTabContentAjax(id);
 });

 $('.gama-scroll-title > span').on('shown.bs.tab', function (e) {
 var id = $(e.target).attr("data-target").split('#')[1].replace('#', '');
 loadTabContentAjax(id);
 });

 });*/





