<?php 
    $page = $this->uri->segment(1);
    // print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">My Profile</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('subadmin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 col-xl-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <?php
                                        if(!empty($adminInfo['profile_pic'])){
                                            $img_path = base_url().'uploads/subadmin/profile-pic/'.$adminInfo['profile_pic'];
                                        }
                                        else{
                                            $img_path = base_url().'assets/images/profile-photo-not-available.png';
                                        }
                                    ?>
                                    
                                    <img class='img_preview' src="<?php echo $img_path; ?>" width='300' height='300' alt="<?php echo $login_detail['admin_name'];?>">
                                </div>
                                <br>
                                <div class="text-center">
                                    <h3 class="mb-0"><?php echo $adminInfo['admin_name'];?></h3>
                                    <p class="text-muted mb-0"><?php echo $adminInfo['admin_emailid'];?></p>
                                </div>
                                <hr>
                                <div class="text-left">
                                    <div class="form-group">
                                        <label>Change Profile Picture</label>
                                        <input type="file" name="upload_image" id="upload_image" class="form-control file-upload"/>
                                    </div>
                                </div>

                                <div id="uploadimageModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog"  role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title text-primary" id="uploadimageModalLabel">Crop & Upload Profile Pic</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-8 text-center">
                                                        <div id="image_demo" style="width:350px; margin-top:30px"></div>
                                                    </div>
                                                    <div class="col-lg-4" style="padding-top:30px;">
                                                        <br />
                                                        <br />
                                                        <br/>
                                                        <button class="btn btn-success crop_image">Crop & Save Image</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-xl-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-xl-12 text-left">
                                        <h2><?php echo $adminInfo['admin_name'];?></h2>
                                    </div>
                                </div>
                                
                                <hr>

                                <h3 style="text-align:justify;color:#3085d6;">Basic Information</h3>

                                <div class="row mt-3">
                                    <div class="col-lg-4 col-xl-4 head-text">Full Name</div>
                                    <div class="col-lg-8 col-xl-8 large-text mb-0"><?php echo $adminInfo['admin_name'];?></div>
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
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-xl-4 head-text">Created On</div>
                                    <div class="col-lg-8 col-xl-8 large-text mb-0"><?php echo date('d-m-Y H:i:s', strtotime($adminInfo['created_date']));?></div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-xl-4 head-text">Updated On</div>
                                    <div class="col-lg-8 col-xl-8 large-text mb-0">
                                        <?php 
                                            if(!empty($adminInfo['updated_date'])){
                                                echo date('d-m-Y H:i:s', strtotime($adminInfo['updated_date']));
                                            }
                                            else{
                                                echo "-";
                                            }
                                        ?>
                                    </div>
                                </div>
                                
                                <hr>

                                <div class="row">
                                    <div class="col-lg-8 col-xl-8 text-left">
                                        <h3 style="text-align:justify;color:#3085d6;">Contact Information</h3>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 text-left">
                                        <button class="btn btn-xs btn-primary" id="btn_contact_details">Update Contact Details</button>
                                    </div>
                                </div>
                                

                                <div class="row mt-3">
                                    <div class="col-lg-4 col-xl-4 head-text">Email Id</div>
                                    <div class="col-lg-8 col-xl-8 large-text mb-0"><?php echo $adminInfo['admin_emailid'];?></div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-lg-4 col-xl-4 head-text">Contact Number</div>
                                    <div class="col-lg-8 col-xl-8 large-text mb-0"><?php echo $adminInfo['admin_contact'];?></div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-lg-4 col-xl-4 head-text">Address</div>
                                    <div class="col-lg-8 col-xl-8 large-text mb-0"><?php echo $adminInfo['admin_address'];?></div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-lg-4 col-xl-4 head-text">Adhar Number</div>
                                    <div class="col-lg-8 col-xl-8 large-text mb-0"><?php echo $adminInfo['aadhar_number'];?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                

                <!-- update user modal content -->
                <div id="update-contact-detail-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"  role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary">Update Contact Details</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                                <hr>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="full_name">Full Name <span class="error-text">*</span> </label>
                                                    <input  type="text" class="form-control"  id="full_name" maxlength="150" value="<?php echo $adminInfo['admin_name'];?>" >
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="emailid">Email <?php if($adminInfo['role'] == 1) { echo "<span class='error-text'><sup>Contact Admin</sup></span>"; } else { echo "<span class='error-text'>*</span>"; } ?></label>
                                                    <input  type="text" class="form-control"  id="emailid" maxlength="150" value="<?php echo $adminInfo['admin_emailid'];?>" <?php if($adminInfo['role'] == 1) { echo "disabled='disabled' readonly"; }?>>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="contact">Phone <span class="error-text">*</span> </label>
                                                    <input  type="text" class="form-control"  id="contact" maxlength="20" value="<?php echo $adminInfo['admin_contact'];?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="address">Address </label>
                                                    <textarea id="address" class="form-control" rows="8" maxlength="500"><?php echo $adminInfo['admin_address'];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="aadhar_number">Aadhar Number </label>
                                                    <input  type="text" class="form-control"  id="aadhar_number" maxlength="12" value="<?php echo $adminInfo['aadhar_number'];?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Aadhar Number Instructions &nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></h3>
                                        <ol style="list-style-position: outside!important;" class="text-primary">
                                            <li>
                                                <p>It should have 12 digits.</p> 
                                            </li>
                                            <li>
                                                <p>It should not start with 0 and 1.</p>
                                            </li>
                                            <li>
                                                <p>It should not contain any alphabet and special characters.</p> 
                                            </li>
                                        </ol>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-12" id="update_contact_status">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="btn_update_contact">Update</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        </div>    
    </div>
</div>
