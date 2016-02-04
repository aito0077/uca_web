'use strict';

angular.module('ucaApp')
.controller('MainCtrl', function ($scope, $timeout, $location, $http, $sce, api_host, Page, instagram_token, instagram_client_id) {
    $scope.mr_firstSectionHeight = 0;
    $scope.mr_nav = 0;
    $scope.mr_navOuterHeight = 0;
    $scope.mr_navScrolled = false;
    $scope.mr_navFixed = false;
    $scope.mr_outOfSight = false;
    $scope.mr_floatingProjectSections = 0;
    $scope.mr_scrollTop = 0;


    $scope.setup_components = function() {

        if(jQuery('.inner-link').length){
            jQuery('.inner-link').smoothScroll({
                offset: -55,
                speed: 800
            });
        }

        addEventListener('scroll', function() {
            $scope.mr_scrollTop = window.pageYOffset;
        }, false);

        jQuery('.background-image-holder').each(function() {
            var imgSrc = jQuery(this).children('img').attr('src');
            jQuery(this).css('background', 'url("' + imgSrc + '")');
            jQuery(this).children('img').hide();
            jQuery(this).css('background-position', 'initial');
        });

        setTimeout(function() {
            jQuery('.background-image-holder').each(function() {
                jQuery(this).addClass('fadeIn');
            });
        }, 200);

        jQuery('[data-toggle="tooltip"]').tooltip();

        // Tabbed Content

        jQuery('.tabbed-content').each(function() {
            jQuery(this).append('<ul class="content"></ul>');
        });

        jQuery('.tabs li').each(function() {
            var originalTab = jQuery(this),
                activeClass = "";
            if (originalTab.is('.tabs li:first-child')) {
                activeClass = ' class="active"';
            }
            var tabContent = originalTab.find('.tab-content').detach().wrap('<li' + activeClass + '></li>').parent();
            originalTab.closest('.tabbed-content').find('.content').append(tabContent);
        });

        jQuery('.tabs li').click(function() {
            jQuery(this).closest('.tabs').find('li').removeClass('active');
            jQuery(this).addClass('active');
            var liIndex = jQuery(this).index() + 1;
            jQuery(this).closest('.tabbed-content').find('.content>li').removeClass('active');
            jQuery(this).closest('.tabbed-content').find('.content>li:nth-of-type(' + liIndex + ')').addClass('active');
        });

        if (!jQuery('nav').hasClass('fixed') && !jQuery('nav').hasClass('absolute')) {

            jQuery('.nav-container').css('min-height', jQuery('nav').outerHeight(true));

            jQuery(window).resize(function() {
                jQuery('.nav-container').css('min-height', jQuery('nav').outerHeight(true));
            });

            if (jQuery(window).width() > 768) {
                jQuery('.parallax:nth-of-type(1) .background-image-holder').css('top', -(jQuery('nav').outerHeight(true)));
            }

            if (jQuery(window).width() > 768) {
                jQuery('section.fullscreen:nth-of-type(1)').css('height', (jQuery(window).height() - jQuery('nav').outerHeight(true)));
            }

        } else {
            jQuery('body').addClass('nav-is-overlay');
        }

        if (jQuery('nav').hasClass('bg-dark')) {
            jQuery('.nav-container').addClass('bg-dark');
        }


        $scope.mr_nav = jQuery('body .nav-container nav:first');
        $scope.mr_navOuterHeight = jQuery('body .nav-container nav:first').outerHeight();
        window.addEventListener("scroll", $scope.updateNav, false);

        jQuery('.mobile-toggle').click(function() {
            jQuery('.nav-bar').toggleClass('nav-open');
            jQuery(this).toggleClass('active');
        });

        jQuery('.menu li').click(function(e) {
            if (!e) e = window.event;
            e.stopPropagation();
            if (jQuery(this).find('ul').length) {
                jQuery(this).toggleClass('toggle-sub');
            } else {
                jQuery(this).parents('.toggle-sub').removeClass('toggle-sub');
            }
        });

        jQuery('.module.widget-handle').click(function() {
            jQuery(this).toggleClass('toggle-widget-handle');
        });
        
        if(jQuery('.offscreen-toggle').length){
            jQuery('body').addClass('has-offscreen-nav');
        }
        
        jQuery('.offscreen-toggle').click(function(){
            jQuery('.main-container').toggleClass('reveal-nav');
            jQuery('.offscreen-container').toggleClass('reveal-nav');
        });
        
        jQuery('.main-container').click(function(){
            if(jQuery(this).hasClass('reveal-nav')){
                jQuery(this).removeClass('reveal-nav');
                jQuery('.offscreen-container').removeClass('reveal-nav');
            }
        });
        
        jQuery('.offscreen-container a').click(function(){
            jQuery('.offscreen-container').removeClass('reveal-nav');
            jQuery('.main-container').removeClass('reveal-nav');
        });

        jQuery('.tweets-feed').each(function(index) {
            jQuery(this).attr('id', 'tweets-' + index);
        }).each(function(index) {

            function handleTweets(tweets) {
                var x = tweets.length;
                var n = 0;
                var element = document.getElementById('tweets-' + index);
                var html = '<ul class="slides">';
                while (n < x) {
                    html += '<li>' + tweets[n] + '</li>';
                    n++;
                }
                html += '</ul>';
                element.innerHTML = html;
                return html;
            }

            twitterFetcher.fetch(jQuery('#tweets-' + index).attr('data-widget-id'), '', 5, true, true, true, '', false, handleTweets);

        });

        jQuery.fn.spectragram.accessData = {
            accessToken: instagram_token,
            clientID: instagram_client_id
        };

        /*
        jQuery('.instafeed').each(function() {
            jQuery(this).children('ul').spectragram('getUserFeed', {
                query: jQuery(this).attr('data-user-name'),
                max: 12
            });
        });
        */


        jQuery('.instafeedtag').each(function() {
            //jQuery(this).children('ul').spectragram('getRecentTagged', {
            jQuery(this).children('ul').spectragram('getUserFeed', {
                query: 'PabellonArteUca',
                max: 12
            });
        });



        jQuery('.slider-all-controls').flexslider({});
        jQuery('.slider-paging-controls').flexslider({
            animation: "slide",
            directionNav: false
        });
        jQuery('.slider-arrow-controls').flexslider({
            controlNav: false
        });
        jQuery('.slider-thumb-controls .slides li').each(function() {
            var imgSrc = jQuery(this).find('img').attr('src');
            jQuery(this).attr('data-thumb', imgSrc);
        });
        jQuery('.slider-thumb-controls').flexslider({
            animation: "slide",
            controlNav: "thumbnails",
            directionNav: true
        });
        jQuery('.logo-carousel').flexslider({
            minItems: 1,
            maxItems: 4,
            move: 1,
            itemWidth: 200,
            itemMargin: 0,
            animation: "slide",
            slideshow: true,
            slideshowSpeed: 3000,
            directionNav: false,
            controlNav: false
        });
        
        jQuery('.lightbox-grid li a').each(function(){
            var galleryTitle = jQuery(this).closest('.lightbox-grid').attr('data-gallery-title');
            jQuery(this).attr('data-lightbox', galleryTitle);
        });


        jQuery('.map-holder').click(function() {
            jQuery(this).addClass('interact');
        });

        jQuery(window).scroll(function() {
            if (jQuery('.map-holder.interact').length) {
                jQuery('.map-holder.interact').removeClass('interact');
            }
        });

        if ((/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)) {
            jQuery('section').removeClass('parallax');
        }
        
        if (jQuery('.masonry').length) {
            var container = document.querySelector('.masonry');
            var msnry = new Masonry(container, {
                itemSelector: '.masonry-item'
            });

            msnry.on('layoutComplete', function() {

                $scope.mr_firstSectionHeight = jQuery('.main-container section:nth-of-type(1)').outerHeight(true);

                // Fix floating project filters to bottom of projects container

                if (jQuery('.filters.floating').length) {
                    $scope.setupFloatingProjectFilters();
                    $scope.updateFloatingFilters();
                    window.addEventListener("scroll", $scope.updateFloatingFilters, false);
                }

                jQuery('.masonry').addClass('fadeIn');
                jQuery('.masonry-loader').addClass('fadeOut');
                if (jQuery('.masonryFlyIn').length) {
                    $scope.masonryFlyIn();
                }
            });

            msnry.layout();
        }

        var setUpTweets = setInterval(function() {
            if (jQuery('.tweets-slider').find('li.flex-active-slide').length) {
                clearInterval(setUpTweets);
                return;
            } else {
                if (jQuery('.tweets-slider').length) {
                    jQuery('.tweets-slider').flexslider({
                        directionNav: false,
                        controlNav: false
                    });
                }
            }
        }, 500);

        $scope.mr_firstSectionHeight = jQuery('.main-container section:nth-of-type(1)').outerHeight(true);

        jQuery('.instafeed').each(function() {
            jQuery(this).children('ul').spectragram('getUserFeed', {
                query: $scope.home.instagram_username,
                max: 12
            });
        });

    };


    $scope.updateNav = function() {

        var scrollY = $scope.mr_scrollTop;

        if (scrollY <= 0) {
            if ($scope.mr_navFixed) {
                $scope.mr_navFixed = false;
                $scope.mr_nav.removeClass('fixed');
            }
            if ($scope.mr_outOfSight) {
                $scope.mr_outOfSight = false;
                $scope.mr_nav.removeClass('outOfSight');
            }
            if ($scope.mr_navScrolled) {
                $scope.mr_navScrolled = false;
                $scope.mr_nav.removeClass('scrolled');
            }
            return;
        }

        if (scrollY > $scope.mr_firstSectionHeight) {
            if (!$scope.mr_navScrolled) {
                $scope.mr_nav.addClass('scrolled');
                $scope.mr_navScrolled = true;
                return;
            }
        } else {
            if (scrollY > $scope.mr_navOuterHeight) {
                if (!$scope.mr_navFixed) {
                    $scope.mr_nav.addClass('fixed');
                    $scope.mr_navFixed = true;
                }

                if (scrollY > $scope.mr_navOuterHeight * 2) {
                    if (!$scope.mr_outOfSight) {
                        $scope.mr_nav.addClass('outOfSight');
                        $scope.mr_outOfSight = true;
                    }
                } else {
                    if ($scope.mr_outOfSight) {
                        $scope.mr_outOfSight = false;
                        $scope.mr_nav.removeClass('outOfSight');
                    }
                }
            } else {
                if ($scope.mr_navFixed) {
                    $scope.mr_navFixed = false;
                    $scope.mr_nav.removeClass('fixed');
                }
                if ($scope.mr_outOfSight) {
                    $scope.mr_outOfSight = false;
                    $scope.mr_nav.removeClass('outOfSight');
                }
            }

            if ($scope.mr_navScrolled) {
                $scope.mr_navScrolled = false;
                $scope.mr_nav.removeClass('scrolled');
            }

        }
    };

    $scope.masonryFlyIn = function () {
        var $items = jQuery('.masonryFlyIn .masonry-item');
        var time = 0;

        $items.each(function() {
            var item = jQuery(this);
            setTimeout(function() {
                item.addClass('fadeIn');
            }, time);
            time += 170;
        });
    };

    $scope.setupFloatingProjectFilters = function () {
        $scope.mr_floatingProjectSections = [];
        jQuery('.filters.floating').closest('section').each(function() {
            var section = jQuery(this);

            $scope.mr_floatingProjectSections.push({
                section: section.get(0),
                outerHeight: section.outerHeight(),
                elemTop: section.offset().top,
                elemBottom: section.offset().top + section.outerHeight(),
                filters: section.find('.filters.floating'),
                filersHeight: section.find('.filters.floating').outerHeight(true)
            });
        });
    };

    $scope.updateFloatingFilters = function () {
        var l = $scope.mr_floatingProjectSections.length;
        while (l--) {
            var section = $scope.mr_floatingProjectSections[l];

            if (section.elemTop < $scope.mr_scrollTop) {
                section.filters.css({
                    position: 'fixed',
                    top: '16px',
                    bottom: 'auto'
                });
                if ($scope.mr_navScrolled) {
                    section.filters.css({
                        transform: 'translate3d(-50%,48px,0)'
                    });
                }
                if ($scope.mr_scrollTop > (section.elemBottom - 70)) {
                    section.filters.css({
                        position: 'absolute',
                        bottom: '16px',
                        top: 'auto'
                    });
                    section.filters.css({
                        transform: 'translate3d(-50%,0,0)'
                    });
                }
            } else {
                section.filters.css({
                    position: 'absolute',
                    transform: 'translate3d(-50%,0,0)'
                });
            }
        }
    };






        $scope.getMuestraLink = function (muestra) {
            return $sce.trustAsResourceUrl(muestra.website);
        };




        $scope.getImageSrc = function (image_name, height, width) {
            return $sce.trustAsResourceUrl('http://images.collab-dev.com/'+height+'x'+width+'/uca/'+image_name);
        };


        $scope.arrange_items = [];
        $scope.items = [];
        $scope.heights = [
            '390', '189', '150', '246', '257', '230', '224', '173'
        ];

        $scope.current_muestras = [];
        $scope.remark_muestras = [];
        $scope.unremark_muestras = [];

        $scope.limit_remark = 2;
        $scope.limit_normal = 8;

        $scope.showMore = function() {
            $scope.limit_remark = $scope.limit_remark + 2;
            $scope.limit_normal = $scope.limit_remark * 4;
        };

        $http.get(api_host+'/api/pages/home').success(function(page) {
            $scope.home = page;

            var data = $scope.home;
            _.each(data.organizations, function(item) {
                if(item.is_current) {
                    $scope.current_muestras.push(item);
                }
                if(item.remark == 1) {
                    $scope.remark_muestras.push(item);
                } else {
                    $scope.unremark_muestras.push(item);
                }
            });

            $timeout(function() {
                $scope.setup_components();
            }, 2000);
        });

        $scope.view = function(type, id) {
            window.loading_screen = window.pleaseWait({
                backgroundColor: '#59BC6C',
                loadingHtml: "<div class='sk-double-bounce'> <div class='sk-child sk-double-bounce1'></div> <div class='sk-child sk-double-bounce2'></div> </div><h1>Pabellón UCA</h1>"
            });

            $location.path('/'+type+'/'+id);
        };

    })
