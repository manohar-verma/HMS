@include('admin.include.header')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Blog Category</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Blog Category</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Add Blog Category</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/blog-cat" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Name {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" placeholder="name"
                                id="name" name="name" rows="3" cols="3" class="form-control"
                                value="">
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
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/blog-cat'">Cancel</button>
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
<script data-sample="2">
        CKEDITOR.replace('short_description', {
            height: 400
        });
    </script>

<script>
    $('.datepicker').datepicker();
    $(function(){
        $('#addEditForm').submit(function(){
            if ($('#name').commonCheck()) 
            {
             $('html, body').animate({
             scrollTop: ($('.ErrorMag').offset().top - 300)
             }, 2000);
              return false;   
            }
            $('html, body').animate({
                scrollTop: ($('.ErrorMag').offset().top - 300)
            }, 2000);

            return false;
        });
        
            $('.datepicker').datepicker();
      
    }); 
   
</script>    