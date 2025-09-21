@include('admin.include.header')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Settings</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Settings</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Settings</h4>
                    <h5 class="card-subtitle mb-3 border-bottom pb-3"> General Setting</h5>
                    <form class="form" action="{{ADMIN_URL}}/setting/doAdd" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="mb-3 row">
                            <label for="site_name" class="col-md-2 col-form-label">Site name {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="{{$settings->site_name}}"
                                    name="site_name" id="site_name">
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="slogan_text" class="col-md-2 col-form-label">Site Slogan</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" 
                                    id="slogan_text" name="slogan_text" rows="3" cols="3" class="form-control"
                                    value="{{$settings->slogan_text}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="site_url" class="col-md-2 col-form-label">Site URL</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="site_url" id="site_url"
                                    value="{{$settings->site_url}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="address" class="col-md-2 col-form-label">Address</label>
                            <div class="col-md-10">
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{$settings->address}}">
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="admin_email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input type="text" name="controller_email" id="admin_email" class="form-control"
                                    value="{{$settings->controller_email}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="admin_ph_no" class="col-md-2 col-form-label">Site Phone</label>
                            <div class="col-md-10">
                                <input type="text" name="admin_ph_no" id="admin_ph_no" class="form-control"
                                    value="{{$settings->admin_ph_no}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="facebook_url" class="col-md-2 col-form-label">Facebook URL</label>
                            <div class="col-md-10">
                                <input type="text" name="facebook_url" id="facebook_url" class="form-control"
                                    value="{{$settings->facebook_url}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="twitter_url" class="col-md-2 col-form-label">Twitter URL</label>
                            <div class="col-md-10">
                                <input type="text" name="twitter_url" id="twitter_url" class="form-control"
                                    value="{{$settings->twitter_url}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="pinstar_url" class="col-md-2 col-form-label">LinkedIn URL</label>
                            <div class="col-md-10">
                                <input type="text" name="pinstar_url" id="pinstar_url" class="form-control"
                                    value="{{$settings->pinstar_url}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="instagram_url" class="col-md-2 col-form-label">Instagram URL</label>
                            <div class="col-md-10">
                                <input type="text" name="instagram_url" id="instagram_url" class="form-control input-sm"
                                    value="{{$settings->instagram_url}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="footer_txt" class="col-md-2 col-form-label">Footer Text</label>
                            <div class="col-md-10">
                                <input type="text" name="footer_txt" id="footer_txt" class="form-control input-sm"
                                    value="{{$settings->footer_txt}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="help_text" class="col-md-2 col-form-label">Disclaimer Text</label>
                            <div class="col-md-10">
                                <input type="text" name="help_text" id="help_text" class="form-control input-sm"
                                    value="{{$settings->help_text}}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="copy_right" class="col-md-2 col-form-label">Copy Right Text</label>
                            <div class="col-md-10">
                                <input type="text" name="copy_right" id="copy_right" class="form-control input-sm"
                                    value="{{$settings->copy_right}}">
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="meta_description" class="col-md-2 col-form-label">Meta Description</label>
                            <div class="col-md-10">
                                <input type="text" name="meta_description" id="meta_description" class="form-control"
                                    value="{{$settings->meta_description}}">
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="meta_keywords" class="col-md-2 col-form-label">Meta Keyword</label>
                            <div class="col-md-10">
                                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                                    value="{{$settings->meta_keywords}}">
                            </div>
                        </div>
                        <div class="form-actions">
                                        <div class="card-body border-top">
                                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i data-feather="save" class="feather-sm me-1 fill-icon"></i> Save
                                                </div>
                                            </button>
                                            <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white" onclick="window.location.href='{{ADMIN_URL}}/dashboard'">Cancel</button>
                                        </div>
                           </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.include.footer')
