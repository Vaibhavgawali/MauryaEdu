$(document).ready(function () {
  //--- Open add course_category modal
  $("#btn_add_course_category_modal").click(function () {
    $("#add-course-category-modal").modal("show");
  });

  // add course category
  $("#btn_add_course_category").click(function () {
    var course_category_name = $("#course_category_name").val();
    var course_category_info = $("#course_category_info").val();

    $("#course_category_add_status").html("");

    if (
      course_category_name == "" ||
      course_category_name == null ||
      course_category_name == "undefined" ||
      course_category_name == undefined
    ) {
      $("#course_category_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>"
      );
      $("#course_category_name").focus();
      return false;
    }

    $("#course_category_add_status").html("");

    $("#btn_add_course_category").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      course_category_name: course_category_name,
      course_category_info: course_category_info,
    };

    $.ajax({
      type: "post",
      url: base_url + "subadmin/course-category-add-process",
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
          $("#btn_add_course_category").attr("disabled", false);
          $("#course_category_add_status").html(
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
  var dataTable = $("#course_category_list").DataTable({
    order: [[1, "asc"]],
    dom: "lBfrtip",
    lengthMenu: [
      [10, 25, 50, 99999999],
      [10, 25, 50, "All"],
    ],
    columnDefs: [{ orderable: false, targets: [0, 6] }],
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
      url: base_url + "subadmin/course-category-list-ajax",
      cache: false,
      type: "post",
      error: function () {
        // error handling
        $("#course_category_list-error").html("");
        $("#course_category_list").append(
          '<tbody class="course_category_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
        );
        $("#course_category_list_processing").css("display", "none");
      },
    },
    columns: [
      { data: "course_category_id" },
      { data: "course_category_name" },
      { data: "created_by" },
      { data: "status" },
      { data: "created_date" },
      { data: "updated_date" },
      { data: "action" },
    ],
  });

  // fetch course category info
  $("#course_category_list tbody").on(
    "click",
    ".edit_course_category",
    function () {
      var course_category_id = $(this).attr("id");

      $("#loader-spin").show();

      $.ajax({
        type: "post",
        dataType: "json",
        url: base_url + "subadmin/get-course-category-detail",
        data: { course_category_id: course_category_id },
        success: function (res) {
          $("#loader-spin").hide();
          if (res.status == true) {
            $("#update_course_category_id").val(
              res.course_category_details.course_category_id
            );
            $("#update_course_category_name").val(
              res.course_category_details.course_category_name
            );
            $("#update_course_category_info").val(
              res.course_category_details.course_category_info
            );
            $("#update_course_category_status").html(
              res.course_category_details.course_category_status_html
            );

            $("#update-course-category-modal").modal("show");
          } else {
            generateNotification("error", res.message);
            return false;
          }
        },
      });
    }
  );

  // update course category
  $("#btn_update_course_category").click(function () {
    var course_category_id = $("#update_course_category_id").val();
    var course_category_name = $("#update_course_category_name").val();
    var course_category_info = $("#update_course_category_info").val();
    var course_category_status = $("#update_course_category_status").val();

    $("#course_category_update_status").html("");

    if (
      course_category_name == "" ||
      course_category_name == null ||
      course_category_name == "undefined" ||
      course_category_name == undefined
    ) {
      $("#course_category_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>"
      );
      $("#course_category_name").focus();
      return false;
    }

    $("#course_category_update_status").html("");

    $("#btn_update_course_category").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      course_category_id: course_category_id,
      course_category_name: course_category_name,
      course_category_info: course_category_info,
      course_category_status: course_category_status,
    };

    $.ajax({
      type: "post",
      url: base_url + "subadmin/course-category-update-process",
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
          $("#course_category_update_status").html(
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
