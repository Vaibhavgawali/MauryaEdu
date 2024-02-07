<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('getContenData')) {

    function getContenData() {
        $CI = & get_instance();
        $CI->load->library('session');
        $data['language'] = $CI->session->userdata('site_lang');
        $CI->lang->load('message', $data['language']);
        $data['welcome_message'] = $CI->lang->line('welcome_message');
        $data['short_desc'] = $CI->lang->line('short_desc');

        $data['languagetext'] = $CI->lang->line('languagetext');


        //--------------------------------Menu-----------------------
        $data['home'] = $CI->lang->line('home');
        $data['about'] = $CI->lang->line('about');
        $data['signIn'] = $CI->lang->line('signIn');
        $data['signUp'] = $CI->lang->line('signUp');
        $data['myAccout'] = $CI->lang->line('myAccout');
        $data['dashboard'] = $CI->lang->line('dashboard');
        $data['logout'] = $CI->lang->line('logout');


        $data['company'] = $CI->lang->line('company');
        $data['history'] = $CI->lang->line('history');
        $data['mission'] = $CI->lang->line('mission');
        $data['vision'] = $CI->lang->line('vision');
        $data['companyDetails'] = $CI->lang->line('companyDetails');
        $data['historyDetails'] = $CI->lang->line('historyDetails');
        $data['missionDetails'] = $CI->lang->line('missionDetails');
        $data['visionDetails'] = $CI->lang->line('visionDetails');
        $data['readMore'] = $CI->lang->line('readMore');


        $data['title'] = $CI->lang->line('title');
        $data['service'] = $CI->lang->line('service');
        $data['pricing'] = $CI->lang->line('pricing');
        $data['blog'] = $CI->lang->line('blog');
        $data['contact'] = $CI->lang->line('contact');
        $data['quote'] = $CI->lang->line('quote');
        $data['quote1'] = $CI->lang->line('quote1');
        $data['quote2'] = $CI->lang->line('quote2');

        $data['insurance'] = $CI->lang->line('insurance');
        $data['siteLanguage'] = $CI->lang->line('language');

        $data['learning'] = $CI->lang->line('learning');
        $data['career'] = $CI->lang->line('career');
        $data['claims'] = $CI->lang->line('claims');






        // --------------------------------------------About Page  Information---------------------------------------------------

        $data['abtTitle'] = $CI->lang->line('abtTitle');
        $data['welcomeMsg'] = $CI->lang->line('welcomeMsg');
        $data['abtBoldtitle'] = $CI->lang->line('abtBoldtitle');
        $data['abtShortDescTitle'] = $CI->lang->line('abtShortDescTitle');
        $data['abtShortDesc'] = $CI->lang->line('abtShortDesc');
        $data['abtCompanyInfo'] = $CI->lang->line('abtCompanyInfo');
        $data['abtCompanyShortInfo'] = $CI->lang->line('abtCompanyShortInfo');
        $data['abtCompanyShortInfo1'] = $CI->lang->line('abtCompanyShortInfo1');
        $data['abtCoreValues'] = $CI->lang->line('abtCoreValues');
        $data['abtCoreValue1'] = $CI->lang->line('abtCoreValue1');
        $data['abtCoreValue2'] = $CI->lang->line('abtCoreValue2');
        $data['abtCoreValue3'] = $CI->lang->line('abtCoreValue3');
        $data['abtCoreValue4'] = $CI->lang->line('abtCoreValue4');
        $data['abtCoreValue5'] = $CI->lang->line('abtCoreValue5');
        $data['abtCoreValue6'] = $CI->lang->line('abtCoreValue6');
        $data['abtCoreValue7'] = $CI->lang->line('abtCoreValue7');



        $data['cusEditButton'] = $CI->lang->line('cusEditButton');
        $data['cusRsCaption'] = $CI->lang->line('cusRsCaption');
        $data['cusPolicyTitle'] = $CI->lang->line('cusPolicyTitle');
        $data['cusPolicyStart'] = $CI->lang->line('cusPolicyStart');
        $data['cusPolicyEnd'] = $CI->lang->line('cusPolicyEnd');
        $data['cusPolicyNAME'] = $CI->lang->line('cusPolicyNAME');
        $data['cusPolicyNAME'] = $CI->lang->line('cusPolicyNAME');
        $data['SumInsured'] = $CI->lang->line('SumInsured');

        //navigation Details

        $data['cusNav1'] = $CI->lang->line('cusNav1');
        $data['cusNav2'] = $CI->lang->line('cusNav2');
        $data['cusNav3'] = $CI->lang->line('cusNav3');
        $data['cusNav4'] = $CI->lang->line('cusNav4');
        $data['cusNav5'] = $CI->lang->line('cusNav5');
        $data['cusNav6'] = $CI->lang->line('cusNav6');
        $data['cusNav7'] = $CI->lang->line('cusNav7');

        //Button Details
        $data['continue'] = $CI->lang->line('continue');
        $data['back'] = $CI->lang->line('back');

        // Owner Details
        $data['ownerDetails'] = $CI->lang->line('ownerDetails');
        $data['travellerDetails'] = $CI->lang->line('travellerDetails');
        $data['emailId'] = $CI->lang->line('emailId');
        $data['phoneNo'] = $CI->lang->line('phoneNo');
        $data['checkBox'] = $CI->lang->line('checkBox');


        $data['salutaion'] = $CI->lang->line('salutaion');
        $data['salutaion1'] = $CI->lang->line('salutaion1');
        $data['salutaion2'] = $CI->lang->line('salutaion2');
        $data['salutaion3'] = $CI->lang->line('salutaion3');
        $data['salutaion4'] = $CI->lang->line('salutaion4');

        $data['fName'] = $CI->lang->line('fName');
        $data['lName'] = $CI->lang->line('lName');
        $data['DOB'] = $CI->lang->line('DOB');
        $data['married'] = $CI->lang->line('married');
        $data['single'] = $CI->lang->line('single');

        //owner Details End
        //Nominee Details
        $data['nomineeDetails'] = $CI->lang->line('nomineeDetails');
        $data['nomiName'] = $CI->lang->line('nomiName');
        $data['nomiAge'] = $CI->lang->line('nomiAge');
        $data['relation'] = $CI->lang->line('relation');
        $data['relation1'] = $CI->lang->line('relation1');
        $data['relation2'] = $CI->lang->line('relation2');
        $data['relation3'] = $CI->lang->line('relation3');
        $data['relation4'] = $CI->lang->line('relation4');
        //Nominee Details End
        //Addess Infomation
        $data['addressInfo'] = $CI->lang->line('addressInfo');
        $data['addressInfo1'] = $CI->lang->line('addressInfo1');
        $data['addressInfo2'] = $CI->lang->line('addressInfo2');
        $data['city'] = $CI->lang->line('city');
        $data['pincode'] = $CI->lang->line('pincode');
        $data['state'] = $CI->lang->line('state');
        //Addess Infomation End
        // Vehicle Infomation
        $data['carRegNo'] = $CI->lang->line('carRegNo');
        $data['onLoad'] = $CI->lang->line('onLoad');
        $data['notOnLoan'] = $CI->lang->line('notOnLoan');
        $data['regDate'] = $CI->lang->line('regDate');
        $data['policyNo'] = $CI->lang->line('policyNo');
        $data['carEngineNo'] = $CI->lang->line('carEngineNo');
        $data['carChassisNo'] = $CI->lang->line('carChassisNo');
        $data['bikeEngineNo'] = $CI->lang->line('bikeEngineNo');
        $data['bikeChassisNo'] = $CI->lang->line('bikeChassisNo');
        // Vehicle Infomation End
// --------------------------------------------Register Pop up Start----------------------------------------------

        $data['rName'] = $CI->lang->line('rName');
        $data['rFullName'] = $CI->lang->line('rFullName');
        $data['eEmailText'] = $CI->lang->line('eEmailText');
        $data['mobile'] = $CI->lang->line('mobile');
        $data['rMobNo'] = $CI->lang->line('rMobNo');
        $data['rPassword'] = $CI->lang->line('rPassword');
        $data['rPasswordV'] = $CI->lang->line('rPasswordV');
        $data['rConfiRePass'] = $CI->lang->line('rConfiRePass');
        $data['rPasswordRe'] = $CI->lang->line('rPasswordRe');
        $data['rSecurityCode'] = $CI->lang->line('rSecurityCode');
        $data['rAns'] = $CI->lang->line('rAns');
        $data['rTermsNCond'] = $CI->lang->line('rTermsNCond');
        $data['rRegister'] = $CI->lang->line('rRegister');
        $data['rExistingU'] = $CI->lang->line('rExistingU');
        $data['rLogin'] = $CI->lang->line('rLogin');


// Error Msg

        $data['rEName'] = $CI->lang->line('rEName');
        $data['eEmail'] = $CI->lang->line('eEmail');
        $data['eMobile'] = $CI->lang->line('eMobile');
        $data['ePass'] = $CI->lang->line('ePass');
        $data['ePass1'] = $CI->lang->line('ePass1');
        $data['eSecurity'] = $CI->lang->line('eSecurity');
        $data['eTermsNCondi'] = $CI->lang->line('eTermsNCondi');
        $data['eMobilepopup'] = $CI->lang->line('eMobilepopup');





        $data['emailaddressvalid'] = $CI->lang->line('emailaddressvalid');
        $data['regpasswordmatch'] = $CI->lang->line('regpasswordmatch');


        $data['regmobexistchk'] = $CI->lang->line('regmobexistchk');
        $data['regemailexistchk'] = $CI->lang->line('regemailexistchk');
        $data['errormobnochk'] = $CI->lang->line('errormobnochk');
        $data['passworderrormsg'] = $CI->lang->line('passworderrormsg');
        $data['errorcaptcha'] = $CI->lang->line('errorcaptcha');
        $data['enterotp'] = $CI->lang->line('enterotp');




// $lang['']
// --------------------------------------------Register Pop up  End----------------------------------------------
// --------------------------------------------Login Pop up Start----------------------------------------------
        $data['lNameText'] = $CI->lang->line('lNameText');
        $data['forgotPass'] = $CI->lang->line('forgotPass');
        $data['loginWithOTP'] = $CI->lang->line('loginWithOTP');
        $data['doNotHaveAcc'] = $CI->lang->line('doNotHaveAcc');
        $data['accCreate'] = $CI->lang->line('accCreate');
// --------------------------------------------Login Pop up  End----------------------------------------------
// --------------------------------------------quotation Start----------------------------------------------
        $data['quoncb'] = $CI->lang->line('quoncb');
        $data['quomd'] = $CI->lang->line('quomd');
        $data['quord'] = $CI->lang->line('quord');
        $data['quoed'] = $CI->lang->line('quoed');
        $data['quopy'] = $CI->lang->line('quopy');



        $data['quotationofcar1'] = $CI->lang->line('quotationofcar1');
        $data['quotationofcar2'] = $CI->lang->line('quotationofcar2');
        $data['quotationofcar3'] = $CI->lang->line('quotationofcar3');
        $data['quotationofcar4'] = $CI->lang->line('quotationofcar4');

// --------------------------------------------quotation  End----------------------------------------------
// POP UP OF BREAK UP OF CAR quotation START

        $data['quotationofcarbreakup1'] = $CI->lang->line('quotationofcarbreakup1');
        $data['quotationofcarbreakup2'] = $CI->lang->line('quotationofcarbreakup2');
        $data['quotationofcarbreakup3'] = $CI->lang->line('quotationofcarbreakup3');
        $data['quotationofcarbreakup4'] = $CI->lang->line('quotationofcarbreakup4');
        $data['quotationofcarbreakup5'] = $CI->lang->line('quotationofcarbreakup5');
        $data['quotationofcarbreakup6'] = $CI->lang->line('quotationofcarbreakup6');
        $data['quotationofcarbreakup7'] = $CI->lang->line('quotationofcarbreakup7');
        $data['quotationofcarbreakup8'] = $CI->lang->line('quotationofcarbreakup8');
        $data['quotationofcarbreakup9'] = $CI->lang->line('quotationofcarbreakup9');
        $data['quotationofcarbreakup10'] = $CI->lang->line('quotationofcarbreakup10');
        $data['quotationofcarbreakup11'] = $CI->lang->line('quotationofcarbreakup11');
        $data['quotationofcarbreakup12'] = $CI->lang->line('quotationofcarbreakup12');

// $data['quotationofcarbreakup13']                =  'Age';
// $data['quotationofcarbreakup14']                =  'CC';
// $data['quotationofcarbreakup15']                =  'Fuel';
        $data['quotationofcarbreakup16'] = $CI->lang->line('quotationofcarbreakup16');
        $data['quotationofcarbreakup17'] = $CI->lang->line('quotationofcarbreakup17');
        $data['quotationofcarbreakup18'] = $CI->lang->line('quotationofcarbreakup18');
        $data['quotationofcarbreakup19'] = $CI->lang->line('quotationofcarbreakup19');
        $data['quotationofcarbreakup20'] = $CI->lang->line('quotationofcarbreakup20');
        $data['quotationofcarbreakup21'] = $CI->lang->line('quotationofcarbreakup21');
        $data['quotationofcarbreakup22'] = $CI->lang->line('quotationofcarbreakup22');
        $data['quotationofcarbreakup23'] = $CI->lang->line('quotationofcarbreakup23');
        $data['quotationofcarbreakup24'] = $CI->lang->line('quotationofcarbreakup24');
        $data['quotationofcarbreakup25'] = $CI->lang->line('quotationofcarbreakup25');


        $data['quotationofcarbreakup26'] = $CI->lang->line('quotationofcarbreakup26');
        $data['quotationofcarbreakup27'] = $CI->lang->line('quotationofcarbreakup27');


        $data['quotationofcarbreakup28'] = $CI->lang->line('quotationofcarbreakup28');

        $data['quotationofcarbreakup29'] = $CI->lang->line('quotationofcarbreakup29');
        $data['quotationofcarbreakup30'] = $CI->lang->line('quotationofcarbreakup30');
        $data['quotationofcarbreakup31'] = $CI->lang->line('quotationofcarbreakup31');
        $data['quotationofcarbreakup32'] = $CI->lang->line('quotationofcarbreakup32');
        $data['quotationofcarbreakup33'] = $CI->lang->line('quotationofcarbreakup33');
        $data['quotationofcarbreakup34'] = $CI->lang->line('quotationofcarbreakup34');
        $data['quotationofcarbreakup35'] = $CI->lang->line('quotationofcarbreakup35');
        $data['quotationofcarbreakup36'] = $CI->lang->line('quotationofcarbreakup36');



        $data['quotationofcarbreakup37'] = $CI->lang->line('quotationofcarbreakup37');
        $data['quotationofcarbreakup38'] = $CI->lang->line('quotationofcarbreakup38');
        $data['quotationofcarbreakup39'] = $CI->lang->line('quotationofcarbreakup39');



        $data['quotationofcarbreakuppremiumsumm'] = $CI->lang->line('quotationofcarbreakuppremiumsumm');
        $data['quotationofcarbreakup40'] = $CI->lang->line('quotationofcarbreakup40');
        $data['quotationofcarbreakup41'] = $CI->lang->line('quotationofcarbreakup41');
        $data['quotationofcarbreakup42'] = $CI->lang->line('quotationofcarbreakup42');
        $data['quotationofcarbreakup43'] = $CI->lang->line('quotationofcarbreakup43');
        $data['quotationofcarbreakup44'] = $CI->lang->line('quotationofcarbreakup44');
        $data['quotationofcarbreakup45'] = $CI->lang->line('quotationofcarbreakup45');
        $data['quotationofcarbreakup46'] = $CI->lang->line('quotationofcarbreakup46');
        $data['quotationofcarbreakup47'] = $CI->lang->line('quotationofcarbreakup47');


        $data['breakup'] = $CI->lang->line('breakup');


// POP UP OF BREAK UP OF CAR quotation END
//-------------------------------------------Home Page pop---------------------------------------------------
        $data['travel'] = $CI->lang->line('travel');
        $data['bike'] = $CI->lang->line('bike');
        $data['home'] = $CI->lang->line('home');
        $data['searchCountry'] = $CI->lang->line('searchCountry');
        $data['rtoncity'] = $CI->lang->line('rtoncity');

        $data['medicalcover'] = $CI->lang->line('medicalcover');

        $data['individual'] = $CI->lang->line('individual');
        $data['couple'] = $CI->lang->line('couple');
        $data['family'] = $CI->lang->line('family');
        $data['comarequote'] = $CI->lang->line('comarequote');



        $data['policyDetails1'] = $CI->lang->line('policyDetails1');
        $data['policyDetails2'] = $CI->lang->line('policyDetails2');
        $data['personalDetails'] = $CI->lang->line('personalDetails');



        $data['policyDetails11'] = $CI->lang->line('policyDetails11');
        $data['policyDetails12'] = $CI->lang->line('policyDetails12');
        $data['policyDetails13'] = $CI->lang->line('policyDetails13');
        $data['policyDetails14'] = $CI->lang->line('policyDetails14');
        $data['policyDetails15'] = $CI->lang->line('policyDetails15');
        $data['policyDetails16'] = $CI->lang->line('policyDetails16');
        $data['policyDetails17'] = $CI->lang->line('policyDetails17');
        $data['policyDetails18'] = $CI->lang->line('policyDetails18');
        $data['policyDetails19'] = $CI->lang->line('policyDetails19');



        $data['fillDetails1'] = $CI->lang->line('fillDetails1');
        $data['fillDetails2'] = $CI->lang->line('fillDetails2');
        $data['fillDetails3'] = $CI->lang->line('fillDetails3');
        $data['fillDetails4'] = $CI->lang->line('fillDetails4');
        $data['fillDetails5'] = $CI->lang->line('fillDetails5');
        $data['fillDetails6'] = $CI->lang->line('fillDetails6');
        $data['fillDetails7'] = $CI->lang->line('fillDetails7');
        $data['fillDetails8'] = $CI->lang->line('fillDetails8');
        $data['fillDetails9'] = $CI->lang->line('fillDetails9');
        $data['fillDetails10'] = $CI->lang->line('fillDetails10');
        $data['fillDetails11'] = $CI->lang->line('fillDetails11');
        $data['fillDetails12'] = $CI->lang->line('fillDetails12');
        $data['fillDetails13'] = $CI->lang->line('fillDetails13');
        $data['fillDetails14'] = $CI->lang->line('fillDetails14');
        $data['fillDetails15'] = $CI->lang->line('fillDetails15');
        $data['fillDetails16'] = $CI->lang->line('fillDetails16');

        $data['fillDetails17'] = $CI->lang->line('fillDetails17');
        $data['fillDetails18'] = $CI->lang->line('fillDetails18');
        $data['fillDetails19'] = $CI->lang->line('fillDetails19');
        $data['fillDetails20'] = $CI->lang->line('fillDetails20');
        $data['fillDetails21'] = $CI->lang->line('fillDetails21');
        $data['fillDetails22'] = $CI->lang->line('fillDetails22');
        $data['fillDetails23'] = $CI->lang->line('fillDetails23');
        ;

        $data['fillDetails24'] = $CI->lang->line('fillDetails24');
        $data['fillDetails25'] = $CI->lang->line('fillDetails25');
        $data['fillDetails26'] = $CI->lang->line('fillDetails26');
        $data['fillDetails27'] = $CI->lang->line('fillDetails27');
        $data['fillDetails28'] = $CI->lang->line('fillDetails28');


        $data['bikemanufa'] = $CI->lang->line('bikemanufa');
        $data['bikemodal'] = $CI->lang->line('bikemodal');
        $data['bikeyear'] = $CI->lang->line('bikeyear');
        $data['bikemonth'] = $CI->lang->line('bikemonth');

        $data['carmodal'] = $CI->lang->line('carmodal');
        $data['carmodalselect'] = $CI->lang->line('carmodalselect');
        $data['pvtcartitle'] = $CI->lang->line('pvtcartitle');

        $data['commercialModal'] = $CI->lang->line('commercialModal');
        $data['commercialmodalselect'] = $CI->lang->line('commercialmodalselect');
        $data['commercialtitle'] = $CI->lang->line('commercialtitle');

        $data['selectNCB'] = $CI->lang->line('selectNCB');

        $data['side2'] = $CI->lang->line('side2');
        $data['side3'] = $CI->lang->line('side3');
        $data['side4'] = $CI->lang->line('side4');
        $data['side5'] = $CI->lang->line('side5');
        $data['side6'] = $CI->lang->line('side6');







//-------------------------------------------Profile Satrt---------------------------------------------------

        $data['profiledetails1'] = $CI->lang->line('profiledetails1');
        $data['profiledetails2'] = $CI->lang->line('profiledetails2');
        $data['profiledetails3'] = $CI->lang->line('profiledetails3');
        $data['profiledetails4'] = $CI->lang->line('profiledetails4');
        $data['profiledetails5'] = $CI->lang->line('profiledetails5');
        $data['profiledetails6'] = $CI->lang->line('profiledetails6');
        $data['profiledetails7'] = $CI->lang->line('profiledetails7');
        $data['profiledetails8'] = $CI->lang->line('profiledetails8');
//------------------------------------------Profile End---------------------------------------------------
//----------------------------quotation Page for travel----------------------------------------------------
        $data['quotravel'] = $CI->lang->line('quotravel');
        $data['quotravel1'] = $CI->lang->line('quotravel1');
        $data['travelplandetail1'] = $CI->lang->line('travelplandetail1');
        $data['travelplandetail2'] = $CI->lang->line('travelplandetail2');
        $data['travelplandetail3'] = $CI->lang->line('travelplandetail3');
        $data['travelplandetail4'] = $CI->lang->line('travelplandetail4');
        $data['travelplandetail5'] = $CI->lang->line('travelplandetail5');
        $data['travelplandetail6'] = $CI->lang->line('travelplandetail6');
        $data['travelplandetail7'] = $CI->lang->line('travelplandetail7');
        $data['travelplandetail8'] = $CI->lang->line('travelplandetail8');
        $data['travelplandetail9'] = $CI->lang->line('travelplandetail9');
        $data['travelplandetail10'] = $CI->lang->line('travelplandetail10');
        $data['travelplandetail11'] = $CI->lang->line('travelplandetail11');
        $data['travelplandetail12'] = $CI->lang->line('travelplandetail12');
        $data['travelplandetail13'] = $CI->lang->line('travelplandetail13');
        $data['travelplandetail14'] = $CI->lang->line('travelplandetail14');
        $data['travelplandetail15'] = $CI->lang->line('travelplandetail15');
        $data['travelplandetail16'] = $CI->lang->line('travelplandetail16');




//travel pop up
        $data['age'] = $CI->lang->line('age');
        $data['self'] = $CI->lang->line('self');


        $data['buynow'] = $CI->lang->line('buynow');
        $data['buypolicy'] = $CI->lang->line('buypolicy');
        $data['closebtn'] = $CI->lang->line('closebtn');
        ;
        $data['previous'] = $CI->lang->line('previous');
        ;
        $data['policy'] = $CI->lang->line('policy');
        ;
        $data['oddiscount'] = $CI->lang->line('oddiscount');
        ;



//footer

        $data['footertext'] = $CI->lang->line('footertext');
        $data['footertext1'] = $CI->lang->line('footertext1');

        $data['calculatepremium'] = $CI->lang->line('calculatepremium');





//quotation for home Start

        $data['quotationhome1'] = $CI->lang->line('quotationhome1');
        $data['quotationhome2'] = $CI->lang->line('quotationhome2');
        $data['quotationhome3'] = $CI->lang->line('quotationhome3');
        $data['quotationhome4'] = $CI->lang->line('quotationhome4');
        $data['quotationhome5'] = $CI->lang->line('quotationhome5');
        $data['quotationhome6'] = $CI->lang->line('quotationhome6');
        $data['quotationhome7'] = $CI->lang->line('quotationhome7');


//quotation for home End
//quotation pop up detatils Start

        $data['quotationpopup1'] = $CI->lang->line('quotationpopup1');
        $data['quotationpopup2'] = $CI->lang->line('quotationpopup2');
        $data['quotationpopup3'] = $CI->lang->line('quotationpopup3');
        $data['quotationpopup4'] = $CI->lang->line('quotationpopup4');
        $data['quotationpopup5'] = $CI->lang->line('quotationpopup5');
        $data['quotationpopup6'] = $CI->lang->line('quotationpopup6');
        $data['quotationpopup7'] = $CI->lang->line('quotationpopup7');
//quotation pop up detatils End
//quotation pop up of premium break up detatils Start

        $data['quotationpopuppremiumbup1'] = $CI->lang->line('quotationpopuppremiumbup1');
        $data['quotationpopuppremiumbup2'] = $CI->lang->line('quotationpopuppremiumbup2');
        $data['quotationpopuppremiumbup3'] = $CI->lang->line('quotationpopuppremiumbup3');
        $data['quotationpopuppremiumbup4'] = $CI->lang->line('quotationpopuppremiumbup4');
        $data['quotationpopuppremiumbup5'] = $CI->lang->line('quotationpopuppremiumbup5');
        $data['quotationpopuppremiumbup6'] = $CI->lang->line('quotationpopuppremiumbup6');

//quotation  pop up of premium break up detatils End
//quotation page of car Start
//Accessories
        $data['quotationaccesspop1'] = $CI->lang->line('quotationaccesspop1');
        $data['quotationaccesspop2'] = $CI->lang->line('quotationaccesspop2');
        $data['quotationaccesspop3'] = $CI->lang->line('quotationaccesspop3');

//Geographical Extension
        $data['quotationgeoextpop1'] = $CI->lang->line('quotationgeoextpop1');
        $data['quotationgeoextpop2'] = $CI->lang->line('quotationgeoextpop2');
        $data['quotationgeoextpop3'] = $CI->lang->line('quotationgeoextpop3');
        $data['quotationgeoextpop4'] = $CI->lang->line('quotationgeoextpop4');
        $data['quotationgeoextpop5'] = $CI->lang->line('quotationgeoextpop5');
        $data['quotationgeoextpop6'] = $CI->lang->line('quotationgeoextpop6');
        $data['quotationgeoextpop7'] = $CI->lang->line('quotationgeoextpop7');

//Geographical Extension
        $data['quotationdeduextpop1'] = $CI->lang->line('quotationdeduextpop1');
        $data['quotationdeduextpop2'] = $CI->lang->line('quotationdeduextpop2');
        $data['quotationdeduextpop3'] = $CI->lang->line('quotationdeduextpop3');


//Geographical Extension
        $data['quotationpacoverpop1'] = $CI->lang->line('quotationpacoverpop1');
        $data['quotationpacoverpop2'] = $CI->lang->line('quotationpacoverpop2');
        $data['quotationpacoverpop3'] = $CI->lang->line('quotationpacoverpop3');
        $data['quotationpacoverpop4'] = $CI->lang->line('quotationpacoverpop4');
        $data['quotationpacoverpop5'] = $CI->lang->line('quotationpacoverpop5');
        $data['quotationpacoverpop6'] = $CI->lang->line('quotationpacoverpop6');
        $data['quotationpacoverpop7'] = $CI->lang->line('quotationpacoverpop7');
        $data['quotationpacoverpop8'] = $CI->lang->line('quotationpacoverpop8');


        $data['quotationpacoverpop9'] = $CI->lang->line('quotationpacoverpop9');



        $data['verify'] = $CI->lang->line('verify');
        $data['otpnotmatch'] = $CI->lang->line('otpnotmatch');
        $data['makemodel'] = $CI->lang->line('makemodel');



//quotation page of car End

        $data['occupationselect'] = $CI->lang->line('occupationselect');

        return $data;
    }

}
?>