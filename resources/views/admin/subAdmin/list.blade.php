@include('admin.include.header')

<link href="{{SITE_URL}}/assets/admin/css/pagination.css" rel="stylesheet">
<!-- Container fluid  -->
<!-- -------------------------------------------------------------- -->
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Sub Admin</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Sub Admin</li>
            </ol>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Start Page Content -->
    <!-- -------------------------------------------------------------- -->
    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-xl-2">
                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                <form action="" method="GET" id="searchForm">
                            
                            <input type="hidden" name="page" id="GoPage" value="">
                            <div class="input-group footable-filtering-search">
                                <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Email Or Name" value="{{Input::get('search')}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success "><span
                                                class="fas fa-search"></span>
                                            </button>
                                            <button type="button" onclick="window.location='{{ADMIN_URL}}/sub-admin'"
                                            class="btn btn-danger ">Reset
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
                <div
                    class="col-md-8 col-xl-10 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    @if($accessAddNew)
                    <a href="{{ADMIN_URL}}/sub-admin/create" id="btn-add-contact" class="btn btn-info">
                    <i data-feather="user" class="feather-sm fill-white me-1"> </i>
                    Add User(Admin)</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table search-table v-middle">
                    <thead class="header-item">
                        
                        <th>Sl No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    
                        @if(count($list))
                        @foreach ($list as $key=>$listitem)
                        <!-- row -->
                        <tr class="search-items">
                           
                            <td>
                                 {{$listitem->id}}
                            </td>
                            <td>
                               {{$listitem->name}}
                            </td>
                            <td>
                               {{$listitem->email}}
                            </td>
                            <td id="statusSet{{$listitem->id}}">
                               @if($listitem->status == 1)
                                <?php 
                                $StatusHtml = '<i class="fa fa-unlock fa-lg"></i>';
                                $statusDisplay='<span class="mb-1 badge font-weight-medium bg-light-success text-success">Active</span>';
                                ?>
                                @else
                                <?php 
                                $StatusHtml = '<i class="fa fa-lock fa-lg"></i>'; 
                                $statusDisplay='<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Deactive</span>';
                                ?>
                                @endif
                                {!!$statusDisplay!!}
                            </td>
                            <td>
                                <div class="action-btn">
                                @if($accessUpdate)
                                    <a href="{{ADMIN_URL}}/sub-admin/{{$listitem->id}}/edit" class="text-info edit"><i data-feather="edit"
                                            class="feather-sm fill-white"></i></a>
                                 @endif
                                 @if($accessDelete)           
                                    <a href="{{ADMIN_URL}}/sub-admin/delete/{{$listitem->id}}" class="text-dark  ms-2" onclick="return confirm('Are you sure to delete?');"><i data-feather="trash-2"
                                            class="feather-sm fill-white"></i></a>
                                 @endif                  
                                 @if($accessUpdate)            
                                    <a href="javascript:void(0)" class="changeStatus" id="changeStatus{{$listitem->id}}" data-id="{{$listitem->id}}">{!!$StatusHtml!!}</a>
                                @endif            
                                </div>
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
<script type="text/javascript">
  $(function(){
	$(document).on('click','#GoSearchPagi', function(){
	  $thisPage = $(this).attr('page');
	  $('#GoPage').val($thisPage);
	  $('#searchForm').submit();
	})
  });


  $(document).on('click','.changeStatus',function(){
	  id = $(this).data('id');
		var _token=$('#_token').val();
	  $('#changeStatus'+id).html('<img src="{{SITE_URL}}/assets/common/img/ajax-loader.gif" style="width: 11px;">');
	  $.ajax({
		  type: "POST",
		  url: "{{ADMIN_URL}}/sub-admin/changeStatus/"+id,
			data: { _token : _token },
		  success: function(data)
		  {
			$('#changeStatus'+id).html('');
			if (data =='') {
			  alert('id not found');
			}
			else{
			  if (data == 1) {
				$('#changeStatus'+id).html('<i class="fa fa-unlock fa-lg"></i>');
                $('#statusSet'+id).html('<span class="mb-1 badge font-weight-medium bg-light-success text-success">Active</span>');
			  }
			  else{
				$('#changeStatus'+id).html('<i class="fa fa-lock fa-lg"></i>');
                $('#statusSet'+id).html('<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Inactive</span>');
			  }
			}
		  }
	  });
	});
</script>