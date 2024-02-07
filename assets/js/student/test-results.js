$(document).ready(function(){    
    
    // datatble initialization
    var dataTable = $('#test_records_list').DataTable( {
        order: [
            [1, 'desc']
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
            url :base_url+"student/test-results-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $("#test_records_list-error").html("");
                $("#test_records_list").append('<tbody class="test_records_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#test_records_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "test_records_master_id" },
            { "data": "test_date" },
            { "data": "is_attempted" },
            { "data": "marks_obtained" },
            { "data": "total_marks" },
            { "data": "no_of_right_questions" },
            { "data": "no_of_wrong_questions" },
            { "data": "created_date" }
        ]
    });

});