<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Announcements</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Announcements</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                
                <button class='btn btn-primary' id="btn_add_announcements_modal"><i class="fa fa-plus"></i> Add New Announcement</button><br><br>

                <table id="announcements_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Course Category</th>
                            <th>Title</th>
                            <th>Description</th>
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
                <div id="add-announcements-modal" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add New Announcement</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_category_id">Course Category <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="course_category_id"  data-placeholder="Choose one" multiple>
                                                <?php
                                                    for($i=0; $i<count($course_category_list); $i++){
                                                        echo "<option value='".$course_category_list[$i]['course_category_id']."'>".$course_category_list[$i]['course_category_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="announcement_title">Announcement Title <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="announcement_title" maxlength="150">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="announcement_description">Announcement Description <span class="error-text">*</span> </label>
                                            <textarea  rows="10" class="form-control"  id="announcement_description" maxlength="1000"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="announcement_add_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_add_announcement"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                <!-- Standard modal content -->
                <div id="update-announcement-modal" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Announcement</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="update_announcement_master_id">

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_category_id">Course Category <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_course_category_id"  data-placeholder="Choose one" multiple>
                                                <?php
                                                    for($i=0; $i<count($course_category_list); $i++){
                                                        echo "<option value='".$course_category_list[$i]['course_category_id']."'>".$course_category_list[$i]['course_category_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_announcement_title">Announcement Title <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_announcement_title" maxlength="150">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_announcement_description">Announcement Description <span class="error-text">*</span> </label>
                                            <textarea  rows="10" class="form-control"  id="update_announcement_description" maxlength="1000"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_announcement_status">Announcement Status <span class="error-text">*</span> </label>
                                            <select class="form-control" id="update_announcement_status">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="announcement_update_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_announcement"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>    
    </div>
</div>