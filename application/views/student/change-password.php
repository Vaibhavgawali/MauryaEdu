<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Change Password</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('student/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
    </ol>
</div>

<div class="row">
    <div class="col mx-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-group mb-0">
                    <div class="card p-4">
                        <div class="card-header">
                            <h3>Instructions &nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></h3>
                        </div>
                        <div class="card-body">
                        
                            <ul style="list-style-position: outside!important;">
                                <li>
                                    <p class="text-primary">Password should be of minimum <?= MIN_LENGTH_PASSWORD; ?> characters.<span class="display-none text-success" id="pw-min"><i class="fa fa-check fa-2x"></i></span></p> 
                                </li>
                                <li>
                                    <p class="text-primary">Password should be of maximum <?= MAX_LENGTH_PASSWORD; ?> characters.<span class="display-none text-success" id="pw-max"><i class="fa fa-check fa-2x"></i></span></p>
                                </li>
                                <li>
                                    <p class="text-primary">Password must have atleast one upper case character.<span class="display-none text-success" id="pw-upper-char"><i class="fa fa-check fa-2x"></i></span></p> 
                                </li>
                                <li>
                                    <p class="text-primary">Password must have atleast one digit.<span class="display-none text-success" id="pw-digit"><i class="fa fa-check fa-2x"></i></span></p> 
                                </li>
                                <li>
                                    <p class="text-primary">Password must have atleast one special characters <strong>[!@#$%)*_(+=}{|:;,.>}]</strong>.<span class="display-none text-success" id="pw-special-char"><i class="fa fa-check fa-2x"></i></span></p>
                                </li>
                            </ul>
                        
                        </div>
                    </div>
                    <div class="card py-4">
                        <div class="card-header">
                            <h3>Change Password &nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></h3>
                        </div>
                        <div class="card-body justify-content-center ">
                            <input type="hidden" value="<?= MIN_LENGTH_PASSWORD; ?>" id="pw_min_len">
                            <input type="hidden" value="<?= MAX_LENGTH_PASSWORD; ?>" id="pw_max_len">
                            <div class="row mt-10">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="required-field">Current Password</label>
                                        <input type="password" class="form-control current_password" id="current_password"  name="current_password"  required autocomplete='off' >
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-10">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="required-field">New Password</label>
                                        <input type="password" class="form-control new_password" id="new_password"  name="new_password" maxlength="<?= MAX_LENGTH_PASSWORD; ?>"  required autocomplete='off' >
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-10">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="required-field">Confirm New Password</label>
                                        <input type="password" class="form-control confirm_password" id="confirm_password"  name="confirm_password" maxlength="<?= MAX_LENGTH_PASSWORD; ?>"  required autocomplete='off' >
                                    </div>
                                </div>
                            </div>

                            <div class="change_password_status"></div>
                            
                            <button class="btn btn-gradient-primary btn-block change_pass_submit" style="float: right;">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
