@include('admin.include.header')

<link href="{{SITE_URL}}/assets/admin/css/pagination.css" rel="stylesheet">
<!-- Container fluid  -->
<!-- -------------------------------------------------------------- -->
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Banner</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Banner</li>
            </ol>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Start Page Content -->
    <!-- -------------------------------------------------------------- -->
    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
                <form action="" method="GET" id="searchForm">
                            
                            <input type="hidden" name="page" id="GoPage" value="">
                            <div class="input-group footable-filtering-search">
                                <div class="input-group">
                                    <input type="hidden" class="form-control" name="search" placeholder="Name" value="{{Input::get('search')}}">
                                    <div class="input-group-append">
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
                <div
                    class="col-md-8 col-xl-8 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    @if($accessAddNew)
                    <a href="{{ADMIN_URL}}/banner/create" id="btn-add-contact" class="btn btn-info">
                    <i data-feather="image" class="feather-sm fill-white me-1"> </i>
                    Add Banner</a>
                    @endif   
                </div>
            </div>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table search-table v-middle">
                    <thead class="header-item">
                        
                        <th>Sl No</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Banner</th>
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
                                 {{$listitem->title}}
                            </td>
                            <td>
                                 {{str_replace('-',' ',$listitem->type)}}
                            </td>
                            <td>
                            @if($listitem->slider_name!='')
                                <div class="row el-element-overlay">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="el-card-item pb-3">
                                                <div
                                                    class="el-card-avatar mb-3 el-overlay-1 w-100 overflow-hidden position-relative text-center">
                                                    <img src="{{url('/')}}/upload/banner/normal/{{$listitem->slider_name}}"
                                                        class="d-block position-relative w-100" alt="user" />
                                                    <div class="el-overlay w-100 overflow-hidden">
                                                        <ul
                                                            class="list-style-none el-info text-white text-uppercase d-inline-block p-0">
                                                            <li class="el-item d-inline-block my-0  mx-1"><a
                                                                    class="btn default btn-outline image-popup-vertical-fit el-link text-white border-white"
                                                                    href="{{url('/')}}/upload/banner/normal/{{$listitem->slider_name}}"><i
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
                                    <a href="{{ADMIN_URL}}/banner/{{$listitem->id}}/edit" class="text-info edit"><i data-feather="edit"
                                            class="feather-sm fill-white"></i></a>
                                @endif
                                @if($accessDelete)               
                                    <a href="{{ADMIN_URL}}/banner/delete/{{$listitem->id}}" class="text-dark  ms-2" onclick="return confirm('Are you sure to delete?');"><i data-feather="trash-2"
                                            class="feather-sm fill-white"></i></a>
                                @endif
                                @if($accessUpdate)             
                                    <a href="javascript:void(0)" class="changeStatus" id="changeStatus{{$listitem->id}}" data-id="{{$listitem->id}}">{!!$StatusHtml!!}</a>        
                                </div>
                                @endif
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
		  url: "{{ADMIN_URL}}/banner/changeStatus/"+id,
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
                $('#statusSet'+id).html('<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Deactive</span>');
			  }
			}
		  }
	  });
	});
</script>