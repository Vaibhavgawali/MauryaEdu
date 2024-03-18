<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-book-multiple-variant"></i>
                </span> Chapter
            </h3>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 text-left">
                                <h5><b class='text-primary'><?php echo $course_category_details['course_category_name']; ?> &nbsp; - &nbsp; <?php echo $course_master_details['course_name']; ?> &nbsp; - &nbsp; <?php echo $chapter_master_details['chapter_name']; ?></b></h5>
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