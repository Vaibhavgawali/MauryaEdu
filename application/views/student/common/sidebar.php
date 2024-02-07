<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="side-menu">
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/dashboard'); ?>"><i class="side-menu__icon fa fa-desktop"></i><span class="side-menu__label">Dashboard</span></a>
        </li>
        <!-- <li>
            <a class="side-menu__item" href="<?php echo base_url('student/my-profile'); ?>"><i class="side-menu__icon fa fa-user"></i><span class="side-menu__label">My Profile</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/change-password'); ?>"><i class="side-menu__icon fa fa-lock"></i><span class="side-menu__label">Change Password</span></a>
        </li> -->
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/courses-list'); ?>"><i class="side-menu__icon fa fa-book"></i><span class="side-menu__label">Our Courses</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/enrolled-courses-list'); ?>"><i class="side-menu__icon fa fa-crosshairs"></i><span class="side-menu__label">Enrolled Courses </span></a>
            <!-- <a class="side-menu__item" href="https://play.google.com/store/apps/details?id=com.rahuldhanawade.chemcaliba" ><i class="side-menu__icon fa fa-crosshairs"></i><span class="side-menu__label">Enrolled Courses </span></a> -->
        </li>
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/test-results'); ?>"><i class="side-menu__icon fa fa-star-half-o"></i><span class="side-menu__label">Test Results</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/test-schedules'); ?>"><i class="side-menu__icon fa fa-calendar"></i><span class="side-menu__label">Test Schedule</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/announcements'); ?>"><i class="side-menu__icon fa fa-bullhorn"></i><span class="side-menu__label">Announcements</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/pt-meetings'); ?>"><i class="side-menu__icon fa fa-slideshare"></i><span class="side-menu__label">Parent - Teacher Meeting</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/holiday-information'); ?>"><i class="side-menu__icon fa fa-calendar"></i><span class="side-menu__label">Holiday Information</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="<?php echo base_url('student/logout'); ?>"><i class="side-menu__icon fa fa-power-off"></i><span class="side-menu__label">Logout</span></a>
        </li>
    </ul>
</aside>

<div class="app-content  my-3 my-md-5">
    <div class="side-app">
        <div id="loader-spin"></div>