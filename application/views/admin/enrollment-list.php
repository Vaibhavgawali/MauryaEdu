<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-table-edit"></i>
                </span>Enrollments
            </h3>
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
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary">Update Student Status For Course</h3>
                                            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Please fill all mandatory(<sup class="text-danger">*</sup>) data</h6>
                                        <hr>
                                        <input type="hidden" id="update_enrollment_id">


                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_enrollment_student_status">Status </label>
                                                    <select class="form-control p-3" id="update_enrollment_student_status">

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
                                        <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                        <button type="button" class="btn btn-primary" id="btn_update_status"><i class="fa fa-save"></i> Update</button>
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