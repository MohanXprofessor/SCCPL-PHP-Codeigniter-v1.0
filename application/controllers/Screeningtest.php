<?php

/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: New enquiry table, model, controller updates
* Created: 2024-03-30 13:17:00
 Last Modification Date: 2024-05-10 18:32:20
*
**/

defined('BASEPATH') or exit('No direct script access allowed');

class Screeningtest extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Enquiry';

        $this->load->model('model_enquiry');
        $this->load->model('model_brands');
        $this->load->model('model_screeningtest');
        $this->load->model('model_enrollmenttemp');
        $this->load->helper('url');
    }

    public function manage()
    {
        if (!in_array('viewScreeningTest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->render_template('screentest/index', $this->data);
    }

    public function update($stId)
    {
        if (!in_array('updateScreeningTest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->form_validation->set_rules('apptitudeTestDate', 'Apptitude Test Date', 'trim|required');
        $this->form_validation->set_rules('apptitudeTestMarks', 'Apptitude Test Marks', 'trim|required');
        $this->form_validation->set_rules('gdTestDate', 'Group Descussion Test Date', 'trim|required');
        $this->form_validation->set_rules('gdTestMarks', 'Group Descussion Test Marks', 'trim|required');
        $this->form_validation->set_rules('totalMarks', 'Total Marks', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'apptitude_test_date' => $this->input->post('apptitudeTestDate'),
                'apptitude_test_marks' => $this->input->post('apptitudeTestMarks'),
                'gd_date' => $this->input->post('gdTestDate'),
                'gd_marks' => $this->input->post('gdTestMarks'),
                'total_result' => $this->input->post('totalMarks'),
                'status' => $this->input->post('status'),
                'added_by' => $this->userId
            );

            // change the flag in enquiry table
            $this->model_enquiry->update(array('isTestSubmited' => 1), $this->input->post('enquiryId'));

            $isCreated = $this->model_screeningtest->update($data, $stId);

            if ($isCreated) {
                $this->session->set_flashdata('success', 'Test Updated Successfully!!');
                redirect('screeningtest/manage', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('enquiry/manage', 'refresh');
            }

        } else {
            $this->data['testData'] = $this->model_screeningtest->getScreeningTestDataById($stId);
            $this->render_template('screentest/update', $this->data);
        }
    }

    public function submitSingleEquiry()
    {
        $this->form_validation->set_rules('enquiryId', 'Project Id', 'trim|required');
        $this->form_validation->set_rules('apptitudeTestDate', 'Apptitude Test Date', 'trim|required');
        $this->form_validation->set_rules('apptitudeTestMarks', 'Apptitude Test Marks', 'trim|required');
        $this->form_validation->set_rules('gdTestDate', 'Group Descussion Test Date', 'trim|required');
        $this->form_validation->set_rules('gdTestMarks', 'Group Descussion Test Marks', 'trim|required');
        $this->form_validation->set_rules('totalMarks', 'Total Marks', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'enquiry_id' => $this->input->post('enquiryId'),
                'apptitude_test_date' => $this->input->post('apptitudeTestDate'),
                'apptitude_test_marks' => $this->input->post('apptitudeTestMarks'),
                'gd_date' => $this->input->post('gdTestDate'),
                'gd_marks' => $this->input->post('gdTestMarks'),
                'total_result' => $this->input->post('totalMarks'),
                'status' => $this->input->post('status'),
                'added_by' => $this->userId
            );

            // change the flag in enquiry table
            $this->model_enquiry->update(array('isTestSubmited' => 1), $this->input->post('enquiryId'));

            $isCreated = $this->model_screeningtest->create($data);
            $screenTestId = $this->db->insert_id();
            if ($this->input->post('status') == 1)
                $this->createTempStudentEnrollForm($this->input->post('enquiryId'), $screenTestId);

            if ($isCreated) {
                $this->session->set_flashdata('success', 'Test Submitted Successfully!!');
                redirect('screeningtest/manage', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('enquiry/manage', 'refresh');
            }

        } else {
            $this->session->set_flashdata('errors', 'All field are mandatory!!');
            redirect('enquiry/manage', 'refresh');
        }
    }

    public function submitBulkEquiry()
    {
        $fileFieldName = "bulkFile";

        if ($this->validateFormFile($fileFieldName)) {
            if ($_FILES[$fileFieldName]["type"] == "text/csv") {
                $file = fopen($_FILES[$fileFieldName]["tmp_name"], "r");
                $i = 0;
                $isValid = false;
                $isUpdated = false;

                while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if (sizeof($getData) != 20)
                        break;
                    if ($i != 0 && $isValid) {
                        $enqId = $getData[0];
                        $enqData = $this->model_enquiry->getEnquiryDataByIdForScreeningTest($enqId);

                        if ($enqData != null) {
                            $aptiDate = $getData[14];
                            $aptiMarks = $getData[15];
                            $gdDate = $getData[16];
                            $gdMarks = $getData[17];
                            $totalMarks = $getData[18];
                            $status = $getData[19];
                            
                            if (!empty($enqId) && !empty($aptiDate) && !empty($aptiMarks) && !empty($gdDate) && !empty($gdMarks) && !empty($totalMarks) && in_array($status, array(0, 1))) {
                                $data = array(
                                    'enquiry_id' => $enqId,
                                    'apptitude_test_date' => $aptiDate,
                                    'apptitude_test_marks' => $aptiMarks,
                                    'gd_date' => $gdDate,
                                    'gd_marks' => $gdMarks,
                                    'total_result' => $totalMarks,
                                    'status' => $status,
                                    'added_by' => $this->userId
                                );

                                // change the flag in enquiry table
                                $this->model_enquiry->update(array('isTestSubmited' => 1), $enqId);

                                $this->model_screeningtest->create($data);
                                $screenTestId = $this->db->insert_id();
                                if ($status == 1)
                                    $this->createTempStudentEnrollForm($this->input->post('enquiryId'), $screenTestId, true);
                                $isUpdated = true;
                            }
                        }
                    } else {
                        $enqId = $getData[0];
                        $aptiDate = $getData[14];
                        $aptiMarks = $getData[15];
                        $gdDate = $getData[16];
                        $gdMarks = $getData[17];
                        $totalMarks = $getData[18];
                        $status = $getData[19];
                        if ($enqId == "Enquiry Id" && $aptiDate == "Aptitude Test Date" && $aptiMarks == "Aptitude Test Marks" && $gdDate == "Group Discussion Date" && $gdMarks == "Group Discussion Marks" && $totalMarks == "Total Marks" && $status == "Pass/Fail")
                            $isValid = true;
                    }
                    $i++;
                }

                if ($isUpdated) {
                    $this->session->set_flashdata('success', 'Test Submitted Successfully!!');
                    redirect('screeningtest/manage', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Unable to submit the tests!!');
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
    }
    
    /**
     * Code updated By: Akash K. Fulari
     * On Date: 10-05-2024
     * As per: Raj Kolhe Sir
     * Description:
     * Here I created new table call enrollement_temp
     * For student will the all required fields
     * And it will comes to the counseller to confirm documents
     * CODE STARTS HERE: 10052024
     * */
   
    /*
        Updated Method By: Akash Fulari
        On Date: 25/08/2024 12:09pm
        Description:
            In mail link was going wrong path.
            So It`s updated. This will not send mail
            If enquiryId, enquiryId is not set or it's null
            After that it will validates for email & the tempEnqId also. 
            If these both email & tempEnqId is not set or null. it will not send an mail.
        Updated Code:250820241209pm
        Code Starts Here
    */ 
    public function createTempStudentEnrollForm($enquiryId, $screenTestId, $overrideMailIfDataExists = false)
    {
        $enData = $this->model_enquiry->getEnquiryDataById($enquiryId);
        if ($enData && $screenTestId) {
            $data = array(
                'project_id' => $enData['project_id'],
                'course_id' => $enData['course_id'],
                'screentest_id' => $screenTestId,
                'name' => $enData['student_name'],
                'gender' => $enData['gender'],
                'address' => $enData['student_address'],
                'contact' => $enData['student_mobile'],
                'email' => $enData['student_email'],
                'college' => $enData['college_name'],
                'education' => $enData['qualification'],
            );
            /*
            * Code By: Akash Fulari
            * On Date: 13-07-2024 12:35PM
            * Update code: 130720241235pm
            * Description: Updated code for method parameter $overrideMailIfDataExists functionality
            * Resend mail funcaitonality.
            * Code STARTS here
            */ 
            $enqTempData = $this->model_enrollmenttemp->findByScreenTestId($screenTestId);
            $enEmail = $enData['student_email'];
            if($enEmail){
                $md5EnMail = md5($enEmail);
                if($enqTempData == null){
                    $isCreated = $this->model_enrollmenttemp->create($data);
                    if ($isCreated) {
                        $tmp_enId = $this->db->insert_id();
                        if($tmp_enId){
                            $msg = "Dear " . $enData['student_name'] . ", Please fill the form to get enrollement. Click bellow button or Open the Url,<br>
                            <a style='background:green;color:white;text-decoration:none; outline:none; border-radius:30px;display:block;' href='" . base_url("/mailtemplete/tempenroll/" . $tmp_enId . "/" . $md5EnMail) . "'>Click Here to Enroll</a>
                            <a>" . base_url("/mailtemplete/tempenroll/" . $tmp_enId . "/" . $md5EnMail) . "</a>
                            ";
                            $this->sendMail($enEmail, "Enrollement Request", $msg);
                            return true;
                        }
                    }
                }else if($overrideMailIfDataExists){
                    $tmp_enId = $enqTempData['id'];
                    if($tmp_enId){
                        $msg = "Dear " . $enData['student_name'] . ", Please fill the form to get enrollement. Click bellow button or Open the Url,<br>
                        <a style='background:green;color:white;text-decoration:none; outline:none; border-radius:30px;display:block;' href='" . base_url("/mailtemplete/tempenroll/" . $tmp_enId . "/" . $md5EnMail) . "'>Click Here to Enroll</a>
                        <a>" . base_url("/mailtemplete/tempenroll/" . $tmp_enId . "/" . $md5EnMail) . "</a>
                        ";
                        $this->sendMail($enEmail, "Enrollement Request", $msg);
                        return true;
                    }
                }
            }
            /*
            * Update code: 130720241235pm
            * Code ENDS here
            */ 
        }
        return false;
    }

    /*
        Updated Code:250820241209pm
        Code Ends Here
    */ 
    
    /*
    * Code By: Akash Fulari
    * On Date: 13-07-2024 12:21PM
    * Update code: 130720241221pm
    * Code STARTS here
    */ 
    public function sendEnrollMailManually(){
        $response = array();
        $response['success'] = false;
        $eqId = $this->input->post("enqId");
        $scId = $this->input->post("screenTestId");
        if($eqId != null && $scId != null){
            $bool = $this->createTempStudentEnrollForm($eqId, $scId, true);
            if($bool){
                $response['success'] = true;
                $response['messages'] = "Mail send successfully!.";
            }else
                $response['messages'] = "Invalid credentials!.";  
        }else
            $response['messages'] = "Invalid credentials!.";
            
        echo json_encode($response);
    }

    /*
    * Update code: 130720241221pm
    * Code ENDS here
    */ 
    public function fetchStudentEnrollsData()
    {
        $result = array('data' => array());
        $data = $this->model_enrollmenttemp->fetchEnrollmentData();
        $i = 0;
        foreach ($data as $value) {
            $pdata = $this->model_stores->getStoresData($value['project_id']);
            $cdata = $this->model_brands->getBrandData($value['course_id']);
            $buttons = "";
            if ($value['isAllocated'] == 0)
                $buttons .= ' <a class="btn btn-sm btn-info d-block" href="' . base_url('enrollment/confirmEnrollement/' . $value['id']) . '">Confirm Enroll</a>';

            $result['data'][$i] = array(
                $pdata['name'],
                $cdata['name'],
                $value['education'],
                $value['name'],
                $value['father_name'],
                $value['mother_name'],
                (($value['gender'] == 0) ? "Female" : (($value['gender'] == 1) ? "Male" : "Other")),
                $value['contact'],
                $value['address'],
                $value['email'],
                $value['city'],
                $value['state'],
                $value['annual_income'],
                $buttons
            );
            $i++;
        }


        echo json_encode($result);
    }
    
    /**
     * CODE ENDS HERE: 10052024
     * */

    public function validateFormFile($field_name)
    {
        if (empty($_FILES[$field_name]['name'])) {
            $this->form_validation->set_message('error', 'The ' . $field_name . ' field is required.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function remove()
    {
        if (!in_array('deleteScreeningTest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id = $this->input->post('id');

        $response = array();
        if ($id) {

            $screenData = $this->model_screeningtest->getScreeningTestDataById($id);
            // change the flag in enquiry table
            $this->model_enquiry->update(array('isTestSubmited' => 0), $screenData['enquiry_id']);

            $delete = $this->model_screeningtest->delete($id);
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

    public function fetchScreenTestData()
    {
        $result = array('data' => array());

        $data = $this->model_screeningtest->getScreeningTestData();
        $i = 0;
        foreach ($data as $key => $value) {
            // if ($value['isEnrolled'] == 0) {
            $eqId = $value['enquiry_id'];
            $eqData = $this->model_enquiry->getEnquiryDataById($eqId);

            if ($eqData != null) {
                $buttons = "";
                
                /*
                * Code By: Akash Fulari
                * On Date: 12-07-2024 07:29PM
                * Update code: 120720240729am
                * Code STARTS here
                */ 
                
                $buttons .= ' <a type="button" class="btn btn-sm btn-warning d-block" onclick="resendEnrollementRequestFormMail(' . $eqId . ', ' . $value['id'] . ')">Send Mail Enquiry Form</a>';

                /*
                * Update code: 120720240729am
                * Code ENDS here
                */ 
                
                if ($value['isEnrolled'] == 0)
                    $buttons .= ' <a class="btn btn-sm btn-info d-block" href="' . base_url('enrollment/create/' . $value['id']) . '">Enroll Now</a>';
                if (in_array('updateScreeningTest', $this->permission))
                    $buttons .= ' <a class="btn btn-sm btn-info d-block" href="' . base_url('screeningtest/update/' . $value['id']) . '"><i class="fa fa-pencil"></i></a>';
                if (in_array('deleteScreeningTest', $this->permission))
                    $buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></a>';

                
                $projectData = $this->model_stores->getStoresData($eqData['project_id']);
                $courseData = $this->model_brands->getBrandData($eqData['course_id']);

                $result['data'][$i] = array(
                    $projectData['name'],
                    $courseData['name'],
                    /*$value['job_description'],*/
                    $eqData['student_name'],
                    $eqData['student_email'],
                    $eqData['student_mobile'],
                    $eqData['student_address'],
                    $eqData['college_name'],
                    // $eqData['created_at'],
                    // $eqData['status'],
                    // $eqData['remark'],
                    $value['apptitude_test_date'],
                    $value['apptitude_test_marks'],
                    $value['gd_date'],
                    $value['gd_marks'],
                    $value['total_result'],
                    (($value['status'] == 0) ? "Fail" : "Pass"),
                    $buttons
                );
                $i++;
            }
            // }
        }

        echo json_encode($result);
    }

    public function fetchFilteredScreenTestData()
    {
        $result = array('data' => array());

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $project_id = $this->input->get('project_id');
        $course_id = $this->input->get('course_id');
        $counseller_id = $this->input->get('counseller_id');

        if ($start_date && $end_date && $project_id && $course_id && $counseller_id) {
            $data = $this->model_screeningtest->getScreeningTestData();
            $i = 0;
            foreach ($data as $key => $value) {
                //if ($value['isEnrolled'] == 0) {
                $eqId = $value['enquiry_id'];
                $eqData = $this->model_enquiry->getFilteredEnquiryDataById($eqId, $start_date, $end_date, $project_id, $course_id, $counseller_id);
                if ($eqData != null) {
                    $buttons = "";

                /*
                * Code By: Akash Fulari
                * On Date: 12-07-2024 07:29PM
                * Update code: 120720240729am
                * Code STARTS here
                */ 
                
                $buttons .= ' <a type="button" class="btn btn-sm btn-warning d-block" onclick="resendEnrollementRequestFormMail(' . $eqId . ', ' . $value['id'] . ')">Send Mail Enquiry Form</a>';

                /*
                * Update code: 120720240729am
                * Code ENDS here
                */ 
                
                    if ($value['isEnrolled'] == 0)
                        $buttons .= ' <a class="btn btn-sm btn-info d-block" href="' . base_url('enrollment/create/' . $value['id']) . ')">Enroll Now</a>';
                    if (in_array('updateScreeningTest', $this->permission))
                        $buttons .= ' <a class="btn btn-sm btn-info d-block" href="' . base_url('screeningtest/update/' . $value['id']) . ')"><i class="fa fa-pencil"></i></a>';
                    if (in_array('deleteScreeningTest', $this->permission))
                        $buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></a>';


                    $projectData = $this->model_stores->getStoresData($eqData['project_id']);
                    $courseData = $this->model_brands->getBrandData($eqData['course_id']);

                    $result['data'][$i] = array(
                        $value['id'],
                        $projectData['name'],
                        $courseData['name'],
                        /*$value['job_description'],*/
                        $eqData['student_name'],
                        $eqData['student_email'],
                        $eqData['student_mobile'],
                        $eqData['student_address'],
                        $eqData['college_name'],
                        // $eqData['created_at'],
                        // $eqData['status'],
                        // $eqData['remark'],
                        $value['apptitude_test_date'],
                        $value['apptitude_test_marks'],
                        $value['gd_date'],
                        $value['gd_marks'],
                        $value['total_result'],
                        (($value['status'] == 0) ? "Fail" : "Pass"),
                        $buttons
                    );
                    $i++;
                }
                //}
            }
        }
        echo json_encode($result);
    }
}