@include('admin.include.header')
<?php
  use App\library\get_site_details; 
 
  $get_site_details = new get_site_details;
?>
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/css/samples.css">
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/admin/libs/select2/dist/css/select2.min.css">
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Booking</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Booking</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                    <h5 class="card-subtitle mb-3 border-bottom pb-3">New Booking</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/booking/new" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                    <div class="mb-3 row">
                        <label for="guest" class="col-md-2 col-form-label">Guest {!!REQUIRED_STAR!!}</label>
                       
                             <div class="col-md-5">
                                <select class="select2-with-menu-bg form-control" id="guest" data-bgcolor="success" data-bgcolor-variation="light" style="width: 100%;height: 36px;">
                                <option value="">Choose Guest</option>
                                    
                                    @foreach($guest as $item)
                                    <option value="{{$item->id}}">{{$item->name}} - {{$item->phone}}</option>
                                    @endforeach     
                                </select>
                            </div>
                            <div class="col-md-1"><h5>OR <i class="fas fa-angle-double-right"></i></h5></div>
                            <div class="col-md-3">
                               
                                <a class="btn btn-primary" href="{{ADMIN_URL}}/users/guest/create" target="_blank" role="button">Create New Guest</a>

                            </div>
                        
                       </div>
                  
                    <div class="mb-3 row">
                            <label for="date" class="col-md-2 col-form-label">Check In Date {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="datepicker form-control"  placeholder="dd-mm-yyyy" type="text" type="text" 
                                    id="checkIn" name="checkIn" rows="3" cols="3" 
                                     readonly="true"></input>
                                    
                            </div>
                    </div>
                    <div class="mb-3 row">
                            <label for="date" class="col-md-2 col-form-label">Check Out Date {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="datepicker form-control"  placeholder="dd-mm-yyyy" type="text" type="text" 
                                    id="checkOut" name="checkOut" rows="3" cols="3" 
                                     readonly="true"></input>
                                    
                            </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="date" class="col-md-2 col-form-label"></label>
                        <div class="col-md-5" id="number_of_days" style="display:none;">
                            <button type="button" class="btn d-flex btn-light-success w-100 d-block text-success font-weight-medium">
                            Number of days <span class="badge ms-auto bg-success" id="count_value"></span>
                            </button>
                        </div>
                    </div>
                        <div class="mb-3 row">
                        <label for="rooms" class="col-md-2 col-form-label">Room {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10" id="rooms_div">
                            <select class="form-select col-12" id="rooms" name="rooms">
                                <option value="">Choose Room</option>
                               
                            </select>
                            
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="room" class="col-md-2 col-form-label"></label>
                        <div class="col-md-10" id="roomInfo">
                               
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="payment_method" class="col-md-2 col-form-label">Payment Method {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <select class="form-select col-12" id="payment_method" name="payment_method">
                                <option value="">Select Payment Method</option>
                                <option value="1">Net Banking/NEFT</option>
                                <option value="2">UPI</option>
                                <option value="3">Cash</option>
                                <option value="4">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="payment_ref" class="col-md-2 col-form-label">Payment Ref {!!REQUIRED_STAR!!}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" placeholder="Payment Reference"
                                id="payment_ref" name="payment_ref" rows="3" cols="3" class="form-control"
                                value="">
                        </div>
                    </div>
                        <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <div class="d-flex align-items-center">
                                    <i data-feather="save" class="feather-sm me-1 fill-icon"></i> Confirm Booking
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
<script src="{{SITE_URL}}/assets/admin/libs/select2/dist/js/select2.full.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/libs/select2/dist/js/select2.min.js"></script>
<script src="{{SITE_URL}}/assets/admin/js/pages/forms/select2/select2.init.js"></script>
<script>
    //$('.datepicker').datepicker({format:'dd-mm-yyyy'});
    $(document).ready(function () {
        // Disable past dates for check-in
        $('#checkIn').datepicker({
            format: 'dd-mm-yyyy',
            startDate: new Date(),
            autoclose: true
        }).on('changeDate', function (e) {
            // Get selected check-in date
            var checkinDate = e.date;

            // Set checkout calendar to disable dates before check-in
            $('#checkOut').datepicker('remove'); // Remove previous instance
            $('#checkOut').datepicker({
            format: 'dd-mm-yyyy',
            startDate: checkinDate,
            autoclose: true
            });
        });

        // Initialize checkout with today's date as minimum (optional)
        $('#checkOut').datepicker({
            format: 'dd-mm-yyyy',
            startDate: new Date(),
            autoclose: true
        });
        });

    $(document).ready(function () {
        $('#checkIn, #checkOut').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $('#checkIn, #checkOut').on('changeDate', function () {
            var checkinDate = $('#checkIn').datepicker('getDate');
            var checkoutDate = $('#checkOut').datepicker('getDate');

            if (checkinDate && checkoutDate) {
            // Calculate difference in milliseconds
            var timeDiff = checkoutDate.getTime() - checkinDate.getTime();

            // Convert to days
            var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

            // Display result
            $("#number_of_days").css("display", "block");
            
            $('#count_value').text(daysDiff > 0 ? `${daysDiff} day(s)` : 'Invalid date range');
            }
        });
    });


      $(function(){
       
        $('#addEditForm').submit(function(){
            if ($('#name').commonCheck() & $('#email').validateEmail() & $('#phone').commonCheck()) 
            { 
                return true;
                
            }
			$('html, body').animate({
         scrollTop: ($('.ErrorMag').offset().top - 300)
      }, 2000);

            return false;
        });
    });

$('#checkIn, #checkOut').datepicker({
  format: 'dd-mm-yyyy',
  autoclose: true
}).on('changeDate', function () {
  const checkin = $('#checkIn').val();
  const checkout = $('#checkOut').val();

  if (checkin && checkout) {
    handleDateChange(checkin, checkout);
  }
});

function handleDateChange(checkin, checkout) {
  if (checkin && checkout) {
    // Call your custom function here
    var _token=$('#_token').val();
      $("#room_loader").remove();
	  $('#rooms_div').append('<button id="room_loader" class="btn btn-primary mt-2" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>');
	  $.ajax({
		  type: "POST",
		  url: "{{ADMIN_URL}}/booking/available-rooms",
			data: { _token : _token,
                   checkin  : checkin,
                   checkout : checkout
             },
		  success: function(response)
		  {
			$("#room_loader").remove();  
			if (Array.isArray(response) && response.length>0){
                // Target the select element by its ID
                const selectElement = $('#rooms'); 
                // Clear existing options
                selectElement.empty(); 
                // Add a default or placeholder option (optional)
                selectElement.append($('<option>', {
                    value: '',
                    text: 'Select an option'
                }));
                // Loop through the array and append options
                $.each(response, function(index, item) {
                    selectElement.append($('<option>', {
                        value: item?.room_id,
                        text: item?.room_number + ' → ' + item?.room_type,
                        'data-details': JSON.stringify(item)
                    }));
                });
			}
			else{
              $("#room_loader").remove();  
			  alert('! Sorry no room found');
			}
		  },
          error: function(data) {
           $("#room_loader").remove();  
           alert('Some thing went wrong');
          }
	  });
  }
}
$(document).ready(function() {
    $('#rooms').on('change', function() {
        // Get the selected option
        var selectedOption = $(this).find(':selected');
        var details = selectedOption.data('details');
        var roomDetails = details ? (typeof details === "string" ? JSON.parse(details) : details) : null;
        if(roomDetails){
            $('#roomInfo').html(
                `<ul class="list-group"> <li class="list-group-item"> <i data-feather="book-open" class="text-info feather-sm me-2"></i> Description : ${roomDetails?.description} </li> <li class="list-group-item"> <i data-feather="users" class="text-info feather-sm me-2"></i> Max Guest : ${roomDetails?.max_guests} </li> <li class="list-group-item"> <i data-feather="home" class="text-info feather-sm me-2"></i> Number Of Bed : ${roomDetails?.number_of_bed} <i class="fas fa-bed"></i> </li> <li class="list-group-item"> <i data-feather="box" class="text-info feather-sm me-2"></i> Base Price : <i class="fas fa-rupee-sign"></i> ${roomDetails?.base_price} </li> <li class="list-group-item"> <i data-feather="shopping-bag" class="text-info feather-sm me-2"></i> Amenities : ${typeof roomDetails?.amenities === "string" ? JSON.parse(roomDetails?.amenities) : roomDetails?.amenities} </li> </ul>`
            );
        }else{
            $('#roomInfo').html(
            ``
         );
        }
        
    });
});

</script>    
