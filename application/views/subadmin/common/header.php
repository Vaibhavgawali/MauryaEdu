<div id="global-loader" ></div>
		<div class="page">
			<div class="page-main">
				<div class="app-header header py-1 d-flex">
					<div class="container-fluid">
						<div class="d-flex">
							<a class="header-brand" href="<?php echo base_url('subadmin/dashboard'); ?>">
								<img src="<?php echo base_url('assets/images/logo.png'); ?>" class="header-brand-img" alt="Spain logo">
							</a>
							<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>

							<div class="d-flex order-lg-2 ml-auto">
							    <div class="dropdown">
									
									<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<?php
											if(!empty($adminInfo['profile_pic'])){
												$img_path = base_url().'uploads/subadmin/profile-pic/'.$adminInfo['profile_pic'];
											}
											else{
												$img_path = base_url().'assets/images/profile-photo-not-available.png';
											}
										?>
										<span class="avatar avatar-md brround"><img src="<?php echo $img_path; ?>" alt="Profile-img" class="avatar avatar-md brround"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<div class="text-center">
											<?= $login_detail['admin_name'] ?>

											<div class="dropdown-divider"></div>
										</div>
										<a class="dropdown-item" href="<?php echo base_url('subadmin/my-profile') ?>">
											<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
										</a>
										<a href="<?php echo base_url('subadmin/change-password') ?>" class="dropdown-item">
											<i class="dropdown-icon mdi  mdi-lock"></i> Change Password
										</a>
										<a href="<?php echo base_url('subadmin/logout')?>" class="dropdown-item"><i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>