@include('admin.include.header')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Change Password</h3>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active d-flex align-items-center">Change Password</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Change Password</h4>
                    <h5 class="card-subtitle mb-3 border-bottom pb-3"> Account Setting</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/password/do-update" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="mb-3 row">
                            <label for="old_password" class="col-md-2 col-form-label">Old password
                                {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-5">
                                <input class="form-control" type="password" value="" name="old_password"
                                    id="old_password">
                                <i class="fa fa-eye password-eye" id="togglePassword" onclick="handelPasswordHideShow('togglePassword','old_password')"></i>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="new_password" class="col-md-2 col-form-label">New password (Exp: abc@1234)
                                {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-5">
                                <input class="form-control" type="password" id="new_password" name="new_password"
                                    rows="3" cols="3" class="form-control" value="">
                                <i class="fa fa-eye password-eye" id="togglePasswordNew" onclick="handelPasswordHideShow('togglePasswordNew','new_password')"></i>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="confirm_password" class="col-md-2 col-form-label">Confirm Password
                                {!!REQUIRED_STAR!!}</label>
                            <div class="col-md-5">
                                <input class="form-control" type="password" name="confirm_password"
                                    id="confirm_password" value="">
                                <i class="fa fa-eye password-eye" id="togglePasswordConf" onclick="handelPasswordHideShow('togglePasswordConf','confirm_password')"></i>    
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="card-body border-top">
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="save" class="feather-sm me-1 fill-icon"></i> Save
                                    </div>
                                </button>
                                <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white"
                                    onclick="window.location.href='{{ADMIN_URL}}/dashboard'">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.include.footer')
<script>
$(function() {
    $('#addEditForm').submit(function() {
        if ($('#old_password').commonCheck() & $('#new_password').passwordCheck({alphaNumericCk: true,minLen:8,maxLen:16,}) & $(
                '#confirm_password').CkConfirmPassword({
                passwordField: '#new_password'
            })) {
            return true;
        }
        $('html, body').animate({
            scrollTop: ($('.ErrorMag').offset().top - 300)
        }, 2000);

        return false;
    });

});
    function handelPasswordHideShow(elementId,filedId)
    {
         const currentField = document.querySelector('#'+filedId);
         const toggleField = document.querySelector('#'+elementId);
        // toggle the type attribute
        const type = currentField.getAttribute('type') === 'password' ? 'text' : 'password';
        currentField.setAttribute('type', type);
        // toggle the eye slash icon
        $("#"+elementId).removeClass();
        type=='password'?toggleField.classList.add("fa","fa-eye","password-eye"):toggleField.classList.add("fa","fa-eye-slash","password-eye");
    }
</script>