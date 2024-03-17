<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-video"></i>
                </span> Live Lecture
            </h3>
        </div>
        <div class="container">
            <div class="row row-cards">
                <div class="container">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <?php
                                if (count($validEnrollmentList) > 0) {
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
                                } else {
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