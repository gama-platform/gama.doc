(function ( $ ) {
    $.fn.stickyTabs = function( options ) {
        var context = this

        var settings = $.extend({
            getHashCallback: function(hash, btn) { return hash }
        }, options );

        // Show the tab corresponding with the hash in the URL, or the first tab.
        var showTabFromHash = function() {
            var hash = window.location.hash;
            var selector = hash ? 'a[href="' + document.location.toString() + '"]' : 'li.active > a';
            $(selector, context).tab('show');
        }

        // We use pushState if it's available so the page won't jump, otherwise a shim.
        var changeHash = function(hash) {
            if (history && history.pushState) {
                history.pushState(null, null, '#' + hash);
            } else {
                scrollV = document.body.scrollTop;
                scrollH = document.body.scrollLeft;
                window.location.hash = hash;
                document.body.scrollTop = scrollV;
                document.body.scrollLeft = scrollH;
            }
        }

        // Set the correct tab when the page loads
        showTabFromHash(context)

        // Set the correct tab when a user uses their back/forward button
        $(window).on('hashchange', showTabFromHash);

        // Change the URL when tabs are clicked
        $('a', context).on('click', function(e) {
            var hash = this.href.split('#')[1];
            var adjustedhash = settings.getHashCallback(hash, this);
            changeHash(adjustedhash);
        });

        return this;
    };
}( jQuery ));


(function ($) {
    'use strict';
    $.fn.historyTabs = function() {
        var that = this;
        window.addEventListener('popstate', function(event) {
            if (event.state) {
                $(that).filter('[href="' + event.state.url + '"]').tab('show');
            }
        });
        return this.each(function(index, element) {
            $(element).on('show.bs.tab', function() {
                var stateObject = {'url' : $(this).attr('href')};

                if (window.location.hash && stateObject.url !== window.location.hash) {
                    window.history.pushState(stateObject, document.title, window.location.pathname + $(this).attr('href'));
                } else {
                    window.history.replaceState(stateObject, document.title, window.location.pathname + $(this).attr('href'));
                }
            });
            if (!window.location.hash && $(element).is('.active')) {
                // Shows the first element if there are no query parameters.
                $(element).tab('show');
            } else if ($(this).attr('href') === window.location.hash) {
                $(element).tab('show');
            }
        });
    };
}(jQuery));