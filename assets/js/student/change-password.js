$(document).ready(function () {
  var min_len = $("#pw_min_len").val();
  var max_len = $("#pw_max_len").val();

  /*   Prevent entering charaters in mobile & phone number   */
  $("#new_password").keyup(function (e) {
    //if the letter is not digit then display error and don't type anything
    var val = $(this).val();
    var val_length = val.length;

    //alert(val_length);
    if (val_length > 0) {
      if (val_length >= min_len) {
        $("#pw-min").show();
      } else {
        $("#pw-min").hide();
      }

      if (val_length <= max_len) {
        $("#pw-max").show();
      } else {
        $("#pw-max").hide();
      }

      if (containsUpperCharcase(val)) {
        $("#pw-upper-char").show();
      } else {
        $("#pw-upper-char").hide();
      }

      if (containsNumberDigitcase(val)) {
        $("#pw-digit").show();
      } else {
        $("#pw-digit").hide();
      }

      if (containsSpecialCharcase(val)) {
        $("#pw-special-char").show();
      } else {
        $("#pw-special-char").hide();
      }
    } else {
      $("#pw-min").hide();
      $("#pw-max").hide();
      $("#pw-upper-char").hide();
      $("#pw-digit").hide();
      $("#pw-special-char").hide();
    }
  });

  function containsUpperCharcase(str) {
    return /[A-Z]/.test(str);
  }

  function containsNumberDigitcase(str) {
    return /[0-9]/.test(str);
  }

  function containsSpecialCharcase(str) {
    const specialChars = /[!@#$%)*_(+=}{\[\]|:;,.>}]/;
    return specialChars.test(str);
  }

  // update button click
  $(".change_pass_submit").click(function () {
    var current_password = $(".current_password").val();
    var new_password = $(".new_password").val();
    var confirm_password = $(".confirm_password").val();

    if (current_password == "" || current_password == null) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Empty! </strong> Current password.</div>"
      );
      return false;
    }
    if (new_password == "" || new_password == null) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Empty field!</strong> Please enter new password.</div>"
      );
      return false;
    }

    if (confirm_password == "" || confirm_password == null) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Empty field!</strong> Please Repeat your New Password!</div>"
      );
      return false;
    }

    if (new_password != confirm_password) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Password Match Error! </strong>New password & confirm password not match</div>"
      );
      return false;
    }

    if (new_password.length < min_len) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Error! </strong>New password should be of minimum " +
          min_len +
          " characters</div>"
      );
      return false;
    }

    if (new_password.length > max_len) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Error! </strong>New password should be of maximum " +
          max_len +
          " characters</div>"
      );
      return false;
    }

    if (!containsUpperCharcase(new_password)) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Error! </strong>New password must have atleast one upper case character</div>"
      );
      return false;
    }

    if (!containsNumberDigitcase(new_password)) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Error! </strong>New password must have atleast one digit</div>"
      );
      return false;
    }

    if (!containsSpecialCharcase(new_password)) {
      $(".change_password_status").html(
        "<div class='text-danger' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><strong>Error! </strong>New password must have atleast one special character</div>"
      );
      return false;
    }

    var data = {
      current_password: current_password,
      new_password: new_password,
      confirm_password: confirm_password,
    };

    $(".change_password_status").html("");
    $("#loader-spin").show();
    $(".change_pass_submit").attr("disabled", true);

    $.ajax({
      type: "post",
      dataType: "json",
      data: data,
      url: base_url + "student/change-password-process",
      success: function (res) {
        $("#loader-spin").hide();
        $(".change_pass_submit").attr("disabled", false);

        if (res.status == true) {
          generateNotification("success", res.message);
        } else {
          generateNotification("error", res.message);
          setTimeout(function () {
            $(".change_pass_submit").attr("disabled", false);
          }, 3500);
          return false;
        }
      },
    });
  });
});
