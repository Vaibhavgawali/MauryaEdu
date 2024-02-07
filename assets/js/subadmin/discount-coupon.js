$(document).ready(function(){

    $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });

    // Select2 by showing the search
	$('#course_master_id').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: ''
	});

	$('#update_course_master_id').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: ''
	});

    /*   Prevent entering charaters in number fields   */
    $("#disount_percent, #discount_amount, #no_of_times_coupon_use, #update_disount_percent, #update_discount_amount, #update_no_of_times_coupon_use").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
        {
            return false;
        }
    });

    //--- Open add test schedules modal
	$("#btn_add_discount_coupon_modal").click(function(){
		$("#add-discount-coupon-modal").modal('show');
	});

    $("#btn_add_discount_coupon").click(function(){
        var discount_coupon_code = $("#discount_coupon_code").val();
		var course_master_id = $("#course_master_id").val();
		var disount_percent = $("#disount_percent").val();
		var discount_amount = $("#discount_amount").val();
		var start_date = $("#start_date").val();
		var end_date = $("#end_date").val();
		var no_of_times_coupon_use = $("#no_of_times_coupon_use").val();
		var is_locked = $("#is_locked").val();

        $("#discount_coupon_add_status").html("");

		if(discount_coupon_code=='' || discount_coupon_code==null || discount_coupon_code=='undefined' || discount_coupon_code==undefined){
			$("#discount_coupon_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Coupon code is required.</div>");
			$("#discount_coupon_code").focus();
			return false;
		}

		if(course_master_id=='' || course_master_id==null || course_master_id=='undefined' || course_master_id==undefined){
			$("#discount_coupon_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Select course from list.</div>");
			$("#course_master_id").focus();
			return false;
		}

		if((disount_percent=='' || disount_percent==null || disount_percent=='undefined' || disount_percent==undefined) && (discount_amount=='' || discount_amount==null || discount_amount=='undefined' || discount_amount==undefined)){
			$("#discount_coupon_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Either discount % or discount amount is required.</div>");
			return false;
		}

        if(disount_percent!='' && discount_amount!=''){
            $("#discount_coupon_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>ERROR!</b> Either discount % or discount amount is required.<br> You can't use both discount percent & discount amount for one coupon code.</div>");
			return false;
        }

		if(no_of_times_coupon_use=='' || no_of_times_coupon_use==null || no_of_times_coupon_use=='undefined' || no_of_times_coupon_use==undefined){
			$("#discount_coupon_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Number of times coupon use is required.</div>");
			$("#no_of_times_coupon_use").focus();
			return false;
		}
        
        $("#discount_coupon_add_status").html("");

        $("#btn_add_discount_coupon").attr('disabled',true);

		$("#loader-spin").show();

        var data = {
            discount_coupon_code : discount_coupon_code,
            course_master_id : course_master_id,
            disount_percent : disount_percent,
            discount_amount : discount_amount,
            start_date : start_date,
            end_date : end_date,
            no_of_times_coupon_use : no_of_times_coupon_use,
            is_locked : is_locked
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/discount-coupon-add",
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
                    $("#btn_add_discount_coupon").attr('disabled',false);
                    $("#discount_coupon_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });
    
    // datatble initialization
    var dataTable = $('#discount_coupon_list').DataTable( {
        order: [
            [10, 'desc']
        ],
        dom: 'lBfrtip',
        "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        "columnDefs": [ { orderable: false, targets: [0,9,12] } ],
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
            url :base_url+"admin/discount-coupon-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $("#discount_coupon_list-error").html("");
                $("#discount_coupon_list").append('<tbody class="discount_coupon_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#discount_coupon_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "discount_coupon_master_id" },
            { "data": "discount_coupon_code" },
            { "data": "course_name" },
            { "data": "disount_percent" },
            { "data": "discount_amount" },
            { "data": "start_date" },
            { "data": "end_date" },
            { "data": "no_of_times_coupon_use" },
            { "data": "is_locked" },
            { "data": "discount_coupon_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    
    // fetch coupon details
    $('#discount_coupon_list tbody').on('click', '.edit_discount_coupon', function () {
        var discount_coupon_master_id = $(this).attr('id');
        var discount_coupon_code = $(this).attr('discount_coupon_code');
        var course_master_id = $(this).attr('course_master_id');
        var disount_percent = $(this).attr('disount_percent');
        var discount_amount = $(this).attr('discount_amount');
        var start_date = $(this).attr('start_date');
        var end_date = $(this).attr('end_date');
        var no_of_times_coupon_use = $(this).attr('no_of_times_coupon_use');
        var is_locked = $(this).attr('is_locked');
        var discount_coupon_status = $(this).attr('discount_coupon_status');

        $("#loader-spin").show();

        $("#update_discount_coupon_master_id").val('');
        $("#update_discount_coupon_code").val('');
        $("#update_course_master_id").val('');
        $("#update_disount_percent").val('');
        $("#update_discount_amount").val('');
        $("#update_start_date").val('');
        $("#update_end_date").val('');
        $("#update_no_of_times_coupon_use").val('');
        $("#update_is_locked").val('');
        $("#update_discount_coupon_status").val('');
        
        $("#update_discount_coupon_master_id").val(discount_coupon_master_id);
        $("#update_discount_coupon_code").val(discount_coupon_code);
        $("#update_course_master_id").val(course_master_id).trigger('change');        
        $("#update_disount_percent").val(disount_percent);
        $("#update_discount_amount").val(discount_amount);
        $("#update_start_date").val(start_date);
        $("#update_end_date").val(end_date);
        $("#update_no_of_times_coupon_use").val(no_of_times_coupon_use);
        $("#update_is_locked").val(is_locked);
        $("#update_discount_coupon_status").val(discount_coupon_status);

        $("#update_discount_coupon_code").attr('disabled',false);
        $("#update_course_master_id").attr('disabled',false); 
        $("#update_disount_percent").attr('disabled',false);
        $("#update_discount_amount").attr('disabled',false);
        $("#update_start_date").attr('disabled',false);
        $("#update_end_date").attr('disabled',false);
        $("#update_no_of_times_coupon_use").attr('disabled',false);
        $("#update_is_locked").attr('disabled',false);

        if(is_locked=='1' || is_locked==1){
            $("#update_discount_coupon_code").attr('disabled',true);
            $("#update_course_master_id").attr('disabled',true); 
            $("#update_disount_percent").attr('disabled',true);
            $("#update_discount_amount").attr('disabled',true);
            $("#update_start_date").attr('disabled',true);
            $("#update_end_date").attr('disabled',true);
            $("#update_no_of_times_coupon_use").attr('disabled',true);
            $("#update_is_locked").attr('disabled',true);
        }

        $("#update-discount-coupon-modal").modal('show');

        $("#loader-spin").hide();
        
    });

    $("#btn_update_discount_coupon").click(function(){
        var discount_coupon_master_id = $("#update_discount_coupon_master_id").val();
		var discount_coupon_code = $("#update_discount_coupon_code").val();
		var course_master_id = $("#update_course_master_id").val();
		var disount_percent = $("#update_disount_percent").val();
		var discount_amount = $("#update_discount_amount").val();
		var start_date = $("#update_start_date").val();
		var end_date = $("#update_end_date").val();
		var no_of_times_coupon_use = $("#update_no_of_times_coupon_use").val();
		var is_locked = $("#update_is_locked").val();
		var discount_coupon_status = $("#update_discount_coupon_status").val();

        $("#discount_coupon_update_status").html("");

		if(discount_coupon_code=='' || discount_coupon_code==null || discount_coupon_code=='undefined' || discount_coupon_code==undefined){
			$("#discount_coupon_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Coupon code is required.</div>");
			$("#update_discount_coupon_code").focus();
			return false;
		}

		if(course_master_id=='' || course_master_id==null || course_master_id=='undefined' || course_master_id==undefined){
			$("#discount_coupon_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Select course from list.</div>");
			$("#update_course_master_id").focus();
			return false;
		}

		if((disount_percent=='' || disount_percent==null || disount_percent=='undefined' || disount_percent==undefined) && (discount_amount=='' || discount_amount==null || discount_amount=='undefined' || discount_amount==undefined)){
			$("#discount_coupon_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Either discount % or discount amount is required.</div>");
			return false;
		}

        if(disount_percent!='' && discount_amount!=''){
            $("#discount_coupon_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>ERROR!</b> Either discount % or discount amount is required.<br> You can't use both discount percent & discount amount for one coupon code.</div>");
			return false;
        }

		if(no_of_times_coupon_use=='' || no_of_times_coupon_use==null || no_of_times_coupon_use=='undefined' || no_of_times_coupon_use==undefined){
			$("#discount_coupon_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Number of times coupon use is required.</div>");
			$("#update_no_of_times_coupon_use").focus();
			return false;
		}
        
        $("#discount_coupon_update_status").html("");

        $("#btn_update_discount_coupon").attr('disabled',true);

		$("#loader-spin").show();

        var data = {
            discount_coupon_master_id : discount_coupon_master_id,
            discount_coupon_code : discount_coupon_code,
            course_master_id : course_master_id,
            disount_percent : disount_percent,
            discount_amount : discount_amount,
            start_date : start_date,
            end_date : end_date,
            no_of_times_coupon_use : no_of_times_coupon_use,
            is_locked : is_locked,
            discount_coupon_status : discount_coupon_status
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/discount-coupon-update",
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
                    $("#btn_update_discount_coupon").attr('disabled',false);
                    $("#discount_coupon_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });

});