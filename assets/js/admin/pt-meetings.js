$(document).ready(function(){

    $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });

    $('#pt_meetings_time').timepicker({
		'scrollDefault': 'now'
	});

    $('#update_pt_meetings_time').timepicker();

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
	$("#btn_add_pt_meetings_modal").click(function(){
		$("#add-pt-meetings-modal").modal('show');
	});

    $("#btn_add_pt_meetings").click(function(){
        var course_category_id = $("#course_category_id").val();
		var pt_meetings_title = $("#pt_meetings_title").val();
		var pt_meetings_description = $("#pt_meetings_description").val();
		var pt_meetings_date = $("#pt_meetings_date").val();
		var pt_meetings_time = $("#pt_meetings_time").val();

        $("#pt_meetings_add_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#pt_meetings_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select atleast one course category from list.</div>");
			$("#course_category_id").focus();
			return false;
		}

		if(pt_meetings_title=='' || pt_meetings_title==null || pt_meetings_title=='undefined' || pt_meetings_title==undefined){
			$("#pt_meetings_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Parent teacher meeting title is required.</div>");
			$("#pt_meetings_title").focus();
			return false;
		}

		if(pt_meetings_date=='' || pt_meetings_date==null || pt_meetings_date=='undefined' || pt_meetings_date==undefined){
			$("#pt_meetings_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Parent teacher meeting date is required.</div>");
			$("#pt_meetings_date").focus();
			return false;
		}

		if(pt_meetings_time=='' || pt_meetings_time==null || pt_meetings_time=='undefined' || pt_meetings_time==undefined){
			$("#pt_meetings_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Parent teacher meeting time is required.</div>");
			$("#pt_meetings_time").focus();
			return false;
		}
        
        $("#pt_meetings_add_status").html("");

        $("#btn_add_pt_meetings").attr('disabled',true);

		$("#loader-spin").show();

        course_category_id = course_category_id.toString();

        var data = {
            course_category_id : course_category_id,
            pt_meetings_title : pt_meetings_title,
            pt_meetings_description : pt_meetings_description,
            pt_meetings_date : pt_meetings_date,
            pt_meetings_time : pt_meetings_time
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/pt-meetings-add",
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
                    $("#btn_add_pt_meetings").attr('disabled',false);
                    $("#pt_meetings_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // datatble initialization
    var dataTable = $('#pt_meetings_list').DataTable( {
        order: [
            [0, 'desc']
        ],
        dom: 'lBfrtip',
        "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        "columnDefs": [ { orderable: false, targets: [4,7] } ],
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
            url :base_url+"admin/pt-meetings-list-ajax",
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
            { "data": "pt_meetings_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    
    // fetch test schedule details
    $('#pt_meetings_list tbody').on('click', '.edit_pt_meetings', function () {
        var pt_meetings_master_id = $(this).attr('id');
        var course_category_id = $(this).attr('course_category_id');
        var pt_meetings_title = $(this).attr('pt_meetings_title');
        var pt_meetings_description = $(this).attr('pt_meetings_description');
        var pt_meetings_date = $(this).attr('pt_meetings_date');
        var pt_meetings_time = $(this).attr('pt_meetings_time');
        var pt_meetings_status = $(this).attr('pt_meetings_status');

        var status_html = null;
        if(pt_meetings_status=="1"){
            status_html += "<option value='1' selected>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        else
        if(pt_meetings_status=="0"){
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0' selected>In-Active</option>";
        }
        else{
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        
        $("#loader-spin").show();

        $("#update_pt_meetings_master_id").val('');
        $("#update_course_category_id").val('');
        $("#update_pt_meetings_title").val('');
        $("#update_pt_meetings_description").val('');
        $("#update_pt_meetings_date").val('');
        $("#update_pt_meetings_time").val('');
        $("#update_pt_meetings_status").html('');
        
        var course_category_idArr = course_category_id.split(',');
        
        $("#update_pt_meetings_master_id").val(pt_meetings_master_id);
        $("#update_course_category_id").val(course_category_idArr).trigger('change');
        $("#update_pt_meetings_title").val(pt_meetings_title);        
        $("#update_pt_meetings_description").val(pt_meetings_description);
        $("#update_pt_meetings_date").val(pt_meetings_date);        
        $("#update_pt_meetings_time").val(pt_meetings_time);
        $("#update_pt_meetings_status").html(status_html);

        $("#update-pt-meetings-modal").modal('show');

        $("#loader-spin").hide();
        
    });

    $("#btn_update_pt_meetings").click(function(){
        var pt_meetings_master_id = $("#update_pt_meetings_master_id").val();
		var course_category_id = $("#update_course_category_id").val();
		var pt_meetings_title = $("#update_pt_meetings_title").val();
		var pt_meetings_description = $("#update_pt_meetings_description").val();
		var pt_meetings_date = $("#update_pt_meetings_date").val();
		var pt_meetings_time = $("#update_pt_meetings_time").val();
		var pt_meetings_status = $("#update_pt_meetings_status").val();

        $("#pt_meetings_update_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#pt_meetings_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select atleast one course category from list.</div>");
			$("#update_course_category_id").focus();
			return false;
		}

		if(pt_meetings_title=='' || pt_meetings_title==null || pt_meetings_title=='undefined' || pt_meetings_title==undefined){
			$("#pt_meetings_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Parent teacher meeting title is required.</div>");
			$("#update_pt_meetings_title").focus();
			return false;
		}

		if(pt_meetings_date=='' || pt_meetings_date==null || pt_meetings_date=='undefined' || pt_meetings_date==undefined){
			$("#pt_meetings_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Parent teacher meeting date is required.</div>");
			$("#update_pt_meetings_date").focus();
			return false;
		}

		if(pt_meetings_time=='' || pt_meetings_time==null || pt_meetings_time=='undefined' || pt_meetings_time==undefined){
			$("#pt_meetings_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Parent teacher meeting time is required.</div>");
			$("#update_pt_meetings_time").focus();
			return false;
		}
        
        $("#pt_meetings_update_status").html("");

        $("#btn_update_pt_meetings").attr('disabled',true);

		$("#loader-spin").show();

        course_category_id = course_category_id.toString();

        var data = {
            pt_meetings_master_id : pt_meetings_master_id,
            course_category_id : course_category_id,
            pt_meetings_title : pt_meetings_title,
            pt_meetings_description : pt_meetings_description,
            pt_meetings_date : pt_meetings_date,
            pt_meetings_time : pt_meetings_time,
            pt_meetings_status : pt_meetings_status
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/pt-meetings-update",
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
                    $("#btn_update_pt_meetings").attr('disabled',false);
                    $("#pt_meetings_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // fetch test schedule details
    $('#pt_meetings_list tbody').on('click', '.send_notification_pt_meetings', function () {
        var pt_meetings_master_id = $(this).attr('id');
        var course_category_id = $(this).attr('course_category_id');

        var data = {
            pt_meetings_master_id: pt_meetings_master_id,
            course_category_id : course_category_id
        };

        $.confirm({
		    title: 'Send parent teacher meeting notification!',
		    content: 'Are you sure you want to send parent teacher meeting notification?',

		    buttons: {
		        confirm: function () {	
                    $("#loader-spin").show();	            
			        $.ajax({
                        type: "post",
                        url:base_url+"admin/pt-meetings-send-notification",
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