<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Discount Coupon</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Discount Coupon</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                
                <button class='btn btn-primary' id="btn_add_discount_coupon_modal"><i class="fa fa-plus"></i> Add New Discount Coupon</button><br><br>

                <table id="discount_coupon_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Coupon Code</th>
                            <th>Course</th>
                            <th>Disc %</th>
                            <th>Disc Amt</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>No of times use</th>
                            <th>Locked</th>
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
                <div id="add-discount-coupon-modal" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add New Discount Coupon</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="discount_coupon_code">Coupon Code <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="discount_coupon_code" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_master_id">Course <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="course_master_id"  data-placeholder="Choose one">
                                                <option value="" selected>---- Select One ----</option>
                                                <option value="0">All</option>
                                                <?php
                                                    for($i=0; $i<count($course_list); $i++){
                                                        echo "<option value='".$course_list[$i]['course_master_id']."'>".$course_list[$i]['course_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="disount_percent">Discount Percentage(%) </label>
                                            <input  type="text" class="form-control"  id="disount_percent" maxlength="3">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="discount_amount">Discount Amount </label>
                                            <input  type="text" class="form-control"  id="discount_amount" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="focus-label" for="start_date">Valid From Date </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="start_date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="focus-label" for="end_date">Valid To Date </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="end_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="form-group">
                                                <label class="focus-label" for="no_of_times_coupon_use">Number of Times Coupon Use <span class="error-text">*</span> </label>
                                                <input  type="text" class="form-control"  id="no_of_times_coupon_use">
                                            </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label class="focus-label" for="is_locked">Lock Coupon Code </label>
                                                    <select class="form-control" id="is_locked">
                                                        <option value="0" selected>No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="discount_coupon_add_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_add_discount_coupon"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Standard modal content -->
                <div id="update-discount-coupon-modal" class="modal fade" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add New Discount Coupon</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <div class="row g-2">
                                    <input type='hidden' id="update_discount_coupon_master_id">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_discount_coupon_code">Coupon Code <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_discount_coupon_code" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_master_id">Course <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_course_master_id"  data-placeholder="Choose one">
                                                <option value="" selected>---- Select One ----</option>
                                                <option value="0">All</option>
                                                <?php
                                                    for($i=0; $i<count($course_list); $i++){
                                                        echo "<option value='".$course_list[$i]['course_master_id']."'>".$course_list[$i]['course_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_disount_percent">Discount Percentage(%) </label>
                                            <input  type="text" class="form-control"  id="update_disount_percent" maxlength="3">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_discount_amount">Discount Amount </label>
                                            <input  type="text" class="form-control"  id="update_discount_amount" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_start_date">Valid From Date </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="update_start_date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_end_date">Valid To Date </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="update_end_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="form-group">
                                                <label class="focus-label" for="update_no_of_times_coupon_use">Number of Times Coupon Use <span class="error-text">*</span> </label>
                                                <input  type="text" class="form-control"  id="update_no_of_times_coupon_use">
                                            </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_is_locked">Lock Coupon Code </label>
                                                    <select class="form-control" id="update_is_locked">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_discount_coupon_status">Discount Coupon Status <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_discount_coupon_status"  data-placeholder="Choose one">
                                                <option value="1">Active</option>
                                                <option value="0">In-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="discount_coupon_update_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_discount_coupon"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>    
    </div>
</div>