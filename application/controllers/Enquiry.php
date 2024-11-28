<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: New enquiry table, model, controller updates
* Created: 2024-03-30 13:17:00
 Last Modification Date: 2024-05-10 15:37:54
*
**/

defined('BASEPATH') or exit('No direct script access allowed');

class Enquiry extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Enquiry';
        $this->load->model('model_enquiry');
        $this->load->model('model_brands');
        $this->load->model('model_screeningtest');
        $this->load->helper('url');
    }

    public function manage()
    {
        $this->render_template('enquiry/index', $this->data);
    }

    /*
     * Create By: Akash K. Fulari
     * Created On: 30-03-2024
     * Code Starts Here
     **/
    public function create()
    {
        $this->data['page_title'] = 'Create Enquiry';

        $this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
        $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required');
        $this->form_validation->set_rules('counseller_id', 'Faculty/Counseller Id', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('student_name', 'Student Name', 'trim|required');
        $this->form_validation->set_rules('student_email', 'Student Email', 'trim|required');
        $this->form_validation->set_rules('student_mobile', 'Student Mobile Number', 'trim|required');
        $this->form_validation->set_rules('student_address', 'Student Address', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('qualification', 'Student Qualification', 'trim|required');
        $this->form_validation->set_rules('specialization', 'Student Specialization', 'trim|required');
        $this->form_validation->set_rules('college_name', 'College Name', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('followup_date', 'Status', 'trim|required');
        $this->form_validation->set_rules('remark', 'Remark', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'project_id' => $this->input->post('project_id'),
                'course_id' => $this->input->post('course_id'),
                'counseller_id' => $this->input->post('counseller_id'),
                'student_name' => $this->input->post('student_name'),
                'student_email' => $this->input->post('student_email'),
                'student_mobile' => $this->input->post('student_mobile'),
                'student_address' => $this->input->post('student_address'),
                'gender' => $this->input->post('gender'),
                'qualification' => $this->input->post('qualification'),
                'specialization' => $this->input->post('specialization'),
                'college_name' => $this->input->post('college_name'),
                'status' => $this->input->post('status'),
                'remark' => $this->input->post('remark'),
                'created_at' => $this->input->post('date'),
                'added_by' => $this->userId
            );

            if ($this->input->post('status') == "Next-date")
                $data['next_follow_date'] = $this->input->post('followup_date');

            $isCreated = $this->model_enquiry->create($data);
            if ($isCreated) {
                $this->session->set_flashdata('success', 'Enquiry created Successfully!!');
                redirect('enquiry/manage', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('enquiry/create', 'refresh');
            }

        } else {
            $this->render_template('enquiry/create', $this->data);
        }
    }

    public function addenquirybulk()
    {
        $this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
        $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required');
        $this->form_validation->set_rules('counseller_id', 'Faculty/Counseller Id', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('followup_date', 'Followup Date', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $fileFieldName = "bulk_file";

            if ($this->validateFormFile($fileFieldName)) {
                if ($_FILES[$fileFieldName]["type"] == "text/csv") {
                    $file = fopen($_FILES[$fileFieldName]["tmp_name"], "r");
                    $i = 0;
                    $isValid = false;
                    $isUpdated = false;
                    while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

                        if (sizeof($getData) != 9)
                            break;

                        if ($i != 0 && $isValid) {
                            $pid = $this->input->post('project_id');
                            $cid = $this->input->post('course_id');
                            $cnsid = $this->input->post('counseller_id');
                            $status = $this->input->post('status');
                            $date = $this->input->post('date');
                            $stdName = $getData[0];
                            $stdMobile = $getData[1];
                            $stdEmail = $getData[2];
                            $address = $getData[3];
                            $qualification = $getData[4];
                            $specialization = $getData[5];
                            $collegeName = $getData[6];
                            $remark = $getData[7];
                            $gender = $getData[8];

                            if (!empty($stdName) && !empty($stdMobile) && !empty($stdEmail) && !empty($address) && !empty($qualification) && !empty($specialization) && !empty($collegeName) && !empty($remark) && $gender != "") {
                                $data = array(
                                    'project_id' => $pid,
                                    'course_id' => $cid,
                                    'status' => $status,
                                    'counseller_id' => $cnsid,
                                    'student_name' => $stdName,
                                    'student_email' => $stdEmail,
                                    'student_mobile' => $stdMobile,
                                    'student_address' => $address,
                                    'qualification' => $qualification,
                                    'specialization' => $specialization,
                                    'college_name' => $collegeName,
                                    'remark' => $remark,
                                    'gender' => $gender,
                                    'created_at' => (new DateTime($date))->format("Y/m/d H:i:s"),
                                    'added_by' => $this->userId
                                );
                                if ($status == "Next-date")
                                    $data['next_follow_date'] = $this->input->post('followup_date');

                                $this->model_enquiry->create($data);
                                $isUpdated = true;
                            }
                        } else {
                            $stdName = trim($getData[0]);
                            $stdMobile = trim($getData[1]);
                            $stdEmail = trim($getData[2]);
                            $address = trim($getData[3]);
                            $qualification = trim($getData[4]);
                            $specialization = trim($getData[5]);
                            $collegeName = trim($getData[6]);
                            $remark = trim($getData[7]);
                            $gender = trim($getData[8]);

                            if ($stdName == "Student Name" && $stdMobile == "Student Mobile" && $stdEmail == "Student Email" && $address == "Address" && $qualification == "Highest Qualification" && $specialization == "Specialization" && $collegeName == "College name" && $remark == "Remark" && $gender == "Gender")
                                $isValid = true;
                        }
                        $i++;
                    }
                    if ($isUpdated) {
                        $this->session->set_flashdata('success', 'Enquiry created Successfully!!');
                        redirect('screeningtest/manage', 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'Unable to submit the enquiry!!');
                        redirect('enquiry/manage', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Invalid file selected, Please selecte CSV file only!');
                    redirect('enquiry/manage', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Please select file!!');
                redirect('enquiry/manage', 'refresh');
            }
        } else {
            redirect('enquiry/manage', 'refresh');
        }
    }

    public function validateFormFile($field_name)
    {
        if (empty($_FILES[$field_name]['name'])) {
            $this->form_validation->set_message('error', 'The ' . $field_name . ' field is required.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function update($enquiryId)
    {
        $this->data['page_title'] = 'Update Enquiry';

        $this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
        $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('counseller_id', 'Faculty/Counseller Id', 'trim|required');
        $this->form_validation->set_rules('student_name', 'Student Name', 'trim|required');
        $this->form_validation->set_rules('student_email', 'Student Email', 'trim|required');
        $this->form_validation->set_rules('student_mobile', 'Student Mobile Number', 'trim|required');
        $this->form_validation->set_rules('student_address', 'Student Address', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('qualification', 'Student Qualification', 'trim|required');
        $this->form_validation->set_rules('specialization', 'Student Specialization', 'trim|required');
        $this->form_validation->set_rules('college_name', 'College Name', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('followup_date', 'Status', 'trim|required');
        $this->form_validation->set_rules('remark', 'Remark', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'project_id' => $this->input->post('project_id'),
                'course_id' => $this->input->post('course_id'),
                'counseller_id' => $this->input->post('counseller_id'),
                'student_name' => $this->input->post('student_name'),
                'student_email' => $this->input->post('student_email'),
                'student_mobile' => $this->input->post('student_mobile'),
                'student_address' => $this->input->post('student_address'),
                'gender' => $this->input->post('gender'),
                'qualification' => $this->input->post('qualification'),
                'specialization' => $this->input->post('specialization'),
                'college_name' => $this->input->post('college_name'),
                'status' => $this->input->post('status'),
                'remark' => $this->input->post('remark'),
                'created_at' => $this->input->post('date'),
                'added_by' => $this->userId
            );
            if ($this->input->post('status') == "Next-date")
                $data['next_follow_date'] = $this->input->post('followup_date');
            else
                $data['next_follow_date'] = null;

            $isCreated = $this->model_enquiry->update($data, $enquiryId);
            if ($isCreated) {
                $this->session->set_flashdata('success', 'Enquiry updated Successfully!!');
                redirect('enquiry/manage', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('enquiry/update/' . $enquiryId, 'refresh');
            }

        } else {
            $enquiry = $this->model_enquiry->getEnquiryDataById($enquiryId);
            if ($enquiry != null) {
                $this->data['enquiry'] = $enquiry;
                $this->render_template('enquiry/update', $this->data);
            } else
                redirect('enquiry/manage', 'refresh');
        }
    }

    public function remove()
    {
        $id = $this->input->post('id');

        $response = array();
        if ($id) {
            $delete = $this->model_enquiry->delete($id);
            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
    }

    public function fetchEnquiryData()
    {
        $result = array('data' => array());

        $data = $this->model_enquiry->getEnquiryData();
        $i = 0;
        foreach ($data as $key => $value) {

            $buttons = "";

            $testData = $this->model_screeningtest->getScreeningTestDataByEnquiryId($value['id']);
            if ($testData == null && $value['isTestSubmited'] == 0 && (in_array('createScreeningTest', $this->permission)))
                $buttons .= ' <a class="btn btn-sm btn-info d-block" onclick="addTestFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#adddTestModal">Submit Test</a>';

            $buttons .= ' <a class="btn btn-sm btn-success d-block" href="' . base_url('enquiry/update/' . $value['id']) . '"><i class="fa fa-pencil"></i></a>';
            $buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></a>';

            $projectData = $this->model_stores->getStoresDataSingle($value['project_id']);
            $courseData = $this->model_brands->getBrandDataSingle($value['course_id']);
            if($projectData !=null && $courseData != null){
                $result['data'][$i] = array(
                    $value['id'],
                    $projectData['name'],
                    $courseData['name'],
                    $value['student_name'],
                    (($value['gender'] == 0) ? "Female" : (($value['gender'] == 1) ? "Male" : "Other")),
                    $value['student_email'],
                    $value['student_mobile'],
                    $value['student_address'],
                    $value['college_name'],
                    $value['status'],
                    (($value['status'] == "Next-date") ? $value['next_follow_date'] : "--"),
                    $value['created_at'],
                    $value['remark'],
                    $buttons,
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                );
                $i++;
            }
        }
        echo json_encode($result);
    }

    public function fetchFilteredEnquiryData()
    {
        $result = array('data' => array());

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $project_id = $this->input->get('project_id');
        $course_id = $this->input->get('course_id');
        $counseller_id = $this->input->get('counseller_id');

        if ($start_date && $end_date && ($project_id || $course_id || $counseller_id)) {

            $data = $this->model_enquiry->getFilteredEnquiryData($start_date, $end_date, $project_id, $course_id, $counseller_id);
            $i = 0;
            foreach ($data as $key => $value) {

                $buttons = "";

                $testData = $this->model_screeningtest->getScreeningTestDataByEnquiryId($value['id']);
                if ($testData == null && $value['isTestSubmited'] == 0 && (in_array('createScreeningTest', $this->permission)))
                    $buttons .= ' <a class="btn btn-sm btn-info d-block" onclick="addTestFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#adddTestModal">Submit Test</a>';

                $buttons .= ' <a class="btn btn-sm btn-success d-block" href="' . base_url('enquiry/update/' . $value['id']) . '"><i class="fa fa-pencil"></i></a>';
                $buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></a>';

                $projectData = $this->model_stores->getStoresDataSingle($value['project_id']);
                $courseData = $this->model_brands->getBrandDataSingle($value['course_id']);
                if($projectData !=null && $courseData != null){

                    $result['data'][$i] = array(
                        $value['id'],
                        $projectData['name'],
                        $courseData['name'],
                        $value['student_name'],
                        (($value['gender'] == 0) ? "Female" : (($value['gender'] == 1) ? "Male" : "Other")),
                        $value['student_email'],
                        $value['student_mobile'],
                        $value['student_address'],
                        $value['college_name'],
                        $value['status'],
                        (($value['status'] == "Next-date") ? $value['next_follow_date'] : "--"),
                        $value['created_at'],
                        $value['remark'],
                        $buttons,
                        "",
                        "",
                        "",
                        "",
                        "",
                        "",
                    );
                    $i++;
                }
            }
        }
        echo json_encode($result);
    }

    /*
     * Created By: Akash K. Fulari
     * On Date: 04-05-2024
     */
    public function loadCoursesByProjectId($pid)
    {
        $res = array("status" => false, "message" => "");
        if ($pid != null) {
            $courses = $this->model_brands->loadCoursesByProjectId($pid);
            if (sizeof($courses) > 0) {
                $sel = "";
                foreach ($courses as $course) {
                    $cid = $course["id"];
                    $cname = $course["name"];
                    $sel .= "<option value='$cid'>" . $cname . "</option>";
                }
                $res['status'] = true;
                $res['message'] = $sel;
            }
        }
        echo json_encode($res);
    }
}