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
}
