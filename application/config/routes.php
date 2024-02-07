<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// $route['default_controller'] = 'student/Login';
$route['default_controller'] = 'course/Course/courses_list';

//---[START] -------   ADMIN
$route['admin'] = 'admin/Login';
$route['admin/login'] = 'admin/Login';
$route['admin/login-process'] = 'admin/Login/LoginProcess';
$route['admin/dashboard'] = 'admin/Dashboard';

//--- Student list
$route['admin/student-list'] = 'admin/Student';
$route['admin/student-list-ajax'] = 'admin/Student/StudentListAjax';
$route['admin/get-student-info'] = 'admin/Student/GetStudentDetails';
$route['admin/student-update-process'] = 'admin/Student/StudentUpdateProcess';
$route['admin/reset-student-password'] = 'admin/Student/ResetStudentPassword';
$route['admin/delete-student'] = 'admin/Student/DeleteStudent';

//--- Course Category list
$route['admin/course-category-list'] = 'admin/CourseCategory';
$route['admin/course-category-add-process'] = 'admin/CourseCategory/CourseCategoryAddProcess';
$route['admin/course-category-list-ajax'] = 'admin/CourseCategory/CourseCategoryListAjax';
$route['admin/get-course-category-detail'] = 'admin/CourseCategory/GetCourseCategoryDetails';
$route['admin/course-category-update-process'] = 'admin/CourseCategory/CourseCategoryUpdateProcess';

//--- Branch list
$route['admin/branch-list'] = 'admin/Branch';
$route['admin/branch-add-process'] = 'admin/Branch/BranchAddProcess';
$route['admin/branch-list-ajax'] = 'admin/Branch/BranchListAjax';
$route['admin/get-branch-detail'] = 'admin/Branch/GetBranchDetails';
$route['admin/branch-update-process'] = 'admin/Branch/BranchUpdateProcess';

//--- Branch Admin list
$route['admin/branch-admin-list'] = 'admin/BranchAdmin';
$route['admin/branch-admin-add-process'] = 'admin/BranchAdmin/BranchAdminAddProcess';
$route['admin/branch-admin-list-ajax'] = 'admin/BranchAdmin/BranchAdminListAjax';
$route['admin/get-branch-admin-detail'] = 'admin/BranchAdmin/GetBranchAdminDetails';
$route['admin/branch-admin-update-process'] = 'admin/BranchAdmin/BranchAdminUpdateProcess';
$route['admin/reset-branch-admin-password'] = 'admin/BranchAdmin/ResetBranchAdminPassword';

//--- Course list
$route['admin/course-list'] = 'admin/Course';
$route['admin/course-add-process'] = 'admin/Course/CourseAddProcess';
$route['admin/course-list-ajax'] = 'admin/Course/CourseListAjax';
$route['admin/get-course-detail'] = 'admin/Course/GetCourseDetails';
$route['admin/course-update-process'] = 'admin/Course/CourseUpdateProcess';
$route['admin/new-course-send-notification'] = 'admin/Course/NewCourseSendNotification';
$route['admin/delete-course'] = 'admin/Course/CourseDelete';


//--- Chapter list
$route['admin/chapter-list'] = 'admin/Chaper';
$route['admin/get-course-list-from-category'] = 'admin/Chaper/GetCourseListFromCategory';
$route['admin/chapter-add-process'] = 'admin/Chaper/ChaperAddProcess';
$route['admin/chapter-list/(:any)'] = 'admin/Chaper/AddCourseChapter/$1';
$route['admin/chapter-list-ajax'] = 'admin/Chaper/ChaperListAjax';
$route['admin/get-chapter-detail'] = 'admin/Chaper/GetChaperDetails';
$route['admin/chapter-update-process'] = 'admin/Chaper/ChaperUpdateProcess';

//--- Sub-chapter list
$route['admin/sub-chapter-list'] = 'admin/SubChaper';
$route['admin/get-chapter-list-from-course'] = 'admin/SubChaper/GetCapterListFromCourse';
$route['admin/sub-chapter-add-process'] = 'admin/SubChaper/SubChaperAddProcess';
$route['admin/sub-chapter-list/(:any)'] = 'admin/SubChaper/AddCourseSubChaper/$1';
$route['admin/sub-chapter-list-ajax'] = 'admin/SubChaper/SubChaperListAjax';
$route['admin/get-sub-chapter-detail'] = 'admin/SubChaper/GetSubChaperDetails';
$route['admin/sub-chapter-update-process'] = 'admin/SubChaper/SubChaperUpdateProcess';

