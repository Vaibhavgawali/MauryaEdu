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
	<link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" />

	<!-- Title -->
	<title>Forgot Password - Student Portal</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/fonts/fonts/font-awesome.min.css'); ?>">

	<!-- Font Family -->
	<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">

	<!-- Dashboard Css -->
	<link href="<?php echo base_url('assets/css/dashboard.css'); ?>" rel="stylesheet" />

	<!-- c3.js Charts Plugin -->
	<link href="<?php echo base_url('assets/plugins/charts-c3/c3-chart.css'); ?>" rel="stylesheet" />

	<!-- Custom scroll bar css-->
	<link href="<?php echo base_url('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css'); ?>" rel="stylesheet" />

	<!---Font icons-->
	<link href="<?php echo base_url('assets/plugins/iconfonts/plugin.css'); ?>" rel="stylesheet" />

	<!-- custom style -->
	<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css" />

	<script type="text/javascript">
		var SITEROOT = '<?php echo base_url(); ?>';
		var current_year = <?php echo date('Y'); ?>;
		var current_month = <?php echo date('m'); ?>;
		var current_day = <?php echo date('d'); ?>;
		var base_url = '<?php echo base_url(); ?>';
	</script>

	<!-- Meta Pixel Code -->
	<script>
		! function(f, b, e, v, n, t, s) {
			if (f.fbq) return;
			n = f.fbq = function() {
				n.callMethod ?
					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};
			if (!f._fbq) f._fbq = n;
			n.push = n;
			n.loaded = !0;
			n.version = '2.0';
			n.queue = [];
			t = b.createElement(e);
			t.async = !0;
			t.src = v;
			s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s)
		}(window, document, 'script',
			'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '481687720181719');
		fbq('track', 'PageView');
	</script>
	<noscript>
		<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=481687720181719&ev=PageView&noscript=1" />
	</noscript>
	<!-- End Meta Pixel Code -->

	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-NN5PFWW');
	</script>
	<!-- End Google Tag Manager -->

</head>

<body class="login-img">

	<!-- Google Tag Manager (noscript) -->
	<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NN5PFWW" height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div class="page">
		<div class="page-single">
			<div class="container">
				<div id="loader-spin"></div>
				<div class="row">
					<div class="col mx-auto">
						<div class="text-center m-5">
							<img src="<?php echo base_url('assets/images/logo.png'); ?>" class="" alt="">
						</div>
						<div class="row justify-content-center">
							<div class="col-md-8 col-lg-6 mb-5 order-2 order-lg-1">
								<div class="card-group mb-0">
									<div class="card p-4 shadow shadow-lg pb-lg-5 pb-0">
										<div class="card-body">
											<h1>Forgot Password</h1>
											<p class="text-muted">Do not remember your password?</p>
											<div class="mt-3">
												<div class="col-12" id="forgot_password_status">

												</div>
											</div>
											<div class="input-group mb-3">
												<button type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
													<i class="mdi mdi-account fs-4 "></i>
												</button>
												<input type="text" class="form-control p-2" id="emailid" placeholder="Email Address">
											</div>

											<div class="row">
												<div class="col-12 d-flex justify-content-end">
													<button type="button" class="btn btn-inverse-success btn-block" id="btn_forgot_password_submit">Submit</button>
												</div>
												<div class="col-12">
													<a href="<?php echo base_url('student/login'); ?>" class="btn btn-link box-shadow-0 px-0">Login?</a>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
							<div class="col-12 col-md-8 col-lg-4  order-lg-2 mb-5 order-1">
								<div class="card text-white bg-secondary  d-md-down-none login-transparent">
									<div class="card-body text-center justify-content-center ">
										<h2>Sign up</h2>
										<div class="w-100 d-flex justify-content-center">
											<div class="w-25"><img class="img-fluid m-3 " src="<?php echo base_url('assets/images/favicon.png'); ?>" alt=""></div>
										</div>
										<p>Welcome to Student Portal, all your needs under one platform</p>
										<p>Do not have account? </p>
										<a href="<?php echo base_url('student/register'); ?>" class="btn btn-gradient-success active mt-3">Register Now!</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Dashboard js -->
	<script src="<?php echo base_url('assets/js/vendors/jquery-3.2.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/vendors/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/vendors/jquery.sparkline.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/vendors/selectize.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/vendors/jquery.tablesorter.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/vendors/circle-progress.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/rating/jquery.rating-stars.js'); ?>"></script>

	<!-- Custom scroll bar Js-->
	<script src="<?php echo base_url('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

	<!-- Login js -->
	<script src="<?php echo base_url('assets/js/student/login.js'); ?>"></script>

</body>

</html>