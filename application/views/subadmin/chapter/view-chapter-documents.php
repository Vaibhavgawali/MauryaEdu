<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">View Chapter Documents</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('subadmin/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('subadmin/course-list'); ?>">Course List</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('subadmin/chapter-list'); ?>">Chapter List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Chapter Documents</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8 text-left">
                        <h5><b class='text-primary'><?php echo $course_category_details['course_category_name'];?> &nbsp; - &nbsp; <?php echo $course_master_details['course_name'];?> &nbsp; - &nbsp; <?php echo $chapter_master_details['chapter_name'];?></b></h5>
                        <input type="hidden" id="curr_chapter_master_id" value="<?php echo $chapter_master_id; ?>">
                    </div>
                  
                </div>
                

                <table id="chapter_documents_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Category</th>
                            <th>Course</th>
                            <th>Chapter</th>
                            <th>Title</th>
                            <th>Document</th>
                            <!-- <th>Document Link</th> -->
                            <th>Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>

            </div>
        </div>    
    </div>
</div>