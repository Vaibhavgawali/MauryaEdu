$(document).ready(function () {
  // datatble initialization
  var dataTable = $("#student_list").DataTable({
    order: [[1, "asc"]],
    dom: "lBfrtip",
    lengthMenu: [
      [10, 25, 50, 99999999],
      [10, 25, 50, "All"],
    ],
    columnDefs: [{ orderable: false, targets: [0, 7] }],
    buttons: [
      {
        extend: "collection",
        text: '<i class="fa fa-file"></i> Export',
        buttons: ["copy", "excel", "csv", "pdf", "print"],
      },
    ],
    processing: true,
    serverSide: true,
    ajax: {
      url: base_url + "admin/student-list-ajax",
      cache: false,
      type: "post", // method  , by default get
      error: function () {
        // error handling
        $("#student_list-error").html("");
        $("#student_list").append(
          '<tbody class="student_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
        );
        $("#student_list_processing").css("display", "none");
      },
    },
    columns: [
      { data: "student_id" },
      { data: "full_name" },
      { data: "emailid" },
      { data: "contact" },
      { data: "branch" },
      { data: "status" },
      { data: "created_date" },
      { data: "updated_date" },
      { data: "action" },
    ],
  });

  // fetch STUDENT info
  $("#student_list tbody").on("click", ".edit_student", function () {
    var student_id = $(this).attr("id");

    $("#loader-spin").show();

    $.ajax({
      type: "post",
      dataType: "json",
      url: base_url + "admin/get-student-info",
      data: { student_id: student_id },
      success: function (res) {
        $("#loader-spin").hide();
        if (res.status == true) {
          $("#update_student_id").val(res.student_details.student_id);
          $("#update_full_name").val(res.student_details.full_name);
          $("#update_emailid").val(res.student_details.emailid);
          $("#update_contact").val(res.student_details.contact);
          $("#update_aadhar_number").val(res.student_details.aadhar_number);
          $("#update_address").val(res.student_details.address);
          $("#update_status").val(res.student_details.status);

          $("#update-student-modal").modal("show");
        } else {
          generateNotification("error", res.message);
          return false;
        }
      },
    });
  });

  // update student details
  $("#btn_update_student").click(function () {
    var student_id = $("#update_student_id").val();
    var full_name = $("#update_full_name").val();
    var emailid = $("#update_emailid").val();
    var contact = $("#update_contact").val();
    var aadhar_number = $("#update_aadhar_number").val();
    var address = $("#update_address").val();
    var status = $("#update_status").val();

    $("#student_update_status").html("");

    if (
      full_name == "" ||
      full_name == null ||
      full_name == "undefined" ||
      full_name == undefined
    ) {
      $("#student_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Full name required.</div>"
      );
      $("#update_full_name").focus();
      return false;
    }

    if (
      emailid == "" ||
      emailid == null ||
      emailid == "undefined" ||
      emailid == undefined
    ) {
      $("#student_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>"
      );
      $("#update_emailid").focus();
      return false;
    }

    function validateEmail($email) {
      var emailReg = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
      return emailReg.test($email);
    }

    if (!validateEmail(emailid)) {
      $("#student_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Email is invalid.</div>"
      );
      $("#update_emailid").focus();
      return false;
    }

    if (
      contact == "" ||
      contact == null ||
      contact == "undefined" ||
      contact == undefined
    ) {
      $("#student_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Contact number is required.</div>"
      );
      $("#update_contact").focus();
      return false;
    }

    $("#student_update_status").html("");

    $("#btn_update_course_category").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      student_id: student_id,
      full_name: full_name,
      emailid: emailid,
      contact: contact,
      aadhar_number: aadhar_number,
      address: address,
      status: status,
    };

    $.ajax({
      type: "post",
      url: base_url + "admin/student-update-process",
      dataType: "json",
      data: data,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          generateNotification("success", res.message);
          setTimeout(function () {
            location.reload(true);
          }, 3500);
        } else {
          $("#btn_update_course_category").attr("disabled", false);
          $("#student_update_status").html(
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

  // reset student password
  $("#student_list tbody").on("click", ".reset_password_student", function () {
    var student_id = $(this).attr("id");

    var data = {
      student_id: student_id,
    };

    $.confirm({
      title: "Reset Student Password!",
      content: "Are you sure you want to reset student password?",

      buttons: {
        confirm: function () {
          $("#loader-spin").show();
          $.ajax({
            type: "post",
            url: base_url + "admin/reset-student-password",
            dataType: "json",
            data: data,
            cache: false,
            success: function (res) {
              $("#loader-spin").hide();
              if (res.status == true) {
                generateNotification("success", res.message);
                setTimeout(function () {
                  location.reload(true);
                }, 3500);
              } else {
                generateNotification("error", res.message);
                return false;
              }
            },
          });
        },
        cancel: function () {
          $(this).hide();
        },
      },
    });
  });

  //   delete enrollment of student
  $("#student_list tbody").on("click", ".delete_student", function () {
    var student_id = $(this).attr("id");
    var data = {
      student_id: student_id,
    };

    $.confirm({
      title: "Delete Student !",
      content: "Are you sure you want to delete student ?",

      buttons: {
        confirm: function () {
          $("#loader-spin").show();
          $.ajax({
            type: "post",
            url: base_url + "admin/delete-student",
            dataType: "json",
            data: data,
            cache: false,
            success: function (res) {
              $("#loader-spin").hide();
              if (res.status == true) {
                generateNotification("success", res.message);
                setTimeout(function () {
                  location.reload(true);
                }, 3500);
              } else {
                generateNotification("error", res.message);
                return false;
              }
            },
          });
        },
        cancel: function () {
          $(this).hide();
        },
      },
    });
  });
});
