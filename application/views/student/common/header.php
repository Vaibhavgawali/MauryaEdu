<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <?php
  if (!empty($studentInfo['profile_pic'])) {
    $img_path = base_url() . 'uploads/student/' . $studentInfo['student_id'] . '/profile-pic/' . $studentInfo['profile_pic'];
  } else {
    $img_path = base_url() . 'assets/images/profile-photo-not-available.png';
  }
  ?>
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="index.html"><img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav navbar-nav-right">
    <input type="hidden" id="logged_in_student_id"
									value="<?= isset($studentInfo['student_id']) && $studentInfo['student_id'] != '' ? $studentInfo['student_id'] : '0'; ?>" />
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
            <img src="<?php echo $img_path; ?>" alt="image">
            <span class="availability-status online"></span>
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black"><?php echo $studentInfo['full_name']; ?></p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="<?php echo base_url('student/my-profile') ?>">
            <i class="mdi mdi-account me-2 text-primary"></i>Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo base_url('student/change-password') ?>">
            <i class="mdi mdi-cached me-2 text-success"></i> Change Password </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo base_url('student/logout') ?>">
            <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
<div class="container-fluid page-body-wrapper">