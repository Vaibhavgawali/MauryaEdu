<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MyProfile extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Student/My_Profile_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Admin/Admin_Login_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkAdminLoginSession();
        
        addCss(array('croppie.css'));

        addJs(array("croppie.js"));
        addJs(array("admin/my-profile.js"));

        $login_detail = $this->session->userdata('login_detail');

        $adminInfo = $this->Admin_Login_Model->getAdminDetailsById($login_detail['userinfo_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['adminInfo'] = $adminInfo;

        $this->load->admintemplate('my-profile', $this->data);
    }

    public function UpdateProfilePicture(){
        
        checkAdminLoginSession();
        
        $login_detail = $this->session->userdata('login_detail');

        $userinfo_id = $login_detail['userinfo_id'];

        if(isset($_POST["image"]))
		{
			$data = $_POST["image"];

			$image_array_1 = explode(";", $data);
			$image_array_2 = explode(",", $image_array_1[1]);
			$data = base64_decode($image_array_2[1]);

            $imageName = md5($userinfo_id). '.png';
            
			$db_image = $imageName;
			//print_r_custom($db_image,1);
			$target_dir = "uploads/admin/profile-pic/";
			if (!file_exists($target_dir)) 
			{
				try 
				{
					mkdir($target_dir, 0777, true);
				} 
				catch (Exception $ex) 
				{
				die("error");
				}
			}

			$imageName = $target_dir.$imageName;
			file_put_contents($imageName, $data);

            $table_name = "userinfo";

            $where = array( "userinfo_id" => $userinfo_id);

			$update_array = array(
                "profile_pic"   => $db_image,
                "updatedBy"	=> $userinfo_id,
                "updatedOn"  => date('Y-m-d H:i:s'),
                "ip_address"    => $_SERVER['REMOTE_ADDR']
            );

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            echo '<img src="'.$imageName.'" class="img-thumbnail rounded img_preview" />';
		}
    }

    public function UpdateProfileContactDetails()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $userinfo_id  = $login_detail['userinfo_id'];
        $role = $login_detail['role'];
        
        $status = true;
        $message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $full_name = filter_smart($post_data['full_name']);
        $emailid = filter_smart($post_data['emailid']);
        $contact = filter_smart($post_data['contact']);
        $address = filter_smart($post_data['address']);
        $aadhar_number = filter_smart($post_data['aadhar_number']);

        $adminInfo = $this->Admin_Login_Model->getAdminInfoFromEmailWithOtherAdminId($emailid, $userinfo_id);
        
        if(empty($adminInfo)){

            $table_name = "userinfo";

            $where = array("userinfo_id" => $userinfo_id);

            $update_array = array(
                "full_name"         => $full_name,
                "contact"           => $contact,
                "address"           => $address,
                "aadhar_number"     => $aadhar_number,
                "updatedBy"         => $userinfo_id,
                "updatedOn"         => date('Y-m-d H:i:s'),
                "ip_address"        => $_SERVER['REMOTE_ADDR']
            );

            if($role != 1){
                $update_array['emailid'] = $emailid;
            }

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $status = true;
            $message = "Contact details updated successfully";
            
        }
        else{
            $status = false;
            $message = "Email already available in records, Please choose different email.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    public function ChangePassword()
    {
        checkAdminLoginSession();
        
        addJs(array("admin/change-password.js"));

        $login_detail = $this->session->userdata('login_detail');

        $adminInfo = $this->Admin_Login_Model->getAdminDetailsById($login_detail['userinfo_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['adminInfo'] = $adminInfo;

        // print_r_custom($this->data,1);

        $this->load->admintemplate('change-password', $this->data);
    }

    public function ChangePasswordProcess()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $userinfo_id  = $login_detail['userinfo_id'];

        $status = true;
        $message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $current_password = filter_smart($post_data['current_password']);
        $new_password = filter_smart($post_data['new_password']);
        $confirm_password = filter_smart($post_data['confirm_password']);
        
        $adminInfo = $this->Admin_Login_Model->getAdminDetailsById($login_detail['userinfo_id']);
        // print_r_custom($adminInfo,1);

        if(!empty($adminInfo)){

            if(strlen($new_password) < MIN_LENGTH_PASSWORD || strlen($new_password) > MAX_LENGTH_PASSWORD){
                $status = false;
                $message = "Password should be of minimum ".MIN_LENGTH_PASSWORD." AND maximum ".MAX_LENGTH_PASSWORD." characters long";
            }
            else{
                $new_passwordtext = filter_smart($post_data['new_password']);
                
                $current_password = hash('sha512',$current_password);
                
                $new_password = hash('sha512',$new_password);
                $confirm_password = hash('sha512',$confirm_password);

                if ($new_password == $confirm_password)
                {
                    $haveuppercase = preg_match('/[A-Z]/', $new_passwordtext);
                    $havenumeric = preg_match('/[0-9]/', $new_passwordtext);
                    $havespecial = preg_match('/[!@#$%)*_(+=}{\[\]|:;,.>}]/', $new_passwordtext);

                    if (!$haveuppercase)
                    {
                        $status = false;
                        $message = "New password must have atleast one upper case character";
                    }
                    else if (!$havenumeric)
                    {
                        $status = false;
                        $message = 'New password must have atleast one digit';
                    }
                    else if (!$havespecial)
                    {
                        $status = false;
                        $message = 'New password must have atleast one special character [!@#$%^)*_(+=}{|:;,.<>}]';
                    }
                    else
                    {
                        $password = $adminInfo['password'];
                        $temp_password = $adminInfo['temp_password'];
                        $temp_password_created_on = $adminInfo['temp_password_created_on'];
                        
                        if($password != $current_password && $temp_password != $current_password)
                        {
                            $status = false;
                            $message = 'Current password does not match with database! <br/>Try again with proper password.';
                        }
                        else{

                            if($password == $current_password)
                            {
                                $table_name = "userinfo";

                                $where = array( "userinfo_id" => $userinfo_id);

                                $update_array = array(
                                    "password"          => $new_password,
                                    "updatedBy"         => $userinfo_id,
                                    "updatedOn"         => date('Y-m-d H:i:s'),
                                    "ip_address"        => $_SERVER['REMOTE_ADDR']
                                );

                                $this->Common_Model->updateTable($table_name, $update_array, $where);

                                $status = true;
                                $message = "Password updated successfully";
                            }
                            else
                            if($temp_password == $current_password){
                                
                                if( strtotime($temp_password_created_on) >= strtotime(date('Y-m-d H:i:s')) ){

                                    $table_name = "userinfo";

                                    $where = array( "userinfo_id" => $userinfo_id);

                                    $update_array = array(
                                        "password"          => $new_password,
                                        "updatedBy"         => $userinfo_id,
                                        "updatedOn"      => date('Y-m-d H:i:s'),
                                        "ip_address"        => $_SERVER['REMOTE_ADDR']
                                    );

                                    $this->Common_Model->updateTable($table_name, $update_array, $where);

                                    $status = true;
                                    $message = "Password updated successfully";
                                }
                                else{
                                    $status = false;
                                    $message = "<b>ERROR! </b>Your current password not matched & also temporary password was expired.";
                                }
                            }
                            
                        }
                    }
                }
                else
                {
                    $status = false;
                    $message = "New password & confirm password not same";
                }
            }
            
        }
        else{
            $status = false;
            $message = "User details not available.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }
}

?>