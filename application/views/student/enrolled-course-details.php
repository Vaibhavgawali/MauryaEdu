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
                                        <img src="<?php echo base_url() . 'uploads/course/' . $course_details['course_master_id'] . '/course-image/' . $course_details['course_image']; ?>" alt="<?php echo $course_details['course_name']; ?>" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-title">
                                        <h4>Course Name : <?php echo $course_details['course_category_name']; ?></h4>
                                    </div>
                                    <div class="card-text">
                                        <p><?php echo $course_details['course_info']; ?></p>
                                    </div>
                                    <div class="card-text">
                                        <p class="text-muted"><?php
                                                                $course_expired = false;
                                                                $is_allow_purchase_after_expire = '';

                                                                $course_expired = $course_details['is_course_expired'];
                                                                $is_allow_purchase_after_expire = $course_details['is_allow_purchase_after_expire'];

                                                                if (!$course_expired || ($course_expired && $is_allow_purchase_after_expire == '1')) {
                                                                    echo '<span class="text-success"><b>Purchase this course now...</b></span>';
                                                                }
                                                                ?></p>
                                        <h6 class="text-muted">Price: <span class="text-success">₹ <?php echo $course_details['course_sell_price']; ?></span></h6>
                                    </div>

                                    <div>
                                        <div class="row g-3">
                                            <div class="col-12 col-xl-4">
                                                <?php
                                                $course_expired = false;
                                                $is_allow_purchase_after_expire = '';

                                                $course_expired = $course_details['is_course_expired'];
                                                $is_allow_purchase_after_expire = $course_details['is_allow_purchase_after_expire'];

                                                if (!$course_expired || ($course_expired && $is_allow_purchase_after_expire == '1')) {

                                                ?>


                                                    <!-- <a href="" class="mt-2 btn btn-sm btn-pill btn-primary">Buy Now</a> -->
                                                    <a href="javascript:void(0)" id="<?php echo $course_details['course_master_id']; ?>" course_sell_price="<?php echo $course_details['course_sell_price']; ?>" class="btn btn-gradient-primary btn-rounded  add_to_cart"><i class="mdi mdi-cart"></i> Add to cart</a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-12 col-xl-4">
                                                <a href="<?php echo base_url('student/enrolled-courses-list'); ?>" class="btn btn-gradient-danger btn-rounded "> <i class="mdi mdi-arrow-left"></i> Go Back</a>
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
                                                                    if ($course_start_date != NULL && $course_start_date != '0000-00-00') {
                                                                        echo date('d-m-Y', strtotime($course_start_date));
                                                                    } else {
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
                                                                    if ($course_end_date != NULL && $course_end_date != '0000-00-00') {
                                                                        echo date('d-m-Y', strtotime($course_end_date));
                                                                    } else {
                                                                        echo '-';
                                                                    }

                                                                    $course_expired = false;

                                                                    $course_expired = $course_details['is_course_expired'];

                                if($course_expired){
                            ?>

                                <span class="text-danger"><b>Course is expired...</b></span>

                            <?php
                                }
                            ?>
                            
                            <?php
                                if($course_details['whatsapp_group_link'] != '')
                                {
                                    ?>
                                    <a target="_blank" href="<?php echo $course_details['whatsapp_group_link'] ; ?>" class="mt-2 btn btn-sm btn-pill btn-success"><i class="fa fa-whatsapp fa-4" aria-hidden="true"></i></a>
                                    <?php
                                }
                            ?>
                            <?php
                                if($course_details['telegram_group_link'] != '')
                                {
                                    ?>
                                    <a target="_blank" href="<?php echo $course_details['telegram_group_link'] ; ?>" class="mt-2 btn btn-sm btn-pill btn-info"><i class="fa fa-telegram fa-4" aria-hidden="true"></i></a>
                                    <?php
                                }
                            ?>                    

                            <table class="table table-bordered table-hover my-5">
                                <tr>
                                    <th><dt>Paid Price</dt></th>
                                    <td><dd><i class="fa fa-rupee"></i> <?php echo $course_details['paid_price'] ; ?></dd></td>
                                </tr>
                                <tr>
                                    <th><dt>Course Duration</dt></th>
                                    <td><dd><?php echo $course_details['no_of_days']." days" ; ?></dd></td>
                                </tr>
                                <tr>
                                    <th><dt>Valid Upto</dt></th>
                                    <td><dd><?php echo $course_details['valid_upto'] ; ?></dd></td>
                                </tr>
                            </table>
                        </div>
                    </div>    

                    <!-- Course Video Links : START-->
                    <?php
                       // if(isset($course_video_details) && count($course_video_details) > 0)
                        {
                            ?>
                            <!-- <div class="col-md-12 ">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Course Video Links</h3>
                                    </div>   

                                    <div class="card-body">
                                        <div class="panel-group1" id="video_links_accordion">
                                            <div class="panel panel-default mb-4">
                                                <div class="panel-heading1 ">
                                                    <h4 class="panel-title1">
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false">Click Here To Get Video Links</a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                    <div class="panel-body">
                                                        <div class="list-group">
                                                                                                        
                                                            <?php
                                                                for($i=0;$i<count($course_video_details);$i++)
                                                                {
                                                                    $active_link = $i%2 == 0 ? 'active' : '' ;        
                                                                    
                                                                    ?>
                                                                    <a href="<?php echo $course_video_details[$i]->video_link; ?>" target="_blank" class="list-group-item list-group-item-action flex-column align-items-start <?php echo $active_link ; ?> course_video_links">
                                                                        <div class="d-flex w-100 justify-content-between">
                                                                            <h5 class="mb-1"><?php echo $course_video_details[$i]->video_title; ?></h5>
                                                                            <small><?php echo $course_video_details[$i]->created_date; ?></small>
                                                                        </div>                
                                                                    </a>    
                                                                    <?php
                                                                }
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>     -->
                            <?php    
                        }
                    ?>
                    <!-- Course Video Links : END-->

                    <!-- Course Chapters : START-->
                    <?php
                        if(isset($course_chapter_details) && count($course_chapter_details) > 0)
                        {
                            ?>
                            <div class="col-md-12 ">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Course Chapters</h3>
                                    </div>   

                                    <div class="card-body">
                                        <div class="panel-group1" id="chapters_accordion">

                                            <?php
                                            for ($i = 0; $i < count($course_video_details); $i++) {
                                                $active_link = $i % 2 == 0 ? 'active' : '';

                                            ?>
                                                <div class="border-bottom py-3 border-3 ">
                                                    <h5 class="text-muted "><?php echo $course_video_details[$i]->video_title; ?></h5>
                                                    <a href="<?php echo $course_video_details[$i]->video_link; ?>" target="_blank" class="btn btn-lg btn-rounded btn-gradient-primary"> <i class="mdi mdi-eye"></i> View</a>
                                                </div>

                                            <?php
                                            }
                                            ?>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
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