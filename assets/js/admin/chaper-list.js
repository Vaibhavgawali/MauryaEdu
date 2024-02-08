$(document).ready(function () {
  //--- Open add chapter modal
  $("#btn_add_chapter_modal").click(function () {
    $("#add-chapter-modal").modal("show");
  });
  $('.modal-close').click(function(){ 
    $("#add-chapter-modal").modal("hide");
  })

  $("#course_category_id, #update_course_category_id").change(function () {
    $("#course_master_id").html(
      "<option value='' selected>----- Select -----</option>"
    );
    $("#update_course_master_id").html(
      "<option value='' selected>----- Select -----</option>"
    );

    var course_category_id = $(this).val();

    if (course_category_id != "") {
      $("#loader-spin").show();

      $.ajax({
        type: "post",
        dataType: "json",
        url: base_url + "admin/get-course-list-from-category",
        data: { course_category_id: course_category_id },
        success: function (res) {
          $("#loader-spin").hide();
          if (res.status == true) {
            var course_details = res.course_details;

            for (var i = 0; i < course_details.length; i++) {
              var course_id = "";
              var course_name = "";

              course_id = course_details[i].course_master_id;
              course_name = course_details[i].course_name;

              $("#course_master_id").append(
                "<option value='" + course_id + "'>" + course_name + "</option>"
              );
              $("#update_course_master_id").append(
                "<option value='" + course_id + "'>" + course_name + "</option>"
              );
            }
          } else {
            generateNotification("error", res.message);
            return false;
          }
        },
      });
    }
  });

  $("#btn_add_chapter_details").click(function () {
    var course_category_id = $("#course_category_id").val();
    var course_master_id = $("#course_master_id").val();

    if (
      course_category_id == "" ||
      course_category_id == null ||
      course_category_id == undefined ||
      course_category_id == "undefined"
    ) {
      $("#add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category required.</div>"
      );
      return false;
    }

    if (
      course_master_id == "" ||
      course_master_id == null ||
      course_master_id == undefined ||
      course_master_id == "undefined"
    ) {
      $("#add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course  is required.</div>"
      );
      return false;
    }

    window.location.href = base_url + "admin/chapter-list/" + course_master_id;
  });

  // add course category
  $("#btn_add_chapter").click(function () {
    var course_category_id = $("#course_category_id").val();
    var course_master_id = $("#course_master_id").val();
    var chapter_name = $("#chapter_name").val();
    var chapter_info = $("#chapter_info").val();

    $("#chapter_add_status").html("");

    if (
      course_category_id == "" ||
      course_category_id == null ||
      course_category_id == "undefined" ||
      course_category_id == undefined
    ) {
      $("#chapter_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>"
      );
      $("#course_category_id").focus();
      return false;
    }

    if (
      course_master_id == "" ||
      course_master_id == null ||
      course_master_id == "undefined" ||
      course_master_id == undefined
    ) {
      $("#chapter_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>"
      );
      $("#course_master_id").focus();
      return false;
    }

    if (
      chapter_name == "" ||
      chapter_name == null ||
      chapter_name == "undefined" ||
      chapter_name == undefined
    ) {
      $("#chapter_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Chapter name is required.</div>"
      );
      $("#chapter_name").focus();
      return false;
    }

    $("#chapter_add_status").html("");

    $("#btn_add_chapter").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      course_category_id: course_category_id,
      course_master_id: course_master_id,
      chapter_name: chapter_name,
      chapter_info: chapter_info,
    };

    $.ajax({
      type: "post",
      url: base_url + "admin/chapter-add-process",
      dataType: "json",
      data: data,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          generateNotification("success", res.message);
          setTimeout(function () {
            window.location.href = base_url + "admin/chapter-list/";
          }, 3500);
        } else {
          $("#btn_add_chapter").attr("disabled", false);
          $("#chapter_add_status").html(
            "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> " +
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
  var dataTable = $("#chapter_list").DataTable({
    order: [[3, "asc"]],
    dom: "lBfrtip",
    lengthMenu: [
      [10, 25, 50, 99999999],
      [10, 25, 50, "All"],
    ],
    columnDefs: [{ orderable: false, targets: [0, 5, 7] }],
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
      url: base_url + "admin/chapter-list-ajax",
      cache: false,
      type: "post", // method  , by default get
      error: function () {
        // error handling
        $("#chapter_list-error").html("");
        $("#chapter_list").append(
          '<tbody class="chapter_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
        );
        $("#chapter_list_processing").css("display", "none");
      },
    },
    columns: [
      { data: "chapter_master_id" },
      { data: "course_category_name" },
      { data: "course_name" },
      { data: "chapter_name" },
      { data: "branch_name" },
      { data: "chapter_status" },
      { data: "created_date" },
      { data: "updated_date" },
      { data: "action" },
    ],
  });

  // fetch chapter info
  $("#chapter_list tbody").on("click", ".edit_chaper", function () {
    var chapter_master_id = $(this).attr("id");

    $("#loader-spin").show();

    $.ajax({
      type: "post",
      dataType: "json",
      url: base_url + "admin/get-chapter-detail",
      data: { chapter_master_id: chapter_master_id },
      success: function (res) {
        $("#loader-spin").hide();
        if (res.status == true) {
          $("#update_chapter_master_id").val(
            res.chapter_details.chapter_master_id
          );
          $("#update_course_category_id").val(
            res.chapter_details.course_category_id
          );
          $("#update_course_master_id").val(
            res.chapter_details.course_master_id
          );
          $("#update_chapter_name").val(res.chapter_details.chapter_name);
          $("#update_chapter_info").val(res.chapter_details.chapter_info);
          $("#update_chapter_status").html(
            res.chapter_details.chapter_status_html
          );

          $("#update-chapter-modal").modal("show");
          $('.modal-close').click(function(){ 
            $("#update-chapter-modal").modal("hide");
          })
        } else {
          generateNotification("error", res.message);
          return false;
        }
      },
    });
  });

  // update course category
  $("#btn_update_chapter").click(function () {
    var chapter_master_id = $("#update_chapter_master_id").val();
    var course_category_id = $("#update_course_category_id").val();
    var course_master_id = $("#update_course_master_id").val();
    var chapter_name = $("#update_chapter_name").val();
    var chapter_info = $("#update_chapter_info").val();
    var chapter_status = $("#update_chapter_status").val();

    $("#chapter_update_status").html("");

    if (
      course_category_id == "" ||
      course_category_id == null ||
      course_category_id == "undefined" ||
      course_category_id == undefined
    ) {
      $("#chapter_update_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>"
      );
      $("#course_category_id").focus();
      return false;
    }

    if (
      course_master_id == "" ||
      course_master_id == null ||
      course_master_id == "undefined" ||
      course_master_id == undefined
    ) {
      $("#chapter_update_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>"
      );
      $("#course_master_id").focus();
      return false;
    }

    if (
      chapter_name == "" ||
      chapter_name == null ||
      chapter_name == "undefined" ||
      chapter_name == undefined
    ) {
      $("#chapter_update_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Chapter name is required.</div>"
      );
      $("#chapter_name").focus();
      return false;
    }

    $("#chapter_update_status").html("");

    $("#btn_add_chapter").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      chapter_master_id: chapter_master_id,
      course_category_id: course_category_id,
      course_master_id: course_master_id,
      chapter_name: chapter_name,
      chapter_info: chapter_info,
      chapter_status: chapter_status,
    };

    $.ajax({
      type: "post",
      url: base_url + "admin/chapter-update-process",
      dataType: "json",
      data: data,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        if (res.status == true) {
          generateNotification("success", res.message);
          setTimeout(function () {
            window.location.href = base_url + "admin/chapter-list/";
          }, 3500);
        } else {
          $("#btn_add_chapter").attr("disabled", false);
          $("#chapter_update_status").html(
            "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> " +
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
