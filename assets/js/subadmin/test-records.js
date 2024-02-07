$(document).ready(function(){

    $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });
    

    // Select2 by showing the search
	$('#student_id').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: ''
	});
	$('#update_student_id').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: ''
	});

    //--- Open add test records modal
	$("#btn_add_test_records_modal").click(function(){
		$("#add-test-records-modal").modal('show');
	});

    $("#btn_add_test_records").click(function(){
        var student_id = $("#student_id").val();
		var test_date = $("#test_date").val();
		var is_attempted = $('input[name="is_attempted"]:checked').val();
		var marks_obtained = $("#marks_obtained").val();
		var total_marks = $("#total_marks").val();
		var no_of_right_questions = $("#no_of_right_questions").val();
		var no_of_wrong_questions = $("#no_of_wrong_questions").val();

        $("#test_records_add_status").html("");

		if(student_id=='' || student_id==null || student_id=='undefined' || student_id==undefined){
			$("#test_records_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select student from list.</div>");
			$("#student_id").focus();
			return false;
		}

		if(test_date=='' || test_date==null || test_date=='undefined' || test_date==undefined){
			$("#test_records_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test date is required.</div>");
			$("#test_date").focus();
			return false;
		}

		if(is_attempted=='' || is_attempted==null || is_attempted=='undefined' || is_attempted==undefined){
			$("#test_records_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select test attempted or not.</div>");
			return false;
		}

		if(marks_obtained=='' || marks_obtained==null || marks_obtained=='undefined' || marks_obtained==undefined){
			$("#test_records_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Marks obtained is required.</div>");
			$("#marks_obtained").focus();
			return false;
		}

		if(total_marks=='' || total_marks==null || total_marks=='undefined' || total_marks==undefined){
			$("#test_records_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Total Marks required.</div>");
			$("#total_marks").focus();
			return false;
		}

		if(no_of_right_questions=='' || no_of_right_questions==null || no_of_right_questions=='undefined' || no_of_right_questions==undefined){
			$("#test_records_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Right questions is required.</div>");
			$("#no_of_right_questions").focus();
			return false;
		}

		if(no_of_wrong_questions=='' || no_of_wrong_questions==null || no_of_wrong_questions=='undefined' || no_of_wrong_questions==undefined){
			$("#test_records_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Wrong questions is required.</div>");
			$("#no_of_wrong_questions").focus();
			return false;
		}
        
        $("#test_records_add_status").html("");

        $("#btn_add_test_records").attr('disabled',true);

		$("#loader-spin").show();

        var data = {
            student_id : student_id,
            test_date : test_date,
            is_attempted : is_attempted,
            marks_obtained : marks_obtained,
            total_marks : total_marks,
            no_of_right_questions : no_of_right_questions,
            no_of_wrong_questions : no_of_wrong_questions
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/test-records-add",
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
                    $("#btn_add_test_records").attr('disabled',false);
                    $("#test_records_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // datatble initialization
    var dataTable = $('#test_records_list').DataTable( {
        order: [
            [0, 'desc']
        ],
        dom: 'lBfrtip',
        "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        "columnDefs": [ { orderable: false, targets: [8,11] } ],
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
            url :base_url+"admin/test-records-list-ajax",
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
            { "data": "full_name" },
            { "data": "test_date" },
            { "data": "is_attempted" },
            { "data": "marks_obtained" },
            { "data": "total_marks" },
            { "data": "no_of_right_questions" },
            { "data": "no_of_wrong_questions" },
            { "data": "test_records_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    
    // fetch test records details
    $('#test_records_list tbody').on('click', '.edit_test_records', function () {
        var test_records_master_id = $(this).attr('id');
        var student_id = $(this).attr('student_id');
        var test_date = $(this).attr('test_date');
        var is_attempted = $(this).attr('is_attempted');
        var marks_obtained = $(this).attr('marks_obtained');
        var total_marks = $(this).attr('total_marks');
        var no_of_right_questions = $(this).attr('no_of_right_questions');
        var no_of_wrong_questions = $(this).attr('no_of_wrong_questions');
        var test_records_status = $(this).attr('test_records_status');

        var status_html = null;
        if(test_records_status=="1"){
            status_html += "<option value='1' selected>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        else
        if(test_records_status=="0"){
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0' selected>In-Active</option>";
        }
        else{
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        
        $("#loader-spin").show();

        $("#update_test_records_master_id").val('');
        $("#update_student_id").val('');
        $("#update_test_date").val('');
        $("#is_attempted_yes").attr('checked', false);
        $("#is_attempted_no").attr('checked', false);
        $("#update_marks_obtained").val('');
        $("#update_total_marks").val('');
        $("#update_no_of_right_questions").val('');
        $("#update_no_of_wrong_questions").val('');
        $("#update_test_records_status").html('');
        
        
        $("#update_test_records_master_id").val(test_records_master_id);
        $("#update_student_id").select2('val', student_id);
        $("#update_test_date").val(test_date);

        if(is_attempted=='1' || is_attempted==1)
        {
            $("#is_attempted_yes").attr('checked', true);
        }
        if(is_attempted=='0' || is_attempted==0)
        {
            $("#is_attempted_no").attr('checked', true);
        }
        
        $("#update_marks_obtained").val(marks_obtained);
        $("#update_total_marks").val(total_marks);
        $("#update_no_of_right_questions").val(no_of_right_questions);
        $("#update_no_of_wrong_questions").val(no_of_wrong_questions);
        $("#update_test_records_status").html(status_html);

        $("#update-test-records-modal").modal('show');

        $("#loader-spin").hide();
        
    });

    $("#btn_update_test_records").click(function(){
        var test_records_master_id = $("#update_test_records_master_id").val();
		var student_id = $("#update_student_id").val();
		var test_date = $("#update_test_date").val();
		var is_attempted = $('input[name="update_is_attempted"]:checked').val();
		var marks_obtained = $("#update_marks_obtained").val();
		var total_marks = $("#update_total_marks").val();
		var no_of_right_questions = $("#update_no_of_right_questions").val();
		var no_of_wrong_questions = $("#update_no_of_wrong_questions").val();
		var test_records_status = $("#update_test_records_status").val();

        $("#test_records_update_status").html("");

		if(student_id=='' || student_id==null || student_id=='undefined' || student_id==undefined){
			$("#test_records_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select student from list.</div>");
			$("#student_id").focus();
			return false;
		}

		if(test_date=='' || test_date==null || test_date=='undefined' || test_date==undefined){
			$("#test_records_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Test date is required.</div>");
			$("#test_date").focus();
			return false;
		}

		if(is_attempted=='' || is_attempted==null || is_attempted=='undefined' || is_attempted==undefined){
			$("#test_records_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Please select test attempted or not.</div>");
			return false;
		}

		if(marks_obtained=='' || marks_obtained==null || marks_obtained=='undefined' || marks_obtained==undefined){
			$("#test_records_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Marks obtained is required.</div>");
			$("#marks_obtained").focus();
			return false;
		}

		if(total_marks=='' || total_marks==null || total_marks=='undefined' || total_marks==undefined){
			$("#test_records_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Total Marks required.</div>");
			$("#total_marks").focus();
			return false;
		}

		if(no_of_right_questions=='' || no_of_right_questions==null || no_of_right_questions=='undefined' || no_of_right_questions==undefined){
			$("#test_records_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Right questions is required.</div>");
			$("#no_of_right_questions").focus();
			return false;
		}

		if(no_of_wrong_questions=='' || no_of_wrong_questions==null || no_of_wrong_questions=='undefined' || no_of_wrong_questions==undefined){
			$("#test_records_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Wrong questions is required.</div>");
			$("#no_of_wrong_questions").focus();
			return false;
		}
        
        $("#test_records_update_status").html("");

        $("#btn_update_test_records").attr('disabled',true);

		$("#loader-spin").show();

        var data = {
            test_records_master_id : test_records_master_id,
            student_id : student_id,
            test_date : test_date,
            is_attempted : is_attempted,
            marks_obtained : marks_obtained,
            total_marks : total_marks,
            no_of_right_questions : no_of_right_questions,
            no_of_wrong_questions : no_of_wrong_questions,
            test_records_status : test_records_status
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/test-records-update",
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
                    $("#btn_update_test_records").attr('disabled',false);
                    $("#test_records_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // fetch test records details
    $('#test_records_list tbody').on('click', '.send_notification', function () {
        var test_records_master_id = $(this).attr('id');
        var student_id = $(this).attr('student_id');

        var data = {
            test_records_master_id: test_records_master_id,
            student_id : student_id
        };

        $.confirm({
		    title: 'Send test result notification!',
		    content: 'Are you sure you want to send test result notification?',

		    buttons: {
		        confirm: function () {	
                    $("#loader-spin").show();	            
			        $.ajax({
                        type: "post",
                        url:base_url+"admin/send-test-result-notification",
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