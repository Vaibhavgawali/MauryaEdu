$(document).ready(function(){

    /*   Prevent entering charaters in mobile & phone number   */
    $("#contact").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
        {
            return false;
        }
    });

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
          width:200,
          height:200,
          type:'circle' //circle
        },
        boundary:{
          width:250,
          height:250
        }
    });

    $('#upload_image').on('change', function(){

        var file = $(this).val();
        var ext = file.split('.').pop();
        var img_array = "jpg,png,jpeg.JPG,JPEG,PNG";

        var i = img_array.indexOf(ext);

        if(i > -1) 
        {
            var reader = new FileReader();
            reader.onload = function (event) {
              $image_crop.croppie('bind', {
                url: event.target.result
              }).then(function(){
                console.log('jQuery bind complete');
              });
            }
            reader.readAsDataURL(this.files[0]);
            $('#uploadimageModal').modal('show');
        } 
        else 
        {
            generateNotification('error', 'Invalid image type');
            return false;
        }
        
    });

    $('.crop_image').click(function(event){
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response){
            $.ajax({
                url:base_url+"student/update-profile-pic",
                type: "POST",
                data:{"image": response},
                success:function(res)
                {
                    $('#uploadimageModal').modal('hide');
                    $('#uploaded_image').html(res);

                    generateNotification('success', 'Profile picture updated successfully');
					setTimeout(function() { location.reload(true); }, 3500);
                    
                }
            });
        })
    });

    $('#btn_contact_details').click(function(){
        $("#update-contact-detail-modal").modal('show');
    });

    //--- Update contact
	$("#btn_update_contact").click(function(){

		var full_name = $("#full_name").val();
        var emailid = $("#emailid").val();
        var contact = $("#contact").val();
        var address = $("#address").val();
        var aadhar_number = $("#aadhar_number").val();
        
        $("#update_contact_status").html("");

        if(full_name=='' || full_name==null || full_name==undefined || full_name=='undefined'){
            $("#update_contact_status").html("<div class='alert alert-secondary text-center' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Empty!</b> User Full Name is required.</div>");
            $("#full_name").focus();
            return false;
        }

        if(emailid=='' || emailid==null || emailid==undefined || emailid=='undefined'){
            $("#update_contact_status").html("<div class='alert alert-secondary text-center' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Empty!</b> User Email id is required.</div>");
            $("#emailid").focus();
            return false;
        }

        function validateEmail($email) 
        {
            var emailReg = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            return emailReg.test( $email );
        }

        if(!validateEmail(emailid)) 
        { 
            $("#update_contact_status").html("<div class='alert alert-secondary text-center' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> User Email is invalid.</div>");
            $("#emailid").focus();
            return false;
        }

        if(contact=='' || contact==null || contact=='undefined'){
            $("#update_contact_status").html("<div class='alert alert-secondary text-center' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Empty!</b> User Phone is required.</div>");
            $("#contact").focus();
            return false;
        }

        function validateAadhar($aadhar) 
        {
            var aadharReg = /^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/;
            return aadharReg.test( $aadhar );
        }
        
        if(aadhar_number!='' && aadhar_number!=null){
            if(!validateAadhar(aadhar_number)) 
            { 
                $("#update_contact_status").html("<div class='alert alert-secondary text-center' style='padding: 5px; margin-bottom: 5px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> <b>Invalid!</b> Aadhar number is invalid.</div>");
                $("#aadhar_number").focus();
                return false;
            }
        }

        $("#update_contact_status").html("");
        $("#loader-spin").show();
        $("#btn_update_contact").attr('disabled','disabled');
        
        var data = {
            full_name : full_name,
            emailid : emailid,
            contact : contact,
            address : address,
            aadhar_number : aadhar_number
        };

        $.ajax({
            type: "post",
            url:base_url+"student/update-contact-details",
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
                    $("#btn_update_contact").attr('disabled', false);
                    return false;
                }
            }
        });

	});

});