.controller('footer-controller', function ($scope, $http, $timeout, $sce, api_host, instagram_token, instagram_client_id) {
    $scope.home = {};

    $scope.tweets = [];
    $scope.handleTweets = function(tweets) {
        $scope.tweets = tweets;
        $scope.$apply();
    };

    $scope.tweetText = function(tweet) {
        return $sce.trustAsHtml(tweet);
    };

    $scope.setup_components = function() {
        //accessToken: '1406933036.fedaafa.feec3d50f5194ce5b705a1f11a107e0b',
        //clientID: 'fedaafacf224447e8aef74872d3820a1'

        jQuery.fn.spectragram.accessData = {
            accessToken: instagram_token,
            clientID: instagram_client_id
        };

        jQuery('.instafeed').each(function() {
            jQuery(this).children('ul').spectragram('getUserFeed', {
                query: $scope.home.instagram_username,
                max: 12
            });
        });

        if($scope.home.twitter_hashtag) {
            twitterFetcher.fetch({
                id: $scope.home.twitter_hashtag, 
                domId: '', 
                maxTweets: 5,
                enableLinks: true,
                showUser:true, 
                showTime: true, 
                dateFunction: '', 
                showRetweet: false,
                customCallback:  $scope.handleTweets
            });
        }
    };

    $http.get(api_host+'/api/pages/home').success(function(page) {
        $scope.home = page;
        $timeout(function() {
            $scope.setup_components();
        }, 2000);
    });


})
;
