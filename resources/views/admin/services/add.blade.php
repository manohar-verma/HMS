@include('admin.include.header')
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/css/samples.css">
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Services</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Services</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Add New</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/services" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    
                     <div class="mb-3 row">
                            <label for="first_Name" class="col-md-2 col-form-label">Name {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="name" id="name"
                                    value="">
                            </div>
                     </div>
                     
                        <div class="mb-3 row">
                            <label for="description" class="col-md-2 col-form-label">Description {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="description" id="description"  rows="10" data-sample="2"placeholder="Description"></textarea>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="first_Name" class="col-md-2 col-form-label">Display Order</label>
                            <div class="col-md-10">
                                <input class="form-control allow_numeric" type="text" name="display_order" id="display_order"
                                    value="" placeholder="Display Order">
                            </div>
                     </div>
                     <div class="mb-3 row">
                            <label for="first_Name" class="col-md-2 col-form-label">Icon Class</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="icon_class" id="icon_class"
                                    value="" placeholder="Icon Class">
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
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/services'">Cancel</button>
                        </div>
                           </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.include.footer')
<script src="{{SITE_URL}}/assets/common/ckeditor/ckeditor.js"></script>
<script src=" {{SITE_URL}}/assets/common/ckeditor/samples/js/sample.js"></script>
<script data-sample="2">
        CKEDITOR.replace('description', {
            height: 400
        });
    </script>
<script>
      $(function(){
        $('#addEditForm').submit(function(){
            if ($('#name').commonCheck() & $('#description').commonCheck()) 
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