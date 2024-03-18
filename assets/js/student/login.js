$(document).ready(function(){
		
	//Login Submit
	$("#btn_login_submit").click(function(){
		var emailid = $("#emailid").val();
		var password = $("#password").val();

		if(emailid=='' || emailid==null || emailid=='undefined' || emailid==undefined){
			$("#login_status").html("<div class='text-danger text-center' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>");
			$("#emailid").focus();
			return false;
		}

		if(password=='' || password==null || password=='undefined' || password==undefined){
			$("#login_status").html("<div class='text-danger text-center' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Password is required.</div>");
			$("#password").focus();
			return false;
		}

		$("#login_status").html("");

		$("#loader-spin").show();

		var data = {
            emailid : emailid,
            password : password
        };

        $.ajax({
            type: "post",
            url:base_url+"student/login-process",
            dataType:'json',
            data:data,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	window.location.href = base_url + 'student/dashboard'; 
                    return false;
                }
                else{

                    $("#login_status").html("<div class='text-danger text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
	});

	//Forgot Password Submit
	$("#btn_forgot_password_submit").click(function(){
		
		var emailid = $("#emailid").val();

		if(emailid=='' || emailid==null || emailid=='undefined' || emailid==undefined){
			$("#forgot_password_status").html("<div class='text-danger text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>EMPTY!</b> Email is required.</div>");
			$("#emailid").focus();
			return false;
		}

		$("#forgot_password_status").html("");

		$("#loader-spin").show();

		$("#btn_forgot_password_submit").attr('disabled', true);

		var data = {
            emailid : emailid
        };

        $.ajax({
            type: "post",
            url:base_url+"student/forgot-password-process",
            dataType:'json',
            data:data,
            cache: false,
            success:function(res){
                $("#loader-spin").hide();
                
                if(res.status==true){
                	$("#forgot_password_status").html("<div class='text-success text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-check'></i> "+res.message+"</div>");
                    return false;
                }
                else{
					$("#btn_forgot_password_submit").attr('disabled', false);
                    $("#forgot_password_status").html("<div class='text-danger text-center' style='padding: 10px; margin-bottom: 10px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
                    return false;
                }
            }
        });

		return false;
	});
});