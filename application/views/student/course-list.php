<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>
<style type="text/css">
    .hovernow {
        padding: 5px !important;
        box-shadow: 0 0px 0px rgba(0, 0, 0, 0.15);
        transition: box-shadow 0.3s ease-in-out;
    }

    .hovernow:hover {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    .row-flex {
        display: flex;
        flex-wrap: wrap;
    }

    .course_title{
        line-height: 1.5em;
        height: 3em;     
        overflow: hidden;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Our Courses</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('student/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Our Courses</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="row row-flex" id= "course-grid">
        </div>

        
        <div class="text-center my-5">
            <input type="hidden" name="page_num" id="page_num" value="1"/>
            <button type="button" id="load-more-btn" class="btn btn-success">Load more...</button>
        </div>
    </div>
</div>