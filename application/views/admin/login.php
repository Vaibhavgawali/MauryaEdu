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
	<title>Admin Login - Student Portal</title>
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

</head>

<body class="login-img">
	<div class="page">
		<div class="page-single">
			<div class="container">
				<div id="loader-spin"></div>
				<div class="row">
					<div class="col mx-auto">
						<div class="text-center mb-6">
							<img src="<?php echo base_url('assets/images/logo.png'); ?>" class="" alt="">
						</div>
						<div class="row justify-content-center">
							<div class="col-md-6">
								<div class="card-group mb-0">
									<div class="card p-4 shadow shadow-lg m-5 ">
										<div class="card-body">
											<h1>Admin Login</h1>
											<p class="text-muted">Sign In to your account</p>
											<div class="mt-3"><div class="col-12" id="login_status">

</div></div>
											<div class="input-group mb-3">
												<button type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
													<i class="mdi mdi-email fs-4 "></i>
												</button>
												<input type="text" class="form-control p-2" id="emailid" placeholder="Email Address">
											</div>
											<div class="input-group mb-4">
												<button type="button" class="btn btn-gradient-danger btn-rounded btn-icon">
													<i class="mdi mdi-lock fs-4 "></i>
												</button>
												<input type="password" class="form-control p-2" id="password" placeholder="Password">
											</div>
											
											<div class="row">
												<div class="col-12 d-flex justify-content-end">
													<button type="button" class="btn btn-inverse-success btn-block" id="btn_login_submit">Login</button>
												</div>
												<div class="col-12">
													<a href="<?php echo base_url('admin/forgot-password'); ?>" class="btn btn-link box-shadow-0 px-0">Forgot password?</a>
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
	<script src="<?php echo base_url('assets/js/admin/login.js'); ?>"></script>

</body>

</html>