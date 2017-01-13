var switchTo5x=true;
if(typeof stLight !== 'undefined') {
    stLight.options({
        publisher: "31abfba6-0978-4139-8479-d6e96f61d25f",
        doNotHash: true,
        doNotCopy: true,
        hashAddressBar: false
    });
}

jQuery(document).ready(function(){
  jQuery(document).foundation();

  jQuery('.services.menu-item a').on('click', function(){
    jQuery('#mega-menu').fadeToggle();
    return false;
  });

  jQuery('.recent-work-slider').slick({
     infinite: true,
     arrows: true,
     dots: false,
     slidesToShow: 4,
     slidesToScroll: 1,
     responsive: [{
         breakpoint: 700,
         settings: {
           slidesToShow: 1
         }
       }, {
       breakpoint: 1024,
       settings: {
         slidesToShow: 2
       }
     }]
  });

    // Fires whenever a player has finished loading
    function onPlayerReady(event) {
        event.target.playVideo();
    }
    
    // Fires when the player's state changes.
    function onPlayerStateChange(event) {
        // Go to the next video after the current one is finished playing
        if (event.data === 0) {
            jQuery.fancybox.next();
        }
    }

  jQuery(".fancybox-media").fancybox({
    helpers: {
        title: {
            type: 'outside',
            position: 'top',
        },
        overlay: {
            opacity: 0.2,
            css: {'background-color': 'rgba(255, 255, 255, 0.65)'}
        }
    },
    tpl: {
      closeBtn : '<a title="Close" class="fancybox-item fancybox-close custom-close" href="javascript:;"></a>',
    },
      beforeShow  : function() {
          // Find the iframe ID
          var id = jQuery.fancybox.inner.find('iframe').attr('id');

          // Create video player object and add event listeners
          var player = new YT.Player(id, {
              events: {
                  'onReady': onPlayerReady,
                  'onStateChange': onPlayerStateChange
              }
          });
      }
  });

    jQuery(".fancybox").fancybox({
    helpers: {
        title: {
            type: 'outside',
            position: 'top',
        },
        overlay: {
            opacity: 0.2,
            css: {'background-color': 'rgba(255, 255, 255, 0.65)'}
        }
    },
    tpl: {
      closeBtn : '<a title="Close" class="fancybox-item fancybox-close custom-close" href="javascript:;"></a>',
    },
    "scrolling": "no",
    "maxWidth" : "600px",
    "fitToView": false
    });

    jQuery(".contact-scroll").click(function() {
        jQuery('html, body').animate({
            scrollTop: jQuery("#contact-form").offset().top
        }, 2000);
    });

    jQuery('.team-members .member > a.hide-for-small-only').on("click", function(e){
        var elem = jQuery('#' + jQuery(this).attr('data-toggle'));

        // close same menu on second click
        if(elem.is(':visible')) {
            elem.slideToggle();
            e.preventDefault();
            return false;
        }

        // close other visable menus before opening new one
        var visible = jQuery('.member-details .member:visible');
        if(visible.length) {
            visible.slideToggle(function () {
                elem.slideToggle();
            });
            e.preventDefault();
            return false;
        }

        // open new menu
        elem.slideToggle(function(){
            jQuery('html, body').animate({
                scrollTop: elem.offset().top - 200
            }, 2000);
        });
        e.preventDefault();
        return false;
    });

    jQuery('.member-details .member a.close').on("click", function(e){
        jQuery(this).parent('.member').slideToggle();
        e.preventDefault();
        e.defaultPrevented;
        return false;
    });

    jQuery('.horizontal-menu a').filter(function(){
        var path = window.location.pathname;
        var href = jQuery(this).attr("href");
        var href_path = href.substring(0, href.indexOf('#'));
        return href_path === path;
    }).on('click', function(e){
        var href= jQuery(this).attr('href');
        var id = href.substr(href.indexOf("#"));
        console.log(id);
        jQuery('html, body').animate({
            scrollTop: jQuery(id).offset().top - 150
    }, 2000);
        e.preventDefault();
        return false;
    });
});


jQuery(document).ready( function() {
    console.log(SP);
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    var current_page = getParameterByName('paged');
    if(!current_page) { current_page = 1; }
    jQuery('#load-more-posts').on('click', function(e){
        var load_button = jQuery(this);
        load_button.fadeOut();
        jQuery.ajax({
            url : SP.ajax_url+"?paged="+(++current_page),
            type : 'post',
            data : {
                action: 'post_love_add_love',
                post_type: 'post',
                tag: 'tag',
                term: getParameterByName('s'),
            },
            success : function(response) {
                console.log(response);
                if(response) {
                    jQuery('.posts-left .posts').append("<div id='post-page-"+current_page+"'>"+response+"</div>");
                    jQuery('body, html').animate({ scrollTop: jQuery("#post-page-"+current_page).offset().top - 200}, 1000);
                    load_button.fadeIn();
                } else {
                    jQuery('.posts-left .posts').append("<h2>No more post</h2>");
                }
            }
        });
        e.preventDefault();
        return false;
    });

});
