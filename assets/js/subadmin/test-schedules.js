$(document).ready(function(){

    $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });

    $('#test_schedule_time').timepicker({
		'scrollDefault': 'now'
	});

    $('#update_test_schedule_time').timepicker();

    // Select2 by showing the search
	$('#course_category_id').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: ''
	});

	$('#update_course_category_id').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: ''
	});

    //--- Open add test schedules modal
	$("#btn_add_test_schedules_modal").click(function(){
		$("#add-test-schedules-modal").modal('show');
	});

    $("#btn_add_test_schedules").click(function(){
        var course_category_id = $("#course_category_id").val();
		var test_schedule_title = $("#test_schedule_title").val();
		var test_schedule_link = $("#test_schedule_link").val();
		var test_schedule_date = $("#test_schedule_date").val();
		var test_schedule_time = $("#test_schedule_time").val();

        $("#test_schedules_add_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#test_schedules_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select atleast one course category from list.</div>");
			$("#course_category_id").focus();
			return false;
		}

		if(test_schedule_title=='' || test_schedule_title==null || test_schedule_title=='undefined' || test_schedule_title==undefined){
			$("#test_schedules_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test schedule title is required.</div>");
			$("#test_schedule_title").focus();
			return false;
		}

		if(test_schedule_link=='' || test_schedule_link==null || test_schedule_link=='undefined' || test_schedule_link==undefined){
			$("#test_schedules_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test schedule llink is required.</div>");
			$("#test_schedule_link").focus();
			return false;
		}

		if(test_schedule_date=='' || test_schedule_date==null || test_schedule_date=='undefined' || test_schedule_date==undefined){
			$("#test_schedules_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test schedule visibility date is required.</div>");
			$("#test_schedule_date").focus();
			return false;
		}

		if(test_schedule_time=='' || test_schedule_time==null || test_schedule_time=='undefined' || test_schedule_time==undefined){
			$("#test_schedules_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test schedule visibility time is required.</div>");
			$("#test_schedule_time").focus();
			return false;
		}
        
        $("#test_schedules_add_status").html("");

        $("#btn_add_test_schedules").attr('disabled',true);

		$("#loader-spin").show();

        course_category_id = course_category_id.toString();

        var data = {
            course_category_id : course_category_id,
            test_schedule_title : test_schedule_title,
            test_schedule_link : test_schedule_link,
            test_schedule_date : test_schedule_date,
            test_schedule_time : test_schedule_time
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/test-schedules-add",
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
                    $("#btn_add_test_schedules").attr('disabled',false);
                    $("#test_schedules_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // datatble initialization
    var dataTable = $('#test_schedules_list').DataTable( {
        order: [
            [0, 'desc']
        ],
        dom: 'lBfrtip',
        "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        "columnDefs": [ { orderable: false, targets: [5,8] } ],
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
            url :base_url+"admin/test-schedules-list-ajax",
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
            { "data": "test_schedule_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    
    // fetch test schedule details
    $('#test_schedules_list tbody').on('click', '.edit_test_schedules', function () {
        var test_schedule_master_id = $(this).attr('id');
        var course_category_id = $(this).attr('course_category_id');
        var test_schedule_title = $(this).attr('test_schedule_title');
        var test_schedule_link = $(this).attr('test_schedule_link');
        var test_schedule_date = $(this).attr('test_schedule_date');
        var test_schedule_time = $(this).attr('test_schedule_time');
        var test_schedule_status = $(this).attr('test_schedule_status');

        var status_html = null;
        if(test_schedule_status=="1"){
            status_html += "<option value='1' selected>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        else
        if(test_schedule_status=="0"){
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0' selected>In-Active</option>";
        }
        else{
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        
        $("#loader-spin").show();

        $("#update_test_schedule_master_id").val('');
        $("#update_course_category_id").val('');
        $("#update_test_schedule_title").val('');
        $("#update_test_schedule_link").val('');
        $("#update_test_schedule_date").val('');
        $("#update_test_schedule_time").val('');
        $("#update_test_schedule_status").html('');
        
        var course_category_idArr = course_category_id.split(',');
        
        $("#update_test_schedule_master_id").val(test_schedule_master_id);
        $("#update_course_category_id").val(course_category_idArr).trigger('change');
        $("#update_test_schedule_title").val(test_schedule_title);        
        $("#update_test_schedule_link").val(test_schedule_link);
        $("#update_test_schedule_date").val(test_schedule_date);        
        $("#update_test_schedule_time").val(test_schedule_time);
        $("#update_test_schedule_status").html(status_html);

        $("#update-test-schedules-modal").modal('show');

        $("#loader-spin").hide();
        
    });

    $("#btn_update_test_schedules").click(function(){
        var test_schedule_master_id = $("#update_test_schedule_master_id").val();
		var course_category_id = $("#update_course_category_id").val();
		var test_schedule_title = $("#update_test_schedule_title").val();
		var test_schedule_link = $("#update_test_schedule_link").val();
		var test_schedule_date = $("#update_test_schedule_date").val();
		var test_schedule_time = $("#update_test_schedule_time").val();
		var test_schedule_status = $("#update_test_schedule_status").val();

        $("#test_schedules_update_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#test_schedules_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select atleast one course category from list.</div>");
			$("#update_course_category_id").focus();
			return false;
		}

		if(test_schedule_title=='' || test_schedule_title==null || test_schedule_title=='undefined' || test_schedule_title==undefined){
			$("#test_schedules_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test schedule title is required.</div>");
			$("#update_test_schedule_title").focus();
			return false;
		}

		if(test_schedule_link=='' || test_schedule_link==null || test_schedule_link=='undefined' || test_schedule_link==undefined){
			$("#test_schedules_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test schedule link is required.</div>");
			$("#update_test_schedule_link").focus();
			return false;
		}

		if(test_schedule_date=='' || test_schedule_date==null || test_schedule_date=='undefined' || test_schedule_date==undefined){
			$("#test_schedules_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test schedule visibility date is required.</div>");
			$("#update_test_schedule_date").focus();
			return false;
		}

		if(test_schedule_time=='' || test_schedule_time==null || test_schedule_time=='undefined' || test_schedule_time==undefined){
			$("#test_schedules_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test schedule visibility time is required.</div>");
			$("#update_test_schedule_time").focus();
			return false;
		}
        
        $("#test_schedules_update_status").html("");

        $("#btn_update_test_schedules").attr('disabled',true);

		$("#loader-spin").show();

        course_category_id = course_category_id.toString();

        var data = {
            test_schedule_master_id : test_schedule_master_id,
            course_category_id : course_category_id,
            test_schedule_title : test_schedule_title,
            test_schedule_link : test_schedule_link,
            test_schedule_date : test_schedule_date,
            test_schedule_time : test_schedule_time,
            test_schedule_status : test_schedule_status
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/test-schedules-update",
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
                    $("#btn_update_test_schedules").attr('disabled',false);
                    $("#test_schedules_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // test schedule notification
    $('#test_schedules_list tbody').on('click', '.send_notification_test_schedule', function () {
        var test_schedule_master_id = $(this).attr('id');
        var course_category_id = $(this).attr('course_category_id');

        var data = {
            test_schedule_master_id: test_schedule_master_id,
            course_category_id : course_category_id
        };

        $.confirm({
		    title: 'Send test schedule notification!',
		    content: 'Are you sure you want to send test schedule notification?',

		    buttons: {
		        confirm: function () {	
                    $("#loader-spin").show();	            
			        $.ajax({
                        type: "post",
                        url:base_url+"admin/test-schedule-send-notification",
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
                                generateNotification('error', res.message);
                                return false;
                            }
                        }
                    });
		        },
		        cancel: function () {
		            $(this).hide();
		        }		        
		    }

		});
    });

});