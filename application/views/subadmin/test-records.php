<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Test Records</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Test Records</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                
                <button class='btn btn-primary' id="btn_add_test_records_modal"><i class="fa fa-plus"></i> Add New Test Record</button><br><br>

                <table id="test_records_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Student Name</th>
                            <th>Test Date</th>
                            <th>Attempted</th>
                            <th>Obtained</th>
                            <th>Total</th>
                            <th>Right</th>
                            <th>Wrong</th>
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
                <div id="add-test-records-modal" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add New Test Record</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="student_id">Student Name <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="student_id"  data-placeholder="Choose one">
                                                <option value="" selected>----- Select -----</option>
                                                <?php
                                                    for($i=0; $i<count($student_list); $i++){
                                                        echo "<option value='".$student_list[$i]['student_id']."'>".$student_list[$i]['full_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="test_date">Test Date <span class="error-text">*</span> </label>
                                            <div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
                                                <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="test_date">
											</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="is_attempted">Test Attempted Or Not<span class="error-text">*</span> </label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="is_attempted" value="1">
                                                        <span class="custom-control-label">Yes</span>
                                                    </label>
                                                </div>
                                                <div class="col-4">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="is_attempted" value="0">
                                                        <span class="custom-control-label">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="marks_obtained">Marks Obtained <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="marks_obtained" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="total_marks">Total Marks <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="total_marks" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="no_of_right_questions">Right Questions <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="no_of_right_questions" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="no_of_wrong_questions">Wrong Questions <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="no_of_wrong_questions" maxlength="5">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="test_records_add_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_add_test_records"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                <!-- Standard modal content -->
                <div id="update-test-records-modal" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Test Record</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="update_test_records_master_id">

                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_student_id">Student Name <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_student_id"  data-placeholder="Choose one">
                                                <option value="">----- Select -----</option>
                                                <?php
                                                    for($i=0; $i<count($student_list); $i++){
                                                        echo "<option value='".$student_list[$i]['student_id']."'>".$student_list[$i]['full_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_test_date">Test Date <span class="error-text">*</span> </label>
                                            <div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
                                                <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="update_test_date">
											</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_is_attempted">Test Attempted Or Not<span class="error-text">*</span> </label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="update_is_attempted" value="1" id="is_attempted_yes">
                                                        <span class="custom-control-label">Yes</span>
                                                    </label>
                                                </div>
                                                <div class="col-4">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="update_is_attempted" value="0" id="is_attempted_no">
                                                        <span class="custom-control-label">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_marks_obtained">Marks Obtained <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_marks_obtained" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_total_marks">Total Marks <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_total_marks" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_no_of_right_questions">Right Questions <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_no_of_right_questions" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_no_of_wrong_questions">Wrong Questions <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_no_of_wrong_questions" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_test_records_status">Test Record Status <span class="error-text">*</span> </label>
                                            <select class="form-control" id="update_test_records_status">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="test_records_update_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_test_records"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>    
    </div>
</div>