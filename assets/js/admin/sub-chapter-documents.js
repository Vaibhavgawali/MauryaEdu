$(document).ready(function(){
    
    //--- Open add chapter modal
	$("#btn_add_sub_chapter_documents_modal").click(function(){
		$("#add-sub-chapter-documents-modal").modal('show');
	});

    $("#document_file, #update_document_file").change(function(){
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["application/pdf"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            
            $.confirm({
                title: 'Invalid file!',
                content: 'Please select valid .pdf document file.',

                buttons: {
                    confirm: function () {
                        $("#document_file, #update_document_file").val("");
                    }
                }

		    });
        }
    });

    // add sub chapter document
    $("#btn_add_sub_chapter_document_details").click(function(){
        var course_category_id = $("#course_category_id").val();
		var course_master_id = $("#course_master_id").val();
		var chapter_master_id = $("#chapter_master_id").val();
		var sub_chapter_master_id = $("#sub_chapter_master_id").val();
		var document_title = $("#document_title").val();
		var document_file = $("#document_file").val();
        
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

		if(chapter_master_id=='' || chapter_master_id==null || chapter_master_id=='undefined' || chapter_master_id==undefined){
			$("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course related general information is required.</div>");
			$("#chapter_master_id").focus();
			return false;
		}

		if(document_title=='' || document_title==null || document_title=='undefined' || document_title==undefined){
			$("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Document title is required.</div>");
			$("#document_title").focus();
			return false;
		}

		if(document_file=='' || document_file==null || document_file=='undefined' || document_file==undefined){
			$("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Document file is required.</div>");
			$("#document_file").focus();
			return false;
		}

        var file_data = $('#document_file').prop('files')[0];

		$("#add_status").html("");

        $("#btn_add_course_category").attr('disabled',true);

		$("#loader-spin").show();

        var form_data = new FormData();
        form_data.append('course_category_id', course_category_id);
        form_data.append('course_master_id', course_master_id);
        form_data.append('chapter_master_id', chapter_master_id);
        form_data.append('sub_chapter_master_id', sub_chapter_master_id);
        form_data.append('document_title', document_title);
        form_data.append('document_file', file_data);

        $.ajax({
            type: "post",
            url:base_url+"admin/sub-chapter-document-add-process",
            dataType:'json',
            data:form_data,
            contentType: false,
            processData: false,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	generateNotification('success', res.message);
					setTimeout(function() { location.reload(true); }, 3500);
                }
                else{
                    $("#btn_add_course_category").attr('disabled',false);
                    $("#add_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });

    // datatble initialization
    var dataTable = $('#sub_chapter_documents_list').DataTable( {
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
            url :base_url+"admin/sub-chapter-document-list-ajax",
            cache: false,
            type: "post",  // method  , by default get
            data : function(d){
                d.sub_chapter_master_id = $("#curr_sub_chapter_master_id").val();
            },
            error: function(){  // error handling
                $("#sub_chapter_documents_list-error").html("");
                $("#sub_chapter_documents_list").append('<tbody class="sub_chapter_documents_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#sub_chapter_documents_list_processing").css("display","none");
            }
        },
        "columns": [
            { "data": "sub_chapter_document_master_id" },
            { "data": "course_category_name" },
            { "data": "course_name" },
            { "data": "chapter_name" },
            { "data": "sub_chapter_name" },
            { "data": "document_title" },
            { "data": "document_file" },
            { "data": "document_status" },
            { "data": "created_date" },
            { "data": "updated_date" },
            { "data": "action" }
        ]
    });
    
    // fetch sub chapter document details
    $('#sub_chapter_documents_list tbody').on('click', '.edit_sub_chapter_document', function () {
        var sub_chapter_document_master_id = $(this).attr('id');
        var sub_chapter_master_id = $(this).attr('sub_chapter_master_id');
        var document_title = $(this).attr('document_title');
        var document_file = $(this).attr('document_file');
        var document_status = $(this).attr('document_status');

        var status_html = null;
        if(document_status=="1"){
            status_html += "<option value='1' selected>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        else
        if(document_status=="0"){
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0' selected>In-Active</option>";
        }
        else{
            status_html += "<option value='1'>Active</option>";
            status_html += "<option value='0'>In-Active</option>";
        }
        
        $("#loader-spin").show();

        $("#update_sub_chapter_document_master_id").val('');
        $("#update_document_title").val('');
        $("#curr_document").attr('href','');
        $("#update_document_status").html('');
        
        var target_dir = "uploads/sub-chapter/"+sub_chapter_master_id+"/sub-chapter-documents/"+sub_chapter_document_master_id+"/";
        
        var document_file_link = base_url + target_dir + document_file;

        $("#update_sub_chapter_document_master_id").val(sub_chapter_document_master_id);
        $("#update_document_title").val(document_title);
        $("#curr_document").attr('href',document_file_link);
        $("#update_document_status").html(status_html);

        $("#update-sub-chapter-documents-modal").modal('show');

        $("#loader-spin").hide();
        
    });

    // add chapter document
    $("#btn_update_sub_chapter_document_details").click(function(){
        var sub_chapter_document_master_id = $("#update_sub_chapter_document_master_id").val();
		var course_category_id = $("#update_course_category_id").val();
		var course_master_id = $("#update_course_master_id").val();
		var chapter_master_id = $("#update_chapter_master_id").val();
		var sub_chapter_master_id = $("#update_sub_chapter_master_id").val();
		var document_title = $("#update_document_title").val();
		var document_file = $("#update_document_file").val();
		var document_status = $("#update_document_status").val();
        
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

		if(chapter_master_id=='' || chapter_master_id==null || chapter_master_id=='undefined' || chapter_master_id==undefined){
			$("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course related general information is required.</div>");
			$("#update_chapter_master_id").focus();
			return false;
		}

		if(chapter_master_id=='' || chapter_master_id==null || chapter_master_id=='undefined' || chapter_master_id==undefined){
			$("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Course related general information is required.</div>");
			$("#update_sub_chapter_master_id").focus();
			return false;
		}

		if(document_title=='' || document_title==null || document_title=='undefined' || document_title==undefined){
			$("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Document title is required.</div>");
			$("#update_document_title").focus();
			return false;
		}

        var file_data = $('#update_document_file').prop('files')[0];

		$("#update_status").html("");

        $("#btn_update_sub_chapter_document_details").attr('disabled',true);

		$("#loader-spin").show();

        var form_data = new FormData();
        form_data.append('sub_chapter_document_master_id', sub_chapter_document_master_id);
        form_data.append('course_category_id', course_category_id);
        form_data.append('course_master_id', course_master_id);
        form_data.append('chapter_master_id', chapter_master_id);
        form_data.append('sub_chapter_master_id', sub_chapter_master_id);
        form_data.append('document_title', document_title);
        form_data.append('document_file', file_data);
        form_data.append('document_status', document_status);

        $.ajax({
            type: "post",
            url:base_url+"admin/sub-chapter-document-update-process",
            dataType:'json',
            data:form_data,
            contentType: false,
            processData: false,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	generateNotification('success', res.message);
					setTimeout(function() { location.reload(true); }, 3500);
                }
                else{
                    $("#btn_update_sub_chapter_document_details").attr('disabled',false);
                    $("#update_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
    });

});