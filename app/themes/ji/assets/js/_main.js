// Modified http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
// Only fires on body class (working off strictly WordPress body_class)

var ExampleSite = {
    // All pages
    common: {
        init: function() {
            // JS here
        },
        finalize: function() {
        }
    },
    // Home page
    home: {
        init: function() {

        }
    },
    // About page
    about: {
        init: function() {
            // JS here
        }
    },
    listings: {
        init: function() {
            
            $('#listings_form select').select2().on('change', function() {
                
                passing_data($(this));
                
            }).trigger('change');
            
        }
    }
};

var UTIL = {
    fire: function(func, funcname, args) {
        var namespace = ExampleSite;
        funcname = (funcname === undefined) ? 'init' : funcname;
        if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
            namespace[func][funcname](args);
        }
    },
    loadEvents: function() {

        UTIL.fire('common');

        $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
            UTIL.fire(classnm);
        });

        UTIL.fire('common', 'finalize');
    }
};

$(document).ready(UTIL.loadEvents);


jQuery(function() {

    var options;

    if ($('#sequence').length > 0) {
        options = {
            autoPlay: true,
            autoPlayDelay: 12000,
            pauseOnHover: false,
            hidePreloaderDelay: 1000,
            nextButton: false,
            prevButton: false,
            pagination: true,
            pauseButton: false,
            preloader: true,
            hidePreloaderUsingCSS: false,
            animateStartingFrameIn: true,
            navigationSkipThreshold: 1700,
            preventDelayWhenReversingAnimations: true,
            customKeyEvents: {
                80: "pause"
            }
        };

        var sequence = $("#sequence").sequence(options).data("sequence");

        sequence.beforeCurrentFrameAnimatesOut = function() {

            var current = sequence.nextFrameID ? sequence.nextFrameID : 1;


            $('.sequence-canvas iframe').remove();

            var currentSlide = $('.sequence-canvas li').eq(current - 1);

            $('.banner-container').css("background-image", "url(" + currentSlide.data('background') + ")");



        };
        $('.box_area_slider .play-button').on('click', function(e) {
            e.preventDefault();

            var src = 'http://www.youtube.com/v/URL&amp;autoplay=0&amp;cc_load_policy=1&amp;hd=1&amp;controls=1&amp;autohide=1&amp;rel=0&amp;modestbranding=1&amp;showinfo=0&amp;wmode=opaque&amp;html5=1'.replace('URL', $(this).closest('li').data('youtube'));

            var parent = $(this).parent();


            $('iframe', parent).remove();

            var movie = $('<iframe>', {
                width: '100%',
                height: '100%',
                frameborder: 0,
                allowfullscreen: true,
                css: {
                    'z-index': 999,
                    'position': 'absolute',
                    'top': 0,
                    'left': 0
                }
            }).attr('src', src);

            parent.append(movie);


        });

    }





    $('.homepage-container .col-sm-4').equalHeights();
    $('.mcm_programs .body p').equalHeights();


});