//--- course video list
$route['admin/course-videos/(:any)'] = 'admin/CourseVideos/CourseVideosData/$1';
$route['admin/course-videos-add-process'] = 'admin/CourseVideos/CourseVideosAddProcess';
$route['admin/course-videos-list-ajax'] = 'admin/CourseVideos/CourseVideosListAjax';
$route['admin/course-videos-update-process'] = 'admin/CourseVideos/CourseVideosUpdateProcess';

//--- Chapter data
$route['admin/chapter-data/(:any)'] = 'admin/ChapterDocuments/ChapterDocumentsDetails/$1';
$route['admin/chapter-document-add-process'] = 'admin/ChapterDocuments/ChapterDocumentsAddProcess';
$route['admin/chapter-document-list-ajax'] = 'admin/ChapterDocuments/ChapterDocumentsListAjax';
$route['admin/chapter-document-update-process'] = 'admin/ChapterDocuments/ChapterDocumentsUpdateProcess';

//--- Sub Chapter data
$route['admin/sub-chapter-data/(:any)'] = 'admin/SubChapterDocuments/SubChapterDocumentsDetails/$1';
$route['admin/sub-chapter-document-add-process'] = 'admin/SubChapterDocuments/SubChapterDocumentsAddProcess';
$route['admin/sub-chapter-document-list-ajax'] = 'admin/SubChapterDocuments/SubChapterDocumentsListAjax';
$route['admin/sub-chapter-document-update-process'] = 'admin/SubChapterDocuments/SubChapterDocumentsUpdateProcess';

//--- Test records
$route['admin/test-records'] = 'admin/TestRecords';
$route['admin/test-records-add'] = 'admin/TestRecords/AddTestRecords';
$route['admin/test-records-list-ajax'] = 'admin/TestRecords/TestRecordsListAjax';
$route['admin/test-records-update'] = 'admin/TestRecords/UpdateTestRecords';
$route['admin/send-test-result-notification'] = 'admin/TestRecords/SendTestResultNotification';

//--- Announcements
$route['admin/announcements'] = 'admin/Announcements';
$route['admin/announcements-add'] = 'admin/Announcements/AddAnnouncements';
$route['admin/announcements-list-ajax'] = 'admin/Announcements/AnnouncementsListAjax';
$route['admin/announcements-update'] = 'admin/Announcements/UpdateAnnouncements';

//--- Test Scheduling
$route['admin/test-schedules'] = 'admin/TestSchedules';
$route['admin/test-schedules-add'] = 'admin/TestSchedules/AddTestSchedules';
$route['admin/test-schedules-list-ajax'] = 'admin/TestSchedules/TestSchedulesListAjax';
$route['admin/test-schedules-update'] = 'admin/TestSchedules/UpdateTestSchedules';
$route['admin/test-schedule-send-notification'] = 'admin/TestSchedules/TestSchedulesSendNotification';

//--- PT meetings
$route['admin/pt-meetings'] = 'admin/PtMeetings';
$route['admin/pt-meetings-add'] = 'admin/PtMeetings/AddPtMeetings';
$route['admin/pt-meetings-list-ajax'] = 'admin/PtMeetings/PtMeetingsListAjax';
$route['admin/pt-meetings-update'] = 'admin/PtMeetings/UpdatePtMeetings';
$route['admin/pt-meetings-send-notification'] = 'admin/PtMeetings/PtMeetingsSendNotification';

//--- Holiday Information
$route['admin/holiday-information'] = 'admin/HolidayInformation';
$route['admin/holiday-information-add'] = 'admin/HolidayInformation/AddHolidayInformation';
$route['admin/holiday-information-list-ajax'] = 'admin/HolidayInformation/HolidayInformationListAjax';
$route['admin/holiday-information-update'] = 'admin/HolidayInformation/UpdateHolidayInformation';
$route['admin/holiday-information-send-notification'] = 'admin/HolidayInformation/HolidayInformationSendNotification';

