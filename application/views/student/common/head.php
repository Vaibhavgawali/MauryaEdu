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
    <!-- plugins:css -->
    <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon"/>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/js/vendors/mdi/css/materialdesignicons.min.css.map');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/js/vendors/css/vendor.bundle.base.css');?>">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
    <!-- End layout styles -->


		<!-- Title -->
		<title>Subadmin - Student Portal</title>
		<link rel="stylesheet" href="<?php echo base_url('assets/fonts/fonts/font-awesome.min.css'); ?>">
		<!-- Font Family-->
		<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">

		<!-- Dashboard Css -->
		<!-- <link href="<?php echo base_url('assets/css/dashboard.css'); ?>" rel="stylesheet" /> -->

		<!-- c3.js Charts Plugin -->
		<link href="<?php echo base_url('assets/plugins/charts-c3/c3-chart.css'); ?>" rel="stylesheet" />

		<!-- Custom scroll bar css-->
		<link href="<?php echo base_url('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css'); ?>" rel="stylesheet" />

		<!-- Sidemenu Css -->
		<!-- <link href="<?php echo base_url('assets/plugins/toggle-sidebar/sidemenu.css'); ?>" rel="stylesheet" /> -->

		<!---Font icons-->
		<link href="<?php echo base_url('assets/plugins/iconfonts/plugin.css'); ?>" rel="stylesheet" />

		<!-- custom style -->
		<!-- <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css" /> -->

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
		<!-- <link href="<?php echo base_url('assets/plugins/select2/select2.min.css'); ?>" rel="stylesheet" /> -->

		<!-- Time picker Plugin -->
		<link href="<?php echo base_url('assets/plugins/time-picker/jquery.timepicker.css'); ?>" rel="stylesheet" />

		<!-- Date Picker Plugin -->
		<link href="<?php echo base_url('assets/plugins/date-picker/spectrum.css'); ?>" rel="stylesheet" />

        <!-- Jquery Librarry -->
        <?php loadCss($application_version); ?>
        <?php //getPartnerCss($application_version); ?>
        <script type="text/javascript">
            var SITEROOT = '<?php echo base_url(); ?>';
            var current_year = <?php echo date('Y'); ?>;
            var current_month = <?php echo date('m'); ?>;
            var current_day = <?php echo date('d'); ?>;
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
	 <body>
    <div class="container-scroller">


     
