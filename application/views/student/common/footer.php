
        <!-- main-panel ends -->
        </div>
      <!-- page-body-wrapper ends -->
    </div>
</div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo base_url('assets/js/vendors/vendor.bundle.base.js');?>"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?php echo base_url('assets/js/vendors/chart.js/Chart.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.cookie.js');?>" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo base_url('assets/js/off-canvas.js');?>"></script>
    <script src="<?php echo base_url('assets/js/hoverable-collapse.js');?>"></script>
    <script src="<?php echo base_url('assets/js/misc.js');?>"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="<?php echo base_url('assets/js/dashboard.js');?>"></script>
    <script src="<?php echo base_url('assets/js/todolist.js');?>"></script>
    
<!-- Dashboard js -->
<script src="<?php echo base_url('assets/js/vendors/jquery-3.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendors/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendors/jquery.sparkline.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendors/selectize.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendors/jquery.tablesorter.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendors/circle-progress.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/rating/jquery.rating-stars.js'); ?>"></script>

<!--Select2 js -->
<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>

<!-- Timepicker js -->
<script src="<?php echo base_url('assets/plugins/time-picker/jquery.timepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/time-picker/toggles.min.js'); ?>"></script>

<!-- Datepicker js -->
<script src="<?php echo base_url('assets/plugins/date-picker/spectrum.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/date-picker/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/input-mask/jquery.maskedinput.js'); ?>"></script>

<!-- third party js -->
<script src="<?php echo base_url('assets/libs/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.flash.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-select/js/dataTables.select.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/pdfmake/build/pdfmake.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/pdfmake/build/vfs_fonts.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert.js'); ?>"></script>

<!-- Tost-->
<script src="<?php echo base_url('assets/libs/jquery-toast-plugin/jquery.toast.min.js'); ?>"></script>

<!-- toastr init js-->
<script src="<?php echo base_url('assets/js/toastr.init.js'); ?>"></script>

<!-- Fullside-menu Js-->
<script src="<?php echo base_url('assets/plugins/toggle-sidebar/sidemenu.js'); ?>"></script>

<!-- Custom scroll bar Js-->
<script src="<?php echo base_url('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

<!-- Custom Js-->
<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

<!-- confirm init js-->
<script src="<?php echo base_url('assets/js/jquery-confirm.min.js'); ?>"></script>

<script>
    function generateNotification(type, message) {
        if (type == 'error')
        {
            $.toast({
                heading: 'Error!',         
                text: message,
                position: 'top-center',
                loaderBg:'#ec2d38',
                icon: 'error',
                hideAfter: 3500, 
                stack: 6
            });
        }
        else if (type == 'success')
        {
            $.toast({
                heading: 'Success!',       
                text: message,
                position: 'top-center',
                loaderBg:'#5ed84f',
                icon: 'success',
                hideAfter: 3500, 
                stack: 6
            });
        }
    } 

</script>
<?php loadJs($application_version); ?>
    <!-- End custom js for this page -->
  </body>
</html>