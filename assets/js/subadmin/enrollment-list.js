$(document).ready(function () {
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
      url: base_url + "subadmin/enrollment-list-ajax",
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
      url: base_url + "subadmin/get-enrollment-student-details",
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
      url: base_url + "subadmin/enrollment-student-update-process",
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
              url: base_url + "subadmin/student-enrollemnt-delete",
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
});
