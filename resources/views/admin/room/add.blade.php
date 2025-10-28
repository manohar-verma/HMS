@include('admin.include.header')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Room</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Room</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Add Room</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/room" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <div class="mb-3 row">
                        <label for="hotel_id" class="col-md-2 col-form-label">Hotel {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <select class="form-select col-12 " id="hotel_id" name="hotel_id">
                                <option value="">Choose Hotel</option>
                                @if($hotel)
                                @foreach($hotel as $count)
                                <option value="{{$count->hotel_id}}">{{$count->name}}</option>
                                @endforeach
                                @endif
                               
                            </select>
                        </div>
                       </div>
                    <div class="mb-3 row">
                        <label for="room_number" class="col-md-2 col-form-label">Room Number {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control allow_numeric" type="text" placeholder="Room Number"
                                id="room_number" name="room_number" rows="3" cols="3" 
                                value="">
                        </div>
                    </div>
                     <div class="mb-3 row">
                        <label for="room_type_id" class="col-md-2 col-form-label">Room Type {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <select class="form-select col-12 " id="room_type_id" name="room_type_id">
                                <option value="">Choose Room Type</option>
                                @if($type)
                                @foreach($type as $ty)
                                <option value="{{$ty->type_id}}">{{$ty->title}}</option>
                                @endforeach
                                @endif
                               
                            </select>
                        </div>
                       </div>

                     <div class="mb-3 row">
                            <label for="description" class="col-md-2 col-form-label"> Description {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                            <textarea class="form-control" rows="10" name="description" id="description"  rows="10" data-sample="2"placeholder="Description"></textarea>
                            </div>
                        </div>
                     
                   <div class="mb-3 row">
                        <label for="max_guests" class="col-md-2 col-form-label">Maximum Guest {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control allow_numeric" type="text" placeholder="Maximum Quest"
                                id="max_guests" name="max_guests" rows="3" cols="3" 
                                value="">
                        </div>
                    </div>

                    
                    <div class="mb-3 row">
                        <label for="base_price" class="col-md-2 col-form-label">Base Price {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control allow_decimal" type="text" placeholder="Base Price"
                                id="base_price" name="base_price" rows="3" cols="3" 
                                value="">
                        </div>
                    </div>

                     
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" id="Active" name="is_active" class="form-check-input" value="true" checked="true">
                                    <label class="form-check-label" for="Active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="Deactivate" name="is_active" class="form-check-input" value="false">
                                    <label class="form-check-label" for="Deactivate">Deactivate</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Amenities</label>
                            <div class="col-md-10">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tbody>
                                           
                                           
                                            <tr>
                                         
                                           
                                                @if($amenities)
                                                @foreach($amenities as $key=>$amen)
                                                    <td>
                                                        <div class="form-check">
                                                            <label class="form-check-label" id="check_level_{{$key}}" style="font-size: 14px;font-weight: 400;color:#0f5e20;">
                                                                <input class="form-check-input" value="{{$amen->title}}"
                                                                    type="checkbox" id="check_level_{{$key}}" name="amenities[]"
                                                                    >{{$amen->title}}
                                                            </label>
                                                        </div>
                                                    </td>
                                                @endforeach
                                                @else
                                                @foreach($amenities as $key=>$amen)
                                                <td>
                                                </td>
                                                @Endforeach
                                                @endif
                                            </tr>
                                            

                                           
                                        </tbody>
                                    </table>
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
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/room'">Cancel</button>
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
            
            if ($('#hotel_id').commonCheck() & $('#room_number').commonCheck() & $('#description').commonCheck() & $('#base_price').commonCheck() & $('#room_type_id').commonCheck() & $('#max_guests').commonCheck() & $('#amenities').commonCheck() ) 
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