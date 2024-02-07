<!doctype html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="msapplication-TileColor" content="#ff685c">
        <meta name="theme-color" content="#32cafe">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon"/>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" />

        <!-- Title -->
        <title>Student Portal-Our Courses</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/fonts/fonts/font-awesome.min.css'); ?>">

        <!-- Font Family-->
        <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">

        <!-- Dashboard Css -->
        <link href="<?php echo base_url('assets/css/dashboard.css'); ?>" rel="stylesheet" />

        <!-- c3.js Charts Plugin -->
        <link href="<?php echo base_url('assets/plugins/charts-c3/c3-chart.css'); ?>" rel="stylesheet" />

        <!-- Custom scroll bar css-->
        <link href="<?php echo base_url('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css'); ?>" rel="stylesheet" />

        <!-- Sidemenu Css -->
        <link href="<?php echo base_url('assets/plugins/toggle-sidebar/sidemenu.css'); ?>" rel="stylesheet" />

        <!---Font icons-->
        <link href="<?php echo base_url('assets/plugins/iconfonts/plugin.css'); ?>" rel="stylesheet" />

        <!-- custom style -->
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- Jquery Toast css -->
        <link href="<?php echo base_url('assets/libs/jquery-toast-plugin/jquery.toast.min.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- third party css -->
        <link href="<?php echo base_url('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- third party css end -->

        <!-- Jquery Confirm css -->
        <link href="<?php echo base_url('assets/css/jquery-confirm.min.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- select2 Plugin -->
        <link href="<?php echo base_url('assets/plugins/select2/select2.min.css'); ?>" rel="stylesheet" />

        <!-- Date Picker Plugin -->
        <link href="<?php echo base_url('assets/plugins/date-picker/spectrum.css'); ?>" rel="stylesheet" />

        <style type="text/css">
            .hovernow {
                padding: 5px !important;
                box-shadow: 0 0px 0px rgba(0, 0, 0, 0.15);
                transition: box-shadow 0.3s ease-in-out;
            }

            .hovernow:hover {
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            }

            .row-flex {
                display: flex;
                flex-wrap: wrap;
            }

            .course_title{
                line-height: 1.5em;
                height: 3em;     
                overflow: hidden;
            }
        </style>

        <!-- Jquery Librarry -->
        <?php //loadCss($application_version); ?>
        <?php //getPartnerCss($application_version); ?>
        <script type="text/javascript">
            var SITEROOT = '<?php echo base_url(); ?>';
            var current_year = <?php echo date('Y'); ?>;
            var current_month = <?php echo date('m'); ?>;
            var current_day = <?php echo date('d'); ?>;
            var base_url = '<?php echo base_url(); ?>';
        </script>

        <!-- Meta Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '481687720181719');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"src="https://www.facebook.com/tr?id=481687720181719&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Meta Pixel Code -->

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NN5PFWW');</script>
        <!-- End Google Tag Manager -->

    </head>
    <body class="app sidebar-mini rtl">

        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NN5PFWW" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->

        <div id="global-loader" ></div>
        <div class="page">
            <div class="page-main">
                <div class="app-header header py-1 d-flex">
                    <div class="container-fluid">
                        <div class="d-flex">
                            <a class="header-brand" href="<?php echo base_url(); ?>">
                                <img src="<?php echo base_url('assets/images/logo.png'); ?>" class="header-brand-img" alt="Spain logo">
                            </a>

                            <div class="d-flex order-lg-2 ml-auto">
                                <div class="dropdown d-none d-md-flex " >
                                    <!-- <a  class="nav-link icon full-screen-link">
                                        <i class="mdi mdi-arrow-expand-all"  id="fullscreen-button"></i>
                                    </a> -->
                                </div>
                                <div class="dropdown">
                                    <input type="hidden" id="logged_in_student_id" value="0" />
                                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                        <span class="avatar avatar-md brround"><img src="<?php echo base_url('assets/images/favicon.png'); ?>" alt="Profile-img" class="avatar avatar-md brround"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                                        <div class="text-center">
                                            <a href="#" class="dropdown-item text-center font-weight-sembold user"><?php echo COMPANY_NAME; ?></a>

                                            <div class="dropdown-divider"></div>
                                        </div>
                                        <a class="dropdown-item" href="<?php echo base_url('student/login'); ?>">
                                        <!-- <a class="dropdown-item" href="https://play.google.com/store/apps/details?id=com.rahuldhanawade.chemcaliba"> -->
                                            <i class="dropdown-icon mdi mdi-account-outline "></i> Login
                                        </a>
                                        <a class="dropdown-item" href="<?php echo base_url('student/register'); ?>">
                                        <!-- <a class="dropdown-item" href="https://play.google.com/store/apps/details?id=com.rahuldhanawade.chemcaliba"> -->
                                            <i class="dropdown-icon  mdi mdi-settings"></i> Register
                                        </a>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Main Body : START-->
                <div class="container" style="margin-top: 5% !important;">
                    <div class="side-app">
                        <div class="page-header">
                            <h4 class="page-title">Our Courses</h4>
                            
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('student/login'); ?>">Login</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('student/register'); ?>">Register</a></li>
                            </ol>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('subadmin/login'); ?>">Branch Login</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/login'); ?>">Superadmin Login</a></li>
                            </ol>

                        </div>

                        <!-- main body: START -->
                        <div class="row row-cards">

                            <!--Filters : START-->
                            <!-- <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <form>
                                            <div class="card">
                                                <div class="row card-body p-2">
                                                    <div class="col-sm-12 p-0">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search ...">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-primary" type="button">Search</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title"> Categories</div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label">Mens</label>
                                                    <select name="beast" id="select-beast" class="form-control custom-select">
                                                        <option value="0">--Select--</option>
                                                        <option value="1">Foot wear</option>
                                                        <option value="2">Top wear</option>
                                                        <option value="3">Bootom wear</option>
                                                        <option value="4">Men's Groming</option>
                                                        <option value="5">Accessories</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Women</label>
                                                    <select name="beast" id="select-beast1" class="form-control custom-select">
                                                        <option value="0">--Select--</option>
                                                        <option value="1">Western wear</option>
                                                        <option value="2">Foot wear</option>
                                                        <option value="3">Top wear</option>
                                                        <option value="4">Bootom wear</option>
                                                        <option value="5">Beuty Groming</option>
                                                        <option value="6">Accessories</option>
                                                        <option value="7">jewellery</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Baby & Kids</label>
                                                    <select name="beast" id="select-beast2" class="form-control custom-select">
                                                        <option value="0">--Select--</option>
                                                        <option value="1">Boys clothing</option>
                                                        <option value="2">girls Clothing</option>
                                                        <option value="3">Toys</option>
                                                        <option value="4">Baby Care</option>
                                                        <option value="5">Kids footwear</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Electronics</label>
                                                    <select name="beast" id="select-beast3" class="form-control custom-select">
                                                        <option value="0">--Select--</option>
                                                        <option value="1">Mobiles</option>
                                                        <option value="2">Laptops</option>
                                                        <option value="3">Gaming & Accessories</option>
                                                        <option value="4">Health care Appliances</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Sport,Books & More </label>
                                                    <select name="beast" id="select-beast4" class="form-control custom-select">
                                                        <option value="0">--Select--</option>
                                                        <option value="1">Stationery</option>
                                                        <option value="2">Books</option>
                                                        <option value="3">Gaming</option>
                                                        <option value="4">Music</option>
                                                        <option value="5">Exercise & fitness</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <form class="shop__filter card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Price
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="radio">
                                                    <input type="radio" name="shop-filter__price" id="shop-filter-price_1" value="" checked="">
                                                    <label for="shop-filter-price_1">Under $25</label>
                                                </div>
                                                <div class="radio">
                                                    <input type="radio" name="shop-filter__price" id="shop-filter-price_2" value="">
                                                    <label for="shop-filter-price_2">$25 to $50</label>
                                                </div>
                                                <div class="radio">
                                                    <input type="radio" name="shop-filter__price" id="shop-filter-price_3" value="">
                                                    <label for="shop-filter-price_3">$50 to $100</label>
                                                </div>
                                                <div class="radio">
                                                    <input type="radio" name="shop-filter__price" id="shop-filter-price_4" value="specify">
                                                    <label for="shop-filter-price_4">Other (specify)</label>
                                                </div>
                                            </div>
                                        </form>

                                        <form class="shop__filter card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Brand
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="checkbox">
                                                    <input type="checkbox" value="" id="shop-filter-checkbox_1" checked="">
                                                    <label for="shop-filter-checkbox_1">Adidas</label>
                                                </div>
                                                <div class="checkbox">
                                                    <input type="checkbox" value="" id="shop-filter-checkbox_2">
                                                    <label for="shop-filter-checkbox_2">Calvin Klein</label>
                                                </div>
                                                <div class="checkbox">
                                                    <input type="checkbox" value="" id="shop-filter-checkbox_3">
                                                    <label for="shop-filter-checkbox_3">Columbia</label>
                                                </div>
                                                <div class="checkbox">
                                                    <input type="checkbox" value="" id="shop-filter-checkbox_4">
                                                    <label for="shop-filter-checkbox_4">Tommy Hilfiger</label>
                                                </div>
                                                <div class="checkbox">
                                                    <input type="checkbox" value="" id="shop-filter-checkbox_5">
                                                    <label for="shop-filter-checkbox_5">Not specified</label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                            <!--Filters : END-->

                            <!-- Courses list: START -->
                            <div class="col-lg-12">                            
                                <div class="row" id= "course-grid">
                                </div>

                                <br/>
                                <br/>
                                <div class="text-center">
                                    <input type="hidden" name="page_num" id="page_num" value="1"/>
                                    <button type="button" id="load-more-btn" class="btn btn-success">Load more...</button>
                                </div>
                                
                                <br/>
                                <br/>
                            </div>                        
                            <!-- Courses list: END -->
                        </div>
                        <!-- Main body: END -->
                    </div>                    
                </div>
                <!-- Main Body : END-->

                <!--footer-->
                <footer class="footer">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-lg-12 col-sm-12 mt-3 mt-lg-0 text-center">
                        &copy;MauryaEdu <script>document.write(new Date().getFullYear())</script>, Designed & Developed By <a href="#"  class="btn btn-link box-shadow-0 px-0">Zynovvatech</a>
                        </div>
                    </div>
                </footer>
                <!-- End Footer-->
            </div>
        </div>

        <!-- Back to top -->
        <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

        <!-- Dashboard js -->
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
                if (type == 'error')
                {
                    $.toast({
                        heading: 'Error!',         
                        text: message,
                        position: 'top-center',
                        loaderBg:'#ec2d38',
                        icon: 'error',
                        hideAfter: 3500, 
                        stack: 6
                    });
                }
                else if (type == 'success')
                {
                    $.toast({
                        heading: 'Success!',       
                        text: message,
                        position: 'top-center',
                        loaderBg:'#5ed84f',
                        icon: 'success',
                        hideAfter: 3500, 
                        stack: 6
                    });
                }
            } 

        </script>

    </body>
</html>