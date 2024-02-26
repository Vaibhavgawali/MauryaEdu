<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Enrollments</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Enrollments</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                
                <table id="student_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Branch Name</th>
                            <th>Course Name</th>
                            <th>Actual Price</th>
                            <th>Paid Price</th>
                            <th>Valid Upto</th>
                            <th>Created Date</th>
                            <th>Validity Status</th>
                            <th>Enrollment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>

                <!-- Standard modal content -->
                <div id="update-status-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Student Status  For Course</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>
                                <input type="hidden" id="update_enrollment_id">

                              
                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_enrollment_student_status">Status </label>
                                            <select class="form-control"  id="update_enrollment_student_status">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="enrollment_student_update_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_status"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Standard modal content -->
                <div id="add-certificate-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add Certificate Details</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="enrollment_id">

                                <h4 class="text-primary">Certificate Details</h4>
                                <input type="hidden" id="update_chapter_document_master_id">

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="certificate_title">Certificate Title<span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="certificate_title">
                                        </div>
                                    </div>
                                </div>

                                <!-- Document upload -->
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="focus-label" for="certificate_file">Upload Certificate</label>
                                            <input  type="file" class="form-control"  id="certificate_file" accept="application/pdf">
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
                                <button type="button" class="btn btn-primary" id="btn_add_certificate_details"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                  <!-- Standard modal content -->
                <div id="update-certificate-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Certificate Details</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="update_certificate_master_id">
                                <input type="hidden" id="update_student_id">

                                <h4 class="text-primary">Certificate Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_certificate_title">Certificate Title<span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_certificate_title">
                                        </div>
                                    </div>
                                </div>

                                <!-- Document upload -->
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="curr_certificate">Current Certificate</label>
                                            <a id="curr_certificate" target='_blank'>View</a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_certificate_file">Upload New Certificate</label>
                                            <input  type="file" class="form-control"  id="update_certificate_file" accept="application/pdf">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_certificate_status">Certificate Status <span class="error-text">*</span> </label>
                                            <select class="form-control" id="update_certificate_status">
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
                                <button type="button" class="btn btn-primary" id="btn_update_certificate_details"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Standard modal content -->
                <div id="add-id-card-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Add Id Card Details</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="enrollment_id" value="5">

                                <h4 class="text-primary">Id Card Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="id_card_title">Id Card Title<span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="id_card_title">
                                        </div>
                                    </div>
                                </div>

                                <!-- Document upload -->
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="focus-label" for="id_card_file">Upload Id Card</label>
                                            <input  type="file" class="form-control"  id="id_card_file" accept="application/pdf">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="add_id_card_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_add_id_card_details"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                  <!-- Standard modal content -->
                <div id="update-id-card-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Id Card Details</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <input type="hidden" id="update_id_card_master_id">
                                <input type="hidden" id="update_card_student_id">

                                <h4 class="text-primary">Id Card Details</h4>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_id_card_title">Id Card Title<span class="error-text">*</span> </label>
                                            <input  type="text" class="form-control"  id="update_id_card_title">
                                        </div>
                                    </div>
                                </div>

                                <!-- Document upload -->
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="curr_id_card">Current Id Card</label>
                                            <a id="curr_id_card" target='_blank'>View</a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_id_card_file">Upload New Id Card</label>
                                            <input  type="file" class="form-control"  id="update_id_card_file" accept="application/pdf">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_id_card_status">Id Card Status <span class="error-text">*</span> </label>
                                            <select class="form-control" id="update_id_card_status">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="update_card_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_id_card_details"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                                <!-- Modal -->
                                <div id="installmentModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Installment Details</h3>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form id="installmentForm">
                                    <input  type="hidden" class="form-control"  id="razor_payment_id" name="razor_payment_id">
                                    <input  type="hidden" class="form-control"  id="last_installment" name="last_installment">
                
                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="focus-label" for="course_price">Course Price:<span class="error-text">*</span> </label>
                                                <input  type="text" class="form-control"  id="course_price" name="course_price" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="focus-label" for="total_installment_amount">Total Amount Paid:<span class="error-text">*</span> </label>
                                                <input  type="text" class="form-control"  id="total_installment_amount" name="total_installment_amount" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="focus-label" for="installment">Installment <span class="error-text">*</span> </label>
                                                <select class="form-control" id="installment" name="installment">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="focus-label" for="installment_amount">Installment Amount<span class="error-text">*</span> </label>
                                                <input  type="text" class="form-control"  id="installment_amount" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="focus-label" for="paid_status">Paid Status <span class="error-text">*</span> </label>
                                                <select class="form-control" id="paid_status">
                                                    <option value='0' selected>Unpaid</option>
                                                    <option value='1'>Paid</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-12" id="update_installment_status">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                <button type="button" class="btn btn-primary" id="add_installment"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>