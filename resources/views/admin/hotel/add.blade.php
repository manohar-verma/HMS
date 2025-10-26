@include('admin.include.header')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Hotel</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Hotel</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Add Hotel</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/hotel" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Name {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" placeholder="Name"
                                id="name" name="name" rows="3" cols="3" 
                                value="">
                        </div>
                    </div>

                     <div class="mb-3 row">
                            <label for="description" class="col-md-2 col-form-label"> Description {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="description" id="description"  rows="10" data-sample="2"placeholder="Description"></textarea>
                            </div>
                        </div>
                     <div class="mb-3 row">
                        <label for="country" class="col-md-2 col-form-label">Country {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <select class="form-select col-12 " id="country" name="country">
                                <option value="">Choose Country</option>
                                @if($country)
                                @foreach($country as $count)
                                <option value="{{$count->id}}">{{$count->country_name}}</option>
                                @endforeach
                                @endif
                               
                            </select>
                        </div>
                       </div>

                    <div class="mb-3 row">
                        <label for="state" class="col-md-2 col-form-label">State {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <select class="form-select col-12 " id="state" name="state">
                                <option value="">Choose State</option>
                                @if($state)
                                @foreach($state as $sta)
                                <option value="{{$sta->id}}">{{$sta->state_name}}</option>
                                @endforeach
                                @endif
                               
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="city" class="col-md-2 col-form-label">City {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" placeholder="City"
                                id="city" name="city" rows="3" cols="3" 
                                value="">
                        </div>
                    </div>

                     
                       <div class="mb-3 row">
                        <label for="zip_code" class="col-md-2 col-form-label">Zip Code {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                             <input class="form-control allow_numeric" type="text" placeholder="Zip Code"
                                id="zip_code" name="zip_code" rows="3" cols="3" 
                                value="">
                        </div>
                       </div>
                        <div class="mb-3 row">
                            <label for="phone" class="col-md-2 col-form-label">Phone {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control allow_numeric" type="text" value=""
                                    id="phone" name="phone" rows="3" cols="3" 
                                    value="">
                            </div>
                        </div>
                       <div class="mb-3 row">
                            <label for="email" class="col-md-2 col-form-label">Email {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control email" type="text" value=""
                                    id="email" name="email" rows="3" cols="3" 
                                    value="">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="star_rating" class="col-md-2 col-form-label">Rating {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value=""
                                    id="star_rating" name="star_rating" rows="3" cols="3" 
                                    value="">
                            </div>
                        </div>
                       
                       
                      
                      
                        <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <div class="d-flex align-items-center">
                                    <i data-feather="save" class="feather-sm me-1 fill-icon"></i> Save
                                </div>
                            </button>
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/hotel'">Cancel</button>
                        </div>
                           </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.include.footer')
<!-- <script src="{{SITE_URL}}/assets/common/ckeditor/ckeditor.js"></script>
<script src=" {{SITE_URL}}/assets/common/ckeditor/samples/js/sample.js"></script> -->
<script src="{{SITE_URL}}/assets/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>


<script>
    $('.datepicker').datepicker({format:'dd-mm-yyyy'});
     $(function(){
        $('#addEditForm').submit(function(){
            
            if ($('#name').commonCheck() & $('#description').commonCheck() & $('#country').commonCheck() & $('#state').commonCheck() & $('#city').commonCheck() & $('#zip_code').commonCheck() & $('#phone').commonCheck() & $('#email').commonCheck() & $('#star_rating').commonCheck()) 
            {
                
            }
            if (document.querySelector('.ErrorMag') !== null) {
            $('html, body').animate({
                scrollTop: ($('.ErrorMag').offset().top - 300)
            }, 2000);
            return false;
              }
            
        });
        
            
      
    }); 
   
</script>    