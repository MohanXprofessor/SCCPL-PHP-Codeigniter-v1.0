<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Attendance';

        $this->load->model('model_attendance');
        $this->load->model('model_users');
        $this->load->model('model_batch');
    }

    public function index()
    {
        // if (in_array('createAttendance', $user_permission) || in_array('updateAttendance', $user_permission) || in_array('viewAttendance', $user_permission) || in_array('deleteAttendance', $user_permission))

        $this->student();
    }

    public function student()
    {
        if (!in_array('viewAttendance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['batchs'] = $this->model_batch->getProductData();
        $this->data['students'] = $this->model_users->getStudentData();
        $this->render_template('attendance/index', $this->data);
    }

    public function staff()
    {
        if (!in_array('viewAttendance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['staffs'] = $this->model_users->getStaffData();
        $this->render_template('attendance/staff', $this->data);
    }

    public function viewStaff($userId)
    {
        if (!in_array('viewAttendance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $staffData = $this->model_users->getUserData($userId);
        $this->data['userId'] = $userId;
        $this->data['staffData'] = $staffData;
        $this->render_template('attendance/viewStaffAttendance', $this->data);
    }
    public function viewStudent($userId, $batchId)
    {
        if (!in_array('viewAttendance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['batchs'] = $this->model_batch->getProductData();

        $studentData = $this->model_users->getUserData($userId);
        $this->data['userId'] = $userId;
        $this->data['batchId'] = $batchId;
        $this->data['studentData'] = $studentData;
        $this->render_template('attendance/viewStudentAttendance', $this->data);
    }

    public function getStaffData()
    {
        $result = array('data' => array());
        $user_data = $this->model_users->getStaffData();
        $i = 0;
        foreach ($user_data as $data) {
            $status = "<label class='label label-success text-light'>Active</label>";
            $buttons = "";
            if (in_array('createAttendance', $this->permission))
                $buttons .= ' <a class="btn btn-sm btn-success d-block"  onclick="openAddAttendanceModal(' . $data['user_id'] . ')" data-toggle="modal" data-target="#addAttendanceModal" title="Add Attendance Salary"><i class="fa fa-calendar-plus-o"></i></a>';
            if (in_array('viewAttendance', $this->permission)) {
                $buttons .= ' <a class="btn btn-sm btn-warning d-block" href="' . base_url('attendance/viewStaff/' . $data['user_id']) . '" title="View Attendance"><i class="fa fa-calendar"></i></a>';
                $buttons .= ' <a class="btn btn-sm btn-info d-block" href="' . base_url('attendance/reportStaff/' . $data['user_id']) . '" title="View Attendance Report"><i class="fa fa-eye"></i></a>';
            }
            if (in_array('deleteAttendance', $this->permission))
                $buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="toggleActiveFunc(' . $data['user_id'] . ', ' . (($data['active'] == 0) ? 1 : 0) . ')" data-toggle="modal" data-target="#toggleActiveModal" title=' . (($data['active'] == 0) ? "Activate" : "De-Activate") . '><i class="fa fa-trash"></i></a>';

            if ($data['active'] == 0)
                $status = "<label class='label label-danger text-light'>In-Active</label>";

            $result['data'][$i] = array(
                $data['user_id'],
                $data['username'],
                $data['email'],
                /*$value['job_description'],*/
                $data['firstname'] . ' ' . $data['lastname'],
                $data['phone'],
                $status,
                $buttons
            );
            $i++;
        }
        echo json_encode($result);
    }

    public function getStudentData()
    {
        $result = array('data' => array());
        $user_data = $this->model_users->getStudentData();
        $i = 0;
        foreach ($user_data as $data) {
            $status = "<label class='label label-success text-light'>Active</label>";
            $buttons = "";

            if (in_array('createAttendance', $this->permission))
                $buttons .= ' <a class="btn btn-sm btn-success d-block"  onclick="openAddAttendanceModal(' . $data['user_id'] . ')" data-toggle="modal" data-target="#addAttendanceModal" title="Add Attendance Salary"><i class="fa fa-calendar-plus-o"></i></a>';
            if (in_array('viewAttendance', $this->permission)) {
                $buttons .= ' <a class="btn btn-sm btn-warning d-block" onclick="openViewAttendanceModal(' . $data['user_id'] . ')" data-toggle="modal" data-target="#viewAttendanceModal" title="View Attendance"><i class="fa fa-calendar"></i></a>';
                $buttons .= ' <a class="btn btn-sm btn-info d-block" href="' . base_url('attendance/reportStudent/' . $data['user_id']) . '" title="View Attendance Report"><i class="fa fa-eye"></i></a>';
            }
            if (in_array('deleteAttendance', $this->permission))
                $buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="toggleActiveFunc(' . $data['user_id'] . ', ' . (($data['active'] == 0) ? 1 : 0) . ')" data-toggle="modal" data-target="#toggleActiveModal" title=' . (($data['active'] == 0) ? "Activate" : "De-Activate") . '><i class="fa fa-trash"></i></a>';

            if ($data['active'] == 0)
                $status = "<label class='label label-danger text-light'>In-Active</label>";

            $result['data'][$i] = array(
                $data['user_id'],
                $data['username'],
                $data['email'],
                /*$value['job_description'],*/
                $data['firstname'] . ' ' . $data['lastname'],
                $data['phone'],
                $status,
                $buttons
            );
            $i++;
        }
        echo json_encode($result);
    }

    public function reportStaff($userId)
    {
        if (!in_array('viewAttendance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $staffData = $this->model_users->getUserData($userId);
        $this->data['userId'] = $userId;
        $this->data['staffData'] = $staffData;

        $mindate = $this->model_attendance->getFirstAttendedDate($userId);
        $this->data['mindate'] = (($mindate != null) ? $mindate['attended_date'] : (new Date("Y-d-m")));
        
        $this->render_template('attendance/viewStaffAttendanceReport', $this->data);
    }

    public function reportStudent($userId)
    {
        if (!in_array('viewAttendance', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['batchs'] = $this->model_batch->getProductData();

        $studentData = $this->model_users->getUserData($userId);
        $this->data['userId'] = $userId;
        $this->data['studentData'] = $studentData;

        $mindate = $this->model_attendance->getFirstAttendedDate($userId);
        $this->data['mindate'] = (($mindate != null) ? $mindate['attended_date'] : (new Date("Y-d-m")));

        $this->render_template('attendance/viewStudentAttendanceReport', $this->data);
    }

    public function loadAttendanceReportData()
    {
        $mainRes = array(
            "Days" => array(),
            "Status" => array(),
            "IN_Time" => array(),
            "OUT_Time" => array(),
            "Duration" => array(),
            "Late_By" => array(),
            "Early_By" => array(),
            "OT" => array(),
            "Shift" => array(),
            "Absents" => "",
            "Presents" => "",
            "OnLeaves" => "",
            "Holidays" => "",
            "DayCounter" => "",
            "Batch" => "",
        );
        $res = array("status" => false, "message" => "");
        $start = $this->input->post("start");
        $end = $this->input->post("end");
        $uid = $this->input->post("uid");
        if (strlen($start) > 0 && strlen($end) > 0 && strlen($uid) > 0) {
            $start_date = strtotime($start);
            $end_date = strtotime($end);
            $bid = $this->input->post("bid");
            if ($bid != null) {
                $bdata = $this->model_batch->getProductData($bid);
                if ($bdata != null)
                    $mainRes['Batch'] = $bdata['batch_name'];
            }

            // Counter vars
            $pC = 0;
            $aC = 0;
            $olC = 0;
            $hC = 0;
            $dC = 0;

            for ($current_date = $start_date; $current_date <= $end_date; $current_date += 86400) {
                $dC++;
                $newDate = date('Y-m-d', $current_date);
                $data = $this->model_attendance->getAttendanceUIDDateAndBID($uid, $newDate, $bid);

                $mainRes["Days"][] = $newDate;

                $inp_Status = "A";
                $inp_INTime = "";
                $inp_OUTTime = "";
                $inp_Duration = "";
                $inp_LateBy = "";
                $inp_EarlyBy = "";
                $inp_OT = "";
                $inp_Shift = "";

                if ($data != null) {
                    $shift = $data["shift"];
                    $status = $data["status"];

                    if ($status == 0) {
                        $inp_Status = "A";
                        $aC++;
                    } else if ($status == 1) {
                        $inp_Status = "P";
                        $pC++;
                    } else if ($status == 2) {
                        $inp_Status = "OL";
                        $olC++;
                    } else if ($status == 3) {
                        $inp_Status = "H";
                        $hC++;
                    }

                    $inp_INTime = $data["in_time"];
                    $inp_OUTTime = $data["out_time"];
                    $inp_Duration = $data["duration"];
                    $inp_LateBy = $data["late_by"];
                    $inp_EarlyBy = $data["early_by"];
                    $inp_OT = $data["ot"];
                    $inp_Shift = (($shift == 1) ? "NS" : (($shift == 1) ? "DS" : "GS"));
                } else
                    $aC++;

                $mainRes["Status"][] = $inp_Status;
                $mainRes["IN_Time"][] = $inp_INTime;
                $mainRes["OUT_Time"][] = $inp_OUTTime;
                $mainRes["Duration"][] = $inp_Duration;
                $mainRes["Late_By"][] = $inp_LateBy;
                $mainRes["Early_By"][] = $inp_EarlyBy;
                $mainRes["OT"][] = $inp_OT;
                $mainRes["Shift"][] = $inp_Shift;
            }

            $mainRes["Absents"] = $aC;
            $mainRes["Presents"] = $pC;
            $mainRes["OnLeaves"] = $olC;
            $mainRes["Holidays"] = $hC;
            $mainRes["DayCounter"] = $dC;
        }
        $res["data"] = $mainRes;

        echo json_encode($res);
    }

    public function activate()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $response = array();

        if (!in_array('deleteAttendance', $this->permission)) {
            $response['success'] = false;
            $response['messages'] = "You dont have an permission to " . (($status == 1) ? "Activated" : "De-Activeated");
        } else {
            if ($id) {
                $delete = $this->model_users->update(array("active" => $status), $id);
                if ($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = "Successfully " . (($status == 1) ? "Activated" : "De-Activeated");
                } else {
                    $response['success'] = false;
                    $response['messages'] = "Error in the database while udpating the staff information";
                }
            } else {
                $response['success'] = false;
                $response['messages'] = "Refersh the page again!!";
            }
        }

        echo json_encode($response);
    }

    // Staff Attendance
    public function addStaffAttendance()
    {
        $res = array("status" => false, "message" => "");
        if (!in_array('createAttendance', $this->permission)) {
            $res['status'] = false;
            $res['messages'] = "You dont have an permission to add record";
        } else {

            $this->form_validation->set_rules('user_id', 'Staff', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('in_time', 'In Time', 'trim|required');
            $this->form_validation->set_rules('out_time', 'Out Time', 'trim|required');
            $this->form_validation->set_rules('duration', 'Duration', 'trim|required');
            $this->form_validation->set_rules('shift', 'Status', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $id = $this->input->post('user_id');
                $date = $this->input->post('date');
                $fetch_data = $this->model_attendance->isAttendanceExists($id, $date);
                if ($fetch_data == null) {
                    $data = array(
                        'user_id' => $id,
                        'date' => $date,
                        'in_time' => $this->input->post('in_time'),
                        'out_time' => $this->input->post('out_time'),
                        'duration' => $this->input->post('duration'),
                        'late_by' => $this->input->post('late_by'),
                        'early_by' => $this->input->post('early_by'),
                        'ot' => $this->input->post('ot'),
                        'shift' => $this->input->post('shift'),
                        'user_type' => 1,
                        'status' => $this->input->post('status')
                    );

                    $isCreated = $this->model_attendance->create($data);
                    if ($isCreated) {
                        $res['status'] = true;
                        $res['message'] = 'Student attendance added successfully!!';
                    } else {
                        $res['message'] = 'Error occurred while adding attendance!!';
                    }
                } else {
                    $res['message'] = 'Attendance already has been added';
                }
            } else {
                $res['message'] = 'Please fill asda all fields.';
            }
        }
        echo json_encode($res);
    }

    public function addStaffBulkAttendance()
    {
        $res = array("status" => false, "message" => "");
        if (!in_array('createAttendance', $this->permission)) {
            $res['status'] = false;
            $res['messages'] = "You dont have an permission to add record";
        } else {

            $this->form_validation->set_rules('user_ids[]', 'Staff', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('in_time', 'In Time', 'trim|required');
            $this->form_validation->set_rules('out_time', 'Out Time', 'trim|required');
            $this->form_validation->set_rules('duration', 'Duration', 'trim|required');
            $this->form_validation->set_rules('shift', 'Shift', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $staffs = $this->model_users->getStaffData();
                $ids = $this->input->post('user_ids[]');
                $isCreated = 0;
                foreach ($staffs as $staff) {
                    $id = $staff['user_id'];

                    $status = "0";
                    if (in_array($id, $ids))
                        $status = "1";

                    $date = $this->input->post('date');
                    $fetch_data = $this->model_attendance->isAttendanceExists($id, $date);
                    if ($fetch_data == null) {
                        $data = array(
                            'user_id' => $id,
                            'date' => $date,
                            'in_time' => $this->input->post('in_time'),
                            'out_time' => $this->input->post('out_time'),
                            'duration' => $this->input->post('duration'),
                            'late_by' => $this->input->post('late_by'),
                            'early_by' => $this->input->post('early_by'),
                            'ot' => $this->input->post('ot'),
                            'shift' => $this->input->post('shift'),
                            'user_type' => 0,
                            'status' => $status
                        );
                        if ($this->model_attendance->create($data))
                            $isCreated = 1;
                    } else {
                        $isCreated = 2;
                    }
                }

                if ($isCreated == 1) {
                    $res['status'] = true;
                    $res['message'] = 'Staff attendance added successfully!!';
                } else if ($isCreated == 2) {
                    $res['status'] = true;
                    $res['message'] = 'Attendance already has been added';
                } else {
                    $res['message'] = 'Error occurred while adding attendance!!';
                }
            } else {
                $res['message'] = 'Please fill all fields.';
            }
        }
        echo json_encode($res);
    }

    // Student Attendance
    public function addStudentAttendance()
    {
        $res = array("status" => false, "message" => "");
        if (!in_array('createAttendance', $this->permission)) {
            $res['status'] = false;
            $res['messages'] = "You dont have an permission to add record";
        } else {
            $this->form_validation->set_rules('user_id', 'Staff', 'trim|required');
            $this->form_validation->set_rules('batch_id', 'Staff', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('in_time', 'In Time', 'trim|required');
            $this->form_validation->set_rules('out_time', 'Out Time', 'trim|required');
            $this->form_validation->set_rules('duration', 'Duration', 'trim|required');
            $this->form_validation->set_rules('shift', 'Status', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $id = $this->input->post('user_id');
                $date = $this->input->post('date');
                $fetch_data = $this->model_attendance->isAttendanceExists($id, $date);
                if ($fetch_data == null) {
                    $data = array(
                        'user_id' => $id,
                        'batch_id' => $this->input->post('batch_id'),
                        'date' => $date,
                        'in_time' => $this->input->post('in_time'),
                        'out_time' => $this->input->post('out_time'),
                        'duration' => $this->input->post('duration'),
                        'late_by' => $this->input->post('late_by'),
                        'early_by' => $this->input->post('early_by'),
                        'ot' => $this->input->post('ot'),
                        'shift' => $this->input->post('shift'),
                        'user_type' => 0,
                        'status' => $this->input->post('status')
                    );

                    $isCreated = $this->model_attendance->create($data);
                    if ($isCreated) {
                        $res['status'] = true;
                        $res['message'] = 'Student attendance added successfully!!';
                    } else {
                        $res['message'] = 'Error occurred while adding attendance!!';
                    }
                } else {
                    $res['message'] = 'Attendance already has been added';
                }
            } else {
                $res['message'] = 'Please fill all fields.';
            }
        }
        echo json_encode($res);
    }

    public function addStudentBulkAttendance()
    {
        $res = array("status" => false, "message" => "");
        if (!in_array('createAttendance', $this->permission)) {
            $res['status'] = false;
            $res['messages'] = "You dont have an permission to add record";
        } else {

            $this->form_validation->set_rules('user_ids[]', 'Staff', 'trim|required');
            $this->form_validation->set_rules('batch_id', 'Staff', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            // $this->form_validation->set_rules('in_time', 'In Time', 'trim|required');
            // $this->form_validation->set_rules('out_time', 'Out Time', 'trim|required');
            $this->form_validation->set_rules('duration', 'Duration', 'trim|required');
            // $this->form_validation->set_rules('shift', 'Shift', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $students = $this->model_users->getStudentData();
                $ids = $this->input->post('user_ids[]');
                $isCreated = 0;
                foreach ($students as $stud) {
                    $id = $stud['user_id'];

                    $status = "0";
                    if (in_array($id, $ids))
                        $status = "1";

                    $date = $this->input->post('date');
                    $fetch_data = $this->model_attendance->isAttendanceExists($id, $date);

                    if ($fetch_data == null) {
                        $data = array(
                            'user_id' => $id,
                            'batch_id' => $this->input->post('batch_id'),
                            'date' => $date,
                            'in_time' => $this->input->post('in_time'),
                            'out_time' => $this->input->post('out_time'),
                            'duration' => $this->input->post('duration'),
                            'late_by' => $this->input->post('late_by'),
                            'early_by' => $this->input->post('early_by'),
                            'ot' => $this->input->post('ot'),
                            'shift' => $this->input->post('shift'),
                            'user_type' => 0,
                            'status' => $status
                        );

                        if ($this->model_attendance->create($data))
                            $isCreated = 1;
                    } else {
                        $isCreated = 2;
                    }
                }

                if ($isCreated == 1) {
                    $res['status'] = true;
                    $res['message'] = 'Student attendance added successfully!!';
                } else if ($isCreated == 2) {
                    $res['status'] = true;
                    $res['message'] = 'Attendance already has been added';
                } else {
                    $res['message'] = 'Error occurred while adding attendance!!';
                }
            } else {
                $res['message'] = 'Please fill all fields.';
            }
        }
        echo json_encode($res);
    }

    public function updateAttendance()
    {
        $res = array("status" => false, "message" => "");
        if (!in_array('updateAttendance', $this->permission)) {
            $res['status'] = false;
            $res['messages'] = "You dont have an permission to update record";
        } else {
            $this->form_validation->set_rules('event_id', 'User Id', 'trim|required');
            $this->form_validation->set_rules('user_id', 'Staff', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('in_time', 'In Time', 'trim|required');
            $this->form_validation->set_rules('out_time', 'Out Time', 'trim|required');
            $this->form_validation->set_rules('duration', 'Duration', 'trim|required');
            $this->form_validation->set_rules('shift', 'Status', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $event_id = $this->input->post('event_id');
                $id = $this->input->post('user_id');
                $date = $this->input->post('date');
                $fetch_data = $this->model_attendance->isAttendanceExists($id, $date);
                if ($fetch_data != null) {
                    $data = array(
                        'date' => $date,
                        'in_time' => $this->input->post('in_time'),
                        'out_time' => $this->input->post('out_time'),
                        'duration' => $this->input->post('duration'),
                        'late_by' => $this->input->post('late_by'),
                        'early_by' => $this->input->post('early_by'),
                        'ot' => $this->input->post('ot'),
                        'shift' => $this->input->post('shift'),
                        'status' => $this->input->post('status')
                    );

                    $isCreated = $this->model_attendance->update($data, $event_id);
                    if ($isCreated) {
                        $res['status'] = true;
                        $res['message'] = 'Attendance updated Successfully!!';

                        $sts = $this->input->post('status');

                        $data['id'] = $event_id;
                        $data['user_id'] = $id;
                        $data['user_id'] = $this->input->post('batch_id');
                        $resData = array(
                            'id' => $event_id,
                            'title' => $this->input->post('status'),
                            'start' => $this->formateDate($this->input->post('date'), $this->input->post('in_time')),
                            'className' => (($sts == 1) ? "fc-success-solid" : (($sts == 2) ? "fc-warning-solid" : (($sts == 3) ? "fc-info-solid" : "fc-danger-solid"))),
                            'extraData' => $data
                        );
                        $res['data'] = $resData;
                    } else {
                        $res['message'] = 'Error occurred while adding attendance!!';
                    }
                } else {
                    $res['message'] = 'Invalid event selected!.';
                }
            } else {
                $res['message'] = 'Please fill all fields.';
            }
        }
        echo json_encode($res);
    }

    public function getStaffAttendanceEvents($user_id)
    {
        $res = array();
        if ($user_id != null) {
            $getAll = $this->model_attendance->getAttendanceDataByUserId($user_id);
            foreach ($getAll as $val) {
                $sts = $val['status'];
                $resData = array(
                    'id' => $val['id'],
                    'title' => (($sts == 1) ? "Present" : (($sts == 2) ? "On Leave" : (($sts == 3) ? "Holiday" : "Absent"))),
                    'start' => $this->formateDate($val['date'], $val['in_time']),
                    'className' => (($sts == 1) ? "fc-success-solid" : (($sts == 2) ? "fc-warning-solid" : (($sts == 3) ? "fc-info-solid" : "fc-danger-solid"))),
                    'extraData' => [
                        "id" => $val['id'],
                        "user_id" => $val['user_id'],
                        "batch_id" => $val['batch_id'],
                        "date" => $val['date'],
                        "in_time" => $val['in_time'],
                        "out_time" => $val['out_time'],
                        "duration" => $val['duration'],
                        "late_by" => $val['late_by'],
                        "early_by" => $val['early_by'],
                        "ot" => $val['ot'],
                        "shift" => $val['shift'],
                        "status" => $val['status']
                    ]
                );
                $res[] = $resData;
            }
        }
        echo json_encode($res);
    }

    public function getStuddentAttendanceEvents($user_id, $batch_id)
    {
        $res = array();
        if ($user_id != null) {
            $getAll = $this->model_attendance->getAttendanceDataByUserIdAndBatch_id($user_id, $batch_id);
            foreach ($getAll as $val) {
                $sts = $val['status'];
                $resData = array(
                    'id' => $val['id'],
                    'title' => (($sts == 1) ? "Present" : (($sts == 2) ? "On Leave" : (($sts == 3) ? "Holiday" : "Absent"))),
                    'start' => $this->formateDate($val['date'], $val['in_time']),
                    'className' => (($sts == 1) ? "fc-success-solid" : (($sts == 2) ? "fc-warning-solid" : (($sts == 3) ? "fc-info-solid" : "fc-danger-solid"))),
                    'extraData' => [
                        "id" => $val['id'],
                        "user_id" => $val['user_id'],
                        "batch_id" => $val['batch_id'],
                        "date" => $val['date'],
                        "in_time" => $val['in_time'],
                        "out_time" => $val['out_time'],
                        "duration" => $val['duration'],
                        "late_by" => $val['late_by'],
                        "early_by" => $val['early_by'],
                        "ot" => $val['ot'],
                        "shift" => $val['shift'],
                        "status" => $val['status']
                    ]
                );
                $res[] = $resData;
            }
        }
        echo json_encode($res);
    }

    public function formateDate($date, $time)
    {
        $datetime_str = $date . ' ' . $time;
        $datetime = new DateTime($datetime_str);
        return $datetime->format('Y-m-d H:i:s');
    }

}