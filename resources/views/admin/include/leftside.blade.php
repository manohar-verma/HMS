
        <!-- -------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------- -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- -------------------------------------------------------------- -->
        <?php 
            $user = auth()->guard('admin')->user();
            use App\library\get_site_details; 
            $get_site_details = new get_site_details;
            $activeUser =isset($user->id)?$user->id:0;
            $accessData = $get_site_details->getUserAccess($activeUser);
            $userRoles=(explode(",",$accessData));
        ?>
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                    <li class="sidebar-item user-profile">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <img src="{{SITE_URL}}/assets/admin/images/icon/staff.png" alt="user">
                                <span class="hide-menu">@if(isset($user['name'])){{$user['name']}}@endif</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                              
                                <li class="sidebar-item">
                                    <a href="{{SITE_URL}}/admin/logout" class="sidebar-link p-0">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> Logout </span>
                                    </a>
                                </li>
                                 
                            </ul>
                        </li>
                        <li class="nav-small-cap">
                            <i class="mdi mdi-dots-horizontal"></i>
                            <span class="hide-menu">Control Panel</span>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/dashboard" aria-expanded="false">
                                🏠<span class="hide-menu">Dashboard</span></a></li>
                        @if(in_array("hotel-profile", $userRoles) ||  in_array("domain-and-brand", $userRoles) ||  in_array("business-info", $userRoles) ||  in_array("security-setting", $userRoles) ||  in_array("hotel", $userRoles))            
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                ⚙️
                                <span class="hide-menu">Settings</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                @if(in_array("hotel-profile", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/hotel-profile" aria-expanded="false">🌐<span class="hide-menu">Domain & Branding</span></a></li> 
                                @endif
                                 @if(in_array("hotel", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/hotel" aria-expanded="false">🏨<span class="hide-menu">Manage Hotels</span></a></li> 
                                @endif
                                <!-- @if(in_array("domain-and-brand", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/domain-and-brand" aria-expanded="false">🌐</i><span class="hide-menu">Domain & Branding</span></a></li> 
                                @endif -->
                                @if(in_array("business-info", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/business-info" aria-expanded="false">💼</i><span class="hide-menu">Business Info</span></a></li> 
                                @endif
                                @if(in_array("security-setting", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/security-setting" aria-expanded="false">🔐<span class="hide-menu">Security Setting</span></a></li> 
                                @endif
                            </ul>
                        </li>
                        @endif
                       
                      
                        @if(in_array("sub-admin", $userRoles) || in_array("guest", $userRoles)) 
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                👤
                                <span class="hide-menu">User Management</span>
                            </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @if(in_array("sub-admin", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/sub-admin" aria-expanded="false">👥<span class="hide-menu">Staff</span></a></li>           
                            @endif
                            @if(in_array("guest", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/guest" aria-expanded="false">👥<span class="hide-menu">Guest</span></a></li>
                            @endif
                          </ul>
                        </li>
                        @endif

                        @if(in_array("all-booking", $userRoles) || in_array("new-booking", $userRoles) || in_array("calendar-view", $userRoles)) 
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                📖
                                <span class="hide-menu">Bookings Management</span>
                            </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @if(in_array("sub-admin", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/all-booking" aria-expanded="false">📋<span class="hide-menu">All Bookings</span></a></li>           
                            @endif
                            @if(in_array("guest", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/new-booking" aria-expanded="false">➕<span class="hide-menu">New Booking</span></a></li>
                            @endif
                            @if(in_array("calendar-view", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/calendar-view" aria-expanded="false">📅<span class="hide-menu">Calendar View</span></a></li>
                            @endif
                          </ul>
                        </li>
                        @endif

                        @if(in_array("room", $userRoles) || in_array("room-type", $userRoles) || in_array("room-inventory", $userRoles) || in_array("availability", $userRoles) || in_array("rate-plans", $userRoles) || in_array("amenities", $userRoles)) 
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                🏨
                                <span class="hide-menu">Rooms & Inventory</span>
                            </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @if(in_array("room-type", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/room-type" aria-expanded="false">🏷️<span class="hide-menu">Room Types</span></a></li>           
                            @endif
                            @if(in_array("room", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/room" aria-expanded="false">🏠<span class="hide-menu">Rooms</span></a></li>
                            @endif
                            @if(in_array("availability", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/availability" aria-expanded="false">📆<span class="hide-menu">Availability</span></a></li>
                            @endif
                             @if(in_array("amenities", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/amenities" aria-expanded="false">📆<span class="hide-menu">Amenities</span></a></li>
                            @endif
                            @if(in_array("rate-plans", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/rate-plans" aria-expanded="false">💰<span class="hide-menu">Rate Plans</span></a></li>
                            @endif
                          </ul>
                        </li>
                        @endif

                        @if(in_array("payments-list", $userRoles) || in_array("invoices", $userRoles) || in_array("gateway-settings", $userRoles)) 
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                💳
                                <span class="hide-menu">Payments & Invoices</span>
                            </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @if(in_array("payments-list", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/payments-list" aria-expanded="false">💳<span class="hide-menu">Payments List</span></a></li>           
                            @endif
                            @if(in_array("invoices", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/invoices" aria-expanded="false">🧾<span class="hide-menu">Invoices</span></a></li>
                            @endif
                            @if(in_array("gateway-settings", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/gateway-settings" aria-expanded="false">🔗<span class="hide-menu">Payment Gateway Settings</span></a></li>
                            @endif
                           
                          </ul>
                        </li>
                        @endif

                        @if(in_array("occupancy", $userRoles) || in_array("revenue", $userRoles) || in_array("cancellation", $userRoles) || in_array("booking-sources", $userRoles)) 
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                📊
                                <span class="hide-menu">Reports & Analytics</span>
                            </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @if(in_array("occupancy", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/occupancy" aria-expanded="false">📈<span class="hide-menu">Occupancy Report</span></a></li>           
                            @endif
                            @if(in_array("revenue", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/revenue" aria-expanded="false">💵<span class="hide-menu">Revenue Report</span></a></li>
                            @endif
                            @if(in_array("cancellation", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/cancellation" aria-expanded="false">❌<span class="hide-menu">Cancellation Report</span></a></li>
                            @endif
                            @if(in_array("booking-sources", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/booking-sources" aria-expanded="false">📊<span class="hide-menu">Booking Sources</span></a></li>
                            @endif
                          </ul>
                        </li>
                        @endif

                        @if(in_array("email-templates", $userRoles) || in_array("sms-templates", $userRoles) || in_array("push", $userRoles)) 
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                🔔
                                <span class="hide-menu">Notifications</span>
                            </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @if(in_array("email-templates", $userRoles))
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/email-templates" aria-expanded="false">📧<span class="hide-menu">Email Templates</span></a></li>           
                            @endif
                            @if(in_array("sms-templates", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/sms-templates" aria-expanded="false">📱<span class="hide-menu">SMS Templates</span></a></li>
                            @endif
                            @if(in_array("push", $userRoles))
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ADMIN_URL}}/push" aria-expanded="false">🔔<span class="hide-menu">Push Notifications</span></a></li>
                            @endif
                            
                          </ul>
                        </li>
                        @endif
                        @if(in_array("logs", $userRoles))           
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{SITE_URL}}/admin/logs" aria-expanded="false">
                            📜
                                <span class="hide-menu">Audit Logs</span>
                            </a>
                        </li>
                        @endif
                        @if(in_array("change-password", $userRoles))           
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{SITE_URL}}/admin/change-password" aria-expanded="false">
                            <i class="fas fa-key"></i>
                                <span class="hide-menu">Change Password</span>
                            </a>
                        </li>
                        @endif
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ADMIN_URL}}/logout" aria-expanded="false"><i data-feather="log-out"
                                    class="feather-icon"></i><span class="hide-menu">Log Out</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- -------------------------------------------------------------- -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- -------------------------------------------------------------- -->