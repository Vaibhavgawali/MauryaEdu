<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>
<div class="page-header">
    <h4 class="page-title">Course Details</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('student/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Course Details</li>
    </ol>

</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card-body">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12 col-lg-5">
                        <div class="cart-product-imitation bg-gray">
                            <img src="<?php echo base_url().'uploads/course/'.$course_details['course_master_id'].'/course-image/'.$course_details['course_image'] ;?>" alt="<?php echo $course_details['course_name'] ; ?>" >
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-7">
                        <div class="card-body p-5">
                            <h4>
                                <a href="javascript:void(0)" class="text-navy">
                                    <strong>Course Category : </strong><?php echo $course_details['course_category_name'] ; ?>
                                </a>    
                            </h4>
                            <dl class="small m-b-none">
                                <dt>Category Information :</dt>
                                <dd><?php echo $course_details['course_category_info'] ; ?></dd>
                            </dl>

                            <h4>
                            <a href="javascript:void(0)" class="text-navy">
                                <strong>Course Title : </strong><?php echo $course_details['course_name'] ; ?>
                            </a>
                            </h4>

                            <dl class="small m-b-none">
                                <dt>Description lists</dt>
                                <dd><?php echo $course_details['course_info'] ; ?></dd>
                            </dl>

                            <dl class="small m-b-none">
                                <dt>Start Date</dt>
                                <dd>
                                    <?php 
                                        $course_start_date = $course_details['course_start_date']; 
                                        if($course_start_date!=NULL && $course_start_date!='0000-00-00'){
                                            echo date('d-m-Y', strtotime($course_start_date)); 
                                        }
                                        else{
                                            echo '-';
                                        }
                                    ?>
                                </dd>
                            </dl>

                            <dl class="small m-b-none">
                                <dt>End Date</dt>
                                <dd>
                                    <?php 
                                        $course_end_date = $course_details['course_end_date']; 
                                        if($course_end_date!=NULL && $course_end_date!='0000-00-00'){
                                            echo date('d-m-Y', strtotime($course_end_date)); 
                                        }
                                        else{
                                            echo '-';
                                        }

                                        $course_expired = false;

                                        $course_expired = $course_details['is_course_expired'];
                                        if($course_expired){
                                            echo "<small class='text-primary'> [Course is already expired]</small>";
                                        }
                                    ?>
                                </dd>
                            </dl>

                            <dl class="small m-b-none">
                                <dt>Course Duration</dt>
                                <dd><?php echo $course_details['course_duration_number_of_days']." days" ; ?></dd>
                            </dl>

                            <dl class="small m-b-none">
                                <dt>Enrollment Expiry Date <small class="text-primary">[After purchase]</small></dt>
                                <dd><?php echo date('d-m-Y', strtotime($course_details['enrollment_expiry_date'])); ?></dd>
                            </dl>

                            <?php
                                $course_expired = false;
                                $is_allow_purchase_after_expire = '';

                                $course_expired = $course_details['is_course_expired'];
                                $is_allow_purchase_after_expire = $course_details['is_allow_purchase_after_expire'];

                                if(!$course_expired || ($course_expired && $is_allow_purchase_after_expire=='1')){
                                    echo '<span class="text-success"><b>Purchase this course now...</b></span>';
                            ?>
                            <br><br>
                            <h4><i class="fa fa-rupee"></i> <?php echo $course_details['course_sell_price'] ; ?></h4>

                            <!-- <a href="" class="mt-2 btn btn-sm btn-pill btn-primary">Buy Now</a> -->
                            <a href="javascript:void(0)" id="<?php echo $course_details['course_master_id'] ; ?>" course_sell_price ="<?php echo $course_details['course_sell_price'] ; ?>"  class="mt-2 btn btn-sm btn-pill btn-primary add_to_cart">Add to cart</a>
                            <?php
                                }
                            ?>

                        </div>

                        <div class="ibox-content card-footer text-right">
                            <a href="<?php echo base_url('student/courses-list'); ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>                
    </div>
</div>