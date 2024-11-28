<?php
/*
 *
 * Author: Akash K Fulari
 * Contact-mail: akashfulari31@gmail.com
 * Description: ________________your_description_here_________________
 * Created: 2024-04-17 13:10:41
 Last Modification Date: 2024-04-22 14:31:52
 *
 **/
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
            Staff
            <small>Attendance</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Staff Attendance</li>
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
                    <a href="<?php echo base_url('enquiry/create') ?>" class="btn btn-primary">Add Staff</a>
                    <br /> <br />
                <?php endif; ?>
                <div class="box">
                    <div class="box-header">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                            <h3 class="box-title" style="text-transform:capitalize">
                                <b><?php echo $staffData['firstname'] . " " . $staffData['lastname']; ?></b>
                                Attendance
                            </h3>
                        </div>
                        <div style="margin-top:20px">
                            <p style="font-size:18px">Indicators</p>
                            <div style="display:flex;gap:10px;">
                                <div style="display:flex;align-items:center;justify-content:start;gap:10px;">
                                    <i class="fa fa-circle text-danger"></i>
                                    <span>Absent</span>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:start;gap:10px;">
                                    <i class="fa fa-circle text-success"></i>
                                    <span>Present</span>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:start;gap:10px;">
                                    <i class="fa fa-circle text-warning"></i>
                                    <span>On Leave</span>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:start;gap:10px;">
                                    <i class="fa fa-circle text-info"></i>
                                    <span>Holiday</span>
                                </div>
                            </div>
                        </div>

                        <!-- /.box-header -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="calendar"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<style>
    .myBox {
        display: flex;
        align-items: center;
        justify-content: between;
        gap: 10px;
    }

    .myBox>div {
        width: 100%;
    }
</style>

<?php
if (in_array('updateAttendance', $this->permission)):
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="updateEventModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Attendance</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="updateForm(this);return false;" method="post" id="udpateAttendanceForm">
                        <div class="form-group" hidden>
                            <label for="event_id">Event ID</label>
                            <input type="number" class="form-control" id="event_id" name="event_id" autocomplete="off"
                                readonly>
                        </div>
                        <div class="form-group" hidden>
                            <label for="user_id">User ID</label>
                            <input type="number" class="form-control" id="user_id" name="user_id" autocomplete="off"
                                readonly>
                        </div>
                        <div class="form-group" hidden>
                            <label for="batch_id">User ID</label>
                            <input type="number" class="form-control" id="batch_id" name="batch_id" autocomplete="off"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" autocomplete="off" readonly>
                        </div>
                        <div class="myBox">
                            <div class="form-group">
                                <label for="in_time">In Time</label>
                                <input type="time" class="form-control" id="in_time" name="in_time" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="out_time">Out Time</label>
                                <input type="time" class="form-control" id="out_time" name="out_time" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration"
                                    onfocus="calculateDuration('#in_time','#out_time','#duration')"
                                    placeholder="Enter Duration" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="myBox">
                            <div class="form-group">
                                <label for="late_by">Late By</label>
                                <input type="time" class="form-control" id="late_by" name="late_by" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="early_by">Early By</label>
                                <input type="time" class="form-control" id="early_by" name="early_by" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ot">Over Time</label>
                            <input type="time" class="form-control" id="ot" name="ot" autocomplete="off">
                        </div>
                        <div class="myBox">
                            <div class="form-group">
                                <label for="shift">Shift</label>
                                <select class="form-control" id="shift" name="shift">
                                    <option value="0">General Shift</option>
                                    <option value="1">Night Shift</option>
                                    <option value="2">Day Shift</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="0">Absent</option>
                                    <option value="1">Present</option>
                                    <option value="2">On Leave</option>
                                    <option value="3">Holiday</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" form="udpateAttendanceForm" class="btn btn-primary">Update Attendance</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>
<script>
    /*----------------------------------------------------------------- initialize the calendar -----------------------------------------------------------------*/

    $(".select_group").select2();
    $calendar = $('#calendar');
    let current_event;
    $calendar.fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        selectable: true,
        selectHelper: true,
        nowIndicator: true,
        selectMirror: true,
        displayEventTime: true,
        <?php
        if (in_array('updateAttendance', $this->permission)):
            ?>
                            eventClick: function (event) {
                current_event = event;
                let data = event.extraData;

                $("#event_id").val(data.id);
                $("#user_id").val(data.user_id);
                $("#batch_id").val(data.batch_id);
                $("#date").val(data.date);
                $("#in_time").val(data.in_time);
                $("#out_time").val(data.out_time);
                $("#duration").val(data.duration);
                $("#late_by").val(data.late_by);
                $("#early_by").val(data.early_by);
                $("#ot").val(data.ot);
                $("#shift").val(data.shift);
                $("#status").val(data.status);

                $("#updateEventModal").modal("show");
            }
        <?php endif; ?>
    });

    loadEvents();

    function loadEvents() {
        $.ajax({
            url: "<?php echo base_url(); ?>attendance/getStaffAttendanceEvents/<?php echo $userId; ?>",
            type: "post",
            data: {},
            dataType: 'json',
            success: function (d) {
                $calendar.fullCalendar('renderEvents', d, true); // stick? = true
                $calendar.fullCalendar('unselect');
            }
        });

    }

    <?php
    if (in_array('updateAttendance', $this->permission)):
        ?>
        function updateForm(me) {
            var form = $(me);
            $.ajax({
                url: "<?php echo base_url(); ?>attendance/updateAttendance",
                type: "post",
                data: form.serialize(),
                dataType: 'json',
                success: function (d) {
                    if (d.status) {
                        current_event.title = d.data.title;
                        current_event.start = d.data.start;
                        current_event.className[0] = d.data.className;
                        // current_event.end = d.data.end;
                        // current_event.extendedProps.description = d.data.extendedProps.description;

                        $calendar.fullCalendar('updateEvent', current_event); // stick? = true

                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + d.message +
                            '</div>');
                        $("#updateEventModal").modal("hide");
                    }
                    else {
                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + d.message +
                            '</div>');
                    }
                },
                error: function (err) {
                    alert("Error occurd: " + err);
                }
            });

        }

        function calculateDuration(ele1, ele2, resEle) {
            var startTime = $(ele1).val();
            var endTime = $(ele2).val();
            if (startTime.length > 0 && endTime.length > 0) {
                // Split the time strings into hours and minutes
                var startParts = startTime.split(':');
                var endParts = endTime.split(':');

                // Convert the hours and minutes into seconds
                var startSeconds = (+startParts[0]) * 60 * 60 + (+startParts[1]) * 60;
                var endSeconds = (+endParts[0]) * 60 * 60 + (+endParts[1]) * 60;

                // Calculate the duration in seconds
                var durationSeconds = endSeconds - startSeconds;

                // Convert the duration to hours, minutes, and seconds
                var hours = Math.floor(durationSeconds / 3600);
                var minutes = Math.floor((durationSeconds % 3600) / 60);
                var seconds = durationSeconds % 60;

                var paddedHours = String(Math.abs(hours)).padStart(2, '0');
                var paddedMinutes = String(Math.abs(minutes)).padStart(2, '0');
                var paddedSeconds = String(Math.abs(seconds)).padStart(2, '0');

                $(resEle).val(paddedHours + ':' + paddedMinutes + ':' + paddedSeconds);
            }
        }

        <?php
    endif;
    ?>
</script>