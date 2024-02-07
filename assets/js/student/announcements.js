$(document).ready(function(){
    
    // datatble initialization
    var dataTable = $('#announcements_list').DataTable( {
        order: [
            [4, 'desc'],
            [5, 'desc']
        ],
        dom: 'lBfrtip',
        "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        buttons: [
            {
                extend: 'collection',
                text: '<i class="fa fa-file"></i> Export',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ],
        "processing": true,
        "serverSide": true,
        "ajax":{
            url :base_url+"student/announcements-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $("#announcements_list-error").html("");
                $("#announcements_list").append('<tbody class="announcements_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#announcements_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "announcement_master_id" },
            { "data": "course_category_name" },
            { "data": "announcement_title" },
            { "data": "announcement_description" },
            { "data": "created_date" },
            { "data": "updated_date" }
        ]
    });

});