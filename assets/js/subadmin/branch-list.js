$(document).ready(function () {
  //--- Open add branch modal
  $("#btn_add_branch_modal").click(function () {
    $("#add-branch-modal").modal("show");
  });

  // add branch category
  $("#btn_add_branch").click(function () {
    var branch_name = $("#branch_name").val();
    var branch_info = $("#branch_info").val();

    $("#branch_add_status").html("");

    if (
      branch_name == "" ||
      branch_name == null ||
      branch_name == "undefined" ||
      branch_name == undefined
    ) {
      $("#branch_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Branch is required.</div>"
      );
      $("#branch_name").focus();
      return false;
    }

    $("#branch_add_status").html("");

    $("#btn_add_branch").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      branch_name: branch_name,
      branch_info: branch_info,
    };

    $.ajax({
      type: "post",
      url: base_url + "admin/branch-add-process",
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
          $("#btn_add_branch").attr("disabled", false);
          $("#branch_add_status").html(
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
  var dataTable = $("#branch_list").DataTable({
    order: [[1, "asc"]],
    dom: "lBfrtip",
    lengthMenu: [
      [10, 25, 50, 99999999],
      [10, 25, 50, "All"],
    ],
    columnDefs: [{ orderable: false, targets: [0, 5] }],
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
      url: base_url + "admin/branch-list-ajax",
      cache: false,
      type: "post", // method  , by default get
      error: function () {
        // error handling
        $("#branch_list-error").html("");
        $("#branch_list").append(
          '<tbody class="branch_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
        );
        $("#branch_list_processing").css("display", "none");
      },
    },
    columns: [
      { data: "branch_id" },
      { data: "branch_name" },
      { data: "status" },
      { data: "created_date" },
      { data: "updated_date" },
      { data: "action" },
    ],
  });

  // fetch branch info
  $("#branch_list tbody").on("click", ".edit_branch", function () {
    var branch_id = $(this).attr("id");

    $("#loader-spin").show();

    $.ajax({
      type: "post",
      dataType: "json",
      url: base_url + "admin/get-branch-detail",
      data: { branch_id: branch_id },
      success: function (res) {
        $("#loader-spin").hide();
        if (res.status == true) {
          $("#update_branch_id").val(res.branch_details.branch_id);
          $("#update_branch_name").val(res.branch_details.branch_name);
          $("#update_branch_info").val(res.branch_details.branch_info);
          $("#update_branch_status").html(
            res.branch_details.branch_status_html
          );

          $("#update-branch-modal").modal("show");
        } else {
          generateNotification("error", res.message);
          return false;
        }
      },
    });
  });

  // update branch
  $("#btn_update_branch").click(function () {
    var branch_id = $("#update_branch_id").val();
    var branch_name = $("#update_branch_name").val();
    var branch_info = $("#update_branch_info").val();
    var branch_status = $("#update_branch_status").val();
    console.log("branch" + branch_id);
    $("#branch_update_status").html("");

    if (
      branch_name == "" ||
      branch_name == null ||
      branch_name == "undefined" ||
      branch_name == undefined
    ) {
      $("#branch_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Branch is required.</div>"
      );
      $("#branch_name").focus();
      return false;
    }

    $("#branch_update_status").html("");

    $("#btn_update_branch").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      branch_id: branch_id,
      branch_name: branch_name,
      branch_info: branch_info,
      branch_status: branch_status,
    };

    $.ajax({
      type: "post",
      url: base_url + "admin/branch-update-process",
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
          $("#btn_update_branch").attr("disabled", false);
          $("#branch_update_status").html(
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
