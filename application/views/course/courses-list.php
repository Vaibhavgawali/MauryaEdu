<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#ff685c">
    <meta name="theme-color" content="#32cafe">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <!-- plugins:css -->
    <link rel="icon" href="http://localhost/mauryaEdu/assets/images/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="http://localhost/mauryaEdu/assets/images/favicon.png" />
    <link rel="stylesheet" href="http://localhost/mauryaEdu/assets/js/vendors/mdi/css/materialdesignicons.min.css.map">
    <link rel="stylesheet" href="http://localhost/mauryaEdu/assets/js/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="http://localhost/mauryaEdu/assets/css/style.css">
    <!-- End layout styles -->


    <!-- Title -->
    <title>Subadmin - Student Portal</title>
    <link rel="stylesheet" href="http://localhost/mauryaEdu/assets/fonts/fonts/font-awesome.min.css">
    <!-- Font Family-->
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">

    <!-- Dashboard Css -->
    <!-- <link href="http://localhost/mauryaEdu/assets/css/dashboard.css" rel="stylesheet" /> -->

    <!-- c3.js Charts Plugin -->
    <link href="http://localhost/mauryaEdu/assets/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="http://localhost/mauryaEdu/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!-- Sidemenu Css -->
    <!-- <link href="http://localhost/mauryaEdu/assets/plugins/toggle-sidebar/sidemenu.css" rel="stylesheet" /> -->

    <!---Font icons-->
    <link href="http://localhost/mauryaEdu/assets/plugins/iconfonts/plugin.css" rel="stylesheet" />

    <!-- custom style -->
    <!-- <link href="http://localhost/mauryaEdu/assets/css/style.css" rel="stylesheet" type="text/css" /> -->

    <!-- Jquery Toast css -->
    <link href="http://localhost/mauryaEdu/assets/libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css" />

    <!-- third party css -->
    <link href="http://localhost/mauryaEdu/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/mauryaEdu/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/mauryaEdu/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="http://localhost/mauryaEdu/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- Jquery Confirm css -->
    <link href="http://localhost/mauryaEdu/assets/css/jquery-confirm.min.css" rel="stylesheet" type="text/css" />

    <!-- select2 Plugin -->
    <!-- <link href="http://localhost/mauryaEdu/assets/plugins/select2/select2.min.css" rel="stylesheet" /> -->

    <!-- Time picker Plugin -->
    <link href="http://localhost/mauryaEdu/assets/plugins/time-picker/jquery.timepicker.css" rel="stylesheet" />

    <!-- Date Picker Plugin -->
    <link href="http://localhost/mauryaEdu/assets/plugins/date-picker/spectrum.css" rel="stylesheet" />

    <!-- Jquery Librarry -->
    <script type="text/javascript">
        var SITEROOT = 'http://localhost/mauryaEdu/';
        var current_year = 2024;
        var current_month = 03;
        var current_day = 26;
        var base_url = 'http://localhost/mauryaEdu/';
    </script>
</head>

<body>
    <div class="container-scroller">



        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="index.html"><img src="http://localhost/mauryaEdu/assets/images/logo.png" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="http://localhost/mauryaEdu/assets/images/favicon.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">

                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">


                    <li class="nav-item active">
                        <a class="nav-link" href="javascript:void(0);">
                            <span class="menu-title">Our Courses</span>
                            <i class="mdi mdi mdi-library-books menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo base_url('student/login'); ?>">
                            <span class="menu-title">Login</span>
                            <i class="mdi mdi mdi-login menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo base_url('student/register'); ?>">
                            <span class="menu-title">Register</span>
                            <i class="mdi mdi mdi-account menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo base_url('subadmin/login'); ?>">
                            <span class="menu-title">Branch Login</span>
                            <i class="mdi mdi-source-branch menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo base_url('admin/login'); ?>">
                            <span class="menu-title">SuperAdmin Login</span>
                            <i class="mdi mdi-account-key menu-icon btn-icon "></i>
                        </a>
                    </li>

                </ul>
            </nav>
            <div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-library-books"></i>
                </span> Our Courses
            </h3>
        </div>
        <div class="container">
            <div class="row g-4" id="course-grid">
                
            </div>
            <div class="text-center my-5">
                <input type="hidden" name="page_num" id="page_num" value="1" />
                <button type="button" id="load-more-btn" class="btn btn-success">Load more...</button>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Maurya 2024 </span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">Designed & Developed By <a style="text-decoration: none;" href="https://www.zynovvatech.com/" target="_blank">Zynovvatech</a></span>
        </div>
    </footer>
    <!-- partial -->
</div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="http://localhost/mauryaEdu/assets/js/vendors/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="http://localhost/mauryaEdu/assets/js/vendors/chart.js/Chart.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="http://localhost/mauryaEdu/assets/js/off-canvas.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/hoverable-collapse.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="http://localhost/mauryaEdu/assets/js/dashboard.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/todolist.js"></script>

    <!-- Dashboard js -->
    <script src="http://localhost/mauryaEdu/assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/vendors/jquery.sparkline.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/vendors/selectize.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/vendors/jquery.tablesorter.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/vendors/circle-progress.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/plugins/rating/jquery.rating-stars.js"></script>

    <!--Select2 js -->
    <script src="http://localhost/mauryaEdu/assets/plugins/select2/select2.full.min.js"></script>

    <!-- Timepicker js -->
    <script src="http://localhost/mauryaEdu/assets/plugins/time-picker/jquery.timepicker.js"></script>
    <script src="http://localhost/mauryaEdu/assets/plugins/time-picker/toggles.min.js"></script>

    <!-- Datepicker js -->
    <script src="http://localhost/mauryaEdu/assets/plugins/date-picker/spectrum.js"></script>
    <script src="http://localhost/mauryaEdu/assets/plugins/date-picker/jquery-ui.js"></script>
    <script src="http://localhost/mauryaEdu/assets/plugins/input-mask/jquery.maskedinput.js"></script>

    <!-- third party js -->
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="http://localhost/mauryaEdu/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="http://localhost/mauryaEdu/assets/js/sweetalert.js"></script>
    <script src="<?php echo base_url('assets/js/vendors/jquery-3.2.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/vendors/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/vendors/jquery.sparkline.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/vendors/selectize.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/vendors/jquery.tablesorter.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/vendors/circle-progress.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/rating/jquery.rating-stars.js'); ?>"></script>

    <!--Select2 js -->
    <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>

    <!-- Datepicker js -->
    <script src="<?php echo base_url('assets/plugins/date-picker/spectrum.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/date-picker/jquery-ui.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/input-mask/jquery.maskedinput.js'); ?>"></script>

    <!-- third party js -->
    <script src="<?php echo base_url('assets/libs/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.flash.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/datatables.net-select/js/dataTables.select.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/pdfmake/build/pdfmake.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/pdfmake/build/vfs_fonts.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/sweetalert.js'); ?>"></script>

    <!-- Tost-->
    <script src="<?php echo base_url('assets/libs/jquery-toast-plugin/jquery.toast.min.js'); ?>"></script>

    <!-- toastr init js-->
    <script src="<?php echo base_url('assets/js/toastr.init.js'); ?>"></script>

    <!-- Fullside-menu Js-->
    <script src="<?php echo base_url('assets/plugins/toggle-sidebar/sidemenu.js'); ?>"></script>

    <!-- Custom scroll bar Js-->
    <script src="<?php echo base_url('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

    <!-- Custom Js-->
    <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

    <!-- confirm init js-->
    <script src="<?php echo base_url('assets/js/jquery-confirm.min.js'); ?>"></script>

    <!-- course list js-->
    <script src="<?php echo base_url('assets/js/course/course-list.js'); ?>"></script>

    <script>
        function generateNotification(type, message) {
            if (type == 'error') {
                $.toast({
                    heading: 'Error!',
                    text: message,
                    position: 'top-center',
                    loaderBg: '#ec2d38',
                    icon: 'error',
                    hideAfter: 3500,
                    stack: 6
                });
            } else if (type == 'success') {
                $.toast({
                    heading: 'Success!',
                    text: message,
                    position: 'top-center',
                    loaderBg: '#5ed84f',
                    icon: 'success',
                    hideAfter: 3500,
                    stack: 6
                });
            }
        }
    </script>

    <!-- Tost-->
    <script src="http://localhost/mauryaEdu/assets/libs/jquery-toast-plugin/jquery.toast.min.js"></script>

    <!-- toastr init js-->
    <script src="http://localhost/mauryaEdu/assets/js/toastr.init.js"></script>

    <!-- Fullside-menu Js-->
    <script src="http://localhost/mauryaEdu/assets/plugins/toggle-sidebar/sidemenu.js"></script>

    <!-- Custom scroll bar Js-->
    <script src="http://localhost/mauryaEdu/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Custom Js-->
    <script src="http://localhost/mauryaEdu/assets/js/custom.js"></script>

    <!-- confirm init js-->
    <script src="http://localhost/mauryaEdu/assets/js/jquery-confirm.min.js"></script>

    <script>
        function generateNotification(type, message) {
            if (type == 'error') {
                $.toast({
                    heading: 'Error!',
                    text: message,
                    position: 'top-center',
                    loaderBg: '#ec2d38',
                    icon: 'error',
                    hideAfter: 3500,
                    stack: 6
                });
            } else if (type == 'success') {
                $.toast({
                    heading: 'Success!',
                    text: message,
                    position: 'top-center',
                    loaderBg: '#5ed84f',
                    icon: 'success',
                    hideAfter: 3500,
                    stack: 6
                });
            }
        }
    </script>
    <!-- End custom js for this page -->
</body>

</html>