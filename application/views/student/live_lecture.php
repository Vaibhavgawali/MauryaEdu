<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Live Lecture</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item " aria-current="page"><a href="<?php echo base_url('student/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Video Lectures</li>
    </ol>

</div>

<div class="row row-cards">
    <div class="container">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">

                    <?php
                        if(count($validEnrollmentList) > 0){
                    ?>

                    <table id="data_list" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Course Category</th>
                                <th>Course Title</th>
                                <th>Video Title</th>
                                <th>Video Link</th>
                                <th>Uploaded_date</th>
                                <th>Validity Upto</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>

                    <?php
                        }
                        else{
                    ?>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h3 class="text-primary">You have not enrolled for course or your enrollment is expired.</h3>
                            <h4 class="text-primary">You are not allowed to access this page.</h4>
                        </div>
                    </div>
                    
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <?php
                        }
                    ?>
                </div>
            </div>    
        </div>
    </div>
</div>    