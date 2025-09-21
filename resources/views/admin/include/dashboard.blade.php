@include('admin.include.header')
<link rel="stylesheet" href="{{SITE_URL}}/assets/admin/css/apexcharts/dist/apexcharts.css">
<link href="{{SITE_URL}}/assets/admin/css/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" />
<link href="{{SITE_URL}}/assets/admin/css/calendar/calendar.css" rel="stylesheet" />
        <!-- -------------------------------------------------------------- -->
        <!-- Page wrapper  -->
        <!-- -------------------------------------------------------------- -->
        
            <!-- -------------------------------------------------------------- -->
            <!-- Container fluid  -->
            <!-- -------------------------------------------------------------- -->
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-center">
                        <h3 class="text-themecolor mb-0">Dashboard</h3>
                    </div>
                    <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="{{SITE_URL}}/admin/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- Start row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3 align-self-center"><img src="{{SITE_URL}}/assets/admin/images/icon/income.png"
                                            alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted mt-2 mb-0">Occupancy
                                             %( Today )</h6>
                                        <h2>1000</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3 align-self-center"><img src="{{SITE_URL}}/assets/admin/images/icon/expense.png"
                                            alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted mt-2 mb-0">Total Revenue
                                             (Today)</h6>
                                        <h2>1000</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3 align-self-center"><img src="{{SITE_URL}}/assets/admin/images/icon/assets.png"
                                            alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted mt-2 mb-0">Bookings(This Week)</h6>
                                        <h2>1000</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="me-3 align-self-center"><img src="{{SITE_URL}}/assets/admin/images/icon/staff.png"
                                            alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted mt-2 mb-0">Revenue (This Month)</h6>
                                        <h2>1000</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="card w-100">
                            <!-- Start Basic Line Chart -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Revenue trend</h4>
                                            <div id="chart-line-basic"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Basic Line Chart -->
                        </div>
                    </div>
                    <!-- -------------------------------------------------------------- -->
                    <!-- Activity widget find scss into widget folder-->
                    <!-- -------------------------------------------------------------- -->
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="border-bottom title-part-padding">
                                            <h4 class="card-title mb-0">Occupancy trend</h4>
                                        </div>
                                        <div class="card-body analytics-info">
                                            <div id="basic-bar" style="height:400px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="">
                                <div class="row">
                                    <div class="col-lg-3 border-end pe-0">
                                        <div class="card-body border-bottom">
                                            <h4 class="card-title mt-2">Drag & Drop Event</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="calendar-events" class="">
                                                        <div class="calendar-events mb-3" data-class="bg-info"><i
                                                                class="ri-checkbox-blank-circle-fill align-middle text-info me-2"></i>Event One</div>
                                                        <div class="calendar-events mb-3" data-class="bg-success"><i
                                                                class="ri-checkbox-blank-circle-fill align-middle text-success me-2"></i> Event Two
                                                        </div>
                                                        <div class="calendar-events mb-3" data-class="bg-danger"><i
                                                                class="ri-checkbox-blank-circle-fill align-middle text-danger me-2"></i>Event Three
                                                        </div>
                                                        <div class="calendar-events mb-3" data-class="bg-warning"><i
                                                                class="ri-checkbox-blank-circle-fill align-middle text-warning me-2"></i>Event Four
                                                        </div>
                                                    </div>
                                                    <!-- checkbox -->
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="drop-remove">
                                                        <label class="form-check-label" for="drop-remove">Remove
                                                            after drop</label>
                                                    </div>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#add-new-event"
                                                        class="btn mt-3 btn-info d-block w-100 waves-effect waves-light d-flex justify-content-center align-items-center">
                                                        <i data-feather="plus" class="feather-sm"></i> Add New Event
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="card-body calender-sidebar">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BEGIN MODAL -->
                <div class="modal" id="my-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title"><strong>Add Event</strong></h4>
                                <button type="button" class="btn-close close-dialog" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close-dialog waves-effect"
                                    data-bs-dismiss="modal" aria-label="Close">Close</button>
                                <button type="button" class="btn btn-success save-event waves-effect waves-light">Create
                                    event</button>
                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light"
                                    data-bs-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop bckdrop hide"></div>
                <!-- Modal Add Category -->
                <div class="modal none-border" id="add-new-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title"><strong>Add</strong> a category</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Category Name</label>
                                            <input class="form-control form-white" placeholder="Enter name" type="text"
                                                name="category-name" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Choose Category Color</label>
                                            <select class="form-select form-white" data-placeholder="Choose a color..."
                                                name="category-color">
                                                <option value="success">Success</option>
                                                <option value="danger">Danger</option>
                                                <option value="info">Info</option>
                                                <option value="primary">Primary</option>
                                                <option value="warning">Warning</option>
                                                <option value="inverse">Inverse</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect waves-light save-category"
                                    data-bs-dismiss="modal">Save</button>
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
            </div>
            <!-- -------------------------------------------------------------- -->
            <!-- End Container fluid  -->
            <!-- -------------------------------------------------------------- -->
            <!-- -------------------------------------------------------------- -->
           
@include('admin.include.footer')

<script src="{{SITE_URL}}/assets/admin/js/pages/dashboards/dashboard4.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/moment/min/moment.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/pages/calendar/cal-init.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/taskboard/js/jquery-ui.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/apexcharts/dist/apexcharts.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/apex-chart/apex.line.init.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/echarts/dist/echarts-en.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/pages/echarts/bar/bar.js"></script>
