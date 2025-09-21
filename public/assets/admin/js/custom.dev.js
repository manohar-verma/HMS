function handleCollPassSideBar() {
    if ($("#collapssidebar").is(":checked")) {
        setCookie("collPassSideBar", "mini-sidebar", 365);
    } else {
        setCookie("collPassSideBar", "full", 365);
    }
}
setTimeout(() => {
    let currentSideBar = getCookie("collPassSideBar")
        ? getCookie("collPassSideBar")
        : "full";
    if (currentSideBar == "mini-sidebar") {
        console.log("currentSideBar", currentSideBar);
        $("#main-wrapper").toggleClass("mini-sidebar");
        $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        $("#collapssidebar").prop("checked", "true");
    }
}, "1000");

function changeAcademicYear(id,SITE_URL,ADMIN_URL,_token) {
    $("#updatingAcademicLoader" + id).html(
        '<img src="'+SITE_URL+'/assets/common/img/ajax-loader.gif" style="width: 11px;">'
    );
    $.ajax({
        type: "POST",
        url: ADMIN_URL+"/academic-year/active/" + id,
        data: { _token: _token },
        success: function (data) {
            $("#updatingAcademicLoader" + id).html("");
            if (data == "") {
                toastr.error("Some thing went wrong", "Failed!");
            } else {
                if (data == "1") {
                    toastr.success(
                        "Academic Year activated Successfully",
                        "Great!"
                    );
                    window.location.reload();
                } else {
                    toastr.error(
                        "Failed to active Academic Year Update",
                        "Failed!"
                    );
                }
            }
        },
    });
}
$(function() {
$(".allow_decimal").on("input", function(evt) {
    var self = $(this);
    self.val(self.val().replace(/[^0-9.]/g, ''));
    if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
    {
        evt.preventDefault();
    }
});
});
