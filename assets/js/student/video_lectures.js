$(document).ready(function(){
     
    // datatble initialization
    var dataTable = $('#data_list').DataTable( {
        order: [
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
            url :base_url+"student/video-lecture-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $("#data_list-error").html("");
                $("#data_list").append('<tbody class="data_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#data_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "course_master_id" },
            { "data": "course_category_name" },
            { "data": "course_name" },
            { "data": "video_title" },
            { "data": "video_link" },
            { "data": "valid_upto" },
            { "data": "uploaded_date" },
        ]
    });

});