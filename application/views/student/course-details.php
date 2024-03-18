<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-library-books"></i>
                </span> Course Details
            </h3>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-sm-5">
                                    <div class="">
                                        <img src="<?php echo base_url().'uploads/course/'.$course_details['course_master_id'].'/course-image/'.$course_details['course_image'] ;?>" alt="<?php echo $course_details['course_name'] ; ?>" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-title">
                                        <h4>Course Name : <?php echo $course_details['course_category_name'] ; ?></h4>
                                    </div>
                                    <div class="card-text">
                                        <p><?php echo $course_details['course_info'] ; ?></p>
                                    </div>
                                    <div class="card-text">
                                        <p class="text-muted"><?php
                                $course_expired = false;
                                $is_allow_purchase_after_expire = '';

                                $course_expired = $course_details['is_course_expired'];
                                $is_allow_purchase_after_expire = $course_details['is_allow_purchase_after_expire'];

                                if(!$course_expired || ($course_expired && $is_allow_purchase_after_expire=='1')){
                                    echo '<span class="text-success"><b>Purchase this course now...</b></span>';
                                }
                            ?></p>
                                        <h6 class="text-muted">Price: <span class="text-success">₹ <?php echo $course_details['course_sell_price'] ; ?></span></h6>
                                    </div>

                                    <div>
                                        <div class="row g-3">
                                            <div class="col-12 col-xl-4">
                                            <?php
                                $course_expired = false;
                                $is_allow_purchase_after_expire = '';

                                $course_expired = $course_details['is_course_expired'];
                                $is_allow_purchase_after_expire = $course_details['is_allow_purchase_after_expire'];

                                if(!$course_expired || ($course_expired && $is_allow_purchase_after_expire=='1')){
                                  
                            ?>
                            

                            <!-- <a href="" class="mt-2 btn btn-sm btn-pill btn-primary">Buy Now</a> -->
                            <a href="javascript:void(0)" id="<?php echo $course_details['course_master_id'] ; ?>" course_sell_price ="<?php echo $course_details['course_sell_price'] ; ?>"  class="btn btn-gradient-primary btn-rounded  add_to_cart"><i class="mdi mdi-cart"></i> Add to cart</a>
                            <?php
                                }
                            ?>
                                            </div>
                                            <div class="col-12 col-xl-4">
                                                <a href="<?php echo base_url('student/courses-list'); ?>" class="btn btn-gradient-danger btn-rounded "> <i class="mdi mdi-arrow-left"></i> Go Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border my-3"></div>
                                <div class="col-6 col-xl-2 ">
                                    <div class="d-flex gap-3  align-items-center ">
                                        <button type="button" class="btn btn-lg btn-inverse-success btn-rounded btn-icon">
                                            <i class="mdi mdi-clock"></i>
                                        </button>
                                        <div class="pt-3">
                                            <h6 class="text-muted">Start Date</h6>
                                            <p class="text-muted"><?php 
                                        $course_start_date = $course_details['course_start_date']; 
                                        if($course_start_date!=NULL && $course_start_date!='0000-00-00'){
                                            echo date('d-m-Y', strtotime($course_start_date)); 
                                        }
                                        else{
                                            echo '-';
                                        }
                                    ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-2">
                                    <div class="d-flex gap-3  align-items-center ">
                                        <button type="button" class="btn btn-lg btn-inverse-danger btn-rounded btn-icon">
                                            <i class="mdi mdi-clock-alert"></i>
                                        </button>
                                        <div class="pt-3">
                                            <h6 class="text-muted">End Date</h6>
                                            <p class="text-muted"><?php 
                                        $course_end_date = $course_details['course_end_date']; 
                                        if($course_end_date!=NULL && $course_end_date!='0000-00-00'){
                                            echo date('d-m-Y', strtotime($course_end_date)); 
                                        }
                                        else{
                                            echo '-';
                                        }

                                        $course_expired = false;

                                        $course_expired = $course_details['is_course_expired'];
                                    
                                    ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-3">
                                    <div class="d-flex gap-3  align-items-center ">
                                        <button type="button" class="btn btn-lg btn-inverse-info btn-rounded btn-icon">
                                            <i class="mdi mdi-clock-fast"></i>
                                        </button>
                                        <div class="pt-3">
                                            <h6 class="text-muted">Course Duration</h6>
                                            <p class="text-muted"><?php echo $course_details['course_duration_number_of_days']." days" ; ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-4">
                                    <div class="d-flex gap-3  align-items-center ">
                                        <button type="button" class="btn btn-lg btn-inverse-warning btn-rounded btn-icon">
                                            <i class="mdi mdi-clock-alert"></i>
                                        </button>
                                        <div class="pt-3">
                                            <h6 class="text-muted">Enrollment Expiry Date [After purchase]</h6>
                                            <p class="text-muted"><?php echo date('d-m-Y', strtotime($course_details['enrollment_expiry_date'])); ?></p>

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
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
                <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Maurya 2024 </span>
                <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">Designed & Developed By <a style="text-decoration: none;" href="https://www.zynovvatech.com/" target="_blank">Zynovvatech</a></span>
            </div>
        </footer>
        <!-- partial -->
    </div>