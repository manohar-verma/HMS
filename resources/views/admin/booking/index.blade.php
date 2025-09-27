@include('admin.include.header')
<?php
  use App\library\get_site_details; 
 
  $get_site_details = new get_site_details;
?>
<link href="{{SITE_URL}}/assets/admin/css/pagination.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/common/ckeditor/samples/css/samples.css">


<!-- Container fluid  -->
<!-- -------------------------------------------------------------- -->
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Booking</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">All Booking</li>
            </ol>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Start Page Content -->
    <!-- -------------------------------------------------------------- -->
    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <div class="col-sm-4 col-md-12 col-xl-12">
                  <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                <form action="" method="GET" id="searchForm">
                            
                            <input type="hidden" name="page" id="GoPage" value="">
                            <div class="input-group footable-filtering-search">
                                <div class="input-group">
                                    <input type="text" class="form-control " name="name" placeholder="By Name" value="{{Input::get('name')}}" >
                                    <input class="datepicker form-control ms-3"  placeholder="yyyy-mm-dd"type="text" type="text" 
                                    id="date" name="date" rows="3" cols="3" 
                                     readonly="true" value="{{Input::get('date')}}"></input>

                                     <select class="form-select col-12 mx-3" id="status" name="status" >
                                        <option value="">Booking Staus</option>
                                        <option value="1">Booked</option>
                                        <option value="0">Pending</option>
                                    </select>
                                    <div class="input-group-append ">
                                        <button type="submit" class="btn btn-success"><span
                                                class="fas fa-search"></span>
                                            </button>
                                            <button type="button" onclick="window.location='{{ADMIN_URL}}/booking/all-booking'"
                                            class="btn btn-danger">Reset
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                  </form>
                </div>
                
            </div>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table search-table v-middle">
                    <thead class="header-item">
                        
                        <th>SI No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Hotel Name</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    
                        @if(count($list))
                        @foreach ($list as $key=>$listitem)
                       
                        <tr class="search-items">
                           
                            <td>
                                 {{$listitem->booking_id}}
                            </td>
                            
                            <td>
                                {{$listitem->name}}
                            </td>
                             
                            <td>
                            {{$listitem->phone}}
                            </td>
                            <td>
                              {{$listitem->hotal_name}}
                            </td>
                             <td>
                              {{$listitem->check_in_date}}
                            </td>
                            <td>
                              {{$listitem->check_out_date}}
                            </td>
                             <td id="statusSet{{$listitem->id}}">
                               @if($listitem->booking_status == 'success')
                                <?php 
                                $StatusHtml = '<i class="fa fa-unlock fa-lg"></i>';
                                $statusDisplay='<span class="mb-1 badge font-weight-medium bg-light-success text-success">Completed</span>';
                                ?>
                                @else
                                <?php 
                                $StatusHtml = '<i class="fa fa-lock fa-lg"></i>'; 
                                $statusDisplay='<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Pending</span>';
                                ?>
                                @endif
                                {!!$statusDisplay!!}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" style="text-align:center;color:#fc8675">No Result Found</td>
                        </tr>
                        @endif
                    
                    </tbody>
                </table>
                <div class="panel-footer clearfix">
			
                   <div class="pagination-xs m-top-none pull-right">
                     {!!$pagination!!}
                    </div>
                 </div>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- End PAge Content -->
    <!-- -------------------------------------------------------------- -->
</div>

<!-- -------------------------------------------------------------- -->
<!-- End Container fluid  -->
@include('admin.include.footer')
<script src="{{SITE_URL}}/assets/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
     $('.datepicker').datepicker({format:'yyyy-mm-dd'});
  $(function(){
	$(document).on('click','#GoSearchPagi', function(){
	  $thisPage = $(this).attr('page');
	  $('#GoPage').val($thisPage);
	  $('#searchForm').submit();
	})
  });

</script>