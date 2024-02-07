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
		<title>Student Portal</title>
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

