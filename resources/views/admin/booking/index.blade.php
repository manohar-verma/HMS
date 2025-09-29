@include('admin.include.header')
<?php
  use App\library\get_site_details; 
 
  $get_site_details = new get_site_details;
?>
<?php
  $currentSortDirection = 'down';
  $currentSortFiled = 'booking_id';
  $nextSortDirection = 'ASC';
  if(Input::get('sortval')=='DESC'){
    $currentSortDirection = 'down';
    $nextSortDirection ='ASC';
  }
  if(Input::get('sortval')=='ASC'){
    $nextSortDirection ='DESC';
    $currentSortDirection = 'up';
  }
  if(!empty(Input::get('orderby'))){
    $currentSortFiled = Input::get('orderby');
  }
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
                <div class="col-sm-4 col-md-4 col-xl-4">
                  <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                <form action="" method="GET" id="searchForm">
                            <input type="hidden" name="orderby" id="orderby" value="{{Input::get('orderby')}}">
                            <input type="hidden" name="sortval" id="sortval" value="{{Input::get('sortval')}}">
                            <input type="hidden" name="page" id="GoPage" value="">
                            <div class="input-group footable-filtering-search">
                                <div class="input-group">
                                    <input type="text" class="form-control " name="searchTerm" placeholder="By Name/Booking ID" value="{{Input::get('searchTerm')}}" >
                                    
                                    <div class="input-group-append ms-2">
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
                        
                        <th style="cursor:pointer;" onClick="handleFilter('booking_id','{{$nextSortDirection}}','{{$currentSortFiled}}');">Booking ID @if($currentSortFiled=='booking_id') <i class="bi-caret-{{$currentSortDirection}}-square-fill" ></i> @endif</th>
                        <th>Guest Name</th>
                        <th style="cursor:pointer;" onClick="handleFilter('check_in_date','{{$nextSortDirection}}','{{$currentSortFiled}}');">Check In  @if($currentSortFiled=='check_in_date') <i class="bi-caret-{{$currentSortDirection}}-square-fill" ></i> @endif</th>
                        <th style="cursor:pointer;" onClick="handleFilter('check_out_date','{{$nextSortDirection}}','{{$currentSortFiled}}');">Check Out  @if($currentSortFiled=='check_out_date') <i class="bi-caret-{{$currentSortDirection}}-square-fill" ></i> @endif</th>
                        <th>Room Type</th>
                        <th>Payment Status</th>
                        <th  style="cursor:pointer;" onClick="handleFilter('booking_status','{{$nextSortDirection}}','{{$currentSortFiled}}');">Booking Status  @if($currentSortFiled=='booking_status') <i class="bi-caret-{{$currentSortDirection}}-square-fill" ></i> @endif</th>
                        <th>Booking Source</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    
                        @if(count($list))
                        @foreach ($list as $key=>$listitem)
                       <?php 
                         $roomInfo = $get_site_details->getRoomInfo($listitem->booking_id);
                         $paymentInfo = $get_site_details->getPaymentInfo($listitem->booking_id);
                       ?>
                        <tr class="search-items">
                           
                            <td>
                                 {{$listitem->booking_id}}
                            </td>
                            
                            <td>
                                {{$listitem->name}}
                            </td>
                           
                             <td>
                              {{$listitem->check_in_date}}
                            </td>
                            <td>
                                {{$listitem->check_out_date}}
                            </td>
                            <td>
                              @if(!empty($roomInfo)) {{$roomInfo->title}} @endif
                            </td>
                             <td>
                               @if(!empty($paymentInfo)) {{$paymentInfo->status}} @endif
                            </td>
                             <td>
                               {{$listitem->booking_ref}}
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
                             <td>
                              <div class="action-btn">
                                @if($accessUpdate)
                                    <a href="{{ADMIN_URL}}/booking/edit/{{$listitem->id}}" class="text-info edit"><i data-feather="edit"
                                            class="feather-sm fill-white"></i></a>
                                @endif
                                @if($accessDelete)               
                                    <a href="{{ADMIN_URL}}/booking/delete/{{$listitem->id}}" class="text-dark  ms-2" onclick="return confirm('Are you sure to delete?');"><i data-feather="trash-2"
                                            class="feather-sm fill-white"></i></a>
                                @endif
                               
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" style="text-align:center;color:#fc8675">No Result Found</td>
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
	});
  });
    function handleFilter(newFiled,sortType,currentField){
        let nextSortType = sortType;
        if(newFiled != currentField){
            nextSortType ='ASC';
        }
        $('#orderby').val(newFiled);
        $('#sortval').val(nextSortType);
        $('#searchForm').submit();
    }

</script>