//----Enrollments
$route['admin/enrollment-list'] = 'admin/Enrollments';
$route['admin/enrollment-list-ajax'] = 'admin/Enrollments/StudentListAjax';
$route['admin/get-enrollment-student-details'] = 'admin/Enrollments/GetEnrollmentStudentsDetails';
$route['admin/enrollment-student-update-process'] = 'admin/Enrollments/EnrollmentStudentUpdateProcess';
$route['admin/student-enrollemnt-delete'] = 'admin/Enrollments/DeleteEnrollmentStudent';

//--- Discount Coupon info
$route['admin/discount-coupon'] = 'admin/DiscountCoupon';
$route['admin/discount-coupon-add'] = 'admin/DiscountCoupon/AddDiscountCoupon';
$route['admin/discount-coupon-list-ajax'] = 'admin/DiscountCoupon/DiscountCouponListAjax';
$route['admin/discount-coupon-update'] = 'admin/DiscountCoupon/UpdateDiscountCoupon';

//----Contact Us List
$route['admin/contact-list'] = 'admin/Contacts';
$route['admin/contact-list-ajax'] = 'admin/Contacts/ContactsListAjax';
$route['admin/contact-delete'] = 'admin/Contacts/DeleteContact';

$route['admin/logout'] = 'admin/Login/Logout';
//---[END]


//---[START] -------   STUDENTS
$route['student/register'] = 'student/Register';
$route['student/register-process'] = 'student/Register/RegisterProcess';
$route['verifyStudentEmailAddress'] = 'student/Register/verifyStudentEmailAddress';

$route['student/login'] = 'student/Login';
$route['student/login-process'] = 'student/Login/LoginProcess';

$route['student/forgot-password'] = 'student/Login/ForgotPassword';
$route['student/forgot-password-process'] = 'student/Login/ForgotPasswordProcess';

$route['student/dashboard'] = 'student/Dashboard';

$route['student/my-profile'] = 'student/MyProfile';
$route['student/update-profile-pic'] = 'student/MyProfile/UpdateProfilePicture';
$route['student/update-contact-details'] = 'student/MyProfile/UpdateProfileContactDetails';
$route['student/change-password'] = 'student/MyProfile/ChangePassword';
$route['student/change-password-process'] = 'student/MyProfile/ChangePasswordProcess';

$route['student/logout'] = 'student/Login/Logout';

$route['student/courses-list'] = 'student/Courselist/courses_list';
$route['student/course/get-course-list'] = 'student/Courselist/courses_listAjax';
$route['student/course-details/(:any)'] = 'student/Courselist/getCourseDetails/$1';

$route['student/enrolled-courses-list'] = 'student/Courselist/enrolled_courses_list';
$route['student/get-enrolled-course-list'] = 'student/Courselist/enrolledcourses_listAjax';
$route['student/enrolled-course-details/(:any)'] = 'student/Courselist/getEnrolledCourseDetails/$1';

//---[START] -------   Course List without student login
$route['courses-list'] = 'course/Course/courses_list';
$route['course/get-course-list'] = 'course/Course/courses_listAjax';
//---[END] -------   Course List without student login


//---[START] -------   Cart
$route['student/add-to-cart'] = 'student/Cart/add_to_cart';
$route['student/view-cart'] = 'student/Cart/view_cart';
$route['student/remove-from-cart'] = 'student/Cart/remove_from_cart';
$route['student/checkout'] = 'student/Cart/checkout';
//---[END] -------   Cart
 
//---[START] -------   test results
$route['student/test-results'] = 'student/TestResults';
$route['student/test-results-list-ajax'] = 'student/TestResults/TestResultsListAjax';
//---[END] -------   test results

//---[START] -------   Announcements
$route['student/announcements'] = 'student/Announcements';
$route['student/announcements-list-ajax'] = 'student/Announcements/AnnouncementsListAjax';
//---[END] -------   Announcements

//---[START] -------   Test Schedules
$route['student/test-schedules'] = 'student/TestSchedules';
$route['student/test-schedules-list-ajax'] = 'student/TestSchedules/TestSchedulesListAjax';
//---[END] -------   Test Schedules

