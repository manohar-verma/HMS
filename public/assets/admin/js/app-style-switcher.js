$(function() {
    "use strict";

    //****************************
    /* Handle style from cookie */
    //****************************  

    let currentActiveTheme = getCookie('currentActiveTheme')?getCookie('currentActiveTheme'):'light';
      
      $('body').attr("data-theme", currentActiveTheme);
      if(currentActiveTheme == 'dark'){
        $("#theme-view").prop("checked","true");
      }
      let currentLogBg = getCookie('currentLogBg')?getCookie('currentLogBg'):'skin6';
      $('.topbar .top-navbar .navbar-header').attr("data-logobg", currentLogBg);

      let currentNavBarBg = getCookie('currentNavBarBg')?getCookie('currentNavBarBg'):'skin6';
      $('#main-wrapper').attr("data-navbarbg", currentNavBarBg);
      $('.topbar').attr("data-navbarbg", currentNavBarBg);
      $('.topbar .navbar-collapse').attr("data-navbarbg", currentNavBarBg);
      
      let currentSideBarBg = getCookie('currentSideBarBg')?getCookie('currentSideBarBg'):'skin6';
      $('.left-sidebar').attr("data-sidebarbg", currentSideBarBg);

      let currentSTyleSideBarBg = getCookie('currentSTyleSideBarBg')?getCookie('currentSTyleSideBarBg'):'skin6';
      $('.side-mini-panel').attr("data-stylishsidebarbg", currentSTyleSideBarBg);

      let currentBarPosition = getCookie('currentBarPosition')?getCookie('currentBarPosition'):'relative';
      if(currentBarPosition == 'fixed'){
            $('#main-wrapper').attr("data-sidebar-position", 'fixed' );
            $('.topbar .top-navbar .navbar-header').attr("data-navheader", 'fixed' );
            $("#sidebar-position").prop("checked","true");
      }
      let currentHeaderPosition = getCookie('currentHeaderPosition')?getCookie('currentHeaderPosition'):'relative';
      if(currentHeaderPosition == 'fixed'){
      setCookie('currentHeaderPosition','fixed',365);
      $('#main-wrapper').attr("data-header-position", 'fixed' );
      $("#header-position").prop("checked","true");
      }
      let currentBoxLayout = getCookie('currentBoxLayout')?getCookie('currentBoxLayout'):'full';
      if(currentBoxLayout == 'boxed'){
        $("#boxed-layout").prop("checked","true");
        $('#main-wrapper').attr("data-boxed-layout", 'boxed' );
       }

    //****************************
    /* Left header Theme Change function Start */
    //****************************
    function handlelogobg() {
        $('.theme-color .theme-item .theme-link').on("click", function() {
            var logobgskin = $(this).attr("data-logobg");
            if(logobgskin) setCookie('currentLogBg',logobgskin,365);
            $('.topbar .top-navbar .navbar-header').attr("data-logobg", logobgskin);
        });
    };
    handlelogobg();
    //****************************
    /* Top navbar Theme Change function Start */
    //****************************
    function handlenavbarbg() {
        if ( $('#main-wrapper').attr('data-navbarbg') == 'skin6' ) {
                    // do this
                    $(".topbar .navbar").addClass('navbar-light');
                    $(".topbar .navbar").removeClass('navbar-dark');
                } else {
                    // do that
                    
                }
        $('.theme-color .theme-item .theme-link').on("click", function() {
            var navbarbgskin = $(this).attr("data-navbarbg");
            console.log('navbarbgskin',navbarbgskin);
            if(navbarbgskin) setCookie('currentNavBarBg',navbarbgskin,365);
            $('#main-wrapper').attr("data-navbarbg", navbarbgskin);
            $('.topbar').attr("data-navbarbg", navbarbgskin);
            $('.topbar .navbar-collapse').attr("data-navbarbg", navbarbgskin);
            if ( $('#main-wrapper').attr('data-navbarbg') == 'skin6' ) {
                    // do this
                    $(".topbar .navbar").addClass('navbar-light');
                    $(".topbar .navbar").removeClass('navbar-dark');
                } else {
                    // do that
                    $(".topbar .navbar").removeClass('navbar-light');
                    $(".topbar .navbar").addClass('navbar-dark');
                }
        });
        
    };

    handlenavbarbg();
    
    //****************************
    // ManageSidebar Type
    //****************************
    function handlesidebartype() {
        
    };
    handlesidebartype();
     
    
    //****************************
    /* Manage sidebar bg color */
    //****************************
    function handlesidebarbg() {
        $('.theme-color .theme-item .theme-link').on("click", function() {
            var sidebarbgskin = $(this).attr("data-sidebarbg");
            if(sidebarbgskin) setCookie('currentSideBarBg',sidebarbgskin,365);
            $('.left-sidebar').attr("data-sidebarbg", sidebarbgskin);
        });
    };
    handlesidebarbg();

    function handlestylishsidebarbg() {
        $('.theme-color .theme-item .theme-link').on("click", function() {
            var stylishsidebarbgskin = $(this).attr("data-stylishsidebarbg");
            if(stylishsidebarbgskin) setCookie('currentSTyleSideBarBg',stylishsidebarbgskin,365);
            $('.side-mini-panel').attr("data-stylishsidebarbg", stylishsidebarbgskin);
        });
    };
    handlestylishsidebarbg();
    //****************************
    /* sidebar position */
    //****************************
    function handlesidebarposition() {
		$('#sidebar-position').change(function() {
            if( $(this).is(":checked")) {
                setCookie('currentBarPosition','fixed',365);
                $('#main-wrapper').attr("data-sidebar-position", 'fixed' );
                $('.topbar .top-navbar .navbar-header').attr("data-navheader", 'fixed' );
            }else {
                setCookie('currentBarPosition','relative',365);
                $('#main-wrapper').attr("data-sidebar-position", 'absolute' ); 
                $('.topbar .top-navbar .navbar-header').attr("data-navheader", 'relative' );
            }
        });
        
	};
    handlesidebarposition ();
    //****************************
    /* Header position */
    //****************************
    function handleheaderposition() {
		$('#header-position').change(function() {
            if( $(this).is(":checked")) {
                setCookie('currentHeaderPosition','fixed',365);
                $('#main-wrapper').attr("data-header-position", 'fixed' );
            }else {
                setCookie('currentHeaderPosition','relative',365);
                $('#main-wrapper').attr("data-header-position", 'relative' ); 
            }      
        });
	};
    handleheaderposition ();
    //****************************
    /* sidebar position */
    //****************************
    function handleboxedlayout() {
		$('#boxed-layout').change(function() {
            if( $(this).is(":checked")) {
                setCookie('currentBoxLayout','boxed',365);
                $('#main-wrapper').attr("data-boxed-layout", 'boxed' );
            }else {
                setCookie('currentBoxLayout','full',365);
                $('#main-wrapper').attr("data-boxed-layout", 'full' ); 
            }
        });
        
	};
    handleboxedlayout ();
    //****************************
    /* Header position */
    //****************************
    function handlethemeview() {
		$('#theme-view').change(function() {
            if( $(this).is(":checked")) {
                setCookie('currentActiveTheme','dark',365);
                $('body').attr("data-theme", 'dark');
            }else {
                setCookie('currentActiveTheme','light',365);
                $('body').attr("data-theme", 'light'); 
            }      
        });
	};
    handlethemeview ();
      
});