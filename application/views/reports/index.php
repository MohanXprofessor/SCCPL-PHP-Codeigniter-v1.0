<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-30 19:58:34
 Last Modification Date: 2024-05-09 16:53:40
*
**/


$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$branch = $query->result_array();

$sql = "SELECT * FROM brands WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$courses = $query->result_array();


$sql = "SELECT users.id,users.firstname FROM users join user_group on users.id=user_group.user_id WHERE group_id = 4";
$query = $this->db->query($sql);
$counseller_details = $query->result_array();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Screening Test</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Screening Test</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="successMessage">

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
                </div>
                <div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Filter Screening Test</h3>
                        </div>
                        <div class="box-body">
                            <form role="form" onsubmit="submitFilter(this);return false;" method="post">
                                <?php echo validation_errors(); ?>

                                <div
                                    style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:0 5px">
                                    <div class="form-group">
                                        <label for="form-text">Date From</label>
                                        <div
                                            style="display:flex;align-items:center;justify-content:space-between;gap:10px">
                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                max="<?php echo date("Y-m-d"); ?>"
                                                onchange="this.nextElementSibling.nextElementSibling.min=this.value" />
                                            <label for="">To</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">Project</label>
                                        <select name="project_id" type="text" class="form-control" required
                                            id="projectCombo" onchange="loadCourses(this, '#coursesAppender')">
                                            <option>Select Project</option>
                                            <?php foreach ($branch as $v) { ?>
                                                <option value="<?php echo $v['id']; ?>">
                                                    <?php echo $v['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">Course</label>
                                        <select name="course_id" type="text" class="form-control" required
                                            id="coursesAppender">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">Faculty Name</label>
                                        <select name="counseller_id" type="text" class="form-control" required>
                                            <?php
                                            foreach ($counseller_details as $v) {
                                                ?>
                                                <option value="<?php echo $v['id']; ?>">
                                                    <?php echo $v['firstname']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-warning">Filter Enquiries</button>
                                    <a onclick="resetFilter()" class="btn btn-primary">Reset Filter</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                    <h3 class="box-title">Screening Test List</h3>
                </div>
                <!-- /.box-header -->
            </div>
            <div class="box-body table-responsive">
                <table id="manageTable"
                    class="table table-bordered table-striped responsive display nowrap table-hover">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Course</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>College</th>
                            <!-- <th>Follow_date</th>
                            <th>Status</th>
                            <th>Remark</th> -->
                            <th>Aptitude Test Date</th>
                            <th>Aptitude Test Marks</th>
                            <th>Group Discussion Date</th>
                            <th>Group Discussion Marks</th>
                            <th>Total Obtained Marks</th>
                            <th>Pass/Fail</th>
                            <th>Action</th>
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


<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Remove Enquiry</h4>
            </div>

            <form role="form" action="<?php echo base_url('screeningtest/remove') ?>" method="post" id="removeForm">
                <div class="modal-body">
                    <p>Do you really want to remove?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        loadCourses($("#projectCombo"), "#coursesAppender");
        $("#mainOrdersNav").addClass('active');
        $("#manageOrdersNav").addClass('active');

        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'screeningtest/fetchScreenTestData',
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
    function loadCourses(me, ele) {
        $.ajax({
            url: "<?php echo base_url('enquiry/loadCoursesByProjectId/') ?>" + me.value,
            type: "get",
            data: {},
            dataType: "json",
            success: function (res) {
                if (res.status) {
                    $(ele).html(res.message);
                } else {
                    $(ele).html("<option>Please select course!</option>");
                }
            }
        });
    }

    // remove functions 
    function removeFunc(id) {
        if (id) {
            $("#removeForm").on('submit', function () {

                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {

                        manageTable.ajax.reload(null, false);

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                '</div>');

                            // hide the modal
                            $("#removeModal").modal('hide');

                        } else {

                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                '</div>');
                        }
                    }
                });

                return false;
            });
        }
    }

    function submitFilter(form) {
        manageTable.ajax.url(base_url + 'screeningtest/fetchFilteredScreenTestData?start_date=' + form.start_date.value + '&end_date=' + form.end_date.value + '&project_id=' + form.project_id.value + '&course_id=' + form.course_id.value + '&counseller_id=' + form.counseller_id.value).load();
    }

    function resetFilter() {
        manageTable.ajax.url(base_url + 'screeningtest/fetchScreenTestData').load();
    }
</script>