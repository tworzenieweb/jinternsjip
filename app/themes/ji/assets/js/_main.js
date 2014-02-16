// Modified http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
// Only fires on body class (working off strictly WordPress body_class)

var YoutubeModule = {
    players: [],
    init: function() {

        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);


    },
    initYoutube: function() {

        console.log('Youtube initialized');

        var self = this;

        function onPlayerReady() {
            console.log("hey Im ready");
            //do whatever you want here. Like, player.playVideo();

        }

        function onPlayerStateChange() {
            console.log("my state changed");
        }

        $('.banner-container .sequence-canvas iframe.youtube').each(function() {

            var t = new YT.Player($(this).attr('id'), {
                videoId: $(this).data('id'),
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }});


            self.players.push(t);

        });

    },
    stopAll: function() {

        var self = this;

        for (var i = 0, max = self.players.length; i < max; i++)
        {
            self.players[i].stopVideo();
        }

    }

};

var YoutubeComponent = {
    wrapper: null,
    playlist: null,
    iframe: null,
    init: function() {

        console.log('Youtube component start');

        this.wrapper = $('.youtube-component');
        this.playlist = $('.thumbnails-youtube', this.wrapper);
        this.iframe = $('.ytplayer', this.wrapper);

        this.initEvents();
    },
    initEvents: function() {

        this.playlist.on('click', 'a.change-movie', $.proxy(this.changeVideo, this));

        this.playlist.tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body",
            placement: 'left'
        });

        this.playlist.mCustomScrollbar({
            scrollButtons: {
                enable: false
            }
        });

    },
    changeVideo: function(event) {

        event.preventDefault();

        console.log('changing video');

        var target = $(event.currentTarget);

        console.log('link target', target.attr('href'));

        this.iframe.attr('src', target.attr('href'));

    }

};

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
    faq: {
        init: function() {

            $('.faq-categories a').on('click', function(e) {

                e.preventDefault();

                var href = $(this).attr('href').split('#')[1];

                href = href + '-wrapper';

                $('.faq-wrapper').hide();

                $('#' + href).show();

            });

        }

    },
    listings: {
        loadResults: function($obj) {

            var ajxdiv = $obj.closest("form").find("#jaxbtn").val();
            var res = {loader: $('<div />', {'class': 'mloading'}), container: $('' + ajxdiv + '')};

            var getdata = $obj.closest("form").serialize();
            var pagenum = '1';

            jQuery.ajax({
                type: 'POST',
                url: ajax.url,
                data: ({action: 'awpqsf_ajax', getdata: getdata, pagenum: pagenum}),
                beforeSend: function() {
                    $('' + ajxdiv + '').empty();
                    res.container.append(res.loader);
                },
                success: function(html) {
                    res.container.find(res.loader).remove();
                    $('' + ajxdiv + '').html(html);

                    $('#listing-results .row').each(function() {
                        
                        if($(window).width() >= 769) {
                            $('.entry-summary', $(this)).equalHeights();
                        }
                        
                    });

                }
            });

        },
        init: function() {

            var listingsForm = $('#listings_form');
            var self = this;
            $('label', listingsForm).on('click', function(e) {

                e.preventDefault();

                var $this = $(this);

                if ($this.hasClass('active'))
                {

                    if ($this.hasClass('all-labels')) {
                        $('label', listingsForm).removeClass('active').children('input').prop('checked', false);
                    }
                    else {
                        $this.removeClass('active');
                        $('input', $this).prop('checked', false);
                    }

                }
                else {

                    if ($this.hasClass('all-labels')) {
                        $('label', listingsForm).addClass('active').children('input').prop('checked', true);
                    }
                    else {
                        $this.addClass('active');
                        $('input', $this).prop('checked', true);
                    }

                }

                self.loadResults($this);

            });

        }
    },
    'what_interns_say': {
        init: function() {

            YoutubeComponent.init();

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
            pauseButton: false,
            preloader: true,
            pagination: '.pagination-block',
            hidePreloaderUsingCSS: false,
            animateStartingFrameIn: true,
            navigationSkipThreshold: 1700,
            preventDelayWhenReversingAnimations: true,
            customKeyEvents: {
                80: "pause"
            }
        };

        var sequence = $("#sequence").sequence(options).data("sequence");

        $("#sequence .wrapper-pagination").smoothDivScroll({
            mousewheelScrolling: "allDirections",
            manualContinuousScrolling: false
        });

        sequence.beforeCurrentFrameAnimatesOut = function() {

            var current = sequence.nextFrameID ? sequence.nextFrameID : 1;

            var currentSlide = $('.sequence-canvas li').eq(current - 1);

            $('.banner-container').css("background-image", "url(" + currentSlide.data('background') + ")");


        };


        $('.sequence-pagination li, .box_area_slider .play-button').on('click', function(e) {

            e.preventDefault();


            var parent;

            if ($(this).is('li'))
            {
                parent = $('.sequence-canvas li').eq($(this).index());

            }
            else {
                parent = $('.sequence-canvas li.animate-in');
            }

            $('.youtube').hide();

//            YoutubeModule.stopAll();

            if($(this).is('.play-button')) {
                $('.youtube', parent).show();
            }

        });

    }

    Programs.init();



    $(window).on('resize', function() {

        if ($(window).width() >= 769) {
            $('.homepage-container .col-sm-4').removeAttr('style');
            $('.mcm_programs .body p').removeAttr('style');

            $('.homepage-container .col-sm-4').equalHeights();
            $('.mcm_programs .body p').equalHeights();
        }
        else {
            $('.homepage-container .col-sm-4').removeAttr('style');
            $('.mcm_programs .body p').removeAttr('style');
        }

    }).trigger('resize');


    YoutubeModule.init();



});

function onYouTubeIframeAPIReady() {


    $(window).on('load', function() {
        console.log('initialized');
//        YoutubeModule.initYoutube();
    });



}