<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <?php
  if (!empty($studentInfo['profile_pic'])) {
    $img_path = base_url() . 'uploads/student/' . $studentInfo['student_id'] . '/profile-pic/' . $studentInfo['profile_pic'];
  } else {
    $img_path = base_url() . 'assets/images/profile-photo-not-available.png';
  }
  ?>
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="<?php echo $img_path; ?>" alt="<?php echo $studentInfo['full_name']; ?>">
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2"><?php echo $studentInfo['full_name']; ?></span>
          <!-- <span class="text-secondary text-small">Project Manager</span> -->
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item ">
      <a class="nav-link" href="<?php echo base_url('student/dashboard');?>">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url('student/courses-list'); ?>">
        <span class="menu-title">Our Courses</span>
        <i class="mdi mdi mdi-library-books menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url('student/enrolled-courses-list'); ?>">
        <span class="menu-title">Enrollments</span>
        <i class="mdi mdi mdi-table-edit menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url('student/certificates');?>">
        <span class="menu-title">Certificate</span>
        <i class="mdi  mdi-star-half menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url('student/id-cards'); ?>">
        <span class="menu-title">Id Card</span>
        <i class="mdi mdi-account-card-details menu-icon"></i>
      </a>
    </li>
  </ul>
</nav>