<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-30 19:58:34
 Last Modification Date: 2024-05-25 08:18:30
*
**/
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="box">
            <div class="box-header">

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="submit" onclick="errorSessionDestory();" class="close" data-dismiss="alert"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-error alert-dismissible" role="alert">
                        <button type="submit" onclick="errorSessionDestory();" class="close" data-dismiss="alert"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                    <h3 class="box-title">Project Eligible Students</h3>
                    <button class="btn btn-sm btn-info" title="Refresh" onclick="loadData()"><i class="fa fa-refresh"></i></button>
                </div>
                <!-- /.box-header -->
            </div>
            <div class="box-body table-responsive">
                <table id="manageTable"
                    class="table table-bordered table-striped responsive display nowrap table-hover">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Project</th>
                            <th>Course</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>College</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
?>

<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'reports/fetchPlacementEligibleStudents',
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });

    /*
     * Created By: Akash K. Fulari
     * On Date: 04-05-2024
     */
    function loadData() {
        manageTable.ajax.url("<?php echo base_url('reports/fetchPlacementEligibleStudents/') ?>");
    }

</script>