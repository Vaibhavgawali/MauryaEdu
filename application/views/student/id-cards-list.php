<?php 
    $page = $this->uri->segment(1);
    //print_r_custom($login_detail,1);
?>

<div class="page-header">
    <h4 class="page-title">ID Cards</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('student/dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Id Card List</li>
    </ol>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <table id="id_cards_list" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Id Card Name</th>
                            <th>Course Name</th>
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