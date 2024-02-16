$(document).ready(function () {
  // datatble initialization
  var dataTable = $("#certificate_list").DataTable({
    order: [[1, "asc"]],
    dom: "lBfrtip",
    lengthMenu: [
      [10, 25, 50, 99999999],
      [10, 25, 50, "All"],
    ],
    columnDefs: [{ orderable: false, targets: [0] }],
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
      url: base_url + "student/certificates-list-ajax",
      cache: false,
      type: "post", // method  , by default get
      error: function () {
        // error handling
        $("#certificate_list-error").html("");
        $("#certificate_list").append(
          '<tbody class="certificate_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
        );
        $("#certificate_list_processing").css("display", "none");
      },
    },
    columns: [
      { data: "certificate_id" },
      { data: "certificate_title" },
      { data: "course_name" },
      { data: "action" },
    ],
  });
});
