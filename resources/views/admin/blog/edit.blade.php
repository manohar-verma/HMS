@include('admin.include.header')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Blogs</h3>
        </div> 
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Blogs</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Edit Blogs</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/blog/{{$blogData->id}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <input name="_method" type="hidden" value="PUT">
                    <div class="mb-3 row">
                        <label for="title" class="col-md-2 col-form-label">Title {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" placeholder="Title"
                                id="title" name="title" rows="3" cols="3" class="form-control"
                                value="{{$blogData->title}}">
                        </div>
                    </div>
                      <div class="mb-3 row">
                        <label for="author" class="col-md-2 col-form-label">Author {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <select class="form-select col-12" id="author" name="author">
                                <option value="">Choose Author</option>
                                @foreach($team as $team)
                                <option value="{{$team->id}}" @if($blogData->author == $team->id) selected @endif>{{$team->first_name}} {{$team->last_name}}</option>
                                @endforeach
                               
                            </select>
                        </div>
                       </div>
                       <div class="mb-3 row">
                        <label for="category" class="col-md-2 col-form-label">Category {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <select class="form-select col-12" id="category" name="category">
                                <option value="">Choose Category</option>
                                @foreach(@$blog_cat as $blog_cat)
                                <option value="{{$blog_cat->id}}" @if($blogData->catagory == $blog_cat->id) selected @endif>{{$blog_cat->name}}</option>
                                @endforeach
                                
                               
                            </select>
                        </div>
                       </div>
                        <div class="mb-3 row">
                            <label for="tags" class="col-md-2 col-form-label">Tags</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" 
                                    id="tags" name="tags" rows="3" cols="3" class="form-control"
                                    value="{{$blogData->tags}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="short_description" class="col-md-2 col-form-label">Description {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="short_description" id="short_description"  rows="10" data-sample="2"placeholder="Description">{{$blogData->description}}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="short_description" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                            <img src="{{url('/')}}/upload/blog/normal/{{$blogData->image}}"alt="blog" width="100px" height="100px"/>
                            </div>
                        </div>
                        <div class="mb-3 row">
                        <label for="image" class="col-md-2 col-form-label">Image {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                        <input class="form-control" type="file" name="image" id="image" value="{{$blogData->image}}">
                        </div>
                        <div id="image_error" style="margin-left: 173px;"></div>
                       </div>
                       <div class="mb-3 row">
                        <label for="alternate_text" class="col-md-2 col-form-label">Alternative Text </label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{$blogData->text}}"
                                id="alternate_text" name="alternate_text" rows="3" cols="3" class="form-control">
                        </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="date" class="col-md-2 col-form-label">Date {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="datepicker form-control" type="text" 
                                    id="date" name="date" rows="3" cols="3" 
                                    value="{{date('d-m-Y',strtotime($blogData->date))}}" placeholder="Blog Date" readonly="true"></input>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="meta_description" class="col-md-2 col-form-label">Meta Description</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="meta_description" id="meta_description"  rows="10" data-sample="2"placeholder="Description">{{$blogData->meta_description}}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                        <label for="meta_keyword" class="col-md-2 col-form-label">Meta Keyword </label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" 
                                id="meta_keyword" name="meta_keyword" rows="3" cols="3" class="form-control"
                                value="{{$blogData->meta_keyword}}">
                        </div>
                        </div>
                       
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" id="Active" name="status" class="form-check-input" value="1" @if($blogData->status == '1') checked @endif>
                                    <label class="form-check-label" for="Active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="Deactivate" name="status" class="form-check-input" value="0" @if($blogData->status == '0') checked @endif>
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
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/blog'">Cancel</button>
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
     $(function(){
        $('#addEditForm').submit(function(){
            
            if ($('#title').commonCheck() & $('#short_description').commonCheck()  & $('#author').commonCheck() & $('#meta_keyword').commonCheck() & $('#date').commonCheck() & $('#category').commonCheck()) 
            {
               
                    return true;
                
            }
            if (document.querySelector('.ErrorMag') !== null) {
            $('html, body').animate({
                scrollTop: ($('.ErrorMag').offset().top - 300)
            }, 2000);
              }
            return false;
        });
        
            $('.datepicker').datepicker({format:'dd-mm-yyyy'});
      
    }); 
   
</script>    