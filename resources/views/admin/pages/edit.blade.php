@include('admin.include.header')
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/css/samples.css">
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Pages</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">CMS Pages</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Edit CMS Page</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/pages/{{$pageData->id}}" method="POST" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <div class="mb-3 row">
                            <label for="type" class="col-md-2 col-form-label">CMS Type</label>
                            <div class="col-md-10">
                                <select class="form-select col-12" id="page_category" name="page_category" >
                                    <option value="">Select CMS Type</option>
                                    @foreach($pageCategory as $type)
                                    <option value="{{$type->id}}" @if($pageData->page_category == $type->id) selected @endif>{{$type->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                      </div>
                     <div class="mb-3 row">
                            <label for="first_Name" class="col-md-2 col-form-label">Title {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="title" id="title"
                                    value="{{$pageData->title}}">
                            </div>
                     </div>
                     <div class="mb-3 row">
                         <label for="example-time-input" class="col-md-2 col-form-label">Image</label>
                         <div class="col-md-10">
                                @if($pageData->image!='')
                                <div class="row el-element-overlay">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="el-card-item pb-3">
                                                <div
                                                    class="el-card-avatar mb-3 el-overlay-1 w-100 overflow-hidden position-relative text-center">
                                                    <img src="{{url('/')}}/upload/pages/thumb/{{$pageData->image}}"
                                                        class="d-block position-relative w-100" alt="user" />
                                                    <div class="el-overlay w-100 overflow-hidden">
                                                        <ul
                                                            class="list-style-none el-info text-white text-uppercase d-inline-block p-0">
                                                            <li class="el-item d-inline-block my-0  mx-1"><a
                                                                    class="btn default btn-outline image-popup-vertical-fit el-link text-white border-white"
                                                                    href="{{url('/')}}/upload/pages/normal/{{$pageData->image}}"><i
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
                        <label for="image" class="col-md-2 col-form-label">Article Banner </label>
                        <div class="col-md-10">
                        <input class="form-control" type="file" name="image" id="image">
                        </div>
                        <div id="banner_error" style="margin-left: 173px;"></div>
                       </div>
                       <div class="mb-3 row">
                            <label for="short_description" class="col-md-2 col-form-label">Short Description</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="short_description" id="short_description"  rows="10" data-sample="2"placeholder="Short Description">{!!$pageData->short_description!!}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="description" class="col-md-2 col-form-label">Description</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="description" id="description"  rows="10" data-sample="2"placeholder="Description">{!!$pageData->description!!}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="description" class="col-md-2 col-form-label">Meta Description</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="5" name="meta_description" id="meta_description"  rows="2" placeholder="Meta Description">{{$pageData->meta_description}}</textarea>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="first_Name" class="col-md-2 col-form-label">Meta Keyword </label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="meta_keyword" id="meta_keyword"
                                    value="{{$pageData->meta_keyword}}" placeholder="Meta Keyword">
                            </div>
                     </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" id="Active" name="status" class="form-check-input" value="1" @if($pageData->status==1) checked="true" @endif>
                                    <label class="form-check-label" for="Active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="Deactivate" name="status" class="form-check-input" value="0" @if($pageData->status==0) checked="true" @endif>
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
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/pages'">Cancel</button>
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
            if ($('#title').commonCheck() ) 
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