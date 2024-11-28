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
        // Load the upload library
        $this->load->library('upload');

        // File upload configuration
        $config['upload_path'] = './uploads/assessments/';
        $config['allowed_types'] = 'pdf|doc|docx|jpg|png';
        $config['max_size'] = 2048; // 2MB

        $this->upload->initialize($config);

        if ($this->upload->do_upload('userfile')) {
            // If file uploaded successfully
            $uploadData = $this->upload->data();
            $file_path = 'uploads/assessments/' . $uploadData['file_name'];
        } else {
            // If file upload failed
            $file_path = null;
        }

        // Collect form data
        $data = array(
            'project_id' => $this->input->post('project_id'),
            'course_id' => $this->input->post('course_id'),
            'subject_id' => $this->input->post('subject'),
            'assignment_type' => $this->input->post('assignment_type'),
            'assignment_marks' => $this->input->post('assignment_marks'),
            'passing_marks' => $this->input->post('passing_marks'),
            'date' => $this->input->post('date'),
            'faculty_id' => $this->input->post('faculty_id'),
            'file_path' => $file_path,
        );

        // Insert data into the database
        if ($this->Model_assessment->save_assessment($data)) {

            redirect('Assessments');

            $this->session->set_flashdata('success', 'Assessment created successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to create assessment.');
        }

        // Redirect back to the form or list
        // redirect('Assessment');
    }
}
