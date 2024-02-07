<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Enrollment Payment Status</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('student/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Enrollment Payment Status</li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <?php
                    if($payment_status == null && $message == null){
                ?>
                    <div class="alert alert-danger text-center">
                        <h3 class="text-danger">Invalid access! <br>You are not allowed to access this page</h3>
                        <br><br>
                        <a href="<?php echo base_url('student/courses-list'); ?>" class="text-white"><i class="fa fa-book"></i> Go to Enrollment course list</a>
                    </div>
                    <br><br><br><br><br><br><br><br><br><br>
                <?php
                    }
                    else
                    if($payment_status == true){
                ?>

                <div class="alert alert-success text-center">
                    <?php echo $message; ?>
                    <br><br>
                    <a href="<?php echo base_url('student/enrolled-courses-list'); ?>" class="text-white"><i class="fa fa-crosshairs"></i> View Enrolled course </a>
                </div>
                    <br><br><br><br><br><br>
                <?php
                    }
                    else
                    if($payment_status == false){
                ?>
                <div class="alert alert-danger text-center">
                    <?php echo $message; ?>
                    <br><br>
                    <a href="<?php echo base_url('student/view-cart'); ?>" class="text-white"><i class="fa fa-shopping-cart"></i> View Cart</a>
                </div>
                    <br><br><br><br><br><br><br><br><br><br>
                <?php
                    }
                ?>
                
            </div>
        </div>    
    </div>
</div>