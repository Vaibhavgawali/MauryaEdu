$(document).ready(function(){
    
    //--- Open add chapter modal
	$("#btn_add_sub_chapter_modal").click(function(){
		$("#add-sub-chapter-modal").modal('show');
	});

    $("#course_category_id, #update_course_category_id").change(function(){

        $("#course_master_id").html("<option value='' selected>----- Select -----</option>");
        $("#update_course_master_id").html("<option value='' selected>----- Select -----</option>");

        var course_category_id = $(this).val();

        if(course_category_id!=''){
            $("#loader-spin").show();

            $.ajax({
                type:'post',
                dataType:'json',
                url:base_url+"admin/get-course-list-from-category", 
                data:{ course_category_id:course_category_id },
                success: function(res){
                    $("#loader-spin").hide(); 
                    if(res.status==true){
                        var course_details = res.course_details;

                        for(var i=0; i<course_details.length; i++){
                            var course_id = "";
                            var course_name = "";

                            course_id = course_details[i].course_master_id;
                            course_name = course_details[i].course_name;

                            $("#course_master_id").append("<option value='"+course_id+"'>"+course_name+"</option>");
                            $("#update_course_master_id").append("<option value='"+course_id+"'>"+course_name+"</option>");
                        }
                    }
                    else{
                        generateNotification('error', res.message);
                        return false;
                    }
                }
            });
        }

    });

    $("#course_master_id, #update_course_master_id").change(function(){

        $("#chapter_master_id").html("<option value='' selected>----- Select -----</option>");
        $("#update_chapter_master_id").html("<option value='' selected>----- Select -----</option>");

        var course_master_id = $(this).val();

        if(course_master_id!=''){
            $("#loader-spin").show();

            $.ajax({
                type:'post',
                dataType:'json',
                url:base_url+"admin/get-chapter-list-from-course", 
                data:{ course_master_id:course_master_id },
                success: function(res){
                    $("#loader-spin").hide(); 
                    if(res.status==true){
                        var chapter_details = res.chapter_details;

                        for(var i=0; i<chapter_details.length; i++){
                            var chapter_id = "";
                            var chapter_name = "";

                            chapter_id = chapter_details[i].chapter_master_id;
                            chapter_name = chapter_details[i].chapter_name;

                            $("#chapter_master_id").append("<option value='"+chapter_id+"'>"+chapter_name+"</option>");
                            $("#update_chapter_master_id").append("<option value='"+chapter_id+"'>"+chapter_name+"</option>");
                        }
                    }
                    else{
                        generateNotification('error', res.message);
                        return false;
                    }
                }
            });
        }

    });

    $("#btn_add_sub_chapter_details").click(function(){
        var course_category_id = $("#course_category_id").val();
        var course_master_id = $("#course_master_id").val();
        var chapter_master_id = $("#chapter_master_id").val();
        
        if(course_category_id=='' || course_category_id==null || course_category_id==undefined || course_category_id=='undefined'){

            $("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category required.</div>");
			return false;

        }

        if(course_master_id=='' || course_master_id==null || course_master_id==undefined || course_master_id=='undefined'){

            $("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course  is required.</div>");
			return false;

        }

        if(chapter_master_id=='' || chapter_master_id==null || chapter_master_id==undefined || chapter_master_id=='undefined'){

            $("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Chapter  is required.</div>");
			return false;

        }

        window.location.href=base_url+"admin/sub-chapter-list/"+chapter_master_id;
    });

    // add sub chapter
    $("#btn_add_sub_chapter").click(function(){
        var course_category_id = $("#course_category_id").val();
		var course_master_id = $("#course_master_id").val();
		var chapter_master_id = $("#chapter_master_id").val();
		var sub_chapter_name = $("#sub_chapter_name").val();
		var sub_chapter_info = $("#sub_chapter_info").val();
        
        $("#sub_chapter_add_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#sub_chapter_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>");
			$("#course_category_id").focus();
			return false;
		}

		if(course_master_id=='' || course_master_id==null || course_master_id=='undefined' || course_master_id==undefined){
			$("#sub_chapter_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>");
			$("#course_master_id").focus();
			return false;
		}

		if(chapter_master_id=='' || chapter_master_id==null || chapter_master_id=='undefined' || chapter_master_id==undefined){
			$("#sub_chapter_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Chapter name is required.</div>");
			$("#chapter_master_id").focus();
			return false;
		}

		if(sub_chapter_name=='' || sub_chapter_name==null || sub_chapter_name=='undefined' || sub_chapter_name==undefined){
			$("#sub_chapter_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Sub Chapter name is required.</div>");
			$("#sub_chapter_name").focus();
			return false;
		}

		$("#sub_chapter_add_status").html("");

        $("#btn_add_sub_chapter").attr('disabled',true);

		$("#loader-spin").show();

		var data = {
            course_category_id : course_category_id,
            course_master_id : course_master_id,
            chapter_master_id : chapter_master_id,
            sub_chapter_name : sub_chapter_name,
            sub_chapter_info : sub_chapter_info
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/sub-chapter-add-process",
            dataType:'json',
            data:data,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	generateNotification('success', res.message);
					setTimeout(function() { window.location.href=base_url+"admin/sub-chapter-list/"; }, 3500);
                }
                else{
                    $("#btn_add_sub_chapter").attr('disabled',false);
                    $("#sub_chapter_add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });

    // datatble initialization
    var dataTable = $('#sub_chapter_list').DataTable( {
        order: [
            [4, 'asc']
        ],
        dom: 'lBfrtip',
        "lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        "columnDefs": [ { orderable: false, targets: [0,5,8] } ],
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
            url :base_url+"admin/sub-chapter-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $("#sub_chapter_list-error").html("");
                $("#sub_chapter_list").append('<tbody class="sub_chapter_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#sub_chapter_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "sub_chapter_master_id" },
            { "data": "course_category_name" },
            { "data": "course_name" },
            { "data": "chapter_name" },
            { "data": "sub_chapter_name" },
            { "data": "sub_chapter_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    // fetch chapter info
    $('#sub_chapter_list tbody').on('click', '.edit_sub_chaper', function () {
        var sub_chapter_master_id = $(this).attr('id');
        
        $("#loader-spin").show();

        $.ajax({
            type:'post',
            dataType:'json',
            url:base_url+"admin/get-sub-chapter-detail", 
            data:{ sub_chapter_master_id:sub_chapter_master_id },
            success: function(res){
                $("#loader-spin").hide(); 
                if(res.status==true){
                    $("#update_sub_chapter_master_id").val(res.sub_chapter_details.sub_chapter_master_id);
                    $("#update_course_category_id").val(res.sub_chapter_details.course_category_id);
                    $("#update_course_master_id").val(res.sub_chapter_details.course_master_id);
                    $("#update_chapter_master_id").val(res.sub_chapter_details.chapter_master_id);
                    $("#update_sub_chapter_name").val(res.sub_chapter_details.sub_chapter_name);
                    $("#update_sub_chapter_info").val(res.sub_chapter_details.sub_chapter_info);
                    $("#update_sub_chapter_status").html( res.sub_chapter_details.sub_chapter_status_html );

                    $("#update-sub-chapter-modal").modal('show');
                }
                else{
                    generateNotification('error', res.message);
                    return false;
                }
            }
        });
    });

    // update course category
    $("#btn_update_sub_chapter").click(function(){
        var sub_chapter_master_id = $("#update_sub_chapter_master_id").val();
		var course_category_id = $("#update_course_category_id").val();
		var course_master_id = $("#update_course_master_id").val();
		var chapter_master_id = $("#update_chapter_master_id").val();
		var sub_chapter_name = $("#update_sub_chapter_name").val();
		var sub_chapter_info = $("#update_sub_chapter_info").val();
		var sub_chapter_status = $("#update_sub_chapter_status").val();
        
        $("#sub_chapter_update_status").html("");

		if(course_category_id=='' || course_category_id==null || course_category_id=='undefined' || course_category_id==undefined){
			$("#sub_chapter_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course category is required.</div>");
			$("#course_category_id").focus();
			return false;
		}

		if(course_master_id=='' || course_master_id==null || course_master_id=='undefined' || course_master_id==undefined){
			$("#sub_chapter_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course name is required.</div>");
			$("#course_master_id").focus();
			return false;
		}

		if(chapter_master_id=='' || chapter_master_id==null || chapter_master_id=='undefined' || chapter_master_id==undefined){
			$("#sub_chapter_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Chapter name is required.</div>");
			$("#chapter_master_id").focus();
			return false;
		}

		if(sub_chapter_name=='' || sub_chapter_name==null || sub_chapter_name=='undefined' || sub_chapter_name==undefined){
			$("#sub_chapter_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Sub Chapter name is required.</div>");
			$("#sub_chapter_name").focus();
			return false;
		}

		$("#sub_chapter_update_status").html("");

        $("#btn_update_sub_chapter").attr('disabled',true);

		$("#loader-spin").show();

		var data = {
            sub_chapter_master_id : sub_chapter_master_id,
            course_category_id : course_category_id,
            course_master_id : course_master_id,
            chapter_master_id : chapter_master_id,
            sub_chapter_name : sub_chapter_name,
            sub_chapter_info : sub_chapter_info,
            sub_chapter_status : sub_chapter_status
        };

        $.ajax({
            type: "post",
            url:base_url+"admin/sub-chapter-update-process",
            dataType:'json',
            data:data,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	generateNotification('success', res.message);
					setTimeout(function() { window.location.href=base_url+"admin/sub-chapter-list/"; }, 3500);
                }
                else{
                    $("#btn_update_sub_chapter").attr('disabled',false);
                    $("#sub_chapter_update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });

});