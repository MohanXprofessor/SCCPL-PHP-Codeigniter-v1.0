<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-30 15:03:39
 Last Modification Date: 2024-05-10 11:52:15
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

<link rel="stylesheet" href="<?php echo base_url('css/dataTableHidde.min.css') ?>">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Enquiry</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Enquiry</li>
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

                <?php if ($userGroup != "Student"): ?>
                    <div style="display:flex;align-items:center;justify-content:flex-start;gap:7px;margin-bottom:20px">
                        <a href="<?php echo base_url('enquiry/create') ?>" class="btn btn-primary">Create Enquiry</a>
                        <a data-toggle="modal" data-target="#bulkUploadModal" class="btn btn-success">Create Bulk
                            Enquiry</a>
                    </div>
                <?php endif; ?>
                <div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Filter Enquiry</h3>
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
                                        <select name="project_id" type="text" class="form-control" id="projectCombo2"
                                            onchange="loadCourses(this, '#coursesAppender2')">
                                            <option value="">Select Project</option>
                                            <?php foreach ($branch as $v) { ?>
                                                <option value="<?php echo $v['id']; ?>">
                                                    <?php echo $v['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">Course</label>
                                        <select name="course_id" type="text" class="form-control" id="coursesAppender2">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">Faculty Name</label>
                                        <select name="counseller_id" type="text" class="form-control">
                                            <option value="">Select Faculty</option>
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
                    <h3 class="box-title">Enquiry List</h3>
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Submit
                        Test</button>
                </div>
                <!-- /.box-header -->
            </div>
            <div class="box-body table-responsive">
                <style>
                </style>
                <table id="manageTable"
                    class="table table-bordered table-striped responsive display nowrap table-hover">
                    <thead>
                        <tr>
                            <th>Enquiry Id</th>
                            <th>Project</th>
                            <th>Course</th>
                            <th>Student Name</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>College</th>
                            <th>Status</th>
                            <th>Follow_date</th>
                            <th>Enquiry Date</th>
                            <th>Remark</th>
                            <th>Action</th>
                            <th>Aptitude Test Date</th>
                            <th>Aptitude Test Marks</th>
                            <th>Group Discussion Date</th>
                            <th>Group Discussion Marks</th>
                            <th>Total Marks</th>
                            <th>Pass/Fail</th>
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

            <form role="form" action="<?php echo base_url('enquiry/remove') ?>" method="post" id="removeForm">
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

<div class="modal fade" tabindex="-1" role="dialog" id="adddTestModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Submit Test</h4>
            </div>

            <form role="form" action="<?php echo base_url('screeningtest/submitSingleEquiry') ?>" method="post"
                id="removeForm">
                <div class="modal-body">
                    <div class="form-group" hidden>
                        <label for="company_name">Enquiry Id</label>
                        <input type="text" class="form-control" id="enquiryId" name="enquiryId"
                            placeholder="Enter Enquiry Id" readonly autocomplete="off">
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px">
                        <div style="width:100%">
                            <div class="form-group">
                                <label for="company_name">Aptitude Test Date</label>
                                <input type="date" class="form-control" id="apptitudeTestDate" name="apptitudeTestDate"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div style="width:100%">
                            <div class="form-group">
                                <label for="company_name">Aptitude Test Marks</label>
                                <input type="number" class="form-control" id="apptitudeTestMarks"
                                    name="apptitudeTestMarks" placeholder="Enter Aptitude Test Marks"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px">
                        <div style="width:100%">
                            <div class="form-group">
                                <label for="company_name">Group Discussion Test Date</label>
                                <input type="date" class="form-control" id="gdTestDate" name="gdTestDate"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div style="width:100%">
                            <div class="form-group">
                                <label for="company_name">Group Discussion Test Marks</label>
                                <input type="number" class="form-control" id="gdTestMarks" name="gdTestMarks"
                                    placeholder="Enter Group Discussion Test Marks" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name">Total Marks</label>
                        <input type="number" class="form-control" id="totalMarks" name="totalMarks"
                            placeholder="Enter Group Discussion Test Marks" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="company_name">Status</label>
                        <select class="form-control" autocomplete="off" id="status" name="status">
                            <option value="1">Pass</option>
                            <option value="0">Fail</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Test</button>
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="bulkUploadModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Bulk Enquiry</h4>
            </div>

            <form role="form" action="<?php echo base_url('enquiry/addenquirybulk') ?>" enctype="multipart/form-data"
                method="post" id="removeForm">
                <div class="modal-body">
                    <div style="width:95%; margin:0 auto">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Project</label>
                                    <select name="project_id" type="text" class="form-control" id="projectCombo"
                                        required onchange='loadCourses(this, "#coursesAppender")'>
                                        <option>Select Project</option>
                                        <?php foreach ($branch as $v) { ?>
                                            <option value="<?php echo $v['id']; ?>">
                                                <?php echo $v['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Course</label>
                                    <select name="course_id" id="coursesAppender" type="text" class="form-control"
                                        required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Counseller Name</label>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Date</label>
                                    <input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control"
                                        name="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="company_name">Select Status :</label>
                                <select class="form-control" id="status" name="status"
                                    onchange="validateFollowUpDate(this)">
                                    <option value="Next-date" slected>Next Follow up date</option>
                                    <option value="Confirm">Confirm</option>
                                    <option value="Ignore">Ignore</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Bulk Enquiry CSV File</label>
                                    <input type="file" class="form-control" name="bulk_file" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6" id="validateFollowUpDateField">
                                <label for="company_name">Next Followup Date:</label>
                                <input type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>"
                                    id="followup_date" name="followup_date" autocomplete="off">
                            </div>
                        </div>
                        <p>
                            <b>Note:</b>
                            <span>Gender should be digits in csv file(0: Female, 1: Male, 2: Other)</span>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Enquiry</button>
                    <a href="<?php echo base_url('assets/templetes/enquiryDataBulkTemplete.csv') ?>"
                        class="btn btn-info">Download Templete</a>
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- upload marks modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Tests</h4>
            </div>
            <form role="form" action="<?php echo base_url('screeningtest/submitBulkEquiry') ?>" method="post"
                id="createForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="brand_name">Bulk Tests Upload</label>
                        <input type="File" class="form-control" id="bulkFile" name="bulkFile" placeholder=""
                            autocomplete="off">
                    </div>
                    <p>
                        <b>Note:</b>
                        <span>Pass/Fails should be digits in csv file(0: Fail, 1: Pass)</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Tests</button>
                    <a class="btn btn-info" onclick="downloadBulkTextSubmitCSVTemplete()">Download Templete</a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {
        loadCourses($("#projectCombo"), "#coursesAppender");
        loadCourses($("#projectCombo2"), "#coursesAppender2");
        $("#mainOrdersNav").addClass('active');
        $("#manageOrdersNav").addClass('active');

        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'enquiry/fetchEnquiryData',
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            order: [],
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
            success: function(res) {
                if (res.status) {
                    $(ele).html("<option value=''>Please select course!</option>" + res.message);
                } else {
                    $(ele).html("<option value=''>Please select course!</option>");
                }
            }
        });
    }

    function addTestFunc(id) {
        $("#enquiryId").val(id);
    }
    // remove functions 
    function removeFunc(id) {
        if (id) {
            $("#removeForm").on('submit', function() {

                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {

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

    function downloadBulkTextSubmitCSVTemplete() {
        $(".dt-button.buttons-csv.buttons-html5").click();
    }

    function submitFilter(form) {
        manageTable.ajax.url(base_url + 'enquiry/fetchFilteredEnquiryData?start_date=' + form.start_date.value + '&end_date=' + form.end_date.value + '&project_id=' + form.project_id.value + '&course_id=' + form.course_id.value + '&counseller_id=' + form.counseller_id.value).load();
    }

    function resetFilter() {
        manageTable.ajax.url(base_url + 'enquiry/fetchEnquiryData').load();
    }

    validateFollowUpDate(document.getElementById("status"));

    function validateFollowUpDate(ele) {
        document.getElementById("validateFollowUpDateField").style.display = ((ele.value == "Next-date") ? "block" : "none");
    }
</script>