<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Assessments extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_assessment');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url'));
        $this->not_logged_in();
    }

    public function index()
    {
        // Fetch subjects from the model
        $this->data['subjects'] = $this->Model_assessment->get_subjectName();

        // Render the template with the data
        $this->render_template('assessments/index', $this->data);
    }

    public function create_assessment()
    {
        // File upload configuration
        $config['upload_path'] = './uploads';
        $config['allowed_types'] = 'pdf|doc|docx|csv|xlsx';
        $config['max_size'] = 2048; // 2MB

        // Load and initialize the upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        // Initialize file path as null
        $file_path = null;

        // Handle file upload
        if ($this->upload->do_upload('file')) {
            // If file uploaded successfully
            $uploadData = $this->upload->data();
            $file_path = $uploadData['file_name']; // Extract file path
        } else {
            // Log upload errors for debugging
            $error = $this->upload->display_errors();
            log_message('error', 'File upload error: ' . $error);
        }

        // Collect form data
        $data = array(
            'project' => $this->input->post('project_id'),
            'course' => $this->input->post('course_id'),
            'subject' => $this->input->post('subject'),
            'assignment_type' => $this->input->post('assignment_type'),
            'assignment_marks' => $this->input->post('assignment_marks'),
            'passing_marks' => $this->input->post('passing_marks'),
            'date' => $this->input->post('date'),
            'faculty' => $this->input->post('faculty_id'),
            'file_path' => $file_path,
        );

        // Debug: Log the $data array for troubleshooting
        log_message('debug', 'Data before database insert: ' . print_r($data, true));

        // Insert data into the database
        if ($this->Model_assessment->save_assessment($data)) {
            $this->session->set_flashdata('success', 'Assessment created successfully!');
            redirect('Assessments');
        } else {
            $this->session->set_flashdata('error', 'Failed to create assessment.');
            redirect('Assessments/create'); // Adjust redirect as needed
        }
    }


    // public function create_assessment()
    // {
    //     // Load the upload library
    //     $this->load->library('upload', $config);

    //     // File upload configuration
    //     $config['upload_path'] = './uploads';
    //     $config['allowed_types'] = 'pdf|doc|docx|csv|xlsx';
    //     $config['max_size'] = 2048; // 2MB

    //     $this->upload->initialize($config);

    //     if ($this->upload->do_upload('file')) {
    //         // If file uploaded successfully
    //         $uploadData = $this->upload->data();
    //         $file_path = './uploads/' . $uploadData['file_name'];
    //     } else {
    //         // If file upload failed
    //         $file_path = null;
    //     }

    //     // Collect form data
    //     $data = array(
    //         'project' => $this->input->post('project_id'),
    //         'course' => $this->input->post('course_id'),
    //         'subject' => $this->input->post('subject'),
    //         'assignment_type' => $this->input->post('assignment_type'),
    //         'assignment_marks' => $this->input->post('assignment_marks'),
    //         'passing_marks' => $this->input->post('passing_marks'),
    //         'date' => $this->input->post('date'),
    //         'faculty' => $this->input->post('faculty_id'),
    //         'file_path' => $file_path,
    //     );

    //     // Insert data into the database
    //     if ($this->Model_assessment->save_assessment($data)) {

    //         redirect('Assessments');

    //         $this->session->set_flashdata('success', 'Assessment created successfully!');
    //     } else {
    //         $this->session->set_flashdata('error', 'Failed to create assessment.');
    //     }

    //     // Redirect back to the form or list
    //     // redirect('Assessment');
    // }




    // TO Display DTATA

    public function show()
    {
        $this->data['dassess'] = $this->Model_assessment->get_all_assessments(); // Get data from model



        $this->render_template('assessments/display', $this->data);
    }

    public function file_view()
    {
        $this->render_template('assessments/assess_view', $this->data);
    }





    // DELETE assessment 
    public function delete_assessment($id)
    {
        if ($id) {
            $deleted = $this->Model_assessment->delete_assessment($id);
            if ($deleted) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }



    // READ PDF AND EXCEL FILE 

    public function assess_viewfiles()
    {
        $this->render_template('assessments/assess_viewfile', $this->$data);
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
}
