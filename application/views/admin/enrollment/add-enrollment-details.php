<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>
<?php // print_r_custom($course_master_list,1); ?>

<div class="page-header">
    <h4 class="page-title">Add Enrollment : <b class='text-primary'><?php // echo $course_category_details['course_category_name'];?></b></h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('subadmin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Enrollment</li>
    </ol>
</div>

<?php // print_r_custom($course_master_list,1); ?>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                <hr>

                <h4 class="text-primary">Enrollment Details</h4>
                
                <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
              
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="focus-label" for="course_master_id">Course Name <span class="error-text">*</span> </label>
                            <select class="form-control"  id="course_master_id">
                                <option value="" selected>----- Select -----</option>
                                <?php
                                    for($i=0; $i<count($course_master_list); $i++){
                                        echo "<option value='".$course_master_list[$i]['course_master_id']."'>".$course_master_list[$i]['course_name']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <br>

                <div class="row g-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="focus-label" for="chapter_name">Course Sell Price <span class="error-text">*</span> </label>
                            <input  type="text" class="form-control"  id="course_price" maxlength="100" readonly>
                        </div>
                    </div>
                </div>


                <div class="row g-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="focus-label" for="chapter_info">Number of Installlments </label>
                            <input  type="text" class="form-control"  id="installment_number" maxlength="5">
                        </div>
                    </div>
                </div>

                <div id="first_installment_field" style="display: none;">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="focus-label" for="installment_amount">Installment Amount</label>
                                <input type="text" class="form-control" id="installment_amount">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-12" id="enrollment_add_status">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" id="btn_add_enrollment"><i class="fa fa-save"></i> Submit</button>
                    </div>
                </div>

            </div>
        </div>    
    </div>
</div>