$(document).ready(function(){
    
    // datatble initialization
    var dataTable = $('#pt_meetings_list').DataTable( {
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
            url :base_url+"student/pt-meetings-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $("#pt_meetings_list-error").html("");
                $("#pt_meetings_list").append('<tbody class="pt_meetings_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#pt_meetings_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "pt_meetings_master_id" },
            { "data": "course_category_name" },
            { "data": "pt_meetings_title" },
            { "data": "pt_meetings_date_time" },
            { "data": "created_date" },
            { "data": "updated_date" }
        ]
    });

});