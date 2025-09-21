@include('admin.include.header')
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/css/samples.css">
<?php 
  $BannerType = array(
    'home'=>'home Page',
    'about'=>'About Page',
    'service'=>'Service Page',
    'contact'=>'Contact Page'
 );
?>
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Banner</h3>
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Add Banner</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/banner/{{$bannerData->id}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <input name="_method" type="hidden" value="PUT">
                    <div class="mb-3 row">
                            <label for="title" class="col-md-2 col-form-label">Title</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="title" id="title"
                                    value="{{$bannerData->title}}">
                            </div>
                        </div>  
                    <div class="mb-3 row">
                            <label for="type" class="col-md-2 col-form-label">Position {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <select class="form-select col-12" id="type" name="type" >
                                    <option value="">Select Type</option>
                                    @foreach($BannerType as $key=>$type)
                                    <option value="{{$key}}" @if($bannerData->type==$key) selected @endif>{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>
                      </div>
                    <div class="mb-3 row">
                    <label for="example-time-input" class="col-md-2 col-form-label">Banner</label>
                       <div class="col-md-10">
                                @if($bannerData->slider_name!='')
                                <div class="row el-element-overlay">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="el-card-item pb-3">
                                                <div
                                                    class="el-card-avatar mb-3 el-overlay-1 w-100 overflow-hidden position-relative text-center">
                                                    <img src="{{url('/')}}/upload/banner/normal/{{$bannerData->slider_name}}"
                                                        class="d-block position-relative w-100" alt="user" />
                                                    <div class="el-overlay w-100 overflow-hidden">
                                                        <ul
                                                            class="list-style-none el-info text-white text-uppercase d-inline-block p-0">
                                                            <li class="el-item d-inline-block my-0  mx-1"><a
                                                                    class="btn default btn-outline image-popup-vertical-fit el-link text-white border-white"
                                                                    href="{{url('/')}}/upload/banner/normal/{{$bannerData->slider_name}}"><i
                                                                        data-feather="search"
                                                                        class="feather-sm"></i></a>
                                                            </li>
                                                            <li class="el-item d-inline-block my-0  mx-1"><a
                                                                    class="btn default btn-outline el-link text-white border-white"
                                                                    href="javascript:void(0);"><i data-feather="link"
                                                                        class="feather-sm"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                   </div>
                      <div class="mb-3 row">
                        <label for="slider_name" class="col-md-2 col-form-label">Image {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                        <input class="form-control" type="file" name="slider_name" id="slider_name">
                        </div>
                        <div id="banner_error" style="margin-left: 173px;"></div>
                       </div>
                        <div class="mb-3 row">
                            <label for="slider_text" class="col-md-2 col-form-label">Banner Description</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="slider_text" id="slider_text" placeholder="Banner Description">{{$bannerData->slider_text}}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="redirection_url" class="col-md-2 col-form-label">Redirection url</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="redirection_url" id="redirection_url"
                                    value="{{$bannerData->redirection_url}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" id="Active" name="status" class="form-check-input" value="1" @if($bannerData->status==1) checked="true" @endif>
                                    <label class="form-check-label" for="Active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="Deactivate" name="status" class="form-check-input" value="0" @if($bannerData->status==0) checked="true" @endif>
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
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/banner'">Cancel</button>
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
        CKEDITOR.replace('slider_text', {
            height: 400
        });
    </script>

<script>
      $(function(){
        $('#addEditForm').submit(function(){
             if ($('#type').commonCheck() & $('#title').commonCheck()) 
             {
                    if($('#slider_name').val() & $('#slider_name').checkFileType({
                        blankCk: false,
                        allowedExtensions: ['jpeg','jpg','png'],
                        errorMessage1: 'Image is required',
                        errorMessage2: 'jpeg,jpg,png file type are allowed only',
                        
                        errorArea:'#banner_error'
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