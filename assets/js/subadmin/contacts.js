$(document).ready(function () {
  // datatble initialization
  var dataTable = $("#contacts_list").DataTable({
    order: [[0, "desc"]],
    dom: "lBfrtip",
    lengthMenu: [
      [10, 25, 50, 99999999],
      [10, 25, 50, "All"],
    ],
    columnDefs: [{ orderable: false, targets: [5] }],
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
      url: base_url + "subadmin/contact-list-ajax",
      cache: false,
      type: "post", // method  , by default get
      error: function () {
        // error handling
        $("#contacts_list-error").html("");
        $("#contacts_list").append(
          '<tbody class="announcements_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
        );
        $("#contacts_list_processing").css("display", "none");
      },
    },
    columns: [
      { data: "id" },
      { data: "fullname" },
      { data: "email" },
      { data: "phone" },
      { data: "created_at" },
      { data: "action" },
    ],
  });

  //   delete contact
  $("#contacts_list tbody").on("click", ".delete_contact", function () {
    var contact_id = $(this).attr("id");
    var data = {
      contact_id: contact_id,
    };

    $.confirm({
      title: "Delete Contact !",
      content: "Are you sure you want to delete contact ?",

      buttons: {
        confirm: function () {
          $("#loader-spin").show();
          $.ajax({
            type: "post",
            url: base_url + "subadmin/contact-delete",
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
