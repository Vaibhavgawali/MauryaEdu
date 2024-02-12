$(document).ready(function () {
  $("#certificate_file, #update_certificate_file").change(function () {
    var file = this.files[0];
    var fileType = file["type"];
    var validImageTypes = ["application/pdf"];
    if ($.inArray(fileType, validImageTypes) < 0) {
      $.confirm({
        title: "Invalid file!",
        content: "Please select valid .pdf document file.",

        buttons: {
          confirm: function () {
            $("#document_file, #update_document_file").val("");
          },
        },
      });
    }
  });

  //--- Open update course_category modal
  $("#btn_update_status_modal").click(function () {
    $("#update-status-modal").modal("show");
  });

  // datatble initialization
  var dataTable = $("#student_list").DataTable({
    order: [[8, "DESC"]],
    dom: "lBfrtip",
    lengthMenu: [
      [10, 25, 50, 99999999],
      [10, 25, 50, "All"],
    ],
    columnDefs: [{ orderable: false, targets: [0, 7, 9] }],
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
      url: base_url + "admin/enrollment-list-ajax",
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
      { data: "branch_name" },
      { data: "course_name" },
      { data: "course_actual_price" },
      { data: "paid_price" },
      { data: "valid_upto" },
      { data: "created_date" },
      { data: "validity_status" },
      { data: "status" },
      { data: "action" },
    ],
  });

  // fetch enrollment info of student
  $("#student_list tbody").on("click", ".edit_student_status", function () {
    var enrollment_id = $(this).attr("id");

    $("#loader-spin").show();

    $.ajax({
      type: "post",
      dataType: "json",
      url: base_url + "admin/get-enrollment-student-details",
      data: { enrollment_id: enrollment_id },
      success: function (res) {
        $("#loader-spin").hide();
        if (res.status == true) {
          $("#update_enrollment_id").val(
            res.enrollment_student_details.enrollment_id
          );

          $("#update_enrollment_student_status").html(
            res.enrollment_student_details.enrollment_student_status_html
          );

          $("#update-status-modal").modal("show");
        } else {
          generateNotification("error", res.message);
          return false;
        }
      },
    });
  });

  // update enrollment info of student
  $("#btn_update_status").click(function () {
    var enrollment_id = $("#update_enrollment_id").val();
    var enrollment_student_status = $(
      "#update_enrollment_student_status"
    ).val();

    $("#enrollment_student_update_status").html("");

    $("#btn_update_status").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      enrollment_id: enrollment_id,
      enrollment_student_status: enrollment_student_status,
    };

    // alert(data.enrollment_student_status);
    // alert(data.enrollment_id);

    $.ajax({
      type: "post",
      url: base_url + "admin/enrollment-student-update-process",
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
          $("#btn_update_status").attr("disabled", false);
          $("#enrollment_student_update_status").html(
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

  //   delete enrollment of student
  $("#student_list tbody").on(
    "click",
    ".delete_student_enrollment",
    function () {
      var enrollment_id = $(this).attr("id");
      var data = {
        enrollment_id: enrollment_id,
      };

      $.confirm({
        title: "Delete Enrollment Of Student !",
        content: "Are you sure you want to delete enrollment ?",

        buttons: {
          confirm: function () {
            $("#loader-spin").show();
            $.ajax({
              type: "post",
              url: base_url + "admin/student-enrollemnt-delete",
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
    }
  );

  // fetch enrollment info of student
  $("#student_list tbody").on("click", ".add_certificate", function () {
    var enrollment_id = $(this).attr("id");
    $("#enrollment_id").val(enrollment_id);

    $("#add-certificate-modal").modal("show");
  });

  // add certificate
  $("#btn_add_certificate_details").click(function () {
    console.log("first");
    var enrollment_id = $("#enrollment_id").val();
    var certificate_title = $("#certificate_title").val();

    var certificate_file = $("#certificate_file").val();
    $("#add_status").html("");

    if (
      certificate_title == "" ||
      certificate_title == null ||
      certificate_title == "undefined" ||
      certificate_title == undefined
    ) {
      $("#add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Certificate title is required.</div>"
      );
      $("#certificate_title").focus();
      return false;
    }

    if (
      certificate_file == "" ||
      certificate_file == null ||
      certificate_file == "undefined" ||
      certificate_file == undefined
    ) {
      $("#add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Certificate file is required.</div>"
      );
      $("#certificate_file").focus();
      return false;
    }

    var file_data = $("#certificate_file").prop("files")[0];

    $("#add_status").html("");

    $("#btn_add_certificate_details").attr("disabled", true);

    $("#loader-spin").show();

    var form_data = new FormData();
    form_data.append("enrollment_id", enrollment_id);
    form_data.append("certificate_title", certificate_title);

    form_data.append("certificate_file", file_data);

    $.ajax({
      type: "post",
      url: base_url + "admin/certificate-add-process",
      dataType: "json",
      data: form_data,
      contentType: false,
      processData: false,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          generateNotification("success", res.message);
          setTimeout(function () {
            location.reload(true);
          }, 3500);
        } else {
          $("#btn_add_certificate_details").attr("disabled", false);
          $("#add_status").html(
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

  // fetch certificate info
  $("#student_list tbody").on("click", ".edit_certificate", function () {
    var certificate_master_id = $(this).attr("id");
    var student_id = $(this).attr("student_id");
    $("#loader-spin").show();

    $.ajax({
      type: "post",
      dataType: "json",
      url: base_url + "admin/get-certificate-details",
      data: { certificate_master_id: certificate_master_id },
      success: function (res) {
        $("#loader-spin").hide();
        if (res.status == true) {
          var target_dir =
            "uploads/student/" +
            student_id +
            "/certificates/" +
            res.certificate_details.certificate_master_id +
            "/";

          var certificate_file_link =
            base_url + target_dir + res.certificate_details.certificate_file;

          $("#update_certificate_master_id").val(
            res.certificate_details.certificate_master_id
          );

          $("#update_student_id").val(student_id);

          $("#update_certificate_title").val(
            res.certificate_details.certificate_title
          );

          $("#curr_certificate").attr("href", certificate_file_link);
          $("#update_certificate_status").html(
            res.certificate_details.certificate_status_html
          );

          $("#update-certificate-modal").modal("show");
        } else {
          generateNotification("error", res.message);
          return false;
        }
      },
    });
  });

  // update certificate info
  $("#btn_update_certificate_details").click(function () {
    var certificate_master_id = $("#update_certificate_master_id").val();
    var certificate_title = $("#update_certificate_title").val();
    var certificate_status = $("#update_certificate_status").val();
    var student_id = $("#update_student_id").val();

    $("#update_status").html("");

    if (
      certificate_title == "" ||
      certificate_title == null ||
      certificate_title == "undefined" ||
      certificate_title == undefined
    ) {
      $("#update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Certificate title is required.</div>"
      );
      $("#update_certificate_title").focus();
      return false;
    }

    var file_data = $("#update_certificate_file").prop("files")[0];

    $("#update_status").html("");

    $("#btn_update_certificate_details").attr("disabled", true);

    $("#loader-spin").show();

    var form_data = new FormData();

    form_data.append("certificate_master_id", certificate_master_id);
    form_data.append("student_id", student_id);
    form_data.append("certificate_title", certificate_title);
    form_data.append("certificate_file", file_data);
    form_data.append("certificate_status", certificate_status);

    $.ajax({
      type: "post",
      url: base_url + "admin/certificate-update-process",
      dataType: "json",
      data: form_data,
      contentType: false,
      processData: false,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          generateNotification("success", res.message);
          setTimeout(function () {
            location.reload(true);
          }, 3500);
        } else {
          $("#btn_update_certificate_details").attr("disabled", false);
          $("#update_status").html(
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

  // open add id card modal
  $("#student_list tbody").on("click", ".add_id_card", function () {
    var enrollment_id = $(this).attr("id");
    $("#enrollment_id").val(enrollment_id);

    $("#add-id-card-modal").modal("show");
  });

  // add id card
  $("#btn_add_id_card_details").click(function () {
    var enrollment_id = $("#enrollment_id").val();
    var id_card_title = $("#id_card_title").val();

    var id_card_file = $("#id_card_file").val();
    $("#add_id_card_status").html("");

    if (
      id_card_title == "" ||
      id_card_title == null ||
      id_card_title == "undefined" ||
      id_card_title == undefined
    ) {
      $("#add_id_card_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> id_card title is required.</div>"
      );
      $("#id_card_title").focus();
      return false;
    }

    if (
      id_card_file == "" ||
      id_card_file == null ||
      id_card_file == "undefined" ||
      id_card_file == undefined
    ) {
      $("#add_id_card_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> id_card file is required.</div>"
      );
      $("#id_card_file").focus();
      return false;
    }

    var file_data = $("#id_card_file").prop("files")[0];

    $("#add_id_card_status").html("");

    $("#btn_add_id_card_details").attr("disabled", true);

    $("#loader-spin").show();

    var form_data = new FormData();
    form_data.append("enrollment_id", enrollment_id);
    form_data.append("id_card_title", id_card_title);

    form_data.append("id_card_file", file_data);

    $.ajax({
      type: "post",
      url: base_url + "admin/id-card-add-process",
      dataType: "json",
      data: form_data,
      contentType: false,
      processData: false,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          generateNotification("success", res.message);
          setTimeout(function () {
            location.reload(true);
          }, 3500);
        } else {
          $("#btn_add_id_card_details").attr("disabled", false);
          $("#add_id_card_status").html(
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

  // fetch id card info
  $("#student_list tbody").on("click", ".edit_id_card", function () {
    var id_card_master_id = $(this).attr("id");
    var student_id = $(this).attr("student_id");

    $("#loader-spin").show();

    $.ajax({
      type: "post",
      dataType: "json",
      url: base_url + "admin/get-id-card-details",
      data: { id_card_master_id: id_card_master_id },
      success: function (res) {
        $("#loader-spin").hide();
        if (res.status == true) {
          var target_dir = "uploads/student/" + student_id + "/id-card/";

          var id_card_file_link =
            base_url + target_dir + res.id_card_details.id_card_file;

          $("#update_id_card_master_id").val(id_card_master_id);

          $("#update_card_student_id").val(student_id);

          $("#update_id_card_title").val(res.id_card_details.id_card_title);

          $("#curr_id_card").attr("href", id_card_file_link);
          $("#update_id_card_status").html(
            res.id_card_details.id_card_status_html
          );

          $("#update-id-card-modal").modal("show");
        } else {
          generateNotification("error", res.message);
          return false;
        }
      },
    });
  });

  // update id card info
  $("#btn_update_id_card_details").click(function () {
    var id_card_master_id = $("#update_id_card_master_id").val();
    var id_card_title = $("#update_id_card_title").val();
    var id_card_status = $("#update_id_card_status").val();
    var student_id = $("#update_card_student_id").val();
    $("#update_card_status").html("");

    if (
      id_card_title == "" ||
      id_card_title == null ||
      id_card_title == "undefined" ||
      id_card_title == undefined
    ) {
      $("#update_card_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Id Card title is required.</div>"
      );
      $("#update_id_card_title").focus();
      return false;
    }

    var file_data = $("#update_id_card_file").prop("files")[0];

    $("#update_card_status").html("");

    $("#btn_update_id_card_details").attr("disabled", true);

    $("#loader-spin").show();

    var form_data = new FormData();

    form_data.append("id_card_master_id", id_card_master_id);
    form_data.append("student_id", student_id);
    form_data.append("id_card_title", id_card_title);
    form_data.append("id_card_file", file_data);
    form_data.append("id_card_status", id_card_status);

    $.ajax({
      type: "post",
      url: base_url + "admin/id-card-update-process",
      dataType: "json",
      data: form_data,
      contentType: false,
      processData: false,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          generateNotification("success", res.message);
          setTimeout(function () {
            location.reload(true);
          }, 3500);
        } else {
          $("#btn_update_certificate_details").attr("disabled", false);
          $("#update_status").html(
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
