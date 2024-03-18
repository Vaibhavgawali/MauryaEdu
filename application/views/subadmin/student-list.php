<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi  mdi-account-card-details"></i>
                </span>Registerd Students
            </h3>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">

                        <!-- <button class='btn btn-primary' id="btn_add_student_modal"><i class="fa fa-plus"></i> Add New Student</button><br><br> -->

                        <table id="student_list" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Student Name</th>
                                    <th>Student Email</th>
                                    <th>Student Phone</th>
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
                        <div id="update-student-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary">Update Student Details</h3>
                                            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                        <hr>
                                        <input type="hidden" id="update_student_id">

                                        <h4 class="text-primary">Student Details</h4>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_full_name">Full Name <span class="error-text">*</span> </label>
                                                    <input type="text" class="form-control" id="update_full_name" maxlength="255">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_emailid">Email Id <span class="error-text">*</span> </label>
                                                    <input type="text" class="form-control" id="update_emailid" maxlength="255">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_contact">Contact Number <span class="error-text">*</span> </label>
                                                    <input type="text" class="form-control" id="update_contact" maxlength="20">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_aadhar_number">Aadhar Number </label>
                                                    <input type="text" class="form-control" id="update_aadhar_number" maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_address">Address </label>
                                                    <textarea class="form-control" id="update_address" maxlength="500"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4 class="text-primary">Student Status</h4>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_status">Status <span class="error-text">*</span> </label>
                                                    <select class="form-control" id="update_status">
                                                        <?php
                                                        for ($i = 0; $i < count($student_status_master); $i++) {
                                                            echo "<option value='" . $student_status_master[$i]['status_id'] . "'>" . $student_status_master[$i]['status_text'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-12" id="student_update_status">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                        <button type="button" class="btn btn-primary " id="btn_update_student"><i class="fa fa-save"></i> Update</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Maurya 2024 </span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">Designed & Developed By <a style="text-decoration: none;" href="https://www.zynovvatech.com/" target="_blank">Zynovvatech</a></span>
        </div>
    </footer>
    <!-- partial -->
</div>