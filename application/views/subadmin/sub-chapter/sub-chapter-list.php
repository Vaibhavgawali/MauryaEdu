<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Sub Chapters</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/chapter-list'); ?>">Chapter List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sub Chapter List</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <button class='btn btn-primary' id="btn_add_sub_chapter_modal"><i class="fa fa-plus"></i> Add New Sub Chapter</button><br><br>

                <table id="sub_chapter_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Category</th>
                            <th>Course</th>
                            <th>Chapter Name</th>
                            <th>Sub Chapter Name</th>
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
                <div id="add-sub-chapter-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add New Sub Chapter</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <h4 class="text-primary">Course Details</h4>
                                
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_category_id">Course Category <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="course_category_id">
                                                <option value="" selected>----- Select -----</option>
                                                <?php
                                                    for($i=0; $i<count($course_category_list); $i++){
                                                        echo "<option value='".$course_category_list[$i]['course_category_id']."'>".$course_category_list[$i]['course_category_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_master_id">Course Name <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="course_master_id">
                                                <option value="" selected>----- Select -----</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                
                                <h4 class="text-primary">Chapter Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="chapter_master_id">Chapter Name <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="chapter_master_id">
                                                <option value="" selected>----- Select -----</option>
                                                
                                            </select>
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
                                <button type="button" class="btn btn-primary" id="btn_add_sub_chapter_details"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Standard modal content -->
                <div id="update-sub-chapter-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Chapter - </h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="update_sub_chapter_master_id">
                                <h4 class="text-primary">Course Details</h4>
                                
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_category_id">Course Category <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_course_category_id">
                                                <option value="" selected>----- Select -----</option>
                                                <?php
                                                    for($i=0; $i<count($course_category_list); $i++){
                                                        echo "<option value='".$course_category_list[$i]['course_category_id']."'>".$course_category_list[$i]['course_category_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_master_id">Course Name <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_course_master_id">
                                                <option value="" selected>----- Select -----</option>
                                                <?php
                                                    for($i=0; $i<count($course_master_list); $i++){
                                                        echo "<option value='".$course_master_list[$i]['course_master_id']."'>".$course_master_list[$i]['course_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <h4 class="text-primary">Chapter Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_chapter_master_id">Course Name <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_chapter_master_id">
                                                <option value="" selected>----- Select -----</option>
                                                <?php
                                                    for($i=0; $i<count($chapter_master_list); $i++){
                                                        echo "<option value='".$chapter_master_list[$i]['chapter_master_id']."'>".$chapter_master_list[$i]['chapter_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <h4 class="text-primary">Sub Chapter Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_sub_chapter_name">Sub Chapter Name <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_sub_chapter_name" maxlength="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_sub_chapter_info">Sub Chapter Information </label>
                                            <textarea class="form-control"  id="update_sub_chapter_info" maxlength="1000" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_sub_chapter_status">Sub Chapter Status </label>
                                            <select class="form-control" id="update_sub_chapter_status">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="sub_chapter_update_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_sub_chapter"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>    
    </div>
</div>