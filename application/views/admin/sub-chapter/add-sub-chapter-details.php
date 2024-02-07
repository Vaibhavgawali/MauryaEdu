<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Add Sub Chapter</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/sub-chapter-list'); ?>">Sub Chapter List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Chapter</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h5><b class='text-primary'><?php echo $course_category_details['course_category_name'];?> &nbsp; - &nbsp; <?php echo $course_master_details['course_name'];?> &nbsp; - &nbsp; <?php echo $chapter_master_details['chapter_name'];?></b></h5>
                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                <hr>

                <h4 class="text-primary">Course Details</h4>
                
                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="focus-label" for="course_category_id">Course Category <span class="error-text">*</span> </label>
                            <select class="form-control"  id="course_category_id" disabled>
                                <option value="<?php echo $course_category_details['course_category_id'];?>" selected>
                                    <?php echo $course_category_details['course_category_name'];?>
                                </option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="focus-label" for="course_master_id">Course Name <span class="error-text">*</span> </label>
                            <select class="form-control"  id="course_master_id" disabled>
                                <option value="<?php echo $course_master_details['course_master_id'];?>" selected>
                                    <?php echo $course_master_details['course_name'];?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="focus-label" for="chapter_master_id">Chapter Name <span class="error-text">*</span> </label>
                            <select class="form-control"  id="chapter_master_id" disabled>
                                <option value="<?php echo $chapter_master_details['chapter_master_id'];?>" selected>
                                    <?php echo $chapter_master_details['chapter_name'];?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <br>
                <h4 class="text-primary">Sub Chapter Details</h4>

                <div class="row g-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="focus-label" for="sub_chapter_name">Sub Chapter Name <span class="error-text">*</span> </label>
                            <input  type="text" class="form-control"  id="sub_chapter_name" maxlength="100">
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="focus-label" for="sub_chapter_info">Sub Chapter Information </label>
                            <textarea class="form-control"  id="sub_chapter_info" maxlength="1000" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-12" id="sub_chapter_add_status">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" id="btn_add_sub_chapter"><i class="fa fa-save"></i> Submit</button>
                    </div>
                </div>

            </div>
        </div>    
    </div>
</div>