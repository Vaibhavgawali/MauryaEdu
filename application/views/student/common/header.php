<div id="global-loader"></div>
<div class="page">
	<div class="page-main">
		<div class="app-header header py-1 d-flex">
			<div class="container-fluid">
				<div class="d-flex">
					<a class="header-brand" href="<?php echo base_url('student/dashboard'); ?>">
						<img src="<?php echo base_url('assets/images/logo.png'); ?>" class="header-brand-img"
							alt="Spain logo">
					</a>
					<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>

					<div class="d-flex order-lg-2 ml-auto">
						<?php
						if (!empty($studentInfo['profile_pic'])) {
							$img_path = base_url() . 'uploads/student/' . $studentInfo['student_id'] . '/profile-pic/' . $studentInfo['profile_pic'];
						} else {
							$img_path = base_url() . 'assets/images/profile-photo-not-available.png';
						}
						?>
						<div class="dropdown d-md-flex">
							<a class="nav-link icon" data-toggle="dropdown">
								<i class="fa fa-shopping-cart"></i>
								<?php
								$cart_details = $this->session->userdata('student_cart_details');

								if ($cart_details) {
									echo '<span id="cart_count" class=" nav-unread badge badge-success  badge-pill">' . count($cart_details) . '</span>';
								} else {
									echo '<span id="cart_count" class=" nav-unread badge badge-success  badge-pill">0</span>';
								}
								?>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
								<?php
								$cart_details = $this->session->userdata('student_cart_details');

								if ($cart_details) {
									?>
									<a href="<?php echo base_url('student/view-cart'); ?>" class="dropdown-item text-center"
										id="cart_item_msg">
										<?php echo count($cart_details) . " product(s) added in the cart"; ?>
									</a>
									<?php

								} else {
									?>
									<a href="<?php echo base_url('student/view-cart'); ?>" class="dropdown-item text-center"
										id="cart_item_msg">You have not added any product to cart.</a>
									<?php
								}
								?>
								<!-- <a href="<?php echo base_url('student/view-cart'); ?>" class="dropdown-item text-center" id = "cart_item_msg">You have not added any product to cart.</a>									 -->
								<div class="dropdown-divider"></div>
								<a href="<?php echo base_url('student/view-cart'); ?>"
									class="dropdown-item text-center">View Cart</a>

							</div>
						</div>

						<div class="dropdown">
							<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
								<span class="avatar avatar-md brround"><img src="<?php echo $img_path; ?>"
										alt="<?php echo $studentInfo['full_name']; ?>"
										class="avatar avatar-md brround"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
								<input type="hidden" id="logged_in_student_id"
									value="<?= isset($studentInfo['student_id']) && $studentInfo['student_id'] != '' ? $studentInfo['student_id'] : '0'; ?>" />
								<div class="text-center">
									<?= $studentInfo['full_name'] ?>

									<div class="dropdown-divider"></div>
								</div>
								<a class="dropdown-item" href="<?php echo base_url('student/my-profile') ?>">
									<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
								</a>
								<a href="<?php echo base_url('student/change-password') ?>" class="dropdown-item">
									<i class="dropdown-icon mdi  mdi-lock"></i> Change Password
								</a>
								<a href="<?php echo base_url('student/logout') ?>" class="dropdown-item">
									<i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
								</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>