<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Test Schedules</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Test Schedules</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                
                <button class='btn btn-primary' id="btn_add_test_schedules_modal"><i class="fa fa-plus"></i> Add New Test Schedules</button><br><br>

                <table id="test_schedules_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Category</th>
                            <th>Schedule Title</th>
                            <th>Schedule Link</th>
                            <th>Visible On</th>
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
                <div id="add-test-schedules-modal" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add New Test Schedules</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <div class="row g-2">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="test_schedule_title">Test Schedule Title <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="test_schedule_title" maxlength="150">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="test_schedule_link">Test Schedule Link <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="test_schedule_link" maxlength="1000">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="form-group">
                                                    <label class="focus-label" for="test_schedule_date">Visibility Date <span class="error-text">*</span> </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="test_schedule_date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label class="focus-label" for="test_schedule_time">Visibility Time <span class="error-text">*</span> </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><!-- input-group-prepend -->
                                                        <input class="form-control" class="tpBasic" id="test_schedule_time" placeholder="Set time" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="test_schedules_add_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_add_test_schedules"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                <!-- Standard modal content -->
                <div id="update-test-schedules-modal" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Test Schedules</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="update_test_schedule_master_id">

                                <div class="row g-2">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_test_schedule_title">Test Schedule Title <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_test_schedule_title" maxlength="150">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_test_schedule_link">Test Schedule Link <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_test_schedule_link" maxlength="1000">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_test_schedule_date">Visibility Date <span class="error-text">*</span> </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="update_test_schedule_date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_test_schedule_time">Visibility Time <span class="error-text">*</span> </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div><!-- input-group-prepend -->
                                                        <input class="form-control" class="tpBasic" id="update_test_schedule_time" placeholder="Set time" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_test_schedule_status">Test Schedule Status <span class="error-text">*</span> </label>
                                            <select class="form-control" id="update_test_schedule_status">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="test_schedules_update_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_test_schedules"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>    
    </div>
</div>