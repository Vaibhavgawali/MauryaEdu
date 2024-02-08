$(document).ready(function () {
  //--- Open add branch admin modal
  $("#btn_add_branch_admin_modal").click(function () {
    $("#add-branch-admin-modal").modal("show");
  });
  $('.modal-close').click(function(){
    $("#add-branch-admin-modal").modal("hide");
  })

  $("#admin_contact").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  $("#update_branch_admin_contact").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });

  // add branch admin
  $("#btn_add_branch_admin").click(function () {
    var admin_name = $("#admin_name").val();
    var branch_id = $("#branch_id").val();
    var admin_emailid = $("#admin_emailid").val();
    var admin_contact = $("#admin_contact").val();

    $("#branch_admin_add_status").html("");

    if (
      admin_name == "" ||
      admin_name == null ||
      admin_name == "undefined" ||
      admin_name == undefined
    ) {
      $("#branch_admin_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Name is required.</div>"
      );
      $("#admin_name").focus();
      return false;
    }

    if (
      branch_id == "" ||
      branch_id == null ||
      branch_id == "undefined" ||
      branch_id == undefined
    ) {
      $("#branch_admin_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Branch is required.</div>"
      );
      $("#branch_id").focus();
      return false;
    }

    if (
      admin_emailid == "" ||
      admin_emailid == null ||
      admin_emailid == "undefined" ||
      admin_emailid == undefined
    ) {
      $("#branch_admin_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>"
      );
      $("#admin_emailid").focus();
      return false;
    }

    function validateEmail($admin_emailid) {
      var emailReg = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
      return emailReg.test($admin_emailid);
    }

    if (!validateEmail(admin_emailid)) {
      $("#branch_admin_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Email is invalid.</div>"
      );
      $("#admin_emailid").focus();
      return false;
    }

    if (
      admin_contact == "" ||
      admin_contact == null ||
      admin_contact == "undefined" ||
      admin_contact == undefined
    ) {
      $("#branch_admin_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Contact is required.</div>"
      );
      $("#admin_contact").focus();
      return false;
    }

    if (admin_contact.length !== 10) {
      $("#branch_admin_add_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Contact is invalid.</div>"
      );
      $("#admin_contact").focus();
      return false;
    }

    $("#branch_admin_add_status").html("");

    $("#btn_add_branch_admin").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      admin_name: admin_name,
      branch_id: branch_id,
      admin_emailid: admin_emailid,
      admin_contact: admin_contact,
    };

    $.ajax({
      type: "post",
      url: base_url + "admin/branch-admin-add-process",
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
          $("#btn_add_branch_admin").attr("disabled", false);
          $("#branch_admin_add_status").html(
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
  var dataTable = $("#branch_admin_list").DataTable({
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
      url: base_url + "admin/branch-admin-list-ajax",
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
      { data: "admin_id" },
      { data: "admin_name" },
      { data: "branch_name" },
      { data: "admin_emailid" },
      { data: "admin_contact" },
      { data: "status" },
      { data: "created_date" },
      { data: "updated_date" },
      { data: "action" },
    ],
  });

  // fetch branch admin info
  $("#branch_admin_list tbody").on("click", ".edit_branch_admin", function () {
    var branch_admin_id = $(this).attr("id");
    $("#loader-spin").show();

    $.ajax({
      type: "post",
      dataType: "json",
      url: base_url + "admin/get-branch-admin-detail",
      data: { branch_admin_id: branch_admin_id },
      success: function (res) {
        $("#loader-spin").hide();
        if (res.status == true) {
          $("#update_branch_admin_id").val(branch_admin_id);

          $("#update_branch_admin_name").val(
            res.branch_admin_details.admin_name
          );
          $("#update_branch_id").val(res.branch_admin_details.branch_id);
          $("#update_branch_admin_emailid").val(
            res.branch_admin_details.admin_emailid
          );
          $("#update_branch_admin_contact").val(
            res.branch_admin_details.admin_contact
          );
          $("#update_branch_admin_status").val(
            res.branch_admin_details.admin_status
          );
          $("#update-branch-admin-modal").modal("show");

          $('.modal-close').click(function(){
            $("#update-branch-admin-modal").modal("hide");
          })
        } else {
          generateNotification("error", res.message);
          return false;
        }
      },
    });
  });

  // update branch
  $("#btn_update_branch_admin").click(function () {
    var branch_admin_id = $("#update_branch_admin_id").val();
    var admin_name = $("#update_branch_admin_name").val();
    var branch_id = $("#update_branch_id").val();
    var admin_emailid = $("#update_branch_admin_emailid").val();
    var admin_contact = $("#update_branch_admin_contact").val();
    var admin_status = $("#update_branch_admin_status").val();
    $("#branch_admin_update_status").html("");

    if (
      admin_name == "" ||
      admin_name == null ||
      admin_name == "undefined" ||
      admin_name == undefined
    ) {
      $("#branch_admin_update_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Branch is required.</div>"
      );
      $("#update_branch_admin_name").focus();
      return false;
    }

    if (
      branch_id == "" ||
      branch_id == null ||
      branch_id == "undefined" ||
      branch_id == undefined
    ) {
      $("#branch_admin_update_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Branch is required.</div>"
      );
      $("#update_branch_id").focus();
      return false;
    }

    if (
      admin_emailid == "" ||
      admin_emailid == null ||
      admin_emailid == "undefined" ||
      admin_emailid == undefined
    ) {
      $("#branch_admin_update_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>"
      );
      $("#update_branch_admin_emailid").focus();
      return false;
    }

    if (
      admin_contact == "" ||
      admin_contact == null ||
      admin_contact == "undefined" ||
      admin_contact == undefined
    ) {
      $("#branch_admin_update_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Contact is required.</div>"
      );
      $("#update_branch_contact").focus();
      return false;
    }

    if (admin_contact.length !== 10) {
      $("#branch_admin_update_status").html(
        "<div class='alert alert-danger text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Contact is invalid.</div>"
      );
      $("#update_branch_admin_contact").focus();
      return false;
    }

    $("#branch_admin_update_status").html("");

    $("#btn_update_branch_admin").attr("disabled", true);

    $("#loader-spin").show();

    var data = {
      branch_admin_id: branch_admin_id,
      branch_id: branch_id,
      admin_name: admin_name,
      admin_emailid: admin_emailid,
      admin_contact: admin_contact,
      admin_status: admin_status,
    };

    $.ajax({
      type: "post",
      url: base_url + "admin/branch-admin-update-process",
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
          $("#branch_admin_update_status").html(
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

  // reset student password
  $("#branch_admin_list tbody").on(
    "click",
    ".reset_password_admin",
    function () {
      var branch_admin_id = $(this).attr("id");

      var data = {
        branch_admin_id: branch_admin_id,
      };

      $.confirm({
        title: "Reset Branch Admin Password!",
        content: "Are you sure you want to reset branch admin password?",

        buttons: {
          confirm: function () {
            $("#loader-spin").show();
            $.ajax({
              type: "post",
              url: base_url + "admin/reset-branch-admin-password",
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
