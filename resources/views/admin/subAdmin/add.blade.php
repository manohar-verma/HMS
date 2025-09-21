@include('admin.include.header')
<?php 

$accessLevelArray = ['view','add-new','update','delete'];
$noAccessLevel = ['change-password','setting'];
?>
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
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-subtitle mb-3 border-bottom pb-3">Add user</h5>
                    <form id="addEditForm" class="form" action="{{ADMIN_URL}}/users/sub-admin" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-2 col-form-label">Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="name" id="name" value="">
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="email" id="email" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Access Modifiers</label>
                            <div class="col-md-10">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tbody>
                                           
                                            @foreach($accessData as $keyAccess=>$access)
                                            <tr>
                                            <td>
                                                <div class="form-check">
                                                    <label class="form-check-label" id="check_label_{{$keyAccess}}">
                                                        <input class="form-check-input" value="{{$access}}"
                                                            type="checkbox" id="check_{{$keyAccess}}" name="allAccess[]"
                                                            @if($access=='change-password' ) checked disabled
                                                            @endif onclick="handleReportSelect('check_{{$keyAccess}}','check_level_{{str_replace('-','_',$access)}}','{{count($accessLevelArray)}}');">{{ucwords(str_replace('-',' ',$access))}}
                                                    </label>
                                                </div>
                                            </td>
                                                @if(!in_array($access,$noAccessLevel))
                                                @foreach($accessLevelArray as $key=>$accessLevel)
                                                    <td>
                                                        <div class="form-check">
                                                            <label class="form-check-label" id="check_level_{{$key}}" style="font-size: 14px;font-weight: 400;color:#0f5e20;">
                                                                <input class="form-check-input" value="{{$accessLevel}}"
                                                                    type="checkbox" id="check_level_{{str_replace('-','_',$access)}}_{{$key}}" name="allAccessLevel[{{$access}}][]"
                                                                    onclick="handleAccessSelect('check_{{$keyAccess}}','check_level_{{str_replace('-','_',$access)}}','{{$key}}','{{count($accessLevelArray)}}');">{{ucwords(str_replace('-',' ',$accessLevel))}}
                                                            </label>
                                                        </div>
                                                    </td>
                                                @endforeach
                                                @else
                                                @foreach($accessLevelArray as $key=>$accessLevel)
                                                <td>
                                                </td>
                                                @Endforeach
                                                @endif
                                            </tr>
                                            @Endforeach

                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" type="text" name="password" id="password"
                                    value="">
                                <i class="fa fa-eye " id="togglePassword"
                                    onclick="handelPasswordHideShow('togglePassword','password')"
                                    style="cursor: pointer;float: right;margin-top: -25px;margin-right: 123px;"></i>
                                <button type="button" class="btn btn-info rounded-pill px-4 ms-2 text-white" style="float: right;
    margin-top: -37px;" onclick="handelPasswordGenerator();">Generate</button>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input type="radio" id="Active" name="status" class="form-check-input" value="1"
                                        checked="true">
                                    <label class="form-check-label" for="Active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="Deactivate" name="status" class="form-check-input"
                                        value="0">
                                    <label class="form-check-label" for="Deactivate">InActive</label>
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
                                <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white"
                                    onclick="window.location.href='{{ADMIN_URL}}/users/sub-admin'">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="passwordGenerator" tabindex="-1" role="dialog" aria-labelledby="passwordGeneratorTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-white">Password Generator</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="compose-box">
                    <div class="compose-content" id="passwordGeneratorTitle">
                        <span id="msgShow"></span>
                        <input type="text" class="form-control" id="passwordFilter" readonly><button type="button"
                            class="btn btn-info rounded-pill px-2 ms-1 text-white" style="float: right;
    margin-top: -37px;" onclick="copyPassword();">Copy</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info add-tsk" onclick="generateNewPasswordHandler();">
                    Generate New
                </button>
            </div>
        </div>
    </div>
</div>

@include('admin.include.footer')
<script>
$(function() {
    $('#addEditForm').submit(function() {
        if ($('#name').commonCheck() & $('#email').validateEmail() & $('#password').passwordCheck({alphaNumericCk: true,minLen:8,maxLen:16,})) {
            return true;
        }
        $('html, body').animate({
            scrollTop: ($('.ErrorMag').offset().top - 300)
        }, 2000);

        return false;
    });
});

function genPassword() {
    var charsNumber = "0123456789";
    var passwordNumber = 2;
    var password = "";
    for (var i = 1; i <= passwordNumber; i++) {
        var randomNumber = Math.floor(Math.random() * charsNumber.length);
        password += charsNumber.substring(randomNumber, randomNumber + 1);
    }
    var charsString = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var passwordString = 5;
    for (var i = 1; i <= passwordString; i++) {
        var randomString = Math.floor(Math.random() * charsString.length);
        password += charsString.substring(randomString, randomString + 1);
    }
    var charsSp = "!@#$%^&*()";
    var passwordSp = 1;
    for (var i = 1; i <= passwordSp; i++) {
        var randSp = Math.floor(Math.random() * charsSp.length);
        password += charsSp.substring(randSp, randSp + 1);
    }
    return password;
}

function handelPasswordGenerator() {
    $('#passwordGenerator').modal('show');
    const newPassword = genPassword();
    $('#msgShow').text('');
    $('#passwordFilter').val(newPassword);
}

function generateNewPasswordHandler() {
    $('#msgShow').text('');
    const newPassword = genPassword();
    $('#passwordFilter').val(newPassword);
}

function copyPassword() {
    var copyText = document.getElementById("passwordFilter");
    copyText.select();
    document.execCommand("copy");
    $('#password').val($('#passwordFilter').val());
    $('#msgShow').text('Copied successfully');
}

function handelPasswordHideShow(elementId, filedId) {
    const currentField = document.querySelector('#' + filedId);
    const toggleField = document.querySelector('#' + elementId);
    // toggle the type attribute
    const type = currentField.getAttribute('type') === 'password' ? 'text' : 'password';
    currentField.setAttribute('type', type);
    // toggle the eye slash icon
    $("#" + elementId).removeClass();
    type == 'password' ? toggleField.classList.add("fa", "fa-eye", "password-eye") : toggleField.classList.add("fa",
        "fa-eye-slash", "password-eye");
}
function handleReportSelect(check_report,check_level_access,totalKeyValue){
    if($('#'+check_report).is(':checked'))
    {
        $("#"+check_level_access+'_0').prop("checked",true);
    }
    else
    {
        for(i=0;i<=totalKeyValue;i++)
        {
            $("#"+check_level_access+'_'+i).prop("checked",false);
        }
    }
}
function handleAccessSelect(check_report,check_level_access,keyValue,totalKeyValue)
{
    if($('#'+check_level_access+'_'+keyValue).is(':checked'))
    {
        $('#'+check_level_access+'_0').prop("checked",true);
        $("#"+check_report).prop("checked",true);
    }
    if($('#'+check_level_access+'_0').is(':checked'))
    {
        $("#"+check_report).prop("checked",true);
    }
    else
    {
        $("#"+check_report).prop("checked",false);
        for(i=0;i<=totalKeyValue;i++)
        {
            $("#"+check_level_access+'_'+i).prop("checked",false);
        }
    }
}
</script>