$(document).ready(function () {
  $("#student_list tbody").on("click", ".payment_btn", function () {
    var razor_payment_id = $(this).attr("id");
    var course_price = $(this).attr("course_price");
    // alert(course_price);

    $.ajax({
      url: base_url + "admin/get-installments",
      type: "POST",
      dataType: "json",
      data: { razor_payment_id: razor_payment_id },
      success: function (response) {
        $("#installmentsList").html("");

        if (response.status == true) {
          $("#razor_payment_id").val(razor_payment_id);
          $("#course_price").val(course_price);
          $("#total_installment_amount").val(response.total_installment_amount);

          var selectElement = $("#installment");
          var unpaidInstallments = response.installments;
          unpaidInstallments.forEach(function (installment, index) {
            if (installment.paid_status == 0) {
              var option = $("<option></option>")
                .attr("value", installment.installment_id)
                .text("Installment " + (index + 1));
              selectElement.append(option);
            }
          });

          var unpaidInstallmentsWithStatusZero = unpaidInstallments.filter(
            function (installment) {
              return installment.paid_status == 0;
            }
          );
          if (unpaidInstallmentsWithStatusZero.length === 1) {
            $("#last_installment").val(1);
          }

          $("#installmentModal").modal("show");
        } else {
          generateNotification("error", "Somethinng went wrong !");
          return false;
        }
      },
    });
  });

  // Handle form submission
  $("#add_installment").click(function () {
    var razor_payment_id = $("#razor_payment_id").val();
    var installment = $("#installment").val();
    var installment_amount = $("#installment_amount").val();
    var paid_status = $("#paid_status").val();
    var last_installment = $("#last_installment").val();
    var course_price = $("#course_price").val();
    var total_installment_amount = $("#total_installment_amount").val();

    $("#update_installment_status").html("");

    if (
      installment == "" ||
      installment == null ||
      installment == "undefined" ||
      installment == undefined
    ) {
      $("#update_installment_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Installment is required.</div>"
      );
      $("#intallment").focus();
      return false;
    }

    if (
      installment_amount == "" ||
      installment_amount == null ||
      installment_amount == "undefined" ||
      installment_amount == undefined
    ) {
      $("#update_installment_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Installment amount is required.</div>"
      );
      $("#installment_amount").focus();
      return false;
    }

    if (paid_status == 0) {
      $("#update_installment_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b>Select paid status .</div>"
      );
      $("#paid_status").focus();
      return false;
    }

    $("#update_installment_status").html("");

    $("#add_installment").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      razor_payment_id: razor_payment_id,
      installment: installment,
      installment_amount: installment_amount,
      paid_status: paid_status,
      last_installment: last_installment,
      course_price: course_price,
      total_installment_amount: total_installment_amount,
    };

    $.ajax({
      url: base_url + "admin/update-installments",
      type: "POST",
      data: data,
      success: function (response) {
        $("#loader-spin").hide();
        var response = JSON.parse(response);
        console.log(response);
        if (response.status == true) {
          $("#installmentModal").modal("hide");
          generateNotification("success", response.message);
          setTimeout(function () {
            location.reload(true);
          }, 3500);
        } else {
          $("#add_installment").attr("disabled", false);
          $("#update_installment_status").html(
            "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> " +
              response.message +
              "</div>"
          );
          return false;
        }
      },
    });
  });
});
