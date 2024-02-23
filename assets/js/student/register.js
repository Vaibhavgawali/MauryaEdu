$(document).ready(function () {
  /*   Prevent entering charaters in mobile & phone number   */
  $("#contact").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  //Login Submit
  $("#btn_register_submit").click(function () {
    var full_name = $("#full_name").val();
    var emailid = $("#emailid").val();
    var contact = $("#contact").val();
    var branch = $("#branch").val();
    var terms_and_policy = "";

    $("#register_status").html("");

    if (
      full_name == "" ||
      full_name == null ||
      full_name == "undefined" ||
      full_name == undefined
    ) {
      $("#register_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Full Name is required.</div>"
      );
      $("#full_name").focus();
      return false;
    }

    if (
      emailid == "" ||
      emailid == null ||
      emailid == "undefined" ||
      emailid == undefined
    ) {
      $("#register_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>"
      );
      $("#emailid").focus();
      return false;
    }

    function validateEmail($email) {
      var emailReg = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
      return emailReg.test($email);
    }

    if (!validateEmail(emailid)) {
      $("#register_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Email is invalid.</div>"
      );
      $("#emailid").focus();
      return false;
    }

    if (
      contact == "" ||
      contact == null ||
      contact == "undefined" ||
      contact == undefined
    ) {
      $("#register_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Mobile number is required.</div>"
      );
      $("#contact").focus();
      return false;
    }

    if (
      branch == "" ||
      branch == null ||
      branch == "undefined" ||
      branch == undefined
    ) {
      $("#register_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Branch is required.</div>"
      );
      $("#branch").focus();
      return false;
    }

    if ($("#terms_and_policy").prop("checked") == false) {
      $("#register_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Agree terms & condition is required.</div>"
      );
      return false;
    } else {
      terms_and_policy = "1";
    }

    $("#register_status").html("");

    $("#loader-spin").show();

    var data = {
      full_name: full_name,
      emailid: emailid,
      contact: contact,
      branch: branch,
      terms_and_policy: terms_and_policy,
    };

    $.ajax({
      type: "post",
      url: base_url + "student/register-process",
      dataType: "json",
      data: data,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          $("#btn_register_submit").attr("disabled", true);
          $("#register_status").html(
            "<div class='alert alert-success text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-check'></i> " +
              res.message +
              "</div>"
          );
          return false;
        } else {
          $("#register_status").html(
            "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> " +
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
