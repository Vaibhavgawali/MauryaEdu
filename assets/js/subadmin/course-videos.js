$(document).ready(function(){
    
    //--- Open add chapter modal
	$("#btn_add_course_video_modal").click(function(){
		$("#add-course-video-modal").modal('show');
	});

    // add course video
    $("#btn_add_course_video_details").click(function(){
        var course_category_id = $("#course_category_id").val();
		var course_master_id = $("#course_master_id").val();
		var video_title = $("#video_title").val();
		var video_link = $("#video_link").val();
        
        $("#add_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>");
			$("#course_category_id").focus();
			return false;
		}

		if(course_master_id=='' || course_master_id==null || course_master_id=='undefined' || course_master_id==undefined){
			$("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>");
			$("#course_master_id").focus();
			return false;
		}

		if(video_title=='' || video_title==null || video_title=='undefined' || video_title==undefined){
			$("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Video title is required.</div>");
			$("#video_title").focus();
			return false;
		}

		if(video_link=='' || video_link==null || video_link=='undefined' || video_link==undefined){
			$("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Video link is required.</div>");
			$("#video_link").focus();
			return false;
		}

		$("#add_status").html("");

        $("#btn_add_course_video_details").attr('disabled',true);

		$("#loader-spin").show();

		var data = {
            course_category_id : course_category_id,
            course_master_id : course_master_id,
            video_title : video_title,
            video_link : video_link
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/course-videos-add-process",
            dataType:'json',
            data:data,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	generateNotification('success', res.message);
					setTimeout(function() { window.location.reload(true); }, 3500);
                }
                else{
                    $("#btn_add_course_video_details").attr('disabled',false);
                    $("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });

    // datatble initialization
    var dataTable = $('#course_video_list').DataTable( {
        order: [
            [0, 'desc']
        ],
        dom: 'lBfrtip',
        "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        "columnDefs": [ { orderable: false, targets: [0,4,7] } ],
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
            url :base_url+"admin/course-videos-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            data : function(d){
                d.course_master_id = $("#curr_course_master_id").val();
            },
            error: function(){  // error handling
                $("#course_video_list-error").html("");
                $("#course_video_list").append('<tbody class="course_video_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#course_video_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "course_video_master_id" },
            { "data": "course_category_name" },
            { "data": "course_name" },
            { "data": "video_link" },
            { "data": "video_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    
    // fetch chapter info
    $('#course_video_list tbody').on('click', '.edit_course_videos', function () {
        var course_video_master_id = $(this).attr('id');
        var video_title = $(this).attr('video_title');
        var video_link = $(this).attr('video_link');
        var video_status = $(this).attr('video_status');

        var status_html = null;
        if(video_status=="1"){
            status_html += "<option value='1' selected>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        else
        if(video_status=="0"){
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0' selected>In-Active</option>";
        }
        else{
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        
        $("#loader-spin").show();

        $("#update_course_video_master_id").val('');
        $("#update_video_title").val('');
        $("#update_video_link").val('');
        $("#update_video_status").html('');
        

        $("#update_course_video_master_id").val(course_video_master_id);
        $("#update_video_title").val(video_title);
        $("#update_video_link").val(video_link);
        $("#update_video_status").html(status_html);

        $("#update-course-video-modal").modal('show');

        $("#loader-spin").hide();
        
    });

    // update course videos
    $("#btn_update_course_video_details").click(function(){
        var course_video_master_id = $("#update_course_video_master_id").val();
		var course_category_id = $("#update_course_category_id").val();
		var course_master_id = $("#update_course_master_id").val();
		var video_title = $("#update_video_title").val();
		var video_link = $("#update_video_link").val();
		var video_status = $("#update_video_status").val();
        
        $("#update_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>");
			$("#update_course_category_id").focus();
			return false;
		}

		if(course_master_id=='' || course_master_id==null || course_master_id=='undefined' || course_master_id==undefined){
			$("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>");
			$("#update_course_master_id").focus();
			return false;
		}

		if(video_title=='' || video_title==null || video_title=='undefined' || video_title==undefined){
			$("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Video title name is required.</div>");
			$("#update_video_title").focus();
			return false;
		}

		if(video_link=='' || video_link==null || video_link=='undefined' || video_link==undefined){
			$("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Video link is required.</div>");
			$("#update_video_link").focus();
			return false;
		}

		$("#update_status").html("");

        $("#btn_update_course_video_details").attr('disabled',true);

		$("#loader-spin").show();

		var data = {
            course_video_master_id : course_video_master_id,
            course_category_id : course_category_id,
            course_master_id : course_master_id,
            video_title : video_title,
            video_link : video_link,
            video_status : video_status
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/course-videos-update-process",
            dataType:'json',
            data:data,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	generateNotification('success', res.message);
					setTimeout(function() { window.location.reload(true); }, 3500);
                }
                else{
                    $("#btn_update_course_video_details").attr('disabled',false);
                    $("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });

});