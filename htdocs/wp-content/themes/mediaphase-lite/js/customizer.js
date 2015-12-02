/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
  // Site title and description.
//	wp.customize( 'blogname', function( value ) {
//		value.bind( function( to ) {
//			$( '.site-title a' ).text( to );
//		} );
//	} );
  wp.customize('blogdescription', function (value) {
    value.bind(function (to) {
      $('.site-description').text(to);
    });
  });
  // Background color.
  wp.customize('background_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('body').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('body').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    });
  });

  // top ribbon
  wp.customize('mediaphase_top_ribbon_show', function (value) {
    value.bind(function (to) {
      to === 'yes' ? $('.topribbon').show() : $('.topribbon').hide();
    });
  });
  wp.customize('mediaphase_top_ribbon_bg_image', function (value) {
    value.bind(function (to) {
      $('.topribbon').attr('style', 'background-image: url(' + to + ');');
    });
  });
  wp.customize('mediaphase_top_ribbon_text', function (value) {
    value.bind(function (to) {
      $('.topribbon .wrap p').html(to);
    });
  });
  // end top ribbon

  // hero banner
  wp.customize('mediaphase_hero_show', function (value) {
    value.bind(function (to) {
      to === 'yes' ? $('#hero').show() : $('#hero').hide();
    });
  });
  wp.customize('mediaphase_hero_bg_image', function (value) {
    value.bind(function (to) {
      $('#hero').attr('style', 'background: url(' + to + ') no-repeat;');
    });
  });
  wp.customize('mediaphase_hero_title', function (value) {
    value.bind(function (to) {
      $('#herotitle').html(to);
    });
  });
  wp.customize('mediaphase_hero_text', function (value) {
    value.bind(function (to) {
      $('#herotext').html(to);
    });
  });
  // end hero banner

  // footer logo
  wp.customize('mediaphase_footer_logo_show', function (value) {
    value.bind(function (to) {
      to === 'yes' ? $('#bottom').show() : $('#bottom').hide();
    });
  });
  wp.customize('mediaphase_footer_logo_image', function (value) {
    value.bind(function (to) {
      $('#bottom .bottomlogo').attr('src', to);
      if (!to) {
        $('#bottom .bottomlogo').hide();
      } else {
        $('#bottom .bottomlogo').show();
      }
    });
  });
  // end footer logo

  // sub features
  wp.customize('mediaphase_sub_features_show', function (value) {
    value.bind(function (to) {
      to === 'yes' ? $('#subfeatures').show() : $('#subfeatures').hide();
    });
  });
  // end sub features

  // main features
  wp.customize('mediaphase_main_features_show', function (value) {
    value.bind(function (to) {
      to === 'yes' ? $('#mainfeatures').show() : $('#mainfeatures').hide();
    });
  });
  wp.customize('mediaphase_main_features_bg_image', function (value) {
    value.bind(function (to) {
      $('#mainfeatures .mainfeaturesimage').attr('src', to);
      if (!to) {
        $('#mainfeatures .mainfeaturesimage').hide();
      } else {
        $('#mainfeatures .mainfeaturesimage').show();
      }
    });
  });
  wp.customize('mediaphase_main_features_title', function (value) {
    value.bind(function (to) {
      $('#mainfeatures .featuretitle h2').text(to);
    });
  });
  // end main features

  // header contacts
  wp.customize('mediaphase_header_contacts_show', function (value) {
    value.bind(function (to) {
      to === 'yes' ? $('.contactdetails').show() : $('.contactdetails').hide();
    });
  });
  wp.customize('mediaphase_header_contacts_phone', function (value) {
    value.bind(function (to) {
      $('.contactdetails .contact-phone').html('<i class="fa fa-phone-square"></i> ' + to);
      if (!to) {
        $('.contactdetails .contact-phone').hide();
      } else {
        $('.contactdetails .contact-phone').show();
      }
    });
  });
  wp.customize('mediaphase_header_contacts_email', function (value) {
    value.bind(function (to) {
      $('.contactdetails .contact-email').html('<i class="fa fa-envelope"></i> ' + to);
      if (!to) {
        $('.contactdetails .contact-email').hide();
      } else {
        $('.contactdetails .contact-email').show();
      }
    });
  });
  // end header contacts

  // header logo
  wp.customize('mediaphase_header_logo_show', function (value) {
    value.bind(function (to) {
      if (to === 'logo') {
        $('.site-title a img').show();
        $('.site-title a h1').hide();
      } else {
        $('.site-title a img').hide();
        $('.site-title a h1').show();
      }
    });
  });
  wp.customize('mediaphase_header_logo_image', function (value) {
    value.bind(function (to) {
      $('.site-title a img').attr('src', to);
      if (!to) {
        $('.site-title a img').hide();
      } else {
        $('.site-title a img').show();
      }
    });
  });
  wp.customize('mediaphase_header_logo_text', function (value) {
    value.bind(function (to) {
      $('.site-title a h1').text(to);
    });
  });
  // end header logo

  // logos
  wp.customize('mediaphase_logos_show', function (value) {
    value.bind(function (to) {
      if (to === 'yes') {
        $('#logos').show();
      } else {
        $('#logos').hide();
      }
    });
  });
  wp.customize('mediaphase_logos_image', function (value) {
    value.bind(function (to) {
      $('#logos img').attr('src', to);
      if (!to) {
        $('#logos img').hide();
      } else {
        $('#logos img').show();
      }
    });
  });
  // end logos

  // bottom ribbon
  wp.customize('mediaphase_bottom_ribbon_show', function (value) {
    value.bind(function (to) {
      if (to === 'yes') {
        $('.botribbon').show();
      } else {
        $('.botribbon').hide();
      }
    });
  });
  wp.customize('mediaphase_bottom_ribbon_bg_image', function (value) {
    value.bind(function (to) {
      $('.botribbon').attr('style', 'background-image: url(' + to + ');');
    });
  });
  wp.customize('mediaphase_bottom_ribbon_text', function (value) {
    value.bind(function (to) {
      $('.botribbon .wrap').html(to);
    });
  });
  // end bottom ribbon

  // latest news
  wp.customize('mediaphase_latest_news_show', function (value) {
    value.bind(function (to) {
      if (to === 'yes') {
        $('#news').show();
      } else {
        $('#news').hide();
      }
    });
  });
  wp.customize('mediaphase_latest_news_title', function (value) {
    value.bind(function (to) {
      $('#news .featuretitle h2').text(to);
    });
  });
  wp.customize('mediaphase_latest_news_text', function (value) {
    value.bind(function (to) {
      $('#news .newsintro').text(to);
    });
  });
  // end latest news

  // meet the team
  wp.customize('mediaphase_meet_the_team_show', function (value) {
    value.bind(function (to) {
      if (to === 'yes') {
        $('#team').show();
      } else {
        $('#team').hide();
      }
    });
  });
  wp.customize('mediaphase_meet_the_team_title', function (value) {
    value.bind(function (to) {
      $('#team .featuretitle h2').text(to);
    });
  });
  wp.customize('mediaphase_meet_the_team_text', function (value) {
    value.bind(function (to) {
      $('#team .teamintro').text(to);
    });
  });
  // end meet the team

  // about us
  wp.customize('mediaphase_about_us_show', function (value) {
    value.bind(function (to) {
      if (to === 'yes') {
        $('#aboutus').show();
      } else {
        $('#aboutus').hide();
      }
    });
  });
  wp.customize('mediaphase_about_us_title', function (value) {
    value.bind(function (to) {
      $('#aboutus .featuretitle h2').text(to);
    });
  });
  wp.customize('mediaphase_about_us_text', function (value) {
    value.bind(function (to) {
      $('#aboutus .wrap p').text(to);
    });
  });
  // end about us

  // middle ribbon
  wp.customize('mediaphase_middle_ribbon_show', function (value) {
    value.bind(function (to) {
      if (to === 'yes') {
        $('.midribbon').show();
      } else {
        $('.midribbon').hide();
      }
    });
  });
  wp.customize('mediaphase_middle_ribbon_bg_image', function (value) {
    value.bind(function (to) {
      $('.midribbon').attr('style', 'background-image: url(' + to + ');');
    });
  });
  wp.customize('mediaphase_middle_ribbon_text', function (value) {
    value.bind(function (to) {
      $('.midribbon .wrap').html(to);
    });
  });
  // end middle ribbon
  // full width page
  wp.customize('mediaphase_page_fullwidth', function (value) {
    value.bind(function (to) {
      if (to === 'yes') {
        $('body').addClass('fullwidth');
      } else {
        $('body').removeClass('fullwidth');
      }
    });
  });
  // end full width page
  // google fonts
  wp.customize('mediaphase_google_fonts_body_font', function (value) {
    value.bind(function (to) {
      var font = to.replace(' ', '+');
      WebFontConfig = {
        google: { families: [ font + '::latin' ] }
      };
      (function () {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
          '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })();

      // style the text
      if (to == 'none') {
        $('body').attr('style', '');
      }
      else {
        var myVar = setInterval(function () {
          if (typeof WebFont != 'undefined') {
            WebFont.load({
              google: {
                families: [font]
              }
            });
            clearInterval(myVar);
          }
        }, 100);

        $('body').attr("style", 'font-family:"' + to + '" !important');
      }

    });
  });
  wp.customize('mediaphase_google_fonts_heading_font', function (value) {
    value.bind(function (to) {
      var font = to.replace(' ', '+');
      WebFontConfig = {
        google: { families: [ font + '::latin' ] }
      };
      (function () {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
          '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })();

      // style the text
      if (to == 'none') {
        $('h1,h2,h3,h4,h5,h6').attr("style", '');
      }
      else {
        var myVar = setInterval(function () {
          if (typeof WebFont != 'undefined') {
            WebFont.load({
              google: {
                families: [font]
              }
            });
            clearInterval(myVar);
          }
        }, 100);

        $('h1,h2,h3,h4,h5,h6').attr("style", 'font-family:"' + to + '" !important');
      }
    });
  });

  // colors
  // Accent color
  wp.customize('mediaphase_accent_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('body, .topsearch .search-submit, #herotitle a, #herotext a:not(.herobutton), .red, .herobutton, .featuretitle, .featurewidgeticon a, .newscategory a, .teamsocial, #backtotop a, .footerwidget li a:before, #backtotop').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('.topsearch .search-submit, .red').css({
          'clip': 'auto',
          'background-color': to,
          'border-color': to,
          'position': 'relative'
        });

        $('#herotitle a, #herotext a:not(.herobutton), .featuretitle, #backtotop').css({
          'clip': 'auto',
          'border-bottom-color': to,
          'position': 'relative'
        });

        $('.herobutton, body').css({
          'clip': 'auto',
          'border-color': to,
          'position': 'relative'
        });

        $('.featurewidgeticon a').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });

        $('.teamsocial, .newscategory a, #backtotop a').css({
          'clip': 'auto',
          'background': to,
          'position': 'relative'
        });

        if ($('#widget-before-styles').length < 1) {
          $('head').append('<style id="widget-before-styles" type="text/css"></style>');
        }

        $('#widget-before-styles').text('.footerwidget li a::before, .footerwidget li::before { color: ' + to + ' !important}');
      }
    });
  });
  // mediaphase_link_color
  wp.customize('mediaphase_link_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('a').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('a, a:visited, .newsmeta .fa').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_heading_color
  wp.customize('mediaphase_heading_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('h1, h2, h3, h4, h5, h6').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('h1, h2, h3, h4, h5, h6').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_text_color
  wp.customize('mediaphase_text_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('body').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('body').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_main_content_background_color
  wp.customize('mediaphase_main_content_background_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#main').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#main').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_post_content_background_color
  wp.customize('mediaphase_post_content_background_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('.singlepost, .sidebarwidget, #authorbox, #comments, #responder, .newspost').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('.singlepost, .sidebarwidget, #authorbox, #comments, #responder, .newspost').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_header_background_color
  wp.customize('mediaphase_header_background_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#header').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#header').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_header_text_color
  wp.customize('mediaphase_header_text_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#header, ').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#header, .site-description, #cssmenu > ul > li > a').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });

        if ($('#menu-before-styles').length < 1) {
          $('head').append('<style id="menu-before-styles" type="text/css"></style>');
        }

        $('#menu-before-styles').text('#cssmenu > ul > li.menu-item-has-children > a::before, #cssmenu > ul > li.menu-item-has-children > a::after { background: ' + to + ' !important}');

      }
    })
  });

  // mediaphase_sub_header_background_color
  wp.customize('mediaphase_sub_header_background_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#subheader, .topsearch .search-field').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#subheader, .topsearch .search-field').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_footer_color
  wp.customize('mediaphase_footer_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#footer').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#footer').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_bottom_bar_color
  wp.customize('mediaphase_bottom_bar_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#bottom').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#bottom').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    })
  });

  // mediaphase_border_color
  wp.customize('mediaphase_border_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('.member, .newspost, .footerwidget li a, .footerwidget #recentcomments li, .featurewidgeticon, .topsearch .search-field, #header, .sidebarwidget li a, .sidebarwidget, .sidebarwidget .search-field, .singlepost, #authorbox, .comments-title, #comments, #reply-title, #responder, textarea, .content blockquote').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('.member, .newspost, .footerwidget li a, .footerwidget #recentcomments li, .featurewidgeticon, .topsearch .search-field, #header, .sidebarwidget li a, .sidebarwidget, .sidebarwidget .search-field, .singlepost, #authorbox, .comments-title, #comments, #reply-title, #responder, textarea, .content blockquote').css({
          'clip': 'auto',
          'border-color': to
        });
      }
    })
  });

})(jQuery);
