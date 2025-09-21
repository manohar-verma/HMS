@include('admin.include.header')

<link href="{{SITE_URL}}/assets/admin/css/pagination.css" rel="stylesheet">

<!-- Container fluid  -->

<!-- -------------------------------------------------------------- -->

<div class="container-fluid">

    <div class="row page-titles">

        <div class="col-md-5 col-12 align-self-center">

            <h3 class="text-themecolor mb-0">Contacts</h3>

        </div>

        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">

            <ol class="breadcrumb mb-0 p-0 bg-transparent">

                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>

                <li class="breadcrumb-item active d-flex align-items-center">Contacts</li>

            </ol>

        </div>

    </div>

    <!-- -------------------------------------------------------------- -->

    <!-- Start Page Content -->

    <!-- -------------------------------------------------------------- -->

    <div class="widget-content searchable-container list">

        <div class="card card-body">

            <div class="row">

                <div class="col-md-5 col-xl-5">

                    <th colspan="3">

                        <form action="" method="GET" id="searchForm">

                            <input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">

                            <input type="hidden" name="page" id="GoPage" value="">

                            <div class="input-group footable-filtering-search">

                                <div class="input-group">

                                    <input type="text" class="form-control" name="search" placeholder="Name or Email" value="{{Input::get('search')}}">

                                    <div class="input-group-append" style="margin-left:10px">

                                        <button type="submit" class="btn btn-success "><span

                                                class="fas fa-search"></span>

                                            </button>

                                            <button type="button" onclick="window.location='{{ADMIN_URL}}/contact'"

                                            class="btn btn-danger ">Reset

                                        </button>

                                        

                                    </div>

                                </div>

                            </div>

                        </form>

                    </th>

                </div>

                <div

                    class="col-md-7 col-xl-10 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">

                    <div class="action-btn show-btn" style="display: none">

                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#confirmDilog"

                            class=" btn-light-danger btn me-2 text-danger d-flex align-items-center font-weight-medium">

                            <i data-feather="trash-2" class="feather-sm fill-white me-1"></i>

                            Delete All Row</a>

                    </div>



                </div>

            </div>

        </div>

        <!-- Modal -->

        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle"

            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-header d-flex align-items-center">

                        <h5 class="modal-title">Contact</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">

                        <div class="add-contact-box">

                            <div class="add-contact-content">

                                <form id="addContactModalTitle">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="mb-3 contact-name">

                                                <input type="text" id="c-name" class="form-control" placeholder="Name"

                                                    readonly>

                                                <span class="validation-text text-danger"></span>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="mb-3 contact-email">

                                                <input type="text" id="c-email" class="form-control" placeholder="Email"

                                                    readonly>

                                                <span class="validation-text text-danger"></span>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="mb-3 contact-occupation">

                                                <input type="text" id="c-occupation" class="form-control"

                                                    placeholder="Contact Date" readonly>

                                            </div>

                                        </div>



                                        <div class="col-md-6">

                                            <div class="mb-3 contact-phone">

                                                <input type="text" id="c-phone" class="form-control" placeholder="Phone"

                                                    readonly>

                                                <span class="validation-text text-danger"></span>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="mb-3 contact-location">

                                                <textarea name="aaa" id="c-location" class="form-control"

                                                    placeholder="Location" rows="4" cols="7" readonly></textarea>

                                            </div>

                                        </div>

                                    </div>



                                </form>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">



                        <button class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal"> Discard</button>

                    </div>

                </div>

            </div>

        </div>

        <!-- Modal -->

        <div class="modal fade" id="confirmDilog" tabindex="-1" aria-labelledby="confirmTitle" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="confirmTitle">Confirm</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">

                Are you sure you want to delete<b style="color:red;"> ALL</b>?

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-success rounded-pill px-4" data-bs-dismiss="modal">Close</button>

                <button type="button" onclick="submitMultiDelete();" class="btn btn-danger rounded-pill px-4">Confirm</button>

            </div>

            </div>

        </div>

        </div>

        <div class="card card-body">

            <div class="table-responsive">

                <table class="table search-table v-middle">

                    <thead class="header-item">

                        <th>

                            <div class="n-chk align-self-center text-center">

                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input secondary" id="contact-check-all">

                                    <label class="form-check-label" for="contact-check-all"></label>

                                    <span class="new-control-indicator"></span>

                                </div>

                            </div>

                        </th>

                        <th>Sl NO</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>Phone</th>

                        <th>Contact Date</th>

                        <th>Action</th>

                    </thead>

                    <tbody>

                    <form action="{{ADMIN_URL}}/contact/multi-delete" method="post" id="multi_delete_form">

                    <input type="hidden" name="_token" value="{{ Session::token() }}">

                        @if(count($list))

                        @foreach ($list as $key=>$listitem)

                        <!-- row -->

                        <tr class="search-items">

                            <td>

                                <div class="n-chk align-self-center text-center">

                                    <div class="form-check">

                                        <input type="checkbox" class="form-check-input contact-chkbox primary"

                                            id="checkbox1" name="multi_delete[]" value="{{$listitem->id}}">

                                        <label class="form-check-label" for="checkbox1"></label>

                                    </div>

                                </div>

                            </td>

                            <td>{{$listitem->id}}</td>

                            <td>

                                <h6 class="user-name mb-0 font-weight-medium" data-name="{{$listitem->name}}">

                                    {{$listitem->name}}</h6>

                            </td>

                            <td>

                                <span class="usr-email-addr" data-email=" {{$listitem->email}}">

                                    {{$listitem->email}}</span>

                            </td>

                            <td>

                                <small style="display: none;" class="user-work text-muted"

                                    data-occupation="{{$listitem->date}}">{{$listitem->date}}</small>

                                <span style="display: none;" class="usr-location"

                                    data-location="{{$listitem->message}}">{{$listitem->message}}</span>

                                <span class="usr-ph-no" data-phone="{{$listitem->phone}}">{{$listitem->phone}}</span>

                            </td>

                            <td>

                                {{$listitem->date}}

                            </td>

                            <td>

                                <div class="action-btn">

                                    <a href="javascript:void(0)" class="text-info edit"><i data-feather="eye"

                                            class="feather-sm fill-white"></i></a>

                                    <a href="{{ADMIN_URL}}/contact/delete/{{$listitem->id}}" class="text-dark  ms-2" onclick="return confirm('Are you sure to delete?');"><i data-feather="trash-2"

                                            class="feather-sm fill-white"></i></a>

                                </div>

                            </td>

                        </tr>

                        @endforeach

                        @else

                        <tr>

                            <td colspan="7" style="text-align:center;color:#fc8675">No Result Found</td>

                        </tr>

                        @endif

                    </form>

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

<script src="{{SITE_URL}}/assets/admin/js/pages/contact/contact.js"></script>

<script type="text/javascript">

  $(function(){

	$(document).on('click','#GoSearchPagi', function(){

	  $thisPage = $(this).attr('page');

	  $('#GoPage').val($thisPage);

	  $('#searchForm').submit();

	})

  });

  function submitMultiDelete()

  {

    $("#multi_delete_form").submit();

  }

</script>