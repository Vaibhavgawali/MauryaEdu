<?php
ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');


/*  Trigger SMS from SMS Gateway  */
if (!function_exists('executeSmsTrigger')) {
    function executeSmsTrigger($url) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}

/*  New Sales Order SMS  */
if (!function_exists('sendNewRegistrationSMS')) {

    function sendNewRegistrationSMS($full_name, $contact, $emailid, $password) {
        
        $message = "Dear ".$full_name.", Your registration is successful! Login id : ".$emailid.", Password: ".$password.", Thanks, ChemCaliba";

        $url  = "http://tagsolutions.in/sms-panel/api/http/index.php?username=".SMS_USER."&apikey=".API_KEY."&apirequest=".API_REQUEST."&sender=".SMS_SENDER."&mobile=".$contact."&message=".$message."&route=".SMS_ROUTE."&TemplateID=".NEW_REGISTRATION_TEMPLATE."&format=JSON";

        $url = preg_replace("/ /", "%20", $url);

        $response = executeSmsTrigger($url);

    }

}


/*  Test Result SMS  */
if (!function_exists('sendTestResultSMS')) {

    function sendTestResultSMS($full_name, $contact, $marks_obtained, $test_date) {
        
        $message = "Dear ".$full_name.", You scored ".$marks_obtained." in a TEST conducted on ".$test_date.". Thanks, ChemCaliba";

        $url  = "http://tagsolutions.in/sms-panel/api/http/index.php?username=".SMS_USER."&apikey=".API_KEY."&apirequest=".API_REQUEST."&sender=".SMS_SENDER."&mobile=".$contact."&message=".$message."&route=".SMS_ROUTE."&TemplateID=".TEST_RESULT_TEMPLATE."&format=JSON";
        
        $url = preg_replace("/ /", "%20", $url);

        $response = executeSmsTrigger($url);

    }

}


/*  Course Enrollment SMS  */
if (!function_exists('sendCourseEnrollmentSMS')) {

    function sendCourseEnrollmentSMS($full_name, $contact) {
        
        $message = "Dear ".$full_name.", Your Course Enrollment is successful! log in to 'Students Dashboard' to access your course. Thanks, ChemCaliba";

        $url  = "http://tagsolutions.in/sms-panel/api/http/index.php?username=".SMS_USER."&apikey=".API_KEY."&apirequest=".API_REQUEST."&sender=".SMS_SENDER."&mobile=".$contact."&message=".$message."&route=".SMS_ROUTE."&TemplateID=".COURSE_ENROLLMENT_TEMPLATE."&format=JSON";
        
        $url = preg_replace("/ /", "%20", $url);

        $response = executeSmsTrigger($url);

    }

}


/*  Parent teacher SMS  */
if (!function_exists('sendParentTeachersMeetingSMS')) {

    function sendParentTeachersMeetingSMS($full_name, $contact, $pt_meetings_date, $pt_meetings_time) {
        
        $message = "Dear ".$full_name.", A 'Parent-Teacher Meeting' has been scheduled for ".$pt_meetings_date." at ".$pt_meetings_time.". Requesting your parent(s) to attend this meeting. Thanks, ChemCaliba";

        $url  = "http://tagsolutions.in/sms-panel/api/http/index.php?username=".SMS_USER."&apikey=".API_KEY."&apirequest=".API_REQUEST."&sender=".SMS_SENDER."&mobile=".$contact."&message=".$message."&route=".SMS_ROUTE."&TemplateID=".PT_MEET_TEMPLATE."&format=JSON";
        
        $url = preg_replace("/ /", "%20", $url);

        $response = executeSmsTrigger($url);

    }

}


/*  Holiday information SMS  */
if (!function_exists('sendHolidayInformationSMS')) {

    function sendHolidayInformationSMS($full_name, $contact, $holiday_information_from_date, $holiday_information_to_date, $holiday_information_title) {
        
        $message = "Dear ".$full_name.", On account of ".$holiday_information_title.", Live Classes will remain off or from ".$holiday_information_from_date." to ".$holiday_information_to_date.", Thanks, ChemCaliba";

        $url  = "http://tagsolutions.in/sms-panel/api/http/index.php?username=".SMS_USER."&apikey=".API_KEY."&apirequest=".API_REQUEST."&sender=".SMS_SENDER."&mobile=".$contact."&message=".$message."&route=".SMS_ROUTE."&TemplateID=".HOLIDAY_INFORMATION_TEMPLATE."&format=JSON";
        
        $url = preg_replace("/ /", "%20", $url);

        $response = executeSmsTrigger($url);

    }

}


/*  New course published SMS  */
if (!function_exists('sendNewCoursePublishedSMS')) {

    function sendNewCoursePublishedSMS($full_name, $contact, $course_name) {
        
        $message = "Dear ".$full_name.", Course for month of '".$course_name."' has been published! Enroll yourself to get access. Thanks, ChemCaliba";

        $url  = "http://tagsolutions.in/sms-panel/api/http/index.php?username=".SMS_USER."&apikey=".API_KEY."&apirequest=".API_REQUEST."&sender=".SMS_SENDER."&mobile=".$contact."&message=".$message."&route=".SMS_ROUTE."&TemplateID=".NEW_COURSE_PUBLISHED_TEMPLATE."&format=JSON";
        
        $url = preg_replace("/ /", "%20", $url);

        $response = executeSmsTrigger($url);

    }

}


/*  New course published SMS  */
if (!function_exists('sendTestScheduleSMS')) {

    function sendTestScheduleSMS($full_name, $contact, $test_schedule_date_time) {
        
        $message = "Dear ".$full_name.", Your TEST has been scheduled for ".$test_schedule_date_time.", Please login to your dashboard for further details. Thanks, ChemCaliba";

        $url  = "http://tagsolutions.in/sms-panel/api/http/index.php?username=".SMS_USER."&apikey=".API_KEY."&apirequest=".API_REQUEST."&sender=".SMS_SENDER."&mobile=".$contact."&message=".$message."&route=".SMS_ROUTE."&TemplateID=".TEST_SCHEDULE_TEMPLATE."&format=JSON";
        
        $url = preg_replace("/ /", "%20", $url);

        $response = executeSmsTrigger($url);

    }

}