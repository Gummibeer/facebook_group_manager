function reposition_topnav() {
    if (jQuery('.nav-horizontal').length > 0) {

        // top navigation move to left nav
        // .nav-horizontal will set position to relative when viewed in screen below 1024
        if (jQuery('.nav-horizontal').css('position') == 'relative') {

            if (jQuery('.leftpanel .nav-bracket').length == 2) {
                jQuery('.nav-horizontal').insertAfter('.nav-bracket:eq(1)');
            } else {
                // only add to bottom if .nav-horizontal is not yet in the left panel
                if (jQuery('.leftpanel .nav-horizontal').length == 0)
                    jQuery('.nav-horizontal').appendTo('.leftpanelinner');
            }

            jQuery('.nav-horizontal').css({display: 'block'})
                .addClass('nav-pills nav-stacked nav-bracket');

            jQuery('.nav-horizontal .children').removeClass('dropdown-menu');
            jQuery('.nav-horizontal > li').each(function () {

                jQuery(this).removeClass('open');
                jQuery(this).find('a').removeAttr('class');
                jQuery(this).find('a').removeAttr('data-toggle');

            });

            if (jQuery('.nav-horizontal li:last-child').has('form')) {
                jQuery('.nav-horizontal li:last-child form').addClass('searchform').appendTo('.topnav');
                jQuery('.nav-horizontal li:last-child').hide();
            }

        } else {
            // move nav only when .nav-horizontal is currently from leftpanel
            // that is viewed from screen size above 1024
            if (jQuery('.leftpanel .nav-horizontal').length > 0) {

                jQuery('.nav-horizontal').removeClass('nav-pills nav-stacked nav-bracket')
                    .appendTo('.topnav');
                jQuery('.nav-horizontal .children').addClass('dropdown-menu').removeAttr('style');
                jQuery('.nav-horizontal li:last-child').show();
                jQuery('.searchform').removeClass('searchform').appendTo('.nav-horizontal li:last-child .dropdown-menu');
                jQuery('.nav-horizontal > li > a').each(function () {

                    jQuery(this).parent().removeClass('nav-active');

                    if (jQuery(this).parent().find('.dropdown-menu').length > 0) {
                        jQuery(this).attr('class', 'dropdown-toggle');
                        jQuery(this).attr('data-toggle', 'dropdown');
                    }
                });
            }
        }
    }
}

function closeVisibleSubMenu() {
    jQuery('.leftpanel .nav-parent').each(function () {
        var t = jQuery(this);
        if (t.hasClass('nav-active')) {
            t.find('> ul').slideUp(200, function () {
                t.removeClass('nav-active');
            });
        }
    });
}

function adjustmainpanelheight() {
    // // Adjust mainpanel height
    // jQuery('.mainpanel').height(0);
    // var docHeight = jQuery(document).height();
    // if (docHeight > jQuery('.mainpanel').height())
    //     jQuery('.mainpanel').height(docHeight);
}

function layoutMasonry() {
    jQuery('.grid').masonry({
        itemSelector: '.grid-item'
    });
    adjustmainpanelheight();
}

jQuery(window).on('load', function () {
    "use strict";

    // Page Preloader
    jQuery('#preloader').delay(350).fadeOut(function () {
        jQuery('body').delay(350).css({'overflow': 'visible'});
    });

    // Toggle Left Menu
    jQuery('.leftpanel .nav-parent > a').on('click', function () {

        var parent = jQuery(this).parent();
        var sub = parent.find('> ul');

        // Dropdown works only when leftpanel is not collapsed
        if (!jQuery('body').hasClass('leftpanel-collapsed')) {
            if (sub.is(':visible')) {
                sub.slideUp(200, function () {
                    parent.removeClass('nav-active');
                    jQuery('.mainpanel').css({height: ''});
                    adjustmainpanelheight();
                });
            } else {
                closeVisibleSubMenu();
                parent.addClass('nav-active');
                sub.slideDown(200, function () {
                    adjustmainpanelheight();
                });
            }
        }
        return false;
    });

    layoutMasonry();


    // Tooltip
    jQuery('.tooltips').tooltip({container: 'body'});
    jQuery('[data-toggle="tooltip"]').tooltip({container: 'body'});

    // Popover
    jQuery('.popovers').popover();

    // Close Button in Panels
    jQuery('.panel .panel-close').click(function () {
        jQuery(this).closest('.panel').fadeOut(200);
        return false;
    });

    // Minimize Button in Panels
    jQuery('.minimize').click(function () {
        var t = jQuery(this);
        var p = t.closest('.panel');
        if (!jQuery(this).hasClass('maximize')) {
            p.find('.panel-body, .panel-footer').slideUp(200);
            t.addClass('maximize');
            t.html('&plus;');
        } else {
            p.find('.panel-body, .panel-footer').slideDown(200);
            t.removeClass('maximize');
            t.html('&minus;');
        }
        return false;
    });

    // Add class everytime a mouse pointer hover over it
    jQuery('.nav-bracket > li').hover(function () {
        jQuery(this).addClass('nav-hover');
    }, function () {
        jQuery(this).removeClass('nav-hover');
    });

    // Menu Toggle
    jQuery('.menutoggle').click(function () {

        var body = jQuery('body');
        var bodypos = body.css('position');

        if (bodypos != 'relative') {

            if (!body.hasClass('leftpanel-collapsed')) {
                body.addClass('leftpanel-collapsed');
                jQuery('.nav-bracket ul').attr('style', '');

                jQuery(this).addClass('menu-collapsed');

            } else {
                body.removeClass('leftpanel-collapsed chat-view');
                jQuery('.nav-bracket li.active ul').css({display: 'block'});

                jQuery(this).removeClass('menu-collapsed');

            }
        } else {

            if (body.hasClass('leftpanel-show'))
                body.removeClass('leftpanel-show');
            else
                body.addClass('leftpanel-show');

            adjustmainpanelheight();
        }

        layoutMasonry();

    });

    reposition_topnav();

    jQuery(window).resize(function () {
        if (jQuery('body').css('position') == 'relative') {

            jQuery('body').removeClass('leftpanel-collapsed chat-view');

        } else {

            jQuery('body').removeClass('chat-relative-view');
            jQuery('body').css({left: '', marginRight: ''});
        }

        reposition_topnav();

        layoutMasonry();
    });

    // Check if leftpanel is collapsed
    if (jQuery('body').hasClass('leftpanel-collapsed')) {
        jQuery('.nav-bracket .children').css({display: ''});
    }
});