//---[START] -------   Razor Pay
$route['razorpay/callback'] = 'RazorPay/callback';
$route['razorpay/success'] = 'RazorPay/success';
$route['razorpay/failed'] = 'RazorPay/failed';
//---[END] -------   Razor Pay


//---[START] -------   Dashboard links
$route['student/live-lecture'] = 'student/Dashboard/live_lecture';
$route['student/video-lecture-list-ajax'] = 'student/Dashboard/videolecturesListAjax';

$route['student/theory-booklet'] = 'student/Dashboard/theory_booklet';

// $route['student/practice-assignments'] = 'student/Dashboard/practice_assignments';
//---[END] -------   Dashboard links

//---[START] -------   Parent Teacher Meeting
$route['student/pt-meetings'] = 'student/ParentTeacherMeetings';
$route['student/pt-meetings-list-ajax'] = 'student/ParentTeacherMeetings/ParentTeacherMeetingsListAjax';
//---[END] -------   Parent Teacher Meeting

//---[START] -------   Holiday Info
$route['student/holiday-information'] = 'student/HolidayInformation';
$route['student/holiday-information-list-ajax'] = 'student/HolidayInformation/HolidayInformationListAjax';
//---[END] -------   Holiday Info


//---[START] -------   Apply Coupon
$route['student/apply-coupon'] = 'student/Cart/applyCoupon';
//---[START] -------   Apply Coupon


//view pdf
// $route['student/view_pdf'] = 'student/Courselist/view_pdf';


//mobile-app-apis
$route['api/register'] = 'api/Api/register' ;
$route['api/login'] = 'api/Api/login' ;
$route['api/courses_list'] = 'api/Api/courses_list' ;
$route['api/enrolled_course_list'] = 'api/Api/enrolled_course_list' ;
$route['api/view_course_details'] = 'api/Api/view_course_details' ;
$route['api/test_results'] = 'api/Api/test_results' ;
$route['api/student_profile'] = 'api/Api/student_profile' ;
$route['api/forgot_password'] = 'api/Api/forgot_password' ;
$route['api/lecture_links'] = 'api/Api/lecture_links' ;
$route['api/test_schedules'] = 'api/Api/test_schedules' ;
$route['api/announcements'] = 'api/Api/announcements' ;
$route['api/parent_teachers_meetings'] = 'api/Api/parent_teachers_meetings' ;
$route['api/holiday_info'] = 'api/Api/holiday_info' ;
$route['api/change_password'] = 'api/Api/change_password' ;
$route['api/update_contact_details'] = 'api/Api/update_contact_details' ;
$route['api/buy_product'] = 'api/Api/buy_product' ;
$route['api/apply_coupon'] = 'api/Api/apply_coupon' ;
$route['api/booklets'] = 'api/Api/booklets' ;
$route['api/payment_params'] = 'api/Api/payment_params' ;
$route['api/app_payment_response'] = 'api/Api/app_payment_response' ;

//---[END]


//---[START] -------   SUBADMIN
$route['subadmin'] = 'subadmin/Login';
$route['subadmin/login'] = 'subadmin/Login';
$route['subadmin/login-process'] = 'subadmin/Login/LoginProcess';
$route['subadmin/dashboard'] = 'subadmin/Dashboard';

$route['verifyBranchAdminEmailAddress'] = 'student/BranchAdmin/verifyBranchAdminEmailAddress';

$route['subadmin/logout'] = 'subadmin/Login/Logout';

//--- Student list
$route['subadmin/student-list'] = 'subadmin/Student';
$route['subadmin/student-list-ajax'] = 'subadmin/Student/StudentListAjax';
$route['subadmin/get-student-info'] = 'subadmin/Student/GetStudentDetails';
$route['subadmin/student-update-process'] = 'subadmin/Student/StudentUpdateProcess';
$route['subadmin/reset-student-password'] = 'subadmin/Student/ResetStudentPassword';
$route['subadmin/delete-student'] = 'subadmin/Student/DeleteStudent';

//--- Course Category list
$route['subadmin/course-category-list'] = 'subadmin/CourseCategory';
$route['subadmin/course-category-add-process'] = 'subadmin/CourseCategory/CourseCategoryAddProcess';
$route['subadmin/course-category-list-ajax'] = 'subadmin/CourseCategory/CourseCategoryListAjax';
$route['subadmin/get-course-category-detail'] = 'subadmin/CourseCategory/GetCourseCategoryDetails';
$route['subadmin/course-category-update-process'] = 'subadmin/CourseCategory/CourseCategoryUpdateProcess';

//--- Course list
$route['subadmin/course-list'] = 'subadmin/Course';
$route['subadmin/course-add-process'] = 'subadmin/Course/CourseAddProcess';
$route['subadmin/course-list-ajax'] = 'subadmin/Course/CourseListAjax';
$route['subadmin/get-course-detail'] = 'subadmin/Course/GetCourseDetails';
$route['subadmin/course-update-process'] = 'subadmin/Course/CourseUpdateProcess';
$route['subadmin/new-course-send-notification'] = 'subadmin/Course/NewCourseSendNotification';
$route['subadmin/delete-course'] = 'subadmin/Course/CourseDelete';


//--- Chapter list
$route['subadmin/chapter-list'] = 'subadmin/Chaper';
$route['subadmin/get-course-list-from-category'] = 'subadmin/Chaper/GetCourseListFromCategory';
$route['subadmin/chapter-add-process'] = 'subadmin/Chaper/ChaperAddProcess';
$route['subadmin/chapter-list/(:any)'] = 'subadmin/Chaper/AddCourseChapter/$1';
$route['subadmin/chapter-list-ajax'] = 'subadmin/Chaper/ChaperListAjax';
$route['subadmin/get-chapter-detail'] = 'subadmin/Chaper/GetChaperDetails';
$route['subadmin/chapter-update-process'] = 'subadmin/Chaper/ChaperUpdateProcess';

//--- Sub-chapter list
$route['subadmin/sub-chapter-list'] = 'subadmin/SubChaper';
$route['subadmin/get-chapter-list-from-course'] = 'subadmin/SubChaper/GetCapterListFromCourse';
$route['subadmin/sub-chapter-add-process'] = 'subadmin/SubChaper/SubChaperAddProcess';
$route['subadmin/sub-chapter-list/(:any)'] = 'subadmin/SubChaper/AddCourseSubChaper/$1';
$route['subadmin/sub-chapter-list-ajax'] = 'subadmin/SubChaper/SubChaperListAjax';
$route['subadmin/get-sub-chapter-detail'] = 'subadmin/SubChaper/GetSubChaperDetails';
$route['subadmin/sub-chapter-update-process'] = 'subadmin/SubChaper/SubChaperUpdateProcess';

//--- course video list
$route['subadmin/course-videos/(:any)'] = 'subadmin/CourseVideos/CourseVideosData/$1';
$route['subadmin/course-videos-add-process'] = 'subadmin/CourseVideos/CourseVideosAddProcess';
$route['subadmin/course-videos-list-ajax'] = 'subadmin/CourseVideos/CourseVideosListAjax';
$route['subadmin/course-videos-update-process'] = 'subadmin/CourseVideos/CourseVideosUpdateProcess';

//--- Chapter data
$route['subadmin/chapter-data/(:any)'] = 'subadmin/ChapterDocuments/ChapterDocumentsDetails/$1';
$route['subadmin/view-chapter-data/(:any)'] = 'subadmin/ChapterDocuments/ViewChapterDocumentsDetails/$1';
$route['subadmin/chapter-document-add-process'] = 'subadmin/ChapterDocuments/ChapterDocumentsAddProcess';
$route['subadmin/chapter-document-list-ajax'] = 'subadmin/ChapterDocuments/ChapterDocumentsListAjax';
$route['subadmin/chapter-document-update-process'] = 'subadmin/ChapterDocuments/ChapterDocumentsUpdateProcess';

//--- Sub Chapter data
$route['subadmin/sub-chapter-data/(:any)'] = 'subadmin/SubChapterDocuments/SubChapterDocumentsDetails/$1';
$route['subadmin/sub-chapter-document-add-process'] = 'subadmin/SubChapterDocuments/SubChapterDocumentsAddProcess';
$route['subadmin/sub-chapter-document-list-ajax'] = 'subadmin/SubChapterDocuments/SubChapterDocumentsListAjax';
$route['subadmin/sub-chapter-document-update-process'] = 'subadmin/SubChapterDocuments/SubChapterDocumentsUpdateProcess';

//--- Test records
$route['subadmin/test-records'] = 'subadmin/TestRecords';
$route['subadmin/test-records-add'] = 'subadmin/TestRecords/AddTestRecords';
$route['subadmin/test-records-list-ajax'] = 'subadmin/TestRecords/TestRecordsListAjax';
$route['subadmin/test-records-update'] = 'subadmin/TestRecords/UpdateTestRecords';
$route['subadmin/send-test-result-notification'] = 'subadmin/TestRecords/SendTestResultNotification';

//--- Announcements
$route['subadmin/announcements'] = 'subadmin/Announcements';
$route['subadmin/announcements-add'] = 'subadmin/Announcements/AddAnnouncements';
$route['subadmin/announcements-list-ajax'] = 'subadmin/Announcements/AnnouncementsListAjax';
$route['subadmin/announcements-update'] = 'subadmin/Announcements/UpdateAnnouncements';

//--- Test Scheduling
$route['subadmin/test-schedules'] = 'subadmin/TestSchedules';
$route['subadmin/test-schedules-add'] = 'subadmin/TestSchedules/AddTestSchedules';
$route['subadmin/test-schedules-list-ajax'] = 'subadmin/TestSchedules/TestSchedulesListAjax';
$route['subadmin/test-schedules-update'] = 'subadmin/TestSchedules/UpdateTestSchedules';
$route['subadmin/test-schedule-send-notification'] = 'subadmin/TestSchedules/TestSchedulesSendNotification';

//--- PT meetings
$route['subadmin/pt-meetings'] = 'subadmin/PtMeetings';
$route['subadmin/pt-meetings-add'] = 'subadmin/PtMeetings/AddPtMeetings';
$route['subadmin/pt-meetings-list-ajax'] = 'subadmin/PtMeetings/PtMeetingsListAjax';
$route['subadmin/pt-meetings-update'] = 'subadmin/PtMeetings/UpdatePtMeetings';
$route['subadmin/pt-meetings-send-notification'] = 'subadmin/PtMeetings/PtMeetingsSendNotification';

//--- Holiday Information
$route['subadmin/holiday-information'] = 'subadmin/HolidayInformation';
$route['subadmin/holiday-information-add'] = 'subadmin/HolidayInformation/AddHolidayInformation';
$route['subadmin/holiday-information-list-ajax'] = 'subadmin/HolidayInformation/HolidayInformationListAjax';
$route['subadmin/holiday-information-update'] = 'subadmin/HolidayInformation/UpdateHolidayInformation';
$route['subadmin/holiday-information-send-notification'] = 'subadmin/HolidayInformation/HolidayInformationSendNotification';

//----Enrollments
$route['subadmin/enrollment-list'] = 'subadmin/Enrollments';
$route['subadmin/enrollment-list-ajax'] = 'subadmin/Enrollments/StudentListAjax';
$route['subadmin/get-enrollment-student-details'] = 'subadmin/Enrollments/GetEnrollmentStudentsDetails';
$route['subadmin/enrollment-student-update-process'] = 'subadmin/Enrollments/EnrollmentStudentUpdateProcess';
$route['subadmin/student-enrollemnt-delete'] = 'subadmin/Enrollments/DeleteEnrollmentStudent';

//--- Discount Coupon info
$route['subadmin/discount-coupon'] = 'subadmin/DiscountCoupon';
$route['subadmin/discount-coupon-add'] = 'subadmin/DiscountCoupon/AddDiscountCoupon';
$route['subadmin/discount-coupon-list-ajax'] = 'subadmin/DiscountCoupon/DiscountCouponListAjax';
$route['subadmin/discount-coupon-update'] = 'subadmin/DiscountCoupon/UpdateDiscountCoupon';

//----Contact Us List
$route['subadmin/contact-list'] = 'subadmin/Contacts';
$route['subadmin/contact-list-ajax'] = 'subadmin/Contacts/ContactsListAjax';
$route['subadmin/contact-delete'] = 'subadmin/Contacts/DeleteContact';
