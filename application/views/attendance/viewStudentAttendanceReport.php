<?php
/*
 *
 * Author: Akash K Fulari
 * Contact-mail: akashfulari31@gmail.com
 * Description: ________________your_description_here_________________
 * Created: 2024-04-17 13:10:41
 Last Modification Date: 2024-04-22 14:32:03
 *
 **/
$current_date = new DateTime();
$end_Date = $current_date->format('Y-m-d');
$current_date->modify('-31 days');
$start_Date = $current_date->format('Y-m-d');

$date1 = new DateTime($start_Date);
$date2 = new DateTime($mindate);
if ($date2 < $date1)
    $start_Date = $date1->format('Y-m-d');
else
    $start_Date = $mindate;

echo $date1->format('Y-m-d') . ">>>" . $date2->format('Y-m-d') . ">>>>>>>>>";

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ak_fullcalendar.min.css" />
<script src="https://themekita.com/demo-ready-pro-bootstrap/livepreview/assets/js/plugin/moment/moment.min.js"></script>
<script
    src="https://themekita.com/demo-ready-pro-bootstrap/livepreview/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script
    src="https://themekita.com/demo-ready-pro-bootstrap/livepreview/assets/js/plugin/fullcalendar/fullcalendar.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Student
            <small>Attendance Reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Student Attendance Report</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="min-height:auto;padding-bottom:0;">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>
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

                <?php if (in_array('createUser', $user_permission)): ?>
                        <a href="<?php echo base_url('enquiry/create') ?>" class="btn btn-primary">Add Student</a>
                        <br /> <br />
                <?php endif; ?>
                <div class="box">
                    <div class="box-header">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                            <h3 class="box-title" style="text-transform:capitalize">Filter Attendance Report</h3>
                        </div>
                    </div>
                    <div class="box-body">
                        <form role="form" onsubmit="filterAttendance(this);return false;" method="post" id="filterForm">
                            <?php echo validation_errors(); ?>

                            <div style="display:flex;align-items:center;justify-content:start;gap:10px;padding:0 5px">
                                <div class="form-group">
                                    <label for="form-text">Date From</label>
                                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px">
                                        <input type="date" name="start" id="start_date" class="form-control" min="<?php echo $mindate; ?>"
                                            max="<?php echo $end_Date; ?>" value="<?php echo $start_Date; ?>"
                                            onchange="this.nextElementSibling.nextElementSibling.min=this.value" />
                                        <label for="">To</label>
                                        <input type="date" value="<?php echo $end_Date; ?>" name="end" id="end_date"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_name">Select Batch</label>
                                    <select name="batch" id="batch_id" type="text" class="form-control" required>
                                        <?php foreach ($batchs as $v) { ?>
                                                <option value="<?php echo $v['id']; ?>">
                                                    <?php echo $v['batch_name']; ?>
                                                </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" id="filterFormBtn" class="btn btn-warning">Filter Attendance</button>
                                <a onclick="resetFilter()" class="btn btn-primary">Reset Filter</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box">
                    <div style="padding:10px">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Student Name:</td>
                                    <td><b><?php echo $studentData['firstname'] . " " . $studentData['lastname']; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Batch:</td>
                                    <td><b id="batch"></b></td>
                                </tr>
                                <tr>
                                    <td>Total Days:</td>
                                    <td><b id="days"></b></td>
                                </tr>
                                <tr>
                                    <td>Absents:</td>
                                    <td><b id="absents"></b></td>
                                </tr>
                                <tr>
                                    <td>Presenties:</td>
                                    <td><b id="presents"></b></td>
                                </tr>
                                <tr>
                                    <td>Leaves:</td>
                                    <td><b id="leaves"></b></td>
                                </tr>
                                <tr>
                                    <td>Holidays:</td>
                                    <td><b id="holidays"></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered table-striped responsive display nowrap table-hover">
                            <thead>
                                <tr>
                                    <th>Days</th>
                                    <th>Status</th>
                                    <th>IN Time</th>
                                    <th>OUT Time</th>
                                    <th>Duration</th>
                                    <th>Late By</th>
                                    <th>Early By</th>
                                    <th>OT</th>
                                    <th>Shift</th>
                                </tr>
                            </thead>
                            <tbody id="tableAppender">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<script>
    let manageTable;
    let ele = document.getElementById("tableAppender");
    $(document).ready(function () {
        const frm = document.getElementById("filterForm");
        // console.log(frm.start.value, frm.end.value, frm.batch.value);
        loadEvents(frm.start.value, frm.end.value, frm.batch.value);
    });

    function filterAttendance(form) {
        loadEvents(form.start.value, form.end.value, form.batch.value);
    }

    function resetFilter() {
        document.getElementById("filterForm").reset();
        document.getElementById("start_date").value = "<?php echo $start_Date; ?>";
        document.getElementById("end_date").value = "<?php echo $end_Date; ?>";
        document.getElementById("filterFormBtn").click();
    }

    function loadEvents(start, end, batch) {
        $.ajax({
            url: "<?php echo base_url(); ?>attendance/loadAttendanceReportData",
            type: "post",
            data: { "start": start, "end": end, "uid": "<?php echo $userId; ?>", "bid": batch },
            dataType: 'json',
            success: function (d) {
                if (d.data != null) {
                    createTableStructure(d.data);
                    document.getElementById("absents").innerHTML = d.data.Absents;
                    document.getElementById("presents").innerHTML = d.data.Presents;
                    document.getElementById("leaves").innerHTML = d.data.OnLeaves;
                    document.getElementById("holidays").innerHTML = d.data.Holidays;
                    document.getElementById("batch").innerHTML = d.data.Batch;
                    document.getElementById("days").innerHTML = d.data.DayCounter;
                }
            }
        });

    }

    function createTableStructure(d) {
        if (ele != null)
            ele.innerHTML = "";
        const status = d.Status;
        const inTime = d.IN_Time;
        const outTime = d.OUT_Time;
        const duration = d.Duration;
        const late = d.Late_By;
        const early = d.Early_By;
        const ot = d.OT;
        const shift = d.Shift;

        d.Days.forEach((el, i, arr) => {
            let tr = document.createElement("tr");
            let d_ele = document.createElement("td");
            d_ele.innerHTML = ((el != "") ? el : "--");
            let sts_ele = document.createElement("td");
            sts_ele.innerHTML = ((status[i] != "") ? status[i] : "--");
            let itime_ele = document.createElement("td");
            itime_ele.innerHTML = ((inTime[i] != "") ? inTime[i] : "--");
            let otime_ele = document.createElement("td");
            otime_ele.innerHTML = ((outTime[i] != "") ? outTime[i] : "--");
            let dur_ele = document.createElement("td");
            dur_ele.innerHTML = ((duration[i] != "") ? duration[i] : "--");
            let late_ele = document.createElement("td");
            late_ele.innerHTML = ((late[i] != "") ? late[i] : "--");
            let early_ele = document.createElement("td");
            early_ele.innerHTML = ((early[i] != "") ? early[i] : "--");
            let ot_ele = document.createElement("td");
            ot_ele.innerHTML = ((ot[i] != "") ? ot[i] : "--");
            let shift_ele = document.createElement("td");
            shift_ele.innerHTML = ((shift[i] != "") ? shift[i] : "--");

            tr.append(d_ele);
            tr.append(sts_ele);
            tr.append(itime_ele);
            tr.append(otime_ele);
            tr.append(dur_ele);
            tr.append(late_ele);
            tr.append(early_ele);
            tr.append(ot_ele);
            tr.append(shift_ele);

            ele.append(tr);
        });
    }

</script>