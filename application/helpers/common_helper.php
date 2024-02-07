<?php
ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');

/*  Add CSS to template  */
if (!function_exists('addCss')) {

    function addCss($css) {
        $ci = &get_instance();
        if ($css)
            if (is_array($css))
                $ci->data['css_files'] = array_merge($ci->data['css_files'], $css);
            else
                $ci->data['css_files'][] = $css;
    }

}

/*  Add JS to template  */
if (!function_exists('addJs')) {

    function addJs($js) {
        $ci = &get_instance();
        if ($js)
            if (is_array($js))
                $ci->data['js_files'] = array_merge($ci->data['js_files'], $js);
            else
                $ci->data['js_files'][] = $js;
    }

}

/*  Load CSS to template  */
if (!function_exists('loadCss')) {

    function loadCss() {
        $ci = &get_instance();
        $html = '';
        foreach ($ci->data['css_files'] as $value) {
            $html .= '<link rel="stylesheet" type="text/css"  href="' . getCssUrl($value) . '">' . "\n";
        }
        echo $html;
    }

}

/*  Load JS to template  */
if (!function_exists('loadJs')) {

    function loadJs() {
        $ci = &get_instance();
        $html = '';
        foreach ($ci->data['js_files'] as $value) {
            $html .= '<script type="text/javascript" src="' . getJsUrl($value) . '"></script>' . "\n";
        }
        echo $html;
    }
    
}

/*  get meta tags  */
if (!function_exists('getMetaTags')) {

    function getMetaTags($meta_tags) {
        $meta_html = '';
        foreach ($meta_tags as $meta_key => $meta_value) {
            $meta_html .= '<meta name="' . $meta_key . '" content="' . $meta_value . '">' . "\n";
        }
        return $meta_html;
    }

}



if (!function_exists('getPartnerCss')) {

    function getPartnerCss($application_version = '?v=g100') {
        $ci = &get_instance();
        $html = '';
        $partner_detail = ($ci->session->userdata('partner_detail')) ? $ci->session->userdata('partner_detail') : '';
        // echo "<pre>"; print_r($partner_detail); echo "</pre>"; die('end of print');
        if ((isset($partner_detail['css_file_name'])) && !empty($partner_detail['css_file_name'])) {
            $html .= '<link rel="stylesheet" type="text/css"  href="' . getCssUrl($partner_detail['css_file_name'], $application_version) . '">' . "\n";
        }
        echo $html;
    }
}

if (!function_exists('getUrl')) {

    function getUrl($url = null) {
        return site_url($url);
    }

}

if (!function_exists('getJs')) {

    function getJs($script = null) {
        return '<script type="text/javascript" src="' . getUrl("assets/js/" . $script) . '"></script>';
    }

}

if (!function_exists('getJsUrl')) {

    function getJsUrl($script = null) {
        if (strstr($script, 'http')) {
            return $script;
        }
        return getUrl("assets/js/" . $script);
    }

}

if (!function_exists('getCss')) {

    function getCss($style) {
        return '<link rel="stylesheet" type="text/css"  href="' . getUrl("assets/css/" . $style) . '">';
    }

}

if (!function_exists('getCssUrl')) {

    function getCssUrl($style = null) {
        return getUrl("assets/css/" . $style);
    }

}

if (!function_exists('getImage')) {

    function getImage($image, $class = '', $id = '') {
        return ' <img class="' . $class . '" id="' . $id . '" src="' . getUrl("assets/images/" . $image) . '">';
    }

}

if (!function_exists('getImageUrl')) {

    function getImageUrl($image = null) {
        return getUrl("assets/images/" . $image);
    }

}

/*  Insert into table  */
if (!function_exists('insertIntoTable')) {
    function insertIntoTable($table_name, $data) {
        $ci = &get_instance();
        if ($ci->db->insert($table_name, $data)) {
            return $ci->db->insert_id();
        } else {
            return false;
        }
    }
}

/*  Send email with single attachments  */
if (!function_exists('sendEmail')) {

    function sendEmail($to='', $subject='', $message='', $from = "", $name = "", $attachement_title='', $attachement='',$cc=null) {
        $ci = & get_instance();
        
        $ci->load->library('email');
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => SMTP_HOST,
            'smtp_port' => SMTP_PORT,
            'smtp_user' => SMTP_USER, // change it to yours
            '_smtp_auth' => TRUE,
            'smtp_pass' => SMTP_PASSWORD, // change it to yours
            'smtp_crypto' => 'tls',
            'smtp_timeout'=>20,
            'mailtype' => 'html',
            //'starttls'  => true,
            'newline'   => "\r\n",
            'wordwrap' => TRUE
        );

        $ci->email->initialize($config);// add this line
        
        if ($attachement != "") {
            $ci->email->attach($attachement);
            //$ci->email->attach($attachement, 'attachment', $attachement_title.'.pdf', 'application/pdf');
        }

        $ci->email->from(SMTP_USER, SMTP_FROM_NAME);
        $ci->email->to($to);

        if($cc!="")
        {
        $ci->email->cc($cc);
        }

        $ci->email->subject($subject);
        $ci->email->message($message);
        if ($ci->email->send()){
            return true;
        }else{
            echo "<pre>"; print_r($ci->email->print_debugger());
            //return $ci->email->print_debugger();

            return false;
        }
    }
}
    
