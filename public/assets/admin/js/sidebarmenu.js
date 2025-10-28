/*
Template Name: Admin Template
Author: Wrappixel

File: js
*/
// ============================================================== 
// Auto select left navbar
// ============================================================== 
$(function() {
    "use strict";
     var url = window.location + "";
     let countUrl=(url.split("/").length - 1);
      url = url.split("?")[0];
        var path = url.replace(window.location.protocol + "//" + window.location.host + "/", "");
        path = path.split("?")[0];
        if(countUrl==7)
        {
            path = path.slice(0, path.lastIndexOf("/"));
            url = url.slice(0, url.lastIndexOf("/"));
        }
        if(countUrl==8)
        {
            path = path.slice(0, path.lastIndexOf('/', path.lastIndexOf('/')-1));
            url = url.slice(0, url.lastIndexOf('/', url.lastIndexOf('/')-1));
        }
        console.log(path);
        console.log(url);
        var element = $('ul#sidebarnav a').filter(function() {
            return this.href === url || this.href === path;// || url.href.indexOf(this.href) === 0;
        });
        element.parentsUntil(".sidebar-nav").each(function (index)
        {
            if($(this).is("li") && $(this).children("a").length !== 0)
            {
                $(this).children("a").addClass("active");
                $(this).parent("ul#sidebarnav").length === 0
                    ? $(this).addClass("active")
                    : $(this).addClass("selected");
            }
            else if(!$(this).is("ul") && $(this).children("a").length === 0)
            {
                $(this).addClass("selected");
                
            }
            else if($(this).is("ul")){
                $(this).addClass('in');
            }
            
        });

    element.addClass("active"); 
    $('#sidebarnav a').on('click', function (e) {
        
            if (!$(this).hasClass("active")) {
                // hide any open menus and remove all other classes
                $("ul", $(this).parents("ul:first")).removeClass("in");
                $("a", $(this).parents("ul:first")).removeClass("active");
                
                // open our new menu and add the open class
                $(this).next("ul").addClass("in");
                $(this).addClass("active");
                
            }
            else if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(this).parents("ul:first").removeClass("active");
                $(this).next("ul").removeClass("in");
            }
    })
    $('#sidebarnav >li >a.has-arrow').on('click', function (e) {
        e.preventDefault();
    });

    // Auto scroll to the active nav
    if ( $(window).width() > 768 || window.Touch) { 
         $('.scroll-sidebar').animate({
            scrollTop: $("#sidebarnav .sidebar-item.selected").offset().top -250
        }, 500);
    }
    
});