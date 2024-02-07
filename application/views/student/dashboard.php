<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Dashboard</h4>
    <ol class="breadcrumb">
        <?php 
            if($live_video_lecture_link != '')
            {
                echo '<li class="breadcrumb-item active" aria-current="page"><a href = "'.$live_video_lecture_link.'" target = "_blank"><i class="fa fa-video-camera"></i> Live Video Lecture</a></li>';
            }
        ?>
        
    </ol>

</div>

<div class="row row-cards">

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <a href="<?php echo base_url('student/live-lecture'); ?>" >
            <div class="card card-counter bg-gradient-primary shadow-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="mt-4 mb-0 text-white">
                                <p class="text-white mt-1">Lecture Links </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <i class="fa fa-file-video-o mt-3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <a href="<?php echo base_url('student/test-results'); ?>" >
            <div class="card card-counter bg-gradient-warning shadow-warning">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="mt-4 mb-0 text-white">
                                <p class="text-white mt-1">Test Result </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <i class="fa fa-bar-chart mt-3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>    
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <a href="<?php echo base_url('student/enrolled-courses-list'); ?>" >
        <!-- <a href="<?php echo APP_LINK; ?>" > -->
            <div class="card card-counter bg-gradient-secondary shadow-secondary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="mt-4 mb-0 text-white">
                                <p class="text-white mt-1">Enrolled Courses</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <i class="fa fa-crosshairs mt-3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>    
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <a href="<?php echo base_url('student/test-schedules'); ?>" >
            <div class="card card-counter bg-gradient-success shadow-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="mt-4 mb-0 text-white">
                                <p class="text-white mt-1">Test Scheduled </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <i class="fa fa-clock-o mt-3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>    
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <a href="<?php echo base_url('student/theory-booklet'); ?>" >
        <!-- <a href="<?php //echo APP_LINK; ?>" > -->
            <div class="card card-counter bg-gradient-danger shadow-danger">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="mt-4 mb-0 text-white">
                                <p class="text-white mt-1">Booklet / Practice Assingments</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <i class="fa fa-book mt-3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>    
    </div>

    <!-- <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <a href="<?php //echo base_url('student/practice-assignments'); ?>" >
            <div class="card card-counter bg-gradient-danger shadow-danger">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="mt-4 mb-0 text-white">
                                <p class="text-white mt-1"> </p>
                            </div>
                        </div>
                        <div class="col-4">
                            <i class="fa fa-file-text-o mt-3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>    
    </div> -->

</div>    