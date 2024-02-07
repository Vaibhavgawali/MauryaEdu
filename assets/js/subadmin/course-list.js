$(document).ready(function () {
  $(".fc-datepicker").datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
  });

  /*   Prevent entering charaters in mobile & phone number   */
  $(
    "#course_actual_price, #course_sell_price, #course_duration_number_of_days, #course_number_of_installments"
  ).keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  //--- Open add course_category modal
  $("#btn_add_course_modal").click(function () {
    $("#add-course-modal").modal("show");
  });

  $("#course_image, #update_course_image").change(function () {
    var file = this.files[0];
    var fileType = file["type"];
    var validImageTypes = ["image/jpeg", "image/png"];
    if ($.inArray(fileType, validImageTypes) < 0) {
      $.confirm({
        title: "Invalid file!",
        content: "Please select valid image .jpeg, .jpg, .png file.",

        buttons: {
          confirm: function () {
            $("#course_image, #update_course_image").val("");
          },
        },
      });
    }
  });

  // add course category
  $("#btn_add_course").click(function () {
    var course_category_id = $("#course_category_id").val();
    var course_name = $("#course_name").val();
    var course_info = $("#course_info").val();
    var course_image = $("#course_image").val();
    var course_actual_price = $("#course_actual_price").val();
    var course_sell_price = $("#course_sell_price").val();
    var course_duration_number_of_days = $(
      "#course_duration_number_of_days"
    ).val();
    var course_number_of_installments = $(
      "#course_number_of_installments"
    ).val();
    var course_start_date = $("#course_start_date").val();
    var course_end_date = $("#course_end_date").val();
    var is_allow_purchase_after_expire = $(
      "#is_allow_purchase_after_expire"
    ).val();
    var telegram_group_link = $("#telegram_group_link").val();
    var whatsapp_group_link = $("#whatsapp_group_link").val();

    $("#course_add_status").html("");

    if (
      course_category_id == "" ||
      course_category_id == null ||
      course_category_id == "undefined" ||
      course_category_id == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>"
      );
      $("#course_category_id").focus();
      return false;
    }

    if (
      course_name == "" ||
      course_name == null ||
      course_name == "undefined" ||
      course_name == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>"
      );
      $("#course_name").focus();
      return false;
    }

    if (
      course_info == "" ||
      course_info == null ||
      course_info == "undefined" ||
      course_info == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course related general information is required.</div>"
      );
      $("#course_info").focus();
      return false;
    }

    if (
      course_image == "" ||
      course_image == null ||
      course_image == "undefined" ||
      course_image == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course image is required.</div>"
      );
      $("#course_image").focus();
      return false;
    }

    if (
      course_actual_price == "" ||
      course_actual_price == null ||
      course_actual_price == "undefined" ||
      course_actual_price == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course actual price is required.</div>"
      );
      $("#course_actual_price").focus();
      return false;
    }

    if (
      course_sell_price == "" ||
      course_sell_price == null ||
      course_sell_price == "undefined" ||
      course_sell_price == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course sell price is required.</div>"
      );
      $("#course_sell_price").focus();
      return false;
    }

    if (
      course_duration_number_of_days == "" ||
      course_duration_number_of_days == null ||
      course_duration_number_of_days == "undefined" ||
      course_duration_number_of_days == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course duration (number of days) is required.</div>"
      );
      $("#course_duration_number_of_days").focus();
      return false;
    }

    if (
      course_number_of_installments == "" ||
      course_number_of_installments == null ||
      course_number_of_installments == "undefined" ||
      course_number_of_installments == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course number of installments is required.</div>"
      );
      $("#course_number_of_installments").focus();
      return false;
    }

    if (
      course_start_date == "" ||
      course_start_date == null ||
      course_start_date == "undefined" ||
      course_start_date == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course start date is required.</div>"
      );
      $("#course_start_date").focus();
      return false;
    }

    if (
      course_end_date == "" ||
      course_end_date == null ||
      course_end_date == "undefined" ||
      course_end_date == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course end date is required.</div>"
      );
      $("#course_end_date").focus();
      return false;
    }

    if (
      is_allow_purchase_after_expire == "" ||
      is_allow_purchase_after_expire == null ||
      is_allow_purchase_after_expire == "undefined" ||
      is_allow_purchase_after_expire == undefined
    ) {
      $("#course_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Is Course allowed to purchase after end date is required.</div>"
      );
      $("#is_allow_purchase_after_expire").focus();
      return false;
    }

    var file_data = $("#course_image").prop("files")[0];
    console.log(file_data);

    $("#course_add_status").html("");

    $("#btn_add_course_category").attr("disabled", true);

    $("#loader-spin").show();

    var form_data = new FormData();
    form_data.append("course_category_id", course_category_id);
    form_data.append("course_name", course_name);
    form_data.append("course_info", course_info);
    form_data.append("course_image", file_data);
    form_data.append("course_actual_price", course_actual_price);
    form_data.append("course_sell_price", course_sell_price);
    form_data.append(
      "course_duration_number_of_days",
      course_duration_number_of_days
    );
    form_data.append(
      "course_number_of_installments",
      course_number_of_installments
    );
    form_data.append("course_start_date", course_start_date);
    form_data.append("course_end_date", course_end_date);
    form_data.append(
      "is_allow_purchase_after_expire",
      is_allow_purchase_after_expire
    );
    form_data.append("telegram_group_link", telegram_group_link);
    form_data.append("whatsapp_group_link", whatsapp_group_link);

    $.ajax({
      type: "post",
      url: base_url + "subadmin/course-add-process",
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
          $("#btn_add_course_category").attr("disabled", false);
          $("#course_add_status").html(
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

  // datatble initialization
  var dataTable = $("#course_list").DataTable({
    order: [[2, "asc"]],
    dom: "lBfrtip",
    lengthMenu: [
      [10, 25, 50, 99999999],
      [10, 25, 50, "All"],
    ],
    columnDefs: [{ orderable: false, targets: [0, 3, 11, 14] }],
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
      url: base_url + "subadmin/course-list-ajax",
      cache: false,
      type: "post", // method  , by default get
      error: function () {
        // error handling
        $("#course_list-error").html("");
        $("#course_list").append(
          '<tbody class="course_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
        );
        $("#course_list_processing").css("display", "none");
      },
    },
    columns: [
      { data: "course_master_id" },
      { data: "course_category_name" },
      { data: "course_name" },
      { data: "course_image" },
      { data: "course_start_date" },
      { data: "course_end_date" },
      { data: "created_by" },
      { data: "is_allow_purchase_after_expire" },
      { data: "course_duration_number_of_days" },
      { data: "course_actual_price" },
      { data: "course_sell_price" },
      { data: "course_number_of_installments" },
      { data: "course_status" },
      { data: "created_date" },
      { data: "updated_date" },
      { data: "action" },
    ],
  });

  // fetch course info
  $("#course_list tbody").on("click", ".edit_course", function () {
    var course_master_id = $(this).attr("id");

    $("#loader-spin").show();

    $.ajax({
      type: "post",
      dataType: "json",
      url: base_url + "subadmin/get-course-detail",
      data: { course_master_id: course_master_id },
      success: function (res) {
        $("#loader-spin").hide();
        if (res.status == true) {
          $("#update_course_master_id").val(
            res.course_details.course_master_id
          );
          $("#update_course_category_id").val(
            res.course_details.course_category_id
          );
          $("#update_course_name").val(res.course_details.course_name);
          $("#update_course_info").val(res.course_details.course_info);
          //$("#update_course_image").val( res.course_details.course_image);
          $("#update_course_actual_price").val(
            res.course_details.course_actual_price
          );
          $("#update_course_sell_price").val(
            res.course_details.course_sell_price
          );
          $("#update_course_duration_number_of_days").val(
            res.course_details.course_duration_number_of_days
          );
          $("#update_course_number_of_installments").val(
            res.course_details.course_number_of_installments
          );
          $("#update_course_start_date").val(
            res.course_details.course_start_date
          );
          $("#update_course_end_date").val(res.course_details.course_end_date);
          $("#update_is_allow_purchase_after_expire").val(
            res.course_details.is_allow_purchase_after_expire
          );
          $("#update_telegram_group_link").val(
            res.course_details.telegram_group_link
          );
          $("#update_whatsapp_group_link").val(
            res.course_details.whatsapp_group_link
          );
          $("#update_course_status").html(
            res.course_details.course_status_html
          );

          $("#course_img").html("");
          $("#course_img").html(res.course_details.course_image);
          $("#update-course-modal").modal("show");
        } else {
          generateNotification("error", res.message);
          return false;
        }
      },
    });
  });

  // update course
  $("#btn_update_course").click(function () {
    var course_master_id = $("#update_course_master_id").val();
    var course_category_id = $("#update_course_category_id").val();
    var course_name = $("#update_course_name").val();
    var course_info = $("#update_course_info").val();
    var course_image = $("#update_course_image").val();
    var course_actual_price = $("#update_course_actual_price").val();
    var course_sell_price = $("#update_course_sell_price").val();
    var course_duration_number_of_days = $(
      "#update_course_duration_number_of_days"
    ).val();
    var course_number_of_installments = $(
      "#update_course_number_of_installments"
    ).val();
    var course_start_date = $("#update_course_start_date").val();
    var course_end_date = $("#update_course_end_date").val();
    var is_allow_purchase_after_expire = $(
      "#update_is_allow_purchase_after_expire"
    ).val();
    var telegram_group_link = $("#update_telegram_group_link").val();
    var whatsapp_group_link = $("#update_whatsapp_group_link").val();
    var course_status = $("#update_course_status").val();

    $("#course_update_status").html("");

    if (
      course_category_id == "" ||
      course_category_id == null ||
      course_category_id == "undefined" ||
      course_category_id == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>"
      );
      $("#update_course_category_id").focus();
      return false;
    }

    if (
      course_name == "" ||
      course_name == null ||
      course_name == "undefined" ||
      course_name == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>"
      );
      $("#update_course_name").focus();
      return false;
    }

    if (
      course_info == "" ||
      course_info == null ||
      course_info == "undefined" ||
      course_info == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course related general information is required.</div>"
      );
      $("#update_course_info").focus();
      return false;
    }

    if (
      course_actual_price == "" ||
      course_actual_price == null ||
      course_actual_price == "undefined" ||
      course_actual_price == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course actual price is required.</div>"
      );
      $("#update_course_actual_price").focus();
      return false;
    }

    if (
      course_sell_price == "" ||
      course_sell_price == null ||
      course_sell_price == "undefined" ||
      course_sell_price == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course sell price is required.</div>"
      );
      $("#update_course_sell_price").focus();
      return false;
    }

    if (
      course_duration_number_of_days == "" ||
      course_duration_number_of_days == null ||
      course_duration_number_of_days == "undefined" ||
      course_duration_number_of_days == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course duration (number of days) is required.</div>"
      );
      $("#update_course_duration_number_of_days").focus();
      return false;
    }

    if (
      course_number_of_installments == "" ||
      course_number_of_installments == null ||
      course_number_of_installments == "undefined" ||
      course_number_of_installments == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course number of installments is required.</div>"
      );
      $("#update_course_number_of_installments").focus();
      return false;
    }

    if (
      course_start_date == "" ||
      course_start_date == null ||
      course_start_date == "undefined" ||
      course_start_date == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course start date is required.</div>"
      );
      $("#update_course_start_date").focus();
      return false;
    }

    if (
      course_end_date == "" ||
      course_end_date == null ||
      course_end_date == "undefined" ||
      course_end_date == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course end date is required.</div>"
      );
      $("#update_course_end_date").focus();
      return false;
    }

    if (
      is_allow_purchase_after_expire == "" ||
      is_allow_purchase_after_expire == null ||
      is_allow_purchase_after_expire == "undefined" ||
      is_allow_purchase_after_expire == undefined
    ) {
      $("#course_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Is Course allowed to purchase after end date is required.</div>"
      );
      $("#update_is_allow_purchase_after_expire").focus();
      return false;
    }

    var file_data = $("#update_course_image").prop("files")[0];
    //console.log(file_data);

    $("#course_update_status").html("");

    $("#btn_update_course_category").attr("disabled", true);

    $("#loader-spin").show();

    var form_data = new FormData();
    form_data.append("course_master_id", course_master_id);
    form_data.append("course_category_id", course_category_id);
    form_data.append("course_name", course_name);
    form_data.append("course_info", course_info);
    form_data.append("course_image", file_data);
    form_data.append("course_actual_price", course_actual_price);
    form_data.append("course_sell_price", course_sell_price);
    form_data.append(
      "course_duration_number_of_days",
      course_duration_number_of_days
    );
    form_data.append(
      "course_number_of_installments",
      course_number_of_installments
    );
    form_data.append("course_start_date", course_start_date);
    form_data.append("course_end_date", course_end_date);
    form_data.append(
      "is_allow_purchase_after_expire",
      is_allow_purchase_after_expire
    );
    form_data.append("telegram_group_link", telegram_group_link);
    form_data.append("whatsapp_group_link", whatsapp_group_link);
    form_data.append("course_status", course_status);

    $.ajax({
      type: "post",
      url: base_url + "subadmin/course-update-process",
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
          $("#btn_update_course_category").attr("disabled", false);
          $("#course_update_status").html(
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

  // send new course published notification
  $("#course_list tbody").on("click", ".new_course_notification", function () {
    var course_master_id = $(this).attr("id");
    var course_category_id = $(this).attr("course_category_id");

    var data = {
      course_master_id: course_master_id,
      course_category_id: course_category_id,
    };

    $.confirm({
      title: "Send new course published notification!",
      content:
        "Are you sure you want to send new course published notification?",

      buttons: {
        confirm: function () {
          $("#loader-spin").show();
          $.ajax({
            type: "post",
            url: base_url + "admin/new-course-send-notification",
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

  //   delete course
  $("#course_list tbody").on("click", ".delete_course", function () {
    var course_master_id = $(this).attr("id");
    var data = {
      course_master_id: course_master_id,
    };

    $.confirm({
      title: "Delete Course !",
      content: "Are you sure you want to delete course ?",

      buttons: {
        confirm: function () {
          $("#loader-spin").show();
          $.ajax({
            type: "post",
            url: base_url + "subadmin/delete-course",
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