/*  Send email with multiple attachments  */
if (!function_exists('sendEmailMultipleAttachments')) {

    function sendEmailMultipleAttachments($to, $subject, $message, $from = "", $name = "", $attachement='', $cc=null) {

        $ci = & get_instance();
        
        $ci->load->library('email');
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => SMTP_HOST,
            'smtp_port' => SMTP_PORT,
            'smtp_user' => SMTP_USER, // change it to yours
            'smtp_pass' => SMTP_PASSWORD, // change it to yours
            'smtp_timeout'=>20,
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $ci->email->initialize($config);// add this line

        if(!empty($attachement)){
            foreach ($attachement as $key => $value) {
                $ci->email->attach($value);
                $ci->email->attach($value, 'attachment', $key, 'application/pdf');
            }
        }
        
        $ci->email->from(SMTP_USER, SMTP_FROM_NAME);
        $ci->email->to($to);

        if($cc!="")
        {
        $ci->email->cc($cc);
        }

        $ci->email->subject($subject);
        $ci->email->message($message);
        if ($ci->email->send()){
            return true;
        }else{
            return $ci->email->print_debugger();
            //return false;
        }
    }

}

/*  print array  */ 
if (!function_exists('print_r_custom')) 
{
    function print_r_custom($data,$die=false) 
    { 
        echo "<pre>";print_r($data);echo "</pre>";
        if($die){
            die;
        }
    }
}

/*  dump array  */ 
if (!function_exists('var_dump_custom')) 
{
    function var_dump_custom($data,$die=false) 
    { 
        echo "<pre>";var_dump($data);echo "</pre>";
        if($die){
            die;
        }
    }
}

/*  Generate random password  */
if (!function_exists('GeneratePassword')) { 
    function GeneratePassword()
    {
        $Special_char_string = '[!@#$%)*_(+=}{|:;,.>}]'; 
        $pos1 = rand(0,(strlen($Special_char_string)-1));
        $pass1 = $Special_char_string[$pos1];

        $Capital_char_string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $pos2 = rand(0,(strlen($Capital_char_string)-1));
        $pass2 = $Capital_char_string[$pos2];

        $Number_char_string = '1234567890'; 
        $pos3 = rand(0,(strlen($Number_char_string)-1));
        $pass3 = $Number_char_string[$pos3];

        $salt = "abchefghjkmnpqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);

        $i = 0;
        while ($i <= 5) 
        {
            $num = rand() % 33;
            $tmp = substr($salt, $num, 1);
            $pass1 = $pass1 . $tmp;
            $i++;
        }
            
        $new_pass = $pass2.$pass3.$pass1;

        return $new_pass;
    }
}


/*  Get page title  */
if (!function_exists('getPageTitle')) { 
    function getPageTitle(){
        $a = pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME);
        $string = str_replace("-", " ", $a);
        $title = ucwords($string).' - '.COMPANY_NAME;

        return $title;
    }
}

/*  Quote variable to make safe  */ 
if (!function_exists('filter_smart'))
{
    function filter_smart($value)
    {
        // Strip HTML & PHP tags & convert all applicable characters to HTML entities
        $value = trim(htmlentities(strip_tags($value)));    

        $value = filter_var(trim($value), FILTER_SANITIZE_STRING);

        return $value;
    }
}


if (!function_exists('checkAdminLoginSession'))
{
    function checkAdminLoginSession()
    {

        $CI = &get_instance();
        $page1 = $CI->uri->segment(1);
        $page2 = $CI->uri->segment(2);
        //print_r($page1);exit;
        $login_detail = $CI->session->userdata('login_detail');
        //print_r_custom($login_detail,1);
        if((empty($CI->session->userdata('login_detail'))) || $login_detail && ($login_detail['userinfo_id'] < 1)){
                  
            redirect(base_url().'admin/login','refresh');
            die();

        }          
       
    }
}

if (!function_exists('checkBranchAdminLoginSession'))
{
    function checkBranchAdminLoginSession()
    {

        $CI = &get_instance();
        $page1 = $CI->uri->segment(1);
        $page2 = $CI->uri->segment(2);
        //print_r($page1);exit;
        $login_detail = $CI->session->userdata('login_detail');
        // print_r_custom($login_detail,1);
        if((empty($CI->session->userdata('login_detail'))) || ($login_detail['admin_id'] < 1)){
                  
            redirect(base_url().'subadmin/login','refresh');
            die();

        }          
       
    }
}


