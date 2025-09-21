<!-- footer -->
<?php
  use App\library\get_site_details; 
 
  $get_site_details = new get_site_details;
  $siteInfo = $get_site_details->get_site_data();
?>
<!-- -------------------------------------------------------------- -->
<footer class="footer text-center">
{!!$siteInfo->copy_right!!}
</footer>
<!-- -------------------------------------------------------------- -->
<!-- End footer -->
<!-- -------------------------------------------------------------- -->
</div>
<!-- -------------------------------------------------------------- -->
<!-- End Page wrapper  -->
<!-- -------------------------------------------------------------- -->
</div>
<!-- -------------------------------------------------------------- -->
<!-- End Wrapper -->
<!-- -------------------------------------------------------------- -->
<!-- -------------------------------------------------------------- -->
<!-- customizer Panel -->
<!-- -------------------------------------------------------------- -->
<aside class="customizer">
    <a href="javascript:void(0)" class="service-panel-toggle"><i data-feather="settings"
            class="feather-sm fa fa-spin"></i></a>
    <div class="customizer-body">
        <ul class="nav customizer-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab"
                    aria-controls="pills-home" aria-selected="true"><i class="ri-tools-fill fs-6"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#chat" role="tab"
                    aria-controls="chat" aria-selected="false"><i class="ri-message-3-line fs-6"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact" role="tab"
                    aria-controls="pills-contact" aria-selected="false"><i class="ri-timer-line fs-6"></i></a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <!-- Tab 1 -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="p-3 border-bottom">
                    <!-- Sidebar -->
                    <h5 class="font-weight-medium mb-2 mt-2">Layout Settings</h5>
                    <div class="form-check mt-3">
                        <input type="checkbox" name="theme-view" class="form-check-input" id="theme-view">
                        <label class="form-check-label" for="theme-view"> <span>Dark Theme</span> </label>
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" class="sidebartoggler form-check-input" name="collapssidebar"
                            id="collapssidebar" onclick="handleCollPassSideBar();">
                        <label class="form-check-label" for="collapssidebar"> <span onclick="handleCollPassSideBar();">Collapse Sidebar</span> </label>
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="sidebar-position" class="form-check-input" id="sidebar-position">
                        <label class="form-check-label" for="sidebar-position"> <span>Fixed Sidebar</span> </label>
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="header-position" class="form-check-input" id="header-position">
                        <label class="form-check-label" for="header-position"> <span>Fixed Header</span> </label>
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="boxed-layout" class="form-check-input" id="boxed-layout">
                        <label class="form-check-label" for="boxed-layout"> <span>Boxed Layout</span> </label>
                    </div>
                </div>
                <div class="p-3 border-bottom">
                    <!-- Logo BG -->
                    <h5 class="font-weight-medium mb-2 mt-2">Logo Backgrounds</h5>
                    <ul class="theme-color m-0 p-0">
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-logobg="skin1"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-logobg="skin2"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-logobg="skin3"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-logobg="skin4"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-logobg="skin5"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-logobg="skin6"></a></li>
                    </ul>
                    <!-- Logo BG -->
                </div>
                <div class="p-3 border-bottom">
                    <!-- Navbar BG -->
                    <h5 class="font-weight-medium mb-2 mt-2">Navbar Backgrounds</h5>
                    <ul class="theme-color m-0 p-0">
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-navbarbg="skin1"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-navbarbg="skin2"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-navbarbg="skin3"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-navbarbg="skin4"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-navbarbg="skin5"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-navbarbg="skin6"></a></li>
                    </ul>
                    <!-- Navbar BG -->
                </div>
                <div class="p-3 border-bottom">
                    <!-- Logo BG -->
                    <h5 class="font-weight-medium mb-2 mt-2">Sidebar Backgrounds</h5>
                    <ul class="theme-color m-0 p-0">
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-sidebarbg="skin1"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-sidebarbg="skin2"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-sidebarbg="skin3"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-sidebarbg="skin4"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-sidebarbg="skin5"></a></li>
                        <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)"
                                class="theme-link rounded-circle d-block" data-sidebarbg="skin6"></a></li>
                    </ul>
                    <!-- Logo BG -->
                </div>
            </div>
           
        </div>
    </div>
</aside>
<div class="chat-windows"></div>
<script>
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      }
      function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return null;
      }
</script>    
<!-- -------------------------------------------------------------- -->
<!-- All Jquery -->
<!-- -------------------------------------------------------------- -->
<script src="{{SITE_URL}}/assets/admin/js/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{SITE_URL}}/assets/admin/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- apps -->
<script src="{{SITE_URL}}/assets/admin/js/app.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/app.init.minimal.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/app-style-switcher.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{SITE_URL}}/assets/admin/js/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="{{SITE_URL}}/assets/admin/js/waves.js"></script>
<!--Menu sidebar -->
<script src="{{SITE_URL}}/assets/admin/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="{{SITE_URL}}/assets/admin/js/feather.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/custom.min.js"></script>
<!--This page JavaScript -->
<script src="{{SITE_URL}}/assets/admin/js/moment/min/moment.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/pages/calendar/cal-init.js"></script>
<!-- Vector map JavaScript -->
<script src="{{SITE_URL}}/assets/admin/js/jvectormap/jquery-jvectormap.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/jvector/jquery-jvectormap-world-mill-en.js"></script>
<!-- Chart JS -->

<script src="{{SITE_URL}}/assets/admin/js/toastr/dist/build/toastr.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/toastr/toastr-init.js"></script>

<!--This page JavaScript -->
<script src="{{SITE_URL}}/assets/admin/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/magnific-popup/meg.init.js"></script>

<script src="{{SITE_URL}}/assets/common/js/FormValidation.1.2.js"></script>

<script src="{{SITE_URL}}/assets/admin/js/custom.dev.js"></script>
@if(Session::has('success'))
<script>
toastr.success('{{Session::get('success')}}', 'Great!');
</script>
{{Session::forget('success')}}
@elseif(Session::has('error'))
<script>
toastr.error('{{Session::get('error')}}', 'Failed!');
</script>
{{Session::forget('error')}}
@else(Session::forget('error') && Session::forget('success'))
@endif
<script>
    
   
</script>

</body>

</html>