<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Add Video : <b class='text-primary'><?php echo $course_category_details['course_category_name'];?> &nbsp; - &nbsp; <?php echo $course_master_details['course_name'];?></b></h4>
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/course-list'); ?>">Courses</a></li>
        <li class="breadcrumb-item active" aria-current="page">Course Video</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <input type="hidden" id="curr_course_master_id" value="<?php echo $course_master_id; ?>">
                <button class='btn btn-primary' id="btn_add_course_video_modal"><i class="fa fa-plus"></i> Add New Course Video</button><br><br>

                <table id="course_video_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Category</th>
                            <th>Course</th>
                            <th>Video</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>

                <!-- Standard modal content -->
                <div id="add-course-video-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add New Course Video</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <h4 class="text-primary">Course Details</h4>
                
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_category_id">Course Category <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="course_category_id" disabled>
                                                <option value="<?php echo $course_category_details['course_category_id'];?>" selected>
                                                    <?php echo $course_category_details['course_category_name'];?>
                                                </option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_master_id">Course Name <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="course_master_id" disabled>
                                                <option value="<?php echo $course_master_details['course_master_id'];?>" selected>
                                                    <?php echo $course_master_details['course_name'];?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                
                                <br>
                                <h4 class="text-primary">Course Video Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="video_title">Video Title<span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="video_title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="video_link">Video Link <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="video_link">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="add_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_add_course_video_details"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Standard modal content -->
                <div id="update-course-video-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Course Video</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="update_course_video_master_id">
                                <h4 class="text-primary">Course Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_category_id">Course Category <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_course_category_id" disabled>
                                                <option value="<?php echo $course_category_details['course_category_id'];?>" selected>
                                                    <?php echo $course_category_details['course_category_name'];?>
                                                </option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_master_id">Course Name <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_course_master_id" disabled>
                                                <option value="<?php echo $course_master_details['course_master_id'];?>" selected>
                                                    <?php echo $course_master_details['course_name'];?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <h4 class="text-primary">Course Video Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_video_title">Video Title<span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_video_title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_video_link">Video Link <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_video_link">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_video_status">Video Status </label>
                                            <select class="form-control" id="update_video_status">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="update_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_course_video_details"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>    
    </div>
</div>