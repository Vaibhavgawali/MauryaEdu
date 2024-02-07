<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>
<style type="text/css">
    .course_video_links:hover{
        color: #ff685c !important;
    }
</style>
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
                        <div class="card-body">
                            <div class="cart-product-imitation bg-gray my-2">
                                <img src="<?php echo base_url().'uploads/course/'.$course_details['course_master_id'].'/course-image/'.$course_details['course_image'] ;?>" alt="<?php echo $course_details['course_name'] ; ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-7">
                        <div class="card-body">
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
                                <dt>Description :</dt>
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
                                    ?>
                                </dd>
                            </dl>

                            <dl class="small m-b-none">
                                <dt>Course Duration</dt>
                                <dd><?php echo $course_details['course_duration_number_of_days']." days" ; ?></dd>
                            </dl>

                            <?php
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
                        if(isset($course_video_details) && count($course_video_details) > 0)
                        {
                            ?>
                            <div class="col-md-12 ">
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
                            </div>    
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
                                                for($j=0;$j<count($course_chapter_details); $j++)
                                                // print_r_custom($course_chapter_details[$j]);
                                                {
                                                    ?>
                                                    <div class="panel panel-default mb-4">
                                                        <div class="panel-heading1 ">
                                                            <h4 class="panel-title1">
                                                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $course_chapter_details[$j]->chapter_master_id ; ?>" aria-expanded="false"><?php echo $course_chapter_details[$j]->chapter_name ; ?></a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapse<?php echo $course_chapter_details[$j]->chapter_master_id ; ?>" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                            <div class="panel-body">

                                                                <!-- Chapter Infromation : Start-->
                                                                <p><?php echo $course_chapter_details[$j]->chapter_info ; ?></p>
                                                                <!-- Chapter Infromation : End-->

                                                                <!-- Chapter Documents : Start-->
                                                                <?php 
                                                                    if(count($course_chapter_details[$j]->chapter_doc) > 0)
                                                                    {     
                                                                      ?>
                                                                        <h3 class="card-title">Chapter Documents : </h3>
                                                                        <ul class="list-group">
                                                                            <?php
                                                                                for($k=0;$k<count($course_chapter_details[$j]->chapter_doc);$k++)
                                                                                {
                                                                                    ?>
                                                                                    <li class="list-group-item">

                                                                                    <!-- <a target = "_blank" href="<?php echo base_url("uploads/chapter/".$course_chapter_details[$j]->chapter_master_id."/chapter-documents/".$course_chapter_details[$j]->chapter_doc[$k]->chapter_document_master_id."/".$course_chapter_details[$j]->chapter_doc[$k]->document_file); ?>"> -->
                                                                                    
                                                                                    <a target="_blank"  href="<?php echo $course_chapter_details[$j]->chapter_doc[$k]->document_link; ?>">
                                                                                      
                                                                                            <?php 
                                                                                                echo $course_chapter_details[$j]->chapter_doc[$k]->document_title;
                                                                                            ?>
                                                                                            <span class="badgetext">
                                                                                                <i class="fa fa-file-pdf-o text-primary" aria-hidden="true"></i>
                                                                                            </span>
                                                                                        </a>
                                                                                        
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </ul>
                                                                        <hr/>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <!-- Chapter Documents : END-->

                                                                <!-- Sub Chapter : Start -->
                                                                <?php
                                                                    if(count($course_chapter_details[$j]->sub_chapters) > 0)
                                                                    {
                                                                        ?>
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h3 class="card-title">Sub Chapters : </h3>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="panel-group1" id="sub_chapter_accordion">

                                                                                    <?php
                                                                                        for($x=0;$x<count($course_chapter_details[$j]->sub_chapters);$x++)
                                                                                        {
                                                                                            ?>
                                                                                            <div class="panel panel-default mb-4">
                                                                                                <div class="panel-heading1 ">
                                                                                                    <h4 class="panel-title1">
                                                                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="<?php echo "#".$course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_master_id ; ?>" aria-expanded="false" style="background: #169db2;"><?php echo $course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_name ; ?></a>
                                                                                                    </h4>
                                                                                                </div>
                                                                                                <div id="<?php echo $course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_master_id ; ?>" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                                                                    <div class="panel-body">

                                                                                                        <!--Sub Chapter Information : Start -->
                                                                                                        <p><?php echo $course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_info ; ?></p>
                                                                                                        <!--Sub Chapter Information : End -->

                                                                                                        <!--Sub Chapter Documents : Start -->
                                                                                                        <?php
                                                                                                            if( count($course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_doc) > 0)
                                                                                                            {
                                                                                                                ?>
                                                                                                                <h3 class="card-title">Chapter Documents : </h3>
                                                                                                                <ul class="list-group">
                                                                                                                    <?php
                                                                                                                        for($k=0;$k<count($course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_doc);$k++)
                                                                                                                        {
                                                                                                                            ?>
                                                                                                                            <li class="list-group-item">
                                                                                                                                <a target = "_blank" href="<?php echo base_url("uploads/sub-chapter/".$course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_master_id."/sub-chapter-documents/".$course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_doc[$k]->sub_chapter_document_master_id."/".$course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_doc[$k]->document_file) ; ?>">
                                                                                                                                    <?php 
                                                                                                                                        echo $course_chapter_details[$j]->sub_chapters[$x]->sub_chapter_doc[$k]->document_title;
                                                                                                                                    ?>
                                                                                                                                    <span class="badgetext">
                                                                                                                                    
                                                                                                                                        <i class="fa fa-file-pdf-o text-primary" aria-hidden="true"></i>
                                                                                                                                    </span>
                                                                                                                                </a>
                                                                                                                                
                                                                                                                            </li>
                                                                                                                            <?php
                                                                                                                        }
                                                                                                                    ?>
                                                                                                                </ul>
                                                                                                                <?php
                                                                                                            }      
                                                                                                        ?>    
                                                                                                        <!--Sub Chapter Documents : End -->


                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <?php
                                                                                        }
                                                                                    ?>
                                                                            
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                        <?php
                                                                    }
                                                                ?>
                                                                <!-- Sub Chapter : END -->
                                                              
                                                            </div>
                                                        </div>
                                                    </div>        
                                                    <?php
                                                }
                                            ?>
                                                                
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>        
                            <?php
                        }
                    ?>
                    <!-- Course Chapters : END-->

                    <div class="col-md-12 ">

                        <div class="ibox-content card-footer text-right">
                            <a href="<?php echo base_url('student/enrolled-courses-list'); ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>                
    </div>
</div>