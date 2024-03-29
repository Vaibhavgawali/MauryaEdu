<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">Parent - Teachers Meetings</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('student/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Parent - Teachers Meetings</li>
    </ol>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <?php
                    if(count($validEnrollmentList) > 0){
                ?>

                <table id="pt_meetings_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Course Category</th>
                            <th>Title</th>
                            <th>PT Meeting On</th>
                            <th>Created</th>
                            <th>Updated</th>
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