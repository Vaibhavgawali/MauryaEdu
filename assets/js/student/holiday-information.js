$(document).ready(function(){
    
    // datatble initialization
    var dataTable = $('#holiday_information_list').DataTable( {
        order: [
            [5, 'desc'],
            [6, 'desc']
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
            url :base_url+"student/holiday-information-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $("#holiday_information_list-error").html("");
                $("#holiday_information_list").append('<tbody class="holiday_information_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#holiday_information_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "holiday_information_master_id" },
            { "data": "course_category_name" },
            { "data": "holiday_information_title" },
            { "data": "holiday_information_from_date" },
            { "data": "holiday_information_to_date" },
            { "data": "created_date" },
            { "data": "updated_date" }
        ]
    });

});