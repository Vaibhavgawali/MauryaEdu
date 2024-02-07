$(document).ready(function () {
  //--- Open add branch modal
  $("#btn_add_branch_modal").click(function () {
    $("#add-branch-modal").modal("show");
  });

  $("#branch_contact").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  $("#update_branch_contact").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  // add branch category
  $("#btn_add_branch").click(function () {
    var branch_name = $("#branch_name").val();
    var branch_emailid = $("#branch_emailid").val();
    var branch_contact = $("#branch_contact").val();
    var branch_address = $("#branch_address").val();
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

    if (
      branch_emailid == "" ||
      branch_emailid == null ||
      branch_emailid == "undefined" ||
      branch_emailid == undefined
    ) {
      $("#branch_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>"
      );
      $("#branch_emailid").focus();
      return false;
    }

    function validateEmail($branch_emailid) {
      var emailReg = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
      return emailReg.test($branch_emailid);
    }

    if (!validateEmail(branch_emailid)) {
      $("#branch_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Email is invalid.</div>"
      );
      $("#branch_emailid").focus();
      return false;
    }

    if (
      branch_contact == "" ||
      branch_contact == null ||
      branch_contact == "undefined" ||
      branch_contact == undefined
    ) {
      $("#branch_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Contact is required.</div>"
      );
      $("#branch_contact").focus();
      return false;
    }

    if (branch_contact.length !== 10) {
      $("#branch_admin_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Contact is invalid.</div>"
      );
      $("#branch_contact").focus();
      return false;
    }

    if (
      branch_address == "" ||
      branch_address == null ||
      branch_address == "undefined" ||
      branch_address == undefined
    ) {
      $("#branch_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Address is required.</div>"
      );
      $("#branch_address").focus();
      return false;
    }

    $("#branch_add_status").html("");

    $("#btn_add_branch").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      branch_name: branch_name,
      branch_emailid: branch_emailid,
      branch_contact: branch_contact,
      branch_address: branch_address,
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
      { data: "branch_emailid" },
      { data: "branch_contact" },
      { data: "branch_address" },
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
          $("#update_branch_emailid").val(res.branch_details.branch_emailid);
          $("#update_branch_contact").val(res.branch_details.branch_contact);
          $("#update_branch_address").val(res.branch_details.branch_address);
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
    var branch_emailid = $("#update_branch_emailid").val();
    var branch_contact = $("#update_branch_contact").val();
    var branch_address = $("#update_branch_address").val();
    var branch_info = $("#update_branch_info").val();
    var branch_status = $("#update_branch_status").val();
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
      $("#update_branch_name").focus();
      return false;
    }

    if (
      branch_emailid == "" ||
      branch_emailid == null ||
      branch_emailid == "undefined" ||
      branch_emailid == undefined
    ) {
      $("#branch_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>"
      );
      $("#update_branch_emailid").focus();
      return false;
    }

    function validateEmail($branch_emailid) {
      var emailReg = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
      return emailReg.test($branch_emailid);
    }

    if (!validateEmail(branch_emailid)) {
      $("#branch_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Email is invalid.</div>"
      );
      $("#update_branch_emailid").focus();
      return false;
    }

    if (
      branch_contact == "" ||
      branch_contact == null ||
      branch_contact == "undefined" ||
      branch_contact == undefined
    ) {
      $("#branch_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Contact is required.</div>"
      );
      $("#update_branch_contact").focus();
      return false;
    }

    if (branch_contact.length !== 10) {
      $("#branch_admin_add_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Contact is invalid.</div>"
      );
      $("#update_branch_contact").focus();
      return false;
    }

    if (
      branch_address == "" ||
      branch_address == null ||
      branch_address == "undefined" ||
      branch_address == undefined
    ) {
      $("#branch_update_status").html(
        "<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Adress is required.</div>"
      );
      $("#update_branch_address").focus();
      return false;
    }

    $("#branch_update_status").html("");

    $("#btn_update_branch").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      branch_id: branch_id,
      branch_name: branch_name,
      branch_emailid: branch_emailid,
      branch_contact: branch_contact,
      branch_address: branch_address,
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
