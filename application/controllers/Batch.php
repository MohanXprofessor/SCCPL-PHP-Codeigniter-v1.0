<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-04-26 17:55:49
 Last Modification Date: 2024-05-09 18:17:59
*
**/

defined('BASEPATH') or exit('No direct script access allowed');

class Batch extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Batches';

        $this->load->model('model_batch');
        $this->load->model('model_brands');
        $this->load->model('model_enrollment');
        $this->load->model('model_stores');
        $this->load->model('model_subjectnew');
        $this->load->model('model_allocated_batch');
    }

    /* 
     * It only redirects to the manage product page
     */
    public function index()
    {
        if (!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('batch/index', $this->data);
    }

    public function batches($id)
    {

        $batch_data = $this->model_batch->getBatchDataById($id);

        $allocated_data = $this->model_batch->get_batch_data($id);

        //  print_r( $batch_data);

        $res['data'] = [];

        foreach ($allocated_data as $record) {
            $en_data = $this->model_enrollment->getJobDataByJobId($record['enid']);
            $sub_data = $this->model_subjectnew->fetchSubjectDataById($record['bid']);
            $project_data = $this->model_stores->getStoresData($en_data['project_id']);
            $course_data = $this->model_brands->getBrandData($en_data['course_id']);
            $faculty_data = $this->model_users->getUserDataById($sub_data['faculty_id']);
            //     print_r($faculty_data);
            //  die();
            if ($en_data && $sub_data) {
                // Populate the data array with the necessary information
                $res['data'][] = [
                    'student_name' => $en_data['name'],
                    'address' => $en_data['address'],
                    'batch_name' => $batch_data['batch_name'],
                    // 'batch_id' => $batch_data['batch_id'],
                    'email' => $en_data['email'],
                    'contact' => $en_data['contact'],
                    'project_name' => $project_data['name'],
                    'course_name' => $course_data['name'],
                    'subject' => $sub_data['subject'],
                    'faculty' => $faculty_data['firstname']
                ];
            }

        }
        $this->data['data'] = $res['data'];
        // print_r($this->data);die();
        $this->render_template('batch/batches', $this->data);
    }

    /*
     * It Fetches the products data from the product table 
     * this function is called from the datatable ajax function
     */
    public function fetchProductData()
    {

        $result = array('data' => array());

        $data = $this->model_batch->getProductData();
        $i = 0;

        foreach ($data as $key => $value) {
            // $pdata = $this->model_stores->getStoresData($value['project_id']);
            // $cdata = $this->model_brands->getBrandData($value['course_id']);
            $sdata = $this->model_subjectnew->fetchSubjectDataById($value['id']);
            // print_r($sdata);die();
            // button
            $buttons = '';
            if (in_array('updateProduct', $this->permission)) {
                $buttons .= '<a href="' . base_url('batch/batches/' . $value['id']) . '" class="btn btn-sm btn-default bg-aqua">Allocated Batch</a>';
                $buttons .= '<a href="' . base_url('batch/update/' . $value['id']) . '" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>';
                $buttons .= '<a href="' . base_url('batch/view/' . $value['id']) . '" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a>';

            }

            if (in_array('deleteProduct', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-sm btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
            $sts = "<label class='label label-primary text-light'>In Progress</label>";
            if ($value['progress'] == 100)
                $sts = "<label class='label label-success text-light'>Completed</label>";

            $projectData = $this->model_stores->getStoresDataSingle($value['project_id']);
            $courseData = $this->model_brands->getBrandDataSingle($value['course_id']);
            
            if($projectData !=null && $courseData!=null){
                $result['data'][$i] = array(
                    $value['batch_name'],
                    $projectData['name'],
                    $courseData['name'],
                    $value['batch_time'],
                    $value['batch_start'],
                    $value['batch_end'],
                    "<label class='label label-success text-light'>" . $value['progress'] . "%</label>",
                    $sts,
                    $value['location'],
                    $buttons
                );
                $i++;
            }
        } // /foreach

        echo json_encode($result);
    }

    /*
     * If the validation is not valid, then it redirects to the create page.
     * If the validation for each input field is valid then it inserts the data into the database 
     * and it stores the operation message into the session flashdata and display on the manage product page
     */
    public function create()
    {
        if (!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }



        $this->form_validation->set_rules('project_id', 'project_id', 'trim|required');
        $this->form_validation->set_rules('course_id', 'course_id', 'trim|required');
        $this->form_validation->set_rules('location', 'location', 'trim|required');
        $this->form_validation->set_rules('batch_id', 'batch_id', 'trim|required');
        $this->form_validation->set_rules('batch_name', 'batch_name', 'trim|required');

        $this->form_validation->set_rules('subject[]', 'subject', 'trim|required');
        $this->form_validation->set_rules('faculty_id[]', 'faculty', 'trim|required');
        $this->form_validation->set_rules('batch_time', 'batch_time', 'trim|required');
        $this->form_validation->set_rules('start_date', 'start_date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'end_date', 'trim|required');



        if ($this->form_validation->run() == TRUE) {
            // true case


            $data = array(
                'project_id' => $this->input->post('project_id'),
                'course_id' => $this->input->post('course_id'),
                'location' => $this->input->post('location'),
                'batch_id' => $this->input->post('batch_id'),
                'batch_name' => $this->input->post('batch_name'),
                //'subject_id' => implode(",", $this->input->post('subject')),
                'batch_time' => $this->input->post('batch_time'),
                'batch_start' => $this->input->post('start_date'),
                'batch_end' => $this->input->post('end_date'),

            );

            $create = $this->model_batch->create($data);
            $bid = $this->db->insert_id();



            if ($create) {
                $sids = $this->input->post('subject');
                $fids = $this->input->post('faculty_id');
                $i = 0;
                foreach ($sids as $a) {

                    $data1 = array(
                        'subject' => $sids[$i],
                        'faculty_id' => $fids[$i],
                        'bid' => $bid,
                    );
                    $this->model_subjectnew->createSubject($data1);
                    $i++;
                }
                $this->session->set_flashdata('success', 'Successfully created');
                //   $this->session->set_flashdata('success', 'Successfully created');
                redirect('batch/index', 'refresh');

            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('batch/create', 'refresh');
            }

        } else {
            $this->render_template("batch/create", $this->data);
            //redirect('enrollment/index', 'refresh');
        }
    }
    public function update($id)
    {
        if (!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('project_id', 'project_id', 'trim|required');
        $this->form_validation->set_rules('course_id', 'course_id', 'trim|required');
        $this->form_validation->set_rules('subject_id[]', 'subject', 'trim|required');
        $this->form_validation->set_rules('subject_name[]', 'Subject Name', 'trim|required');
        $this->form_validation->set_rules('faculty_id[]', 'batch end', 'trim|required');
        $this->form_validation->set_rules('batch_name', 'batch name', 'trim|required');
        $this->form_validation->set_rules('batch_start', 'batch start', 'trim|required');
        $this->form_validation->set_rules('batch_time', 'batch time', 'trim|required');
        $this->form_validation->set_rules('batch_end', 'batch end', 'trim|required');
        $this->form_validation->set_rules('progress', 'Progress(In %)', 'trim|required');

        $this->form_validation->set_rules('location', 'location', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case

            $sids = $this->input->post('subject_id');
            $snames = $this->input->post('subject_name');
            $fids = $this->input->post('faculty_id');
            $i = 0;
            foreach ($sids as $a) {
                $data1 = array(
                    'subject' => $snames[$i],
                    'faculty_id' => $fids[$i]
                );
                $this->model_subjectnew->updateSubject($data1, $a);
                $i++;
            }

            $data = array(
                // 'subject_id' => implode(",", $this->input->post('subject_id')),
                'project_id' => $this->input->post('project_id'),
                'course_id' => $this->input->post('course_id'),
                'batch_name' => $this->input->post('batch_name'),
                'batch_time' => $this->input->post('batch_time'),
                'batch_start' => $this->input->post('batch_start'),
                'batch_end' => $this->input->post('batch_end'),
                'location' => $this->input->post('location'),
                'progress' => $this->input->post('progress'),
            );
            //print_r($data);die();
            $update = $this->model_batch->update($data, $id);

            if ($update == true) {
                $new_sids = $this->input->post('new_subject');
                $new_fids = $this->input->post('new_faculty_id');
                $i = 0;
                foreach ($new_sids as $a) {
                    $d1 = $new_sids[$i];
                    $d2 = $new_fids[$i];
                    if (!empty($d1) && !empty($d2)) {
                        $data1 = array(
                            'subject' => $d1,
                            'faculty_id' => $d2,
                            'bid' => $id,
                        );
                    }
                    $this->model_subjectnew->createSubject($data1);
                    $i++;
                }
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('batch/index', $this->data1);
            }
        } else {
            if ($id) {
                $product_data = $this->model_batch->single_batch($id);

                $this->data['data'] = $product_data;
                $this->render_template('batch/edit', $this->data);
            } else {
                $this->render_template('batch/index', $this->data);
            }
        }



    }

    /**
     * This function if is used for the staff
     * @author Akash Fulari 
     * @date 27-04-2024
     */
    public function viewMyBatch($bid)
    {
        $bd = $this->model_batch->getProductData($bid);
        $this->data["bdata"] = $bd;
        if (!in_array('viewMyBatches', $this->permission) || $bd == null) {
            redirect('dashboard', 'refresh');
        }
        $this->data['bid'] = $bid;
        $this->render_template("batch/viewMyBatch", $this->data);

    }
    public function loadStudentDataBID($bid)
    {
        $allocated_data = $this->model_batch->get_batch_data($bid);
        $res = array("data" => array());
        $i = 0;
        foreach ($allocated_data as $record) {
            $en_data = $this->model_enrollment->getJobDataByJobId($record['enid']);
            $sub_data = $this->model_subjectnew->fetchSubjectDataById($record['bid']);
            $project_data = $this->model_stores->getStoresData($en_data['project_id']);
            $course_data = $this->model_brands->getBrandData($en_data['course_id']);
            //     print_r($faculty_data);
            //  die();
            if ($en_data && $sub_data) {
                // Populate the data array with the necessary information
                $res['data'][$i] = [
                    ($i + 1),
                    $en_data['name'],
                    $en_data['address'],
                    $en_data['email'],
                    $en_data['contact'],
                    $project_data['name'],
                    $course_data['name'],
                    $sub_data['subject']
                ];
                $i++;
            }
        }
        echo json_encode($res);
    }

    public function loadStudentDataBIDForResult($bid)
    {
        $allocated_data = $this->model_batch->get_batch_data($bid);
        $res = array("data" => array());
        $i = 0;
        foreach ($allocated_data as $record) {
            $en_data = $this->model_enrollment->getJobDataByJobId($record['enid']);
            $sub_data = $this->model_subjectnew->fetchSubjectDataById($record['bid']);
            $project_data = $this->model_stores->getStoresData($en_data['project_id']);
            $course_data = $this->model_brands->getBrandData($en_data['course_id']);
            //     print_r($faculty_data);
            //  die();
            if ($en_data && $sub_data) {
                // Populate the data array with the necessary information
                $res['data'][$i] = [
                    ($i + 1),
                    $en_data['name'],
                    $en_data['email'],
                    $project_data['name'],
                    $course_data['name'],
                    $sub_data['subject'],
                    "<center>--</center>",
                    "<center>--</center>",
                    "<center>--</center>",
                    "<center>--</center>",
                    "<center>--</center>",
                    "<center>--</center>",
                    "<center>--</center>",
                    "<center>--</center>",
                    "<center>--</center>"
                ];
                $i++;
            }
        }
        echo json_encode($res);
    }

    /*
     * It removes the data from the database
     * and it returns the response into the json format
     */
    public function remove()
    {
        if (!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id = $this->input->post('id');

        $response = array();
        if ($id) {
            $delete = $this->model_batch->remove($id);
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

    //3-28-19 added new view of pkg RMZ

    // product changess if data not in course field then set null and view null in array 'h' RMZ 4-1-19  
    public function view($id)
    {

        $data = $this->model_batch->single_batch($id);

        $this->data['data'] = $data;
        $this->render_template("batch/list", $this->data);

    }

    public function load($id)
    {

        if ($id) {
            $sql = "SELECT brand_id FROM batch  where id  = ? order by id desc";
            $query = $this->db->query($sql, $id);
            $data = $query->row_array();


            echo json_encode($data);


        }
    }

    public function fetchCompletedStudent()
    {
        $result = array('data' => array());
    
        $batch_data = $this->model_batch->getBatchData();
       
        foreach ($batch_data as $value) 
        { 
            if ($value['progress'] == 100)
            {
                $en_data = $this->model_allocated_batch->getEnrollmentId($value['id']); // Correct method name
                //$stud_data = $this->model_enrollment->getEnrollmentById($en_data['enid']); // Correct method name
                
                if($en_data && isset($en_data['enid'])) 
                {
                  $stud_data = $this->model_enrollment->getEnrollmentById($en_data['enid']);
                  
                   
                    // Check if stud_data is not empty
                    if (!empty($stud_data)) 
                    {
                    $result['data'][] = [ // Use [] to append to the array
                    $stud_data['name'],
                    $stud_data['father_name'],
                    $stud_data['mother_name'],
                    $stud_data['email'],
                    $stud_data['contact'],
                    $stud_data['address'],
                    $stud_data['college'],
                  ];               

                }
                else
                {
                    // Log error or handle case where student data is not found
                    log_message('error', 'Student data not found for enrollment ID: ' . $en_data['enid']);
                }
            
            }
            else
            {
                // Log error or handle case where enrollment ID is not found
                log_message('error', 'Enrollment data not found for batch ID: ' . $value['id']);
            }
            }

        }
    
        echo json_encode($result);
    }
    

    public function batchWiseCompletion()
    {
        $result = array('data' => array());
        
        // Retrieve batch data
        $batch_data = $this->model_batch->getBatchData();
        if (empty($batch_data)) {
            log_message('error', 'No batch data found');
            echo json_encode($result);
            return;
        }
    
        log_message('debug', 'Batch data: ' . print_r($batch_data, true));
        
        // Iterate through each batch to find completed students
        foreach ($batch_data as $batch) 
        {
            if ($batch['progress'] == 100)
            {
                $enrollments = $this->model_allocated_batch->getEnrollmentIdsByBatchId($batch['id']);
                if (empty($enrollments)) {
                    log_message('error', 'No enrollments found for batch ID: ' . $batch['id']);
                    continue;
                }
                
                log_message('debug', 'Enrollment data for batch ID ' . $batch['id'] . ': ' . print_r($enrollments, true));
    
                foreach ($enrollments as $enrollment)
                {
                    if (isset($enrollment['enid']))
                    {
                        $student = $this->model_enrollment->getEnrollmentById($enrollment['enid']);
                        log_message('debug', 'Student data for enrollment ID ' . $enrollment['enid'] . ': ' . print_r($student, true));
                        
                        if (!empty($student)) 
                        {
                            $result['data'][] = [
                                $student['name'],
                                $student['father_name'],
                                $student['mother_name'],
                                $student['email'] ,
                                $student['contact'],
                                $student['address'],
                                $student['college'],
                            ];
                        }
                        else
                        {
                            log_message('error', 'Student data not found for enrollment ID: ' . $enrollment['enid']);
                        }
                    }
                    else
                    {
                        log_message('error', 'Enrollment ID not set for batch ID: ' . $batch['id']);
                    }
                }
            }
        }
    
        echo json_encode($result);
    }
    

}