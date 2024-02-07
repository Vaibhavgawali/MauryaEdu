$(document).ready(function(){

    // Select2 by showing the search
	$('#course_category_id').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: ''
	});

	$('#update_course_category_id').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: ''
	});

    //--- Open add test records modal
	$("#btn_add_announcements_modal").click(function(){
		$("#add-announcements-modal").modal('show');
	});

    $("#btn_add_announcement").click(function(){
        var course_category_id = $("#course_category_id").val();
		var announcement_title = $("#announcement_title").val();
		var announcement_description = $("#announcement_description").val();
        
        $("#announcement_add_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#announcement_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Select at least one course category.</div>");
			$("#course_category_id").focus();
			return false;
		}

		if(announcement_title=='' || announcement_title==null || announcement_title=='undefined' || announcement_title==undefined){
			$("#announcement_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Title is required.</div>");
			$("#announcement_title").focus();
			return false;
		}

		if(announcement_description=='' || announcement_description==null || announcement_description=='undefined' || announcement_description==undefined){
			$("#announcement_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Announcement description is required.</div>");
			$("#announcement_description").focus();
			return false;
		}
        
        $("#announcement_add_status").html("");

        $("#btn_add_announcement").attr('disabled',true);

		$("#loader-spin").show();

        course_category_id = course_category_id.toString();

        var data = {
            course_category_id : course_category_id,
            announcement_title : announcement_title,
            announcement_description : announcement_description
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/announcements-add",
            dataType:'json',
            data:data,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	generateNotification('success', res.message);
					setTimeout(function() { location.reload(true); }, 3500);
                }
                else{
                    $("#btn_add_announcement").attr('disabled',false);
                    $("#announcement_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // datatble initialization
    var dataTable = $('#announcements_list').DataTable( {
        order: [
            [0, 'desc']
        ],
        dom: 'lBfrtip',
        "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        "columnDefs": [ { orderable: false, targets: [1,4,7] } ],
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
            url :base_url+"admin/announcements-list-ajax",
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
            { "data": "course_category_id" },
            { "data": "announcement_title" },
            { "data": "announcement_description" },
            { "data": "announcement_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    
    // fetch test records details
    $('#announcements_list tbody').on('click', '.edit_announcement', function () {
        var announcement_master_id = $(this).attr('id');
        var course_category_id = $(this).attr('course_category_id');
        var announcement_title = $(this).attr('announcement_title');
        var announcement_description = $(this).attr('announcement_description');
        var announcement_status = $(this).attr('announcement_status');

        var status_html = null;
        if(announcement_status=="1"){
            status_html += "<option value='1' selected>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        else
        if(announcement_status=="0"){
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0' selected>In-Active</option>";
        }
        else{
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        
        $("#loader-spin").show();

        $("#update_announcement_master_id").val('');
        $("#update_course_category_id").val('');
        $("#update_announcement_title").val('');
        $("#update_announcement_description").val('');
        $("#update_announcement_status").html('');
        
        var course_category_idArr = course_category_id.split(',');
        
        $("#update_announcement_master_id").val(announcement_master_id);
        $('#update_course_category_id').val(course_category_idArr).trigger('change');
        $("#update_announcement_title").val(announcement_title);
        $("#update_announcement_description").val(announcement_description);
        $("#update_announcement_status").html(status_html);

        // for(var i=0; i<course_category_idArr.length; i++){
        //     console.log(course_category_idArr[i]);
        //     $("#update_course_category_id").select2('val', course_category_idArr[i]);
        // }
        $("#update-announcement-modal").modal('show');

        $("#loader-spin").hide();
        
    });

    $("#btn_update_announcement").click(function(){
        var course_category_id = $("#update_course_category_id").val();
		var announcement_master_id = $("#update_announcement_master_id").val();
		var announcement_title = $("#update_announcement_title").val();
		var announcement_description = $("#update_announcement_description").val();
		var announcement_status = $("#update_announcement_status").val();

        $("#announcement_update_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#announcement_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Select atleast one course category.</div>");
			$("#course_category_id").focus();
			return false;
		}

		if(announcement_title=='' || announcement_title==null || announcement_title=='undefined' || announcement_title==undefined){
			$("#announcement_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Announcement title is required.</div>");
			$("#announcement_title").focus();
			return false;
		}

		if(announcement_description=='' || announcement_description==null || announcement_description=='undefined' || announcement_description==undefined){
			$("#announcement_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Announcement description is required.</div>");
			$("#announcement_description").focus();
			return false;
		}
        
        $("#announcement_update_status").html("");

        $("#btn_update_announcement").attr('disabled',true);

		$("#loader-spin").show();

        course_category_id = course_category_id.toString();

        var data = {
            announcement_master_id : announcement_master_id,
            course_category_id : course_category_id,
            announcement_title : announcement_title,
            announcement_description : announcement_description,
            announcement_status : announcement_status
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/announcements-update",
            dataType:'json',
            data:data,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	generateNotification('success', res.message);
					setTimeout(function() { location.reload(true); }, 3500);
                }
                else{
                    $("#btn_update_announcement").attr('disabled',false);
                    $("#announcement_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });

});