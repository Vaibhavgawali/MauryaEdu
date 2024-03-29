<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi mdi-note-plus"></i>
                </span>Add Chapter Documents
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
                            <div class="col-4 text-right">
                                <button class='btn btn-primary' id="btn_add_chapter_documents_modal"><i class="fa fa-plus"></i> Add New Chapter Document</button><br><br>
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

                        <!-- Standard modal content -->
                        <div id="add-chapter-documents-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary">Add New Chapter Document</h3>
                                            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Please fill all mandatory(<sup class="text-danger">*</sup>) data</h6>
                                        <hr>

                                        <h4 class="text-primary">Course & Chapter Details</h4>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="course_category_id">Course Category <span class="text-danger">*</span> </label>
                                                    <select class="form-control p-3" id="course_category_id" disabled>
                                                        <option value="<?php echo $course_category_details['course_category_id']; ?>" selected>
                                                            <?php echo $course_category_details['course_category_name']; ?>
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="course_master_id">Course Name <span class="text-danger">*</span> </label>
                                                    <select class="form-control p-3" id="course_master_id" disabled>
                                                        <option value="<?php echo $course_master_details['course_master_id']; ?>" selected>
                                                            <?php echo $course_master_details['course_name']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="chapter_master_id">Chapter Name <span class="text-danger">*</span> </label>
                                                    <select class="form-control p-3" id="chapter_master_id" disabled>
                                                        <option value="<?php echo $chapter_master_details['chapter_master_id']; ?>" selected>
                                                            <?php echo $chapter_master_details['chapter_name']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <br>
                                        <h4 class="text-primary">Chapter Document Details</h4>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="document_title">Document Title<span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="document_title">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- upload document -->
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="document_file">Upload Document <span class="text-danger">*</span> </label>
                                                    <input type="file" class="form-control" id="document_file" accept="application/pdf">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Document link -->
                                        <!-- <div class="row g-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="focus-label" for="document_link">Document Link<span class="text-danger">*</span> </label>
                                            <input  type="text" class="form-control"  id="document_link">
                                        </div>
                                    </div>
                                </div> -->

                                        <div class="row g-2">
                                            <div class="col-md-12" id="add_status">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                        <button type="button" class="btn btn-primary" id="btn_add_chapter_document_details"><i class="fa fa-save"></i> Submit</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <!-- Standard modal content -->
                        <div id="update-chapter-documents-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary">Update Chapter Document Details</h3>
                                            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Please fill all mandatory(<sup class="text-danger">*</sup>) data</h6>
                                        <hr>

                                        <input type="hidden" id="update_chapter_document_master_id">
                                        <h4 class="text-primary">Course & Chapter Details</h4>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_course_category_id">Course Category <span class="text-danger">*</span> </label>
                                                    <select class="form-control" id="update_course_category_id" disabled>
                                                        <option value="<?php echo $course_category_details['course_category_id']; ?>" selected>
                                                            <?php echo $course_category_details['course_category_name']; ?>
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_course_master_id">Course Name <span class="text-danger">*</span> </label>
                                                    <select class="form-control p-3" id="update_course_master_id" disabled>
                                                        <option value="<?php echo $course_master_details['course_master_id']; ?>" selected>
                                                            <?php echo $course_master_details['course_name']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_chapter_master_id">Chapter Name <span class="text-danger">*</span> </label>
                                                    <select class="form-control p-3" id="update_chapter_master_id" disabled>
                                                        <option value="<?php echo $chapter_master_details['chapter_master_id']; ?>" selected>
                                                            <?php echo $chapter_master_details['chapter_name']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <br>
                                        <h4 class="text-primary">Chapter Document Details</h4>

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_document_title">Document Title<span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="update_document_title">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Document upload -->
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="focus-label" for="curr_document">Current Document</label>
                                                    <a id="curr_document" target='_blank'>View</a>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_document_file">Upload New Document </label>
                                                    <input type="file" class="form-control" id="update_document_file" accept="application/pdf">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Document Link -->
                                        <!-- <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="focus-label" for="curr_document">Current Document Link</label>
                                            <a id="curr_document_link" target='_blank'>View</a>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="focus-label" for="update_document_link">Upload New Document Link</label>
                                            <input  type="text" class="form-control"  id="update_document_link">
                                        </div>
                                    </div>
                                </div> -->

                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="focus-label" for="update_document_status">Document Status <span class="text-danger">*</span> </label>
                                                    <select class="form-control p-3" id="update_document_status">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-12" id="update_status">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                                        <button type="button" class="btn btn-primary" id="btn_update_chapter_document_details"><i class="fa fa-save"></i> Update</button>
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