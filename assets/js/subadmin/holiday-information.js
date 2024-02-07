$(document).ready(function(){

    $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });

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
	$("#btn_add_holiday_information_modal").click(function(){
		$("#add-holiday-information-modal").modal('show');
	});

    $("#btn_add_holiday_information").click(function(){
        var course_category_id = $("#course_category_id").val();
		var holiday_information_title = $("#holiday_information_title").val();
		var holiday_information_description = $("#holiday_information_description").val();
		var holiday_information_from_date = $("#holiday_information_from_date").val();
		var holiday_information_to_date = $("#holiday_information_to_date").val();

        $("#holiday_information_add_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#holiday_information_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select atleast one course category from list.</div>");
			$("#course_category_id").focus();
			return false;
		}

		if(holiday_information_title=='' || holiday_information_title==null || holiday_information_title=='undefined' || holiday_information_title==undefined){
			$("#holiday_information_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Holiday information title is required.</div>");
			$("#holiday_information_title").focus();
			return false;
		}

		if(holiday_information_from_date=='' || holiday_information_from_date==null || holiday_information_from_date=='undefined' || holiday_information_from_date==undefined){
			$("#holiday_information_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> From date is required.</div>");
			$("#holiday_information_from_date").focus();
			return false;
		}

		if(holiday_information_to_date=='' || holiday_information_to_date==null || holiday_information_to_date=='undefined' || holiday_information_to_date==undefined){
			$("#holiday_information_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> To date is required.</div>");
			$("#holiday_information_to_date").focus();
			return false;
		}
        
        $("#holiday_information_add_status").html("");

        $("#btn_add_holiday_information").attr('disabled',true);

		$("#loader-spin").show();

        course_category_id = course_category_id.toString();

        var data = {
            course_category_id : course_category_id,
            holiday_information_title : holiday_information_title,
            holiday_information_description : holiday_information_description,
            holiday_information_from_date : holiday_information_from_date,
            holiday_information_to_date : holiday_information_to_date
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/holiday-information-add",
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
                    $("#btn_add_holiday_information").attr('disabled',false);
                    $("#holiday_information_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // datatble initialization
    var dataTable = $('#holiday_information_list').DataTable( {
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
            url :base_url+"admin/holiday-information-list-ajax",
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
            { "data": "holiday_information_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    
    // fetch test schedule details
    $('#holiday_information_list tbody').on('click', '.edit_holiday_information', function () {
        var holiday_information_master_id = $(this).attr('id');
        var course_category_id = $(this).attr('course_category_id');
        var holiday_information_title = $(this).attr('holiday_information_title');
        var holiday_information_description = $(this).attr('holiday_information_description');
        var holiday_information_from_date = $(this).attr('holiday_information_from_date');
        var holiday_information_to_date = $(this).attr('holiday_information_to_date');
        var holiday_information_status = $(this).attr('holiday_information_status');

        var status_html = null;
        if(holiday_information_status=="1"){
            status_html += "<option value='1' selected>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        else
        if(holiday_information_status=="0"){
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0' selected>In-Active</option>";
        }
        else{
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        
        $("#loader-spin").show();

        $("#update_holiday_information_master_id").val('');
        $("#update_course_category_id").val('');
        $("#update_holiday_information_title").val('');
        $("#update_holiday_information_description").val('');
        $("#update_holiday_information_from_date").val('');
        $("#update_holiday_information_to_date").val('');
        $("#update_holiday_information_status").html('');
        
        var course_category_idArr = course_category_id.split(',');
        
        $("#update_holiday_information_master_id").val(holiday_information_master_id);
        $("#update_course_category_id").val(course_category_idArr).trigger('change');
        $("#update_holiday_information_title").val(holiday_information_title);        
        $("#update_holiday_information_description").val(holiday_information_description);
        $("#update_holiday_information_from_date").val(holiday_information_from_date);        
        $("#update_holiday_information_to_date").val(holiday_information_to_date);
        $("#update_holiday_information_status").html(status_html);

        $("#update-holiday-information-modal").modal('show');

        $("#loader-spin").hide();
        
    });

    $("#btn_update_holiday_information").click(function(){
        var holiday_information_master_id = $("#update_holiday_information_master_id").val();
		var course_category_id = $("#update_course_category_id").val();
		var holiday_information_title = $("#update_holiday_information_title").val();
		var holiday_information_description = $("#update_holiday_information_description").val();
		var holiday_information_from_date = $("#update_holiday_information_from_date").val();
		var holiday_information_to_date = $("#update_holiday_information_to_date").val();
		var holiday_information_status = $("#update_holiday_information_status").val();

        $("#holiday_information_update_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#holiday_information_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select atleast one course category from list.</div>");
			$("#update_course_category_id").focus();
			return false;
		}

		if(holiday_information_title=='' || holiday_information_title==null || holiday_information_title=='undefined' || holiday_information_title==undefined){
			$("#holiday_information_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Holiday information title is required.</div>");
			$("#update_holiday_information_title").focus();
			return false;
		}

		if(holiday_information_from_date=='' || holiday_information_from_date==null || holiday_information_from_date=='undefined' || holiday_information_from_date==undefined){
			$("#holiday_information_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Holiday information visibility date is required.</div>");
			$("#update_holiday_information_from_date").focus();
			return false;
		}

		if(holiday_information_to_date=='' || holiday_information_to_date==null || holiday_information_to_date=='undefined' || holiday_information_to_date==undefined){
			$("#holiday_information_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Holiday information visibility time is required.</div>");
			$("#update_holiday_information_to_date").focus();
			return false;
		}
        
        $("#holiday_information_update_status").html("");

        $("#btn_update_holiday_information").attr('disabled',true);

		$("#loader-spin").show();

        course_category_id = course_category_id.toString();

        var data = {
            holiday_information_master_id : holiday_information_master_id,
            course_category_id : course_category_id,
            holiday_information_title : holiday_information_title,
            holiday_information_description : holiday_information_description,
            holiday_information_from_date : holiday_information_from_date,
            holiday_information_to_date : holiday_information_to_date,
            holiday_information_status : holiday_information_status
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/holiday-information-update",
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
                    $("#btn_update_holiday_information").attr('disabled',false);
                    $("#holiday_information_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // fetch test schedule details
    $('#holiday_information_list tbody').on('click', '.send_notification_holiday_information', function () {
        var holiday_information_master_id = $(this).attr('id');
        var course_category_id = $(this).attr('course_category_id');

        var data = {
            holiday_information_master_id: holiday_information_master_id,
            course_category_id : course_category_id
        };

        $.confirm({
		    title: 'Send holiday information notification!',
		    content: 'Are you sure you want to send holiday information notification?',

		    buttons: {
		        confirm: function () {	
                    $("#loader-spin").show();	            
			        $.ajax({
                        type: "post",
                        url:base_url+"admin/holiday-information-send-notification",
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