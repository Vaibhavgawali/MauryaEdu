<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="<?php echo base_url('assets/images/faces/face1.jpg');?>" lt="profile">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2"><?php echo ($login_detail['full_name']) > 20 ? substr($login_detail['full_name'],0,20).'...' : $login_detail['full_name'] ?></span>
                  <span class="text-secondary text-small">Super Admin</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('admin/branch-list'); ?>">
                <span class="menu-title">Branches</span>
                <i class="mdi mdi-source-branch menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('admin/branch-admin-list'); ?>">
                <span class="menu-title">Branch Admin</span>
                <i class="mdi  mdi-account-multiple menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('admin/student-list'); ?>">
                <span class="menu-title">Registerd Students</span>
                <i class="mdi mdi-account-card-details menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('admin/course-category-list'); ?>">
                <span class="menu-title">Course Category</span>
                <i class="mdi  mdi-library-books menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('admin/course-list'); ?>">
                <span class="menu-title">Course </span>
                <i class="mdi mdi mdi-book-open-variant menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('admin/chapter-list'); ?>">
                <span class="menu-title">Chapter</span>
                <i class="mdi mdi mdi-book-multiple-variant menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('admin/enrollment-list'); ?>">
                <span class="menu-title">Enrollments</span>
                <i class="mdi mdi mdi-table-edit menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('admin/contact-list'); ?>">
                <span class="menu-title">Contacts</span>
                <i class="mdi mdi mdi-contact-mail menu-icon"></i>
              </a>
            </li>
      
          </ul>
        </nav>