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
	<link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/js/vendors/mdi/css/materialdesignicons.min.css.map'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/js/vendors/css/vendor.bundle.base.css'); ?>">
	<!-- endinject -->
	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<!-- endinject -->
	<!-- Layout styles -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
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
				<div class="row ">
					<div class="col mx-auto ">
						<div class="text-center mt-5">
							<img src="<?php echo base_url('assets/images/logo.png'); ?>" class="" alt="">
						</div>
						<div class="row justify-content-center mt-5">
							<div class="col-md-8 col-lg-6 mb-5 order-2 order-lg-1">
								<div class="card-group mb-0 ">
									<div class="card p-4 shadow shadow-lg pb-lg-5 pb-0">
										<div class="card-body">
											<h1>Register</h1>
											<p class="text-muted">Create New Account</p>
											<div class="mb-3">
												<div class="col-12" id="register_status">

												</div>
											</div>
											<div class="input-group mb-3">
												<button type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
													<i class="mdi mdi-account fs-4 "></i>
												</button>
												<input type="text" class="form-control p-2" id="full_name" placeholder="Enter full name">
											</div>
											<div class="input-group mb-4">
												<button type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
													<i class="mdi mdi-email fs-4 "></i>
												</button>
												<input type="text" class="form-control p-2" id="emailid" placeholder="Enter Email id">
											</div>
											<div class="input-group mb-4">
												<button type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
													<i class="mdi mdi-cellphone fs-4 "></i>
												</button>
												<input type="text" class="form-control p-2" id="contact" placeholder="Enter Mobile Number">
											</div>
											<div class="input-group mb-4">
												<button type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
													<i class="mdi mdi-book-open-page-variant fs-4 "></i>
												</button>
												<select class="form-control" id="branch">
													<option value="" selected disabled>Select Branch</option>
													<?php foreach ($branches as $branch) : ?>
														<option value="<?php echo $branch['branch_id']; ?>"><?php echo $branch['branch_name']; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="form-group">
												<div class="form-check form-check-success">
													<label class="form-check-label">
														<input type="checkbox" class="form-check-input " id="terms_and_policy"> <i class="input-helper"><a href="" class="text-decoration-none text-muted">Terms & Conditions</a></i></label>
												</div>

											</div>

											<div class="row">
												<div class="col-12">
													<button type="button" class="btn btn-inverse-success btn-block px-4" id="btn_register_submit">Create a new account</button>
												</div>

											</div>

										</div>
									</div>

								</div>
							</div>
							<div class="col-12 col-md-8 col-lg-4  order-lg-2 mb-5 order-1">
								<div class="card text-white bg-secondary py-1 d-md-down-none login-transparent">
									<div class="card-body text-center ">
										<div>
											<h2>Login</h2>
											<img class="img-fluid m-3 " src="<?php echo base_url('assets/images/favicon.png'); ?>" alt="">
											<p>Welcome to Student Portal, all your needs under one platform</p>
											<p>Already have account?</p>
											<a href="<?php echo base_url('student/login'); ?>" class="btn btn-gradient-success  active mt-1">Login</a>
										</div>
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

	<!-- Register js -->
	<script src="<?php echo base_url('assets/js/student/register.js'); ?>"></script>

</body>

</html>