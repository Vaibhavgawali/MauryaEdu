$(document).ready(function(){
    
    // datatble initialization
    var dataTable = $('#test_schedules_list').DataTable( {
        order: [
            [0, 'desc']
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
            url :base_url+"student/test-schedules-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $("#test_schedules_list-error").html("");
                $("#test_schedules_list").append('<tbody class="test_schedules_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#test_schedules_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "test_schedule_master_id" },
            { "data": "course_category_name" },
            { "data": "test_schedule_title" },
            { "data": "test_schedule_link" },
            { "data": "test_schedule_date_time" },
            { "data": "created_date" }
        ]
    });

});