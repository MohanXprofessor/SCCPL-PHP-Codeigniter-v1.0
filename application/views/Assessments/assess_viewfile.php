<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reading |</title>

    <style>
        .table-responsive {
            overflow-x: auto;
            /* Enable horizontal scroll */
        }
    </style>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Assessment
                <small>Manage Assessment</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Manage Assessment</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">

            <h3>Reading CSV File....!</h3>
            <div class="box">
                <div class="box-header">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                        <h3 class="box-title">Assess List</h3>
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
        </section>
    </div>



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
</body>

</html>