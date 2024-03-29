<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi  mdi-account-multiple"></i>
                </span> Branch Admin
            </h3>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">

                        <button class='btn btn-primary' id="btn_add_branch_admin_modal"><i class="fa fa-plus"></i> Add New Branch Admin</button><br><br>

                        <table id="branch_admin_list" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Email</th>
                                    <th>Contact</th>
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
                        <div id="add-branch-admin-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary">Add New Branch Admin</h3>
                                            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Please fill all mandatory(<sup class="text-danger">*</sup>) data</h6>
                                        <hr>

                                        <h4 class="text-primary">Branch Admin Details</h4>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="admin_name">Name <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="admin_name" maxlength="100">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="branch_id">Branch <span class="text-danger">*</span> </label>
                                                    <select class="form-control p-3" id="branch_id">
                                                        <option value="" selected>----- Select -----</option>
                                                        <?php
                                                        for ($i = 0; $i < count($branch_list); $i++) {
                                                            echo "<option value='" . $branch_list[$i]['branch_id'] . "'>" . $branch_list[$i]['branch_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="admin_emailid">Email <span class="text-danger">*</span> </label>
                                                    <input type="email" class="form-control" id="admin_emailid" maxlength="100">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="admin_contact">Contact <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="admin_contact" maxlength="100">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-12" id="branch_admin_add_status">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                        <button type="button" class="btn btn-primary" id="btn_add_branch_admin"><i class="fa fa-save"></i> Submit</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <!-- Standard modal content -->
                        <div id="update-branch-admin-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary">Update Branch Admin</h3>
                                            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Please fill all mandatory(<sup class="text-danger">*</sup>) data</h6>
                                        <hr>
                                        <input type="hidden" id="update_branch_admin_id">

                                        <h4 class="text-primary">Branch Admin Details</h4>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_branch_admin_name">Name <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="update_branch_admin_name" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_branch_id">Branch <span class="text-danger">*</span> </label>
                                                    <select class="form-control p-3" id="update_branch_id">
                                                        <option value="" selected>----- Select -----</option>
                                                        <?php
                                                        for ($i = 0; $i < count($branch_list); $i++) {
                                                            // $selected = ($branch_list[$i]['branch_id'] == $update_branch_id) ? 'selected' : '';

                                                            echo "<option value='" . $branch_list[$i]['branch_id'] . "' >" . $branch_list[$i]['branch_name'] . $update_branch_id . " </option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_branch_admin_emailid">Email <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="update_branch_admin_emailid" maxlength="100" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_branch_admin_contact">Contact <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="update_branch_admin_contact" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_branch_admin_status">Status </label>
                                                    <select class="form-control p-3" id="update_branch_admin_status">
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
                                            <div class="col-md-12" id="branch_admin_update_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                        <button type="button" class="btn btn-primary" id="btn_update_branch_admin"><i class="fa fa-save"></i> Update</button>
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