<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account"></i>
                </span> Profile
            </h3>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 col-xl-5 ">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="text-center">
                                        <?php
                                            if (!empty($adminInfo['profile_pic'])) {
                                                $img_path = base_url() . 'uploads/subadmin/profile-pic/' . $adminInfo['profile_pic'];
                                            } else {
                                                $img_path = base_url() . 'assets/images/profile-photo-not-available.png';
                                            }
                                            ?>
                                            <div class="img-container border-primary p-3 " style="border-style: dashed; border-radius:8px;width:100% ">
                                                <div class="img_div w-100
                                                ">
                                                    <div class="w-100">
                                                        <img class='img_preview img-fluid' src="<?php echo $img_path; ?>" alt="<?php echo $login_detail['admin_name']; ?>">
                                                        <br>
                                                        <button class="btn btn-primary btn-sm my-3 upload_image">Upload Profile Pic</button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="img-dropbox" onclick="redirectToFiles()" style="cursor: pointer;display:none">
                                                        <div class="py-5 ">
                                                            <i class="mdi mdi-cloud-upload btn-icon btn-icon-primary" style="color:#B66DFF;font-size:50px"></i>
                                                            <h4 class="text-center" style="color:#B66DFF">Click here to upload profile picture</h4>
                                                            <input type="file" name="upload_image" id="upload_image" class="form-control file-upload" hidden />
                                                        </div>
                                                    </div>
                                                    <a href="<?php echo base_url('student/my-profile') ?>" class="btn btn-secondary btn-sm my-2 cancel-btn">Cancel</a>
                                                </div>
                                                <script>
                                                    function redirectToFiles() {
                                                        // Get the input element by its id
                                                        var uploadImageInput = document.getElementById('upload_image');
                                                        // Trigger the click event on the input element
                                                        uploadImageInput.click();
                                                    }
                                                </script>
                                            </div>

                                        </div>
                                        <br>



                                        <div id="uploadimageModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title text-primary" id="uploadimageModalLabel">Crop & Upload Profile Pic</h3>
                                                        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-8 text-center">
                                                                <div id="image_demo" style="width:350px; margin-top:30px"></div>
                                                            </div>
                                                            <div class="col-lg-4" style="padding-top:30px;">
                                                                <br />
                                                                <br />
                                                                <br />
                                                                <button class="btn btn-success crop_image">Crop & Save Image</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn btn-secondary modal-close" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-xl-7">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 text-left">
                                                <h3 style="text-align:justify;color:#3085d6;">Personal Information</h3>

                                            </div>
                                        </div>

                                        <hr>


                                        <div class="form-group row">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Full Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username" disabled value="<?php echo $adminInfo['admin_name']; ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-4 col-xl-4 head-text">Status</div>
                                            <div class="col-lg-8 col-xl-8 large-text mb-0">
                                            <?php
                                                $status = $adminInfo['admin_status'];

                                                $status_display = "";

                                                $status_display = "<span class='badge badge-success'>Active</span>";

                                                echo $status_display;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Created On</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username" disabled value="<?php echo date('d-m-Y H:i:s', strtotime($adminInfo['created_date'])); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Updated On</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username" disabled value="<?php
                                                                                                                                                            if (!empty($adminInfo['updated_date'])) {
                                                                                                                                                                echo date('d-m-Y H:i:s', strtotime($adminInfo['updated_date']));
                                                                                                                                                            } else {
                                                                                                                                                                echo "-";
                                                                                                                                                            }
                                                                                                                                                            ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 py-2">
                                <div class="d-flex justify-content-between my-3">
                                    <h3 style="text-align:justify;color:#3085d6; ">Contact Information</h3>
                                    <button class="btn btn-primary btn-sm" id="edit_contact"><i class="mdi mdi-pen"> Edit</i></button>
                                </div>
                                <form action="">
                                    <div class="form-group">
                                        <label for="full_name">Full Name </label>
                                        <input type="text" id="full_name" value="<?php echo $adminInfo['admin_name']; ?>" class="form-control input-contact" placeholder="Enter Full Name" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="emailid">Email</label>
                                        <input type="email" class="form-control input-contact" id="emailid" placeholder="Email" value="<?php echo $adminInfo['admin_emailid']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Phone</label>
                                        <input type="text" class="form-control input-contact" id="contact" placeholder="Contact Number" value="<?php echo $adminInfo['admin_contact']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="aadhar_number">Aadhar Number</label>
                                        <input type="text" class="form-control input-contact" id="aadhar_number" placeholder="Aadhar Number" value="<?php echo isset($adminInfo['aadhar_number']) ? $adminInfo['aadhar_number'] : 'N/A'; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control input-contact" id="address" rows="4" placeholder="Enter Address" disabled><?php echo $adminInfo['admin_address'] ? $adminInfo['admin_address'] : 'N/A'; ?></textarea>
                                    </div>
                                    <div>
                                        <div id="update_contact_status">
                                        </div>
                                    </div>
                                    <div class="button_div" style="display: none;">
                                        <button type="submit" class="btn btn-primary btn-md" id="btn_update_contact">Update</button>
                                        <button type="cancel" class="btn bg-secondary text-light btn-md">Cancel</button>
                                    </div>
                                </form>

                            </div>
                        </div>
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