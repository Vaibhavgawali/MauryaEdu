$(document).ready(function () {
  //--- Open add chapter modal
  $("#btn_add_chapter_modal").click(function () {
    $("#add-chapter-modal").modal("show");
  });

  $("#course_master_id").change(function () {
    var course_master_id = $(this).val();
    if (course_master_id != "") {
      $("#loader-spin").show();

      $.ajax({
        type: "post",
        dataType: "json",
        url: base_url + "subadmin/get-course-details",
        data: { course_master_id: course_master_id },
        success: function (res) {
          $("#loader-spin").hide();
          if (res.status == true) {
            var course_details = res.course_details;
            $("#course_price").val(course_details.course_sell_price);
          } else {
            generateNotification("error", res.message);
            return false;
          }
        },
      });
    }
  });

  $("#btn_add_chapter_details").click(function () {
    var student_id = $("#student_id").val();
    var course_master_id = $("#course_master_id").val();

    if (
      course_master_id == "" ||
      course_master_id == null ||
      course_master_id == undefined ||
      course_master_id == "undefined"
    ) {
      $("#add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course  is required.</div>"
      );
      return false;
    }

    window.location.href =
      base_url + "subadmin/chapter-list/" + course_master_id;
  });

  $("#installment_number").on("change", function () {
    var installmentNumber = parseInt($(this).val(), 10);

    // Check if the installment number is greater than 1
    if (installmentNumber > 1) {
      $("#first_installment_field").show();
    } else {
      $("#first_installment_field").hide();
    }
  });

  // add course category
  $("#btn_add_enrollment").click(function () {
    var student_id = $("#student_id").val();
    var course_master_id = $("#course_master_id").val();
    var course_price = $("#course_price").val();
    var installment_number = $("#installment_number").val();
    let installment_amount = $("#installment_amount").val();

    $("#enrollment_add_status").html("");

    if (
      course_master_id == "" ||
      course_master_id == null ||
      course_master_id == "undefined" ||
      course_master_id == undefined
    ) {
      $("#enrollment_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>"
      );
      $("#course_master_id").focus();
      return false;
    }

    if (
      course_price == "" ||
      course_price == null ||
      course_price == "undefined" ||
      course_price == undefined
    ) {
      $("#enrollment_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course price is required.</div>"
      );
      $("#course_price").focus();
      return false;
    }

    if (
      installment_number == "" ||
      installment_number == null ||
      installment_number == "undefined" ||
      installment_number == undefined
    ) {
      $("#enrollment_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Installment number is required.</div>"
      );
      $("#installment_number").focus();
      return false;
    }

    if (isNaN(installment_number)) {
      $("#enrollment_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b> INVALID!</b> Installment number must be a number .</div>"
      );
      $("#installment_number").focus();
      return false;
    }

    if (installment_number == 1) {
      installment_amount = course_price;
    }

    if (
      installment_amount == "" ||
      installment_amount == null ||
      installment_amount == "undefined" ||
      installment_amount == undefined
    ) {
      $("#enrollment_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Installment amount is required.</div>"
      );
      $("#installment_amount").focus();
      return false;
    }

    if (isNaN(installment_amount)) {
      $("#enrollment_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b> INVALID!</b> Installment amount must be a number .</div>"
      );
      $("#installment_amount").focus();
      return false;
    }

    $("#enrollment_add_status").html("");

    $("#btn_add_enrollment").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      student_id: student_id,
      course_master_id: course_master_id,
      course_price: course_price,
      installment_number: installment_number,
      installment_amount: installment_amount,
    };

    $.ajax({
      type: "post",
      url: base_url + "subadmin/enrollment-add-process",
      dataType: "json",
      data: data,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          generateNotification("success", res.message);
          setTimeout(function () {
            window.location.href = base_url + "subadmin/enrollment-list/";
          }, 3500);
        } else {
          $("#btn_add_chapter").attr("disabled", false);
          $("#chapter_add_status").html(
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
