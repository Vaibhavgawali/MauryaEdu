<?php
class Dispositions_Model extends CI_Model 

{
    public function __construct(){
            parent::__construct();
    $this->load->helper('Common_helper');

    }

function Action_data($post_data,$product_type)
{   

      switch ($post_data['dispositions_id']) {
            case '1':
                $data= $this->Wondispositions($post_data,$product_type);
                  break;
             case '2':
                  $data= $this->FollowUpdispositions($post_data,$product_type);
                  break;
             case '3':
                 $data=  $this->NonContactabledispositions($post_data,$product_type);
                  break;
            case '4':
                  $data= $this->NotEligibledispositions($post_data,$product_type);
                  break;
            case '5':
                  $data= $this->NotInteresteddispositions($post_data,$product_type);
                  break;
             case '6':
                  $data= $this->RPCdispositions($post_data,$product_type);
                  break; 
            case '7':
                  $data= $this->Closeddispositions($post_data,$product_type);
                  break; 
            case '8':
                  $data= $this->LostCasedispositions($post_data,$product_type);
                  break;      
   
      }
            return  $data;

}

function Wondispositions($post_data)
{
/*
policy number and price
*/ 


   $data_array=array
           (
            "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );

           
return $data_array;
}

function LostCasedispositions($post_data,$product_type)
{
/*
policy number and price
*/ 
switch($product_type){

     case('private_car'):
      $data_array=array
           (
            "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('health'):
      $data_array=array
           (
            "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('twowheeler'):
        $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );

     break;
   } 
  

           
   return $data_array;
}

function FollowUpdispositions($post_data,$product_type)
{
if(isset($post_data['call_back_date'])){$date_follow=str_replace('/','-',$post_data['call_back_date']);}

if(isset($post_data['policy_master_id'])){
 
    $policy_master_id=$post_data['policy_master_id'];

}

if(isset($post_data['health_master_id'])){
 
    $health_master_id=$post_data['health_master_id'];

}

if(isset($post_data['twowheeler_master_id'])){
 
    $twowheeler_master_id=$post_data['twowheeler_master_id'];

}


$dispositions_id=$post_data['dispositions_id'];
$sub_dispositions_id=$post_data['sub_dispositions_id'];

//echo "<pre>";print_r($post_data);die;
switch ($sub_dispositions_id) 
{

  case '3':
      $date_follow=str_replace('/','-',$post_data['call_back_date']);
           if($product_type=='private_car'){
             $data_array=array
             (
               "policy_master_id"=>$post_data['policy_master_id'],
              "dispositions_id"=>$post_data['dispositions_id'],
              "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
              "follow_date"=>date('Y-m-d',strtotime($date_follow)),
              "follow_time"=>$post_data['call_back_time'],
              "mobile_number_2"=>$post_data['mobile_number2'],
              "comment"=>$post_data['disposition_comment'],
               "lead_owner_id"=>$post_data['login_id']
             );
            
            updateTable("policy_master", array("status"=>1), array("id"=>$policy_master_id));

           }

            if($product_type=='twowheeler'){
             $data_array=array
             (
               "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
              "dispositions_id"=>$post_data['dispositions_id'],
              "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
              "follow_date"=>date('Y-m-d',strtotime($date_follow)),
              "follow_time"=>$post_data['call_back_time'],
              "mobile_number_2"=>$post_data['mobile_number2'],
              "comment"=>$post_data['disposition_comment'],
               "lead_owner_id"=>$post_data['login_id']
             );
            
            updateTable("twowheeler_master", array("status"=>1), array("id"=>$twowheeler_master_id));

           }

           if($product_type=='health'){
             
             $data_array=array
             (
               "health_master_id"=>$post_data['health_master_id'],
              "dispositions_id"=>$post_data['dispositions_id'],
              "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
              "follow_date"=>date('Y-m-d',strtotime($date_follow)),
              "follow_time"=>$post_data['call_back_time'],
              "mobile_number_2"=>$post_data['mobile_number2'],
              "comment"=>$post_data['disposition_comment'],
               "lead_owner_id"=>$post_data['login_id']
             );
           // echo "<pre>";print_r($data_array);die;
            updateTable("health_master", array("h_status"=>1), array("id"=>$health_master_id));

           }
           

  break;

  case '4':
      $date_follow=str_replace('/','-',$post_data['call_back_date']);
           if($product_type=='private_car'){
               $data_array=array
           (
            "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
           updateTable("policy_master", array("status"=>1), array("id"=>$policy_master_id));
         }
         if($product_type=='health'){

            $data_array=array
           (
            "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
           updateTable("health_master", array("h_status"=>1), array("id"=>$health_master_id));

         }

          if($product_type=='twowheeler'){

            $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
           updateTable("twowheeler_master", array("status"=>1), array("id"=>$twowheeler_master_id));

         }

  break;

  case '5':
      $date_follow=str_replace('/','-',$post_data['call_back_date']);
          if($product_type=='private_car'){
  
           $data_array=array
           (
            "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
           updateTable("policy_master", array("status"=>2), array("id"=>$policy_master_id));
         }
          if($product_type=='health'){

              $data_array=array
               (
                "health_master_id"=>$post_data['health_master_id'],
                "dispositions_id"=>$post_data['dispositions_id'],
                "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
                "follow_date"=>date('Y-m-d',strtotime($date_follow)),
                "follow_time"=>$post_data['call_back_time'],
                "follow_date"=>date('Y-m-d',strtotime($date_follow)),
                "follow_time"=>$post_data['call_back_time'],
                "comment"=>$post_data['disposition_comment'],
                 "lead_owner_id"=>$post_data['login_id']
               );
               updateTable("health_master", array("h_status"=>2), array("id"=>$health_master_id));
             }

          if($product_type=='twowheeler'){

              $data_array=array
               (
                "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
                "dispositions_id"=>$post_data['dispositions_id'],
                "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
                "follow_date"=>date('Y-m-d',strtotime($date_follow)),
                "follow_time"=>$post_data['call_back_time'],
                "follow_date"=>date('Y-m-d',strtotime($date_follow)),
                "follow_time"=>$post_data['call_back_time'],
                "comment"=>$post_data['disposition_comment'],
                 "lead_owner_id"=>$post_data['login_id']
               );
               updateTable("twowheeler_master", array("status"=>2), array("id"=>$twowheeler_master_id));
             }
          

  break;
          case '6':
          if($product_type=='private_car'){

              $this->SendMessage($post_data);
              $date_follow=str_replace('/','-',$post_data['call_back_date']);
              $data_array=array
           (
            "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id'],
             "customer_address_1"=>$post_data['customer_address_1'],
             "customer_address_2"=>$post_data['customer_address_2'],
             "customer_state"=>$post_data['customer_state'],
             "customer_city"=>$post_data['customer_city'],
             "customer_pincode"=>$post_data['customer_pincode'],
           );
          updateTable("policy_master", array("status"=>2), array("id"=>$policy_master_id));
        }

        if($product_type=='health'){
            
              $this->SendMessage($post_data,$product_type);
              $date_follow=str_replace('/','-',$post_data['call_back_date']);
              $data_array=array
           (
            "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id'],
             "customer_address_1"=>$post_data['customer_address_1'],
             "customer_address_2"=>$post_data['customer_address_2'],
             "customer_state"=>$post_data['customer_state'],
             "customer_city"=>$post_data['customer_city'],
             "customer_pincode"=>$post_data['customer_pincode'],
           );
          updateTable("health_master", array("h_status"=>2), array("id"=>$health_master_id));

          }
           if($product_type=='twowheeler'){
            
              $this->SendMessage($post_data,$product_type);
              $date_follow=str_replace('/','-',$post_data['call_back_date']);
              $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id'],
             "customer_address_1"=>$post_data['customer_address_1'],
             "customer_address_2"=>$post_data['customer_address_2'],
             "customer_state"=>$post_data['customer_state'],
             "customer_city"=>$post_data['customer_city'],
             "customer_pincode"=>$post_data['customer_pincode'],
           );
          updateTable("twowheeler_master", array("status"=>2), array("id"=>$twowheeler_master_id));

          }

  break;

  default:
      $date_follow=str_replace('/','-',$post_data['call_back_date']);
          if($product_type=='private_car'){

              $data_array=array
           (
              "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
           updateTable("policy_master", array("status"=>1), array("id"=>$policy_master_id));

           }
           if($product_type=='health'){

           $data_array=array
           (
              "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
           updateTable("health_master", array("h_status"=>1), array("id"=>$health_master_id));

           }

           if($product_type=='twowheeler'){

           $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "follow_date"=>date('Y-m-d',strtotime($date_follow)),
            "follow_time"=>$post_data['call_back_time'],
            "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
           updateTable("twowheeler_master", array("status"=>1), array("id"=>$twowheeler_master_id));

           }
     break;
}

  /*
  1)  Alt Number Taken  -input box show
  update on policy master second mobile number 1
  2)Call Back By TL - 
  assign to tl same as call back
  3)Cheque Pick up - Send to mobile details
  4)Customer hung up
  5)Customer Not Available
  6)Customer Want Discount - API USE    
  7)Customer Want To Increase IDV -API USE    
  8)Inspection-API USE
  9)Not Sure To Renewed With From- 
  10)Payu Link Send
  11)Policy Holder not available in business hours - update table
  12)Promise to Pay -No Idea
  13)Want To Renew from  LGI Branch - LOST CASE 

  14)
  */   
  return $data_array; 
}

function NonContactabledispositions($post_data,$product_type){
/*If Customer not  pick  up phone in three time 
that time tl download the report and upload and chnage prime number 
*/

switch($product_type){

     case('private_car'):
      $data_array=array
           (
             "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('health'):
      $data_array=array
           (
            "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('twowheeler'):
        $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );

     break;
   } 
   


return $data_array;

      
}

function NotEligibledispositions($post_data,$product_type)
{

   switch($product_type){

     case('private_car'):
      $data_array=array
           (
             "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('health'):
      $data_array=array
           (
            "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('twowheeler'):
        $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );

     break;
   } 

           
return $data_array;
      
}

function NotInteresteddispositions($post_data,$product_type)
{

   switch($product_type){

     case('private_car'):
      $data_array=array
           (
             "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('health'):
      $data_array=array
           (
            "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('twowheeler'):
        $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );

     break;
   } 

           
return $data_array;
      
}

function RPCdispositions($post_data,$product_type)
{

   switch($product_type){

     case('private_car'):
      $data_array=array
           (
             "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('health'):
      $data_array=array
           (
            "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );
     break;
     case('twowheeler'):
        $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
             "comment"=>$post_data['disposition_comment'],
             "lead_owner_id"=>$post_data['login_id']
           );

     break;
   }

           
return $data_array;  
}

function Closeddispositions($post_data,$product_type)
{
 if($product_type=='private_car'){
   $data_array=array
           (
            "policy_master_id"=>$post_data['policy_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "comment"=>$post_data['disposition_comment'],
            "lead_owner_id"=>$post_data['login_id']

           );
 updateTable("policy_master", array("status"=>8), array("id"=>$post_data['policy_master_id']));
}

  if($product_type=='health'){

    $data_array=array
           (
            "health_master_id"=>$post_data['health_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "comment"=>$post_data['disposition_comment'],
            "lead_owner_id"=>$post_data['login_id']

           );
    updateTable("health_master", array("h_status"=>8), array("id"=>$post_data['health_master_id']));

  }

    if($product_type=='twowheeler'){

    $data_array=array
           (
            "twowheeler_master_id"=>$post_data['twowheeler_master_id'],
            "dispositions_id"=>$post_data['dispositions_id'],
            "sub_dispositions_id"=>$post_data['sub_dispositions_id'],
            "comment"=>$post_data['disposition_comment'],
            "lead_owner_id"=>$post_data['login_id']

           );
    updateTable("twowheeler_master", array("status"=>8), array("id"=>$post_data['twowheeler_master_id']));

  }
           
return $data_array;
      
}

function SendMessage($post_data,$product_type=false)
{
    if($post_data['product_type']=='private_car'){

    $policy_master_id=$post_data['policy_master_id'];
    $result=$this->db->query("select * from policy_master where id= '".$policy_master_id."'")->row_array();
    $sm_name=$result['newsales_manager_name'];
    $sm_code = $result['newsales_manager_code'];

    $policy_Number=$result['policy_Number'];
    $renewal_copy_url = base_url().'downloadRenewalNotice?PolNumber='.$policy_Number;

    // $sm_code='N0262177';
  /*Get data by user email id  code */
    $sale_table=$this->db->query("select * from  users where code = '".$sm_code."'")->row_array();
    $sales_manager_name=$sale_table['fullname'];
    $sales_manager_email_id=$sale_table['email'];

    $this->checkPasswordExperied($sales_manager_email_id);


    /*check passowrd*/


      /**/
    $result_token=$this->db->query("select * from auth_token")->row_array();
    $auth_token=$result_token['token'];


 /**/
   /*Manager Deatils*/
    $url='https://graph.microsoft.com/v1.0/users/'.$sales_manager_email_id;
    $paramter="";
    $response=GETUserDetailsCurlGet($url,$paramter,$auth_token);

  /*SM SEND MAIL*/
    $json_data=json_decode($response,true);
    $managner_email_id=$json_data['mail'];
    //print_r_custom($json_data);
    $this->sendSMS($result,$json_data,$post_data);          //remove comment to send sms
    
    // $this->checkPasswordExperied($sales_manager_email_id);
  /*END SM SEND MAIL*/


  /*Manger level SEND MAIL*/
    $url='https://graph.microsoft.com/v1.0/users/'.$managner_email_id.'/manager';
    $paramter="";
    $response_data=GETUserDetailsCurlGet($url,$paramter,$auth_token);
    $json_data_array=json_decode($response_data,true);
    //print_r_custom($json_data,1);
    $this->sendSMS($result,$json_data_array,$post_data);          //remove comment to send sms
    $this->sendMail($sales_manager_email_id,$json_data_array['mail'],$json_data['displayName'],$renewal_copy_url,$result,$post_data);          //remove comment to send email
    /*END*/

 

/*END*/
/**/
 }

  if($product_type=='health'){

    $health_master_id=$post_data['health_master_id'];
    $result=$this->db->query("select * from health_master where id= '".$health_master_id."'")->row_array();
    $sm_name=$result['sales_manager_name'];
    $sm_code = $result['sales_manager_code'];

    $policy_Number=$result['policy_number'];
    $renewal_copy_url = base_url().'downloadRenewalNotice?PolNumber='.$policy_Number;

  /*Get data by user email id  code */
    $sale_table=$this->db->query("select * from  users where code = '".$sm_code."'")->row_array();
    $sales_manager_name=$sale_table['fullname'];
    $sales_manager_email_id=$sale_table['email'];
    $this->checkPasswordExperied($sales_manager_email_id);
    /*check passowrd*/
      /**/
    $result_token=$this->db->query("select * from auth_token")->row_array();
    $auth_token=$result_token['token'];
 /**/
   /*Manager Deatils*/
    $url='https://graph.microsoft.com/v1.0/users/'.$sales_manager_email_id;
    $paramter="";
    $response=GETUserDetailsCurlGet($url,$paramter,$auth_token);
    $json_data=json_decode($response,true);

    $managner_email_id=$json_data['mail'];
    $this->sendSMS($result,$json_data,$post_data);
    $this->checkPasswordExperied($sales_manager_email_id);

    $url='https://graph.microsoft.com/v1.0/users/'.$managner_email_id.'/manager';
    $paramter="";
    $response_data=GETUserDetailsCurlGet($url,$paramter,$auth_token);
    $json_data_array=json_decode($response_data,true);
    $this->sendSMS($result,$json_data_array,$post_data);
    $this->sendMail($sales_manager_email_id,$json_data_array['mail'],$json_data['displayName'],$renewal_copy_url,$result,$post_data);

/*END*/
/**/
 }

  if($product_type=='twowheeler'){

    $twowheeler_master_id=$post_data['twowheeler_master_id'];
    $result=$this->db->query("select * from twowheeler_master where id= '".$twowheeler_master_id."'")->row_array();
    $sm_name=$result['new_sales_manager_name'];
    $sm_code=$result['new_sales_manager_code'];

    $policy_Number=$result['policy_Number'];
    $renewal_copy_url = base_url().'downloadRenewalNotice?PolNumber='.$policy_Number;

  /*Get data by user email id  code */
    $sale_table=$this->db->query("select * from  users where code = '".$sm_code."'")->row_array();
    $sales_manager_name=$sale_table['fullname'];
    $sales_manager_email_id=$sale_table['email'];
    $this->checkPasswordExperied($sales_manager_email_id);
    /*check passowrd*/
      /**/
    $result_token=$this->db->query("select * from auth_token")->row_array();
    $auth_token=$result_token['token'];
 /**/
   /*Manager Deatils*/
    $url='https://graph.microsoft.com/v1.0/users/'.$sales_manager_email_id;
    $paramter="";
    $response=GETUserDetailsCurlGet($url,$paramter,$auth_token);
    $json_data=json_decode($response,true);

    $managner_email_id=$json_data['mail'];
    $this->sendSMS($result,$json_data,$post_data);
    $this->checkPasswordExperied($sales_manager_email_id);

    $url='https://graph.microsoft.com/v1.0/users/'.$managner_email_id.'/manager';
    $paramter="";
    $response_data=GETUserDetailsCurlGet($url,$paramter,$auth_token);
    $json_data_array=json_decode($response_data,true);

    $this->sendSMS($result,$json_data_array,$post_data);
    $this->sendMail($sales_manager_email_id,$json_data_array['mail'],$json_data['displayName'],$renewal_copy_url,$result,$post_data);

/*END*/
/**/
 }


}

function sendSMS($result_database,$api_data,$post_data)
{
  $sales_manager_name = (!empty($result_database['sales_manager_name'])) ? $result_database['sales_manager_name'] : "";
  $product_name = (!empty($result_database['product_name'])) ? $result_database['product_name'] : "";
  $disposition_comment = (!empty($post_data['disposition_comment'])) ? $post_data['disposition_comment'] : "";
  $call_back_date = (!empty($post_data['call_back_date'])) ? $post_data['call_back_date'] : "";
  $call_back_time = (!empty($post_data['call_back_time'])) ? $post_data['call_back_time'] : "";
  $insured_name = (!empty($result_database['insured_name'])) ? $result_database['insured_name'] : "";
  $mobile1 = (!empty($result_database['mobile1'])) ? $result_database['mobile1'] : "";

  switch($post_data['product_type']){
    case 'private_car':
    case 'twowheeler':
      $smsTemplet = "Dear ".$api_data['displayName']." your appointment has been fixed for ".$product_name." renewal for cheque pickup/discussion on ".date('d/m/Y', strtotime($call_back_date))." at ".$call_back_time." at customers place against policy number:".$result_database['policy_Number']." (".base_url().'downloadRenewalNotice?PolNumber='.$result_database['policy_Number'].") & customer name: ".$insured_name." and mobile number: ".$mobile1." Pls connect with client.";
      break;

    case 'health':
      $smsTemplet = "Dear ".$api_data['displayName']." your appointment has been fixed for ".$product_name." renewal for cheque pickup/discussion on ".date('d/m/Y', strtotime($call_back_date))." at ".$call_back_time." at customers place against policy number:".$result_database['policy_number']." (".base_url().'downloadRenewalNotice?PolNumber='.$result_database['policy_number'].") & customer name: ".$result_database['insured_name_proposer_name']." and mobile number: ".$mobile1." Pls connect with client.";
      break;
  }
  // $api_data['mobilePhone'] = '8097690206';
  sendSms($api_data['mobilePhone'],$smsTemplet);
}


function sendMail($smemail_id,$manger_email_id,$sales_manager_name,$renewal_copy_url,$result_database,$post_data)
{
switch($post_data['product_type']){
    case 'private_car':
    case 'twowheeler':
      $insured_name = $result_database['insured_name'];
      $policy_Number = $result_database['policy_Number'];
      $total_premium_payable = $result_database['total_premium_payable'];
      break;

    case 'health':
      $insured_name = $result_database['insured_name_proposer_name'];
      $policy_Number = $result_database['policy_number'];
      $total_premium_payable = $result_database['total_premium'];
      break;
  }

$message='
<table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 600px; font-family: sans-serif;">
  <tr>
     <td bgcolor="#ffd000" style="padding: 40px 30px 20px 30px;">
        <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">  
           <tr>
             <td height="70" style="padding: 0 20px 20px 0;">
               <img src="'.base_url().'assets/img/logo.png" width="200"  border="0" alt="" />
             </td>
           </tr>
        </table>
        <table align="right" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 300px;">  
            <tr>
              <td height="70">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align: right;">
                  <tr>
                    <td style="padding: 0; font-size: 15px;  font-family: sans-serif; letter-spacing: 10px;">APPOINTMENT</td>
                  </tr>
                  <tr>
                    <td style="padding: 5px 10px 0 0; font-size: 20px; line-height: 38px; font-weight: bold;">Cheque Pick Up</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 50px 30px 50px 30px; border: 10px solid #153643;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td style="padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold; color: #153643;">
                Dear '.$sales_manager_name.',
              </td>
            </tr>
            <tr>
              <td>
                Your appointment is fixed with customer <b>'.$insured_name.'</b> against renewal of his/her <b>'.$result_database['product_name'].'</b> insurance <b>Policy Number -'.$policy_Number.'</b> Renewal copy url: '.$renewal_copy_url.'  which is expiring on <b> '.date('d/m/Y', strtotime($result_database['policy_end_date'])).'</b>. The appointment is on <b>'.$post_data['call_back_date'].' at '.$post_data['call_back_time'].'</b>,  Premium Rs <b>'.$total_premium_payable.'</b>/ renewal discussion.
              </td>
            </tr>
          </table>
        </td>
      </tr>
</table>';
// print_r_custom($message,1);


sendEmail($smemail_id, "APPOINTMENT FOR CHEQUE PICK UP", $message,'','', "","",$manger_email_id);
}



function checkPasswordExperied($email)
{ 

     $result_token=$this->db->query("select * from auth_token")->row_array();
     $auth_token=$result_token['token'];
 

 /*Manager Deatils*/
    $url='https://graph.microsoft.com/v1.0/users/'.$email.'/manager';
    $paramter="";
    $response=GETUserDetailsCurlGet($url,$paramter,$auth_token);
    $json_data=json_decode($response,true);

    if(isset($json_data['error']['code']) && $json_data['error']['code']=="InvalidAuthenticationToken")
    {
      Access_Token();
    }

}


	
}
	
