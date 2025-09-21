@include('admin.include.header')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Feedback</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Feedback</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Add Feedback</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/testimonials" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <div class="mb-3 row">
                        <label for="title" class="col-md-2 col-form-label">Title {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10"> 
                            <input class="form-control" type="text" placeholder="Title"
                                id="title" name="title" rows="3" cols="3" class="form-control"
                                >
                        </div>
                    </div>
                      <div class="mb-3 row">
                            <label for="description" class="col-md-2 col-form-label"> Description </label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="description" id="description"  rows="10" data-sample="2" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                        <label for="image" class="col-md-2 col-form-label">Image Image {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                        <input class="form-control" type="file" name="image" id="image">
                        </div>
                        <div id="image_error" style="margin-left: 173px;"></div>
                       </div>
                       <div class="mb-3 row">
                        <label for="alt_tag" class="col-md-2 col-form-label">Star Rate(Max 5) {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" value=""
                                id="alt_tag" name="alt_tag" rows="3" cols="3" class="form-control"  placeholder="Star Rate">
                        </div>
                        </div>
                        <div class="mb-3 row">
                        <label for="client_name" class="col-md-2 col-form-label">Client Name {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value=""
                                id="client_name" name="client_name" rows="3" cols="3" class="form-control"  placeholder="client name">
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
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/testimonials'">Cancel</button>
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
<script src="{{SITE_URL}}/assets/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

<script>
  
     $(function(){
        $('#addEditForm').submit(function(){
            
            if ($('#title').commonCheck() & $('#client_name').commonCheck() & $('#alt_tag').commonCheck() & $('#image').commonCheck()) 
            {
                if($('#image').checkFileType({
				blankCk: false,
				allowedExtensions: ['jpeg','jpg','png'],
				errorMessage1: 'Image is required',
				errorMessage2: 'jpeg,jpg,png file type are allowed only',
				errorArea:'#image_error'
                })){
                    return true;
                }
            }
			$('html, body').animate({
         scrollTop: ($('.ErrorMag').offset().top - 300)
      }, 2000);

            return false;
        });

    }); 
   
</script>    