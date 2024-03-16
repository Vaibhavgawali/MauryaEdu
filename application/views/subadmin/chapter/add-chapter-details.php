<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi mdi-book-plus"></i>
                </span>Add Chapter
            </h3>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">

                        <h6>Please fill all mandatory(<sup class="error-text">*</sup>) data</h6>
                        <hr>

                        <h4 class="text-primary">Course Details</h4>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="focus-label" for="course_category_id">Course Category <span class="error-text">*</span> </label>
                                    <select class="form-control" id="course_category_id" disabled>
                                        <option value="<?php echo $course_category_details['course_category_id']; ?>" selected>
                                            <?php echo $course_category_details['course_category_name']; ?>
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="focus-label" for="course_master_id">Course Name <span class="error-text">*</span> </label>
                                    <select class="form-control" id="course_master_id" disabled>
                                        <option value="<?php echo $course_master_details['course_master_id']; ?>" selected>
                                            <?php echo $course_master_details['course_name']; ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <h4 class="text-primary">Chapter Details</h4>

                        <div class="row g-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="focus-label" for="chapter_name">Chapter Name <span class="error-text">*</span> </label>
                                    <input type="text" class="form-control" id="chapter_name" maxlength="100">
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="focus-label" for="chapter_info">Chapter Information </label>
                                    <textarea class="form-control" id="chapter_info" maxlength="1000" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-12" id="chapter_add_status">
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" id="btn_add_chapter"><i class="fa fa-save"></i> Submit</button>
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