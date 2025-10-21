@include('admin.include.header')
<?php
  use App\library\get_site_details; 
 
  $get_site_details = new get_site_details;
?>

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
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/payment/invoicesSearch" method="POST" enctype="multipart/form-data">
                   <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                    <div class="mb-3 row">
                        <label for="hotels" class="col-md-2 col-form-label">Booking/Payment ID</label>
                        <div class="col-md-5">
                           <input class="form-control" type="text" placeholder="Payment/Booking ID"
                                id="invoice_search" name="invoice_search" rows="3" cols="3" class="form-control"
                                value="">
                        </div>
                    </div>
                   
                        <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <div class="d-flex align-items-center">
                                    <i data-feather="search" class="feather-sm me-1 fill-icon"></i>Search
                                </div>
                            </button>
                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/payment/payment-list'">Cancel</button>
                        </div>
                           </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.include.footer')