if (!function_exists('checkStudentLoginSession'))
{
    function checkStudentLoginSession()
    {

        $CI = &get_instance();
        $page1 = $CI->uri->segment(1);
        $page2 = $CI->uri->segment(2);
        //print_r($page1);exit;
        $login_detail = $CI->session->userdata('student_login_detail');
        //print_r_custom($login_detail,1);
        if(empty($login_detail) || ($login_detail['student_id'] < 1)){
                  
            redirect(base_url().'student/login','refresh');
            die();

        }          
       
    }
}

if (!function_exists('GenerateTCPDF')) {
    function GenerateTCPDF($view_html, $pdf_title, $pdf_action, $pdf_name, $extra_paramter) {
        //print_r_custom($view_html, 1);
        $style = '<style>
            .pagewrap {color: #333; font-size: 6.5pt; line-height:9pt;}
            .textcenter {text-align:center;}
            .textleft {text-align:left;}
            .textright {text-align:right;}
            .font-7{font-size: 7pt; line-height:9pt;}
            .font-8{font-size: 8pt; line-height:10pt;}
            .font-9{font-size: 9pt; line-height:11pt;}
            .font-10{font-size: 10pt; line-height:12pt;}
            .font-11{font-size: 11pt; line-height:13pt;}
            .font-12{font-size: 11pt; line-height:14pt;}
            .font-13{font-size: 11pt; line-height:15pt;}
            .font-14{font-size: 11pt; line-height:16pt;}
            .font-15{font-size: 11pt; line-height:17pt;}
            .line-height-9{line-height:9pt;}
            .line-height-10{line-height:10pt;}
            .line-height-11{line-height:11pt;}
            .line-height-12{line-height:12pt;}
            .line-height-13{line-height:13pt;}
            .line-height-14{line-height:14pt;}
            .line-height-15{line-height:15pt;}
            .line-height-16{line-height:16pt;}
            .line-height-17{line-height:17pt;}
            .line-height-18{line-height:18pt;}
            .line-height-19{line-height:19pt;}
            .line-height-20{line-height:20pt;}
            .proposal-header {background-color:#ffd000 ;}
            .headertext {font-size:14pt; line-height:16pt; color:#1a1446;}
            .border, .boxtable td, th {border:1px solid #000000;vertical-align: middle!important;}
            .heading {background-color:#f4f4f4;}
            .sectionhead { font-size:7.5pt; line-height:12pt; background-color:#78e1e1; color:#1a1446; font-weight:bold;}
            .footer {border-top:0.5px solid #808080; text-align:center; line-height:9pt;}
        </style>';
        
        //echo '<pre>'; print_r($view_html);die('here');
        $CI = &get_instance();
        $CI->load->library('tcpdf/tcpdf.php');
        ob_start();
        $pdf = new TCPDF();
        $pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->AddPage();
        //$pdf->Image($img_file, 0, 0, 10, 297, 1000, '', 500, false, 300, '', false, false, 0);
        $pdf->setTitle($pdf_title);
        $pdf->writeHTML($style.$view_html);
        ob_clean();
        
        $pdf->Output('tcpdfexample-onlinecode.pdf', 'I');

        return $pdf;
    }
}

if (!function_exists('getShortUrl')) {
    function getShortUrl($long_url) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://roaqua.in/?url='.$long_url,
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

if (!function_exists('convertNumberToWord')) {

    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = ucwords($hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? '' . $list3[$levels] . '' : '' ));
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode('', $words);
    }
}


function convertNumberToWord2($number = false)
{
    $hyphen      = '-';
    $conjunction = ' And ';
    $separator   = ', ';
    $negative    = 'Negative ';
    $decimal     = ' Rupees ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        100000             => 'Lakh',
        10000000          => 'Crore'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convertNumberToWord only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumberToWord(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convertNumberToWord($remainder);
            }
            break;
        case $number < 100000:
            $thousands   = ((int) ($number / 1000));
            $remainder = $number % 1000;

            $thousands = convertNumberToWord($thousands);

            $string .= $thousands . ' ' . $dictionary[1000];
            if ($remainder) {
                $string .= $separator . convertNumberToWord($remainder);
            }
            break;
        case $number < 10000000:
            $lakhs   = ((int) ($number / 100000));
            $remainder = $number % 100000;

            $lakhs = convertNumberToWord($lakhs);

            $string = $lakhs . ' ' . $dictionary[100000];
            if ($remainder) {
                $string .= $separator . convertNumberToWord($remainder);
            }
            break;
        case $number < 1000000000:
            $crores   = ((int) ($number / 10000000));
            $remainder = $number % 10000000;

            $crores = convertNumberToWord($crores);

            $string = $crores . ' ' . $dictionary[10000000];
            if ($remainder) {
                $string .= $separator . convertNumberToWord($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convertNumberToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumberToWord($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}