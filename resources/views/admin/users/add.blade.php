@include('admin.include.header')
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/css/samples.css">
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Guest</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Guest</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Add Users</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/users/guest" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    
                     <div class="mb-3 row">
                            <label for="name" class="col-md-2 col-form-label">Name {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="name" id="name"
                                    value="">
                            </div>
                     </div>
                     
                     <div class="mb-3 row">
                            <label for="email" class="col-md-2 col-form-label">Email {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email"
                                    value="">
                            </div>
                     </div>
                     <div class="mb-3 row">
                            <label for="phone" class="col-md-2 col-form-label">Phone {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control allow_numeric"type="text" name="phone" id="phone"
                                    value="" minlength="10" maxlength="10">
                            </div>
                     </div>
                    <div class="mb-3 row">
                            <label for="date" class="col-md-2 col-form-label">Date {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="datepicker form-control"  placeholder="yyyy-mm-dd"type="text" type="text" 
                                    id="dob" name="dob" rows="3" cols="3" 
                                     readonly="true"></input>
                                    
                            </div>
                    </div>
                     <div class="mb-3 row">
                            <label for="address" class="col-md-2 col-form-label">Address</label>
                            <div class="col-md-10">
                                <input class="form-control"type="text" name="address" id="address"
                                    value="">
                            </div>
                     </div>
                     <div class="mb-3 row">
                        <label for="image" class="col-md-2 col-form-label">Profile Image</label>
                        <div class="col-md-10">
                        <input class="form-control" type="file" name="image" id="image">
                    </div>
                     <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Gender</label>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" id="male" name="gender" class="form-check-input" value="M" checked="true">
                                    <label class="form-check-label" for="gender">Male</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="female" name="gender" class="form-check-input" value="F">
                                    <label class="form-check-label" for="gender">Female</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="other" name="gender" class="form-check-input" value="O">
                                    <label class="form-check-label" for="gender">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" id="Active" name="status" class="form-check-input" value="1" checked="true">
                                    <label class="form-check-label" for="Active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="Deactivate" name="status" class="form-check-input" value="0">
                                    <label class="form-check-label" for="Deactivate">Deactivate</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <div class="d-flex align-items-center">
                                    <i data-feather="save" class="feather-sm me-1 fill-icon"></i> Save
                                </div>
                            </button>
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/users/guest'">Cancel</button>
                        </div>
                           </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.include.footer')
<script src="{{SITE_URL}}/assets/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script>
    $('.datepicker').datepicker({format:'yyyy-mm-dd'});
      $(function(){
       
        $('#addEditForm').submit(function(){
            if ($('#name').commonCheck() & $('#email').validateEmail() & $('#phone').commonCheck() & $('#dob').commonCheck()) 
            { 
                return true;
                
            }
			$('html, body').animate({
         scrollTop: ($('.ErrorMag').offset().top - 300)
      }, 2000);

            return false;
        });
    });
  
</script>    