$(document).ready(function () {
  //Login Submit
  $("#btn_login_submit").click(function () {
    var emailid = $("#emailid").val();
    var password = $("#password").val();

    if (
      emailid == "" ||
      emailid == null ||
      emailid == "undefined" ||
      emailid == undefined
    ) {
      $("#login_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>"
      );
      $("#emailid").focus();
      return false;
    }

    if (
      password == "" ||
      password == null ||
      password == "undefined" ||
      password == undefined
    ) {
      $("#login_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Password is required.</div>"
      );
      $("#password").focus();
      return false;
    }

    $("#login_status").html("");

    $("#loader-spin").show();

    var data = {
      emailid: emailid,
      password: password,
    };

    $.ajax({
      type: "post",
      url: base_url + "subadmin/login-process",
      dataType: "json",
      data: data,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          window.location.href = base_url + "subadmin/dashboard";
          return false;
        } else {
          $("#login_status").html(
            "<div class='alert alert-secondary text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> " +
              res.message +
              "</div>"
          );
          return false;
        }
      },
    });

    return false;
  });
});
