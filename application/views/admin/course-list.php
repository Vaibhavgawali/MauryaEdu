<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Course List</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Course List</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <button class='btn btn-primary' id="btn_add_course_modal"><i class="fa fa-plus"></i> Add New Course</button><br><br>

                <table id="course_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Category</th>
                            <th>Course Name</th>
                            <th>Branch Name</th>
                            <th>Image</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Allow Purchase</th>
                            <th>Duration</th>
                            <th>Actual Price</th>
                            <th>Sell Price</th>
                            <th>Installments</th>
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
                <div id="add-course-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add New Course</h3>
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
                                            <label class="focus-label" for="course_name">Course Name <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="course_name" maxlength="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_info">Course Related General Information <span class="error-text">*</span> <span class="text-warning">Add HTML content foe eg, <<br>br> for line break. <<b>b> for bold etc...</b>> </span>  </label>
                                            <textarea class="form-control"  id="course_info" maxlength="1000" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_image">Course Image <span class="error-text">*</span> </label>
                                            <input  type="file" class="form-control"  id="course_image" accept="image/png, image/jpeg">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h4 class="text-primary">Course Duration & Payment Details</h4>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_actual_price">Actual Price <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="course_actual_price">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_sell_price">Sell Price <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="course_sell_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_duration_number_of_days">Duration (Number of Days) <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="course_duration_number_of_days">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_number_of_installments">Number of Installments<span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="course_number_of_installments">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_start_date">Start Date <span class="error-text">*</span>  </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="course_start_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="course_end_date">End Date <span class="error-text">*</span>  </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="course_end_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="is_allow_purchase_after_expire">Allow Purchase After Course Expiry Date <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="is_allow_purchase_after_expire">
                                                <option value="" selected>----Select----</option>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h4 class="text-primary">Telegram & Whatsapp Group Link</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="telegram_group_link">Telegram Group Link </label>
                                            <input  type="text" class="form-control"  id="telegram_group_link">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="whatsapp_group_link">Whatsapp Group Link </label>
                                            <input  type="text" class="form-control"  id="whatsapp_group_link">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="course_add_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_add_course"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Standard modal content -->
                <div id="update-course-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Course Details</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>
                                <input type="hidden" id="update_course_master_id">

                                <h4 class="text-primary">Course Details</h4>
                                
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_category_id">Course Category <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_course_category_id">
                                                <option value="" selected>----- Select -----</option>
                                                <?php
                                                    for($i=0; $i<count($course_category_list); $i++){
                                                        echo "<option value='".$course_category_list[$i]['course_category_id']."' >".$course_category_list[$i]['course_category_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_name">Course Name <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_course_name" maxlength="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_info">Course Related General Information <span class="error-text">*</span> <span class="text-warning">Add HTML content foe eg, <<br>br> for line break. <<b>b> for bold etc...</b>> </span> </label>
                                            <textarea class="form-control"  id="update_course_info" maxlength="1000" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_image">Course Image </label>
                                            <input  type="file" class="form-control"  id="update_course_image" accept="image/png, image/jpeg">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="course_img"></div>
                                    </div>
                                </div>

                                <hr>
                                <h4 class="text-primary">Course Duration & Payment Details</h4>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_actual_price">Actual Price <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_course_actual_price">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_sell_price">Sell Price <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_course_sell_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_duration_number_of_days">Duration (Number of Days) <span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_course_duration_number_of_days">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_number_of_installments">Number of Installments<span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_course_number_of_installments">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_start_date">Start Date <span class="error-text">*</span>  </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="update_course_start_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_end_date">End Date <span class="error-text">*</span>  </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="update_course_end_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_is_allow_purchase_after_expire">Allow Purchase After Course Expiry Date <span class="error-text">*</span> </label>
                                            <select class="form-control"  id="update_is_allow_purchase_after_expire">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h4 class="text-primary">Telegram & Whatsapp Group Link</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_telegram_group_link">Telegram Group Link </label>
                                            <input  type="text" class="form-control"  id="update_telegram_group_link">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_whatsapp_group_link">Whatsapp Group Link </label>
                                            <input  type="text" class="form-control"  id="update_whatsapp_group_link">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h4 class="text-primary">Course Status</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_course_status">Status </label>
                                            <select class="form-control"  id="update_course_status">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="course_update_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_course"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>    
    </div>
</div>