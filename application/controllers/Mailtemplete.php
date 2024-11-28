<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mailtemplete extends Admin_Controller
{
    /**
     * This code added on Date: 06-06-2024 04:20PM
     * For to access un-authorised student api`s
     * */

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_enquiry');
        $this->load->model('model_brands');
        $this->load->model('model_stores');
        $this->load->model('model_enrollmenttemp');
    }

    public function tempenroll($tempEnqId = null, $md5Data = null)
    {
        if($tempEnqId == null || $md5Data == null){
            echo "Invalid url. Please kindly check your url. It's invalid.";
            return;
        }
        if ($tempEnqId && $md5Data) {
            $tmpEnqData = $this->model_enrollmenttemp->getOrdersData($tempEnqId);
            if ($tmpEnqData != null) {
                $md5Mail = $tmpEnqData['email'];
                if (!empty($md5Mail) && (md5($md5Mail) == $md5Data)) {
                    $isUplaoded = $this->model_enrollmenttemp->checkExistingUploadedData($tempEnqId);
                    if (!$isUplaoded) {
                        $data['data'] = $tmpEnqData;
                        $data['project_data'] = $this->model_stores->getStoresData($tmpEnqData['project_id']);
                        $data['course_data'] = $this->model_brands->getBrandData($tmpEnqData['course_id']);
                        $this->load->view('screentest/temporary_enrollment/create', $data);
                    } else {
                        echo "You have already attempted!!!.";
                    }
                } else {
                    echo "Invalid Access!!!.";
                }
            } else {
                echo "Invalid Access!!!.";
            }
        }
    }

    public function fillMyRequiredDocuments()
    {
        $res = array("status" => false, "message" => "");
        $this->form_validation->set_rules('temp_enq_id', 'Enquiry Id', 'trim|required');
        $this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
        $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('father_name', 'father_name', 'trim|required');
        $this->form_validation->set_rules('mother_name', 'mother_name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('address', 'address', 'trim|required');
        $this->form_validation->set_rules('college', 'College', 'trim|required');
        $this->form_validation->set_rules('education', 'Education', 'trim|required');
        $this->form_validation->set_rules('tenth', ' 10th', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[100]', 
        array(
            'required' => 'The %s field is required.',
            'numeric' => 'The %s field must contain a numeric value.',
            'greater_than_equal_to' => 'Marks should be in percent (1 to 100).',
            'less_than_equal_to' => 'Marks should be in percent (1 to 100).'
        ));
        $this->form_validation->set_rules('contact', 'contact', 'trim|required');
        $this->form_validation->set_rules('twelth', '12th', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[100]', 
        array(
            'required' => 'The %s field is required.',
            'numeric' => 'The %s field must contain a numeric value.',
            'greater_than_equal_to' => 'Marks should be in percent (1 to 100).',
            'less_than_equal_to' => 'Marks should be in percent (1 to 100).'
        ));
        $this->form_validation->set_rules('graduation', 'graduation', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[100]', 
        array(
            'required' => 'The %s field is required.',
            'numeric' => 'The %s field must contain a numeric value.',
            'greater_than_equal_to' => 'Marks should be in percent (1 to 100).',
            'less_than_equal_to' => 'Marks should be in percent (1 to 100).'
        ));
        $this->form_validation->set_rules('graduation_passing', 'graduation_passing', 'trim|required');
        $this->form_validation->set_rules('admission', 'admission', 'trim|required');
        $this->form_validation->set_rules('annual_income', 'annual_income', 'trim|required');
        $this->form_validation->set_rules('state', 'state', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('adhar_no', 'adhar', 'trim|required');

        if ($this->form_validation->run() == true) {
            if ($this->validateFormFile("tenth_certificate") && $this->validateFormFile("twelth_certificate") && $this->validateFormFile("income") && $this->validateFormFile("adhar") && $this->validateFormFile("photograph") && $this->validateFormFile("graduate_certificate")) {
                $tempEnqId = $this->input->post('temp_enq_id');
                $isExistsData = $this->model_enrollmenttemp->getOrdersData($tempEnqId);
                if ($isExistsData) {
                    $isUplaoded = $this->model_enrollmenttemp->checkExistingUploadedData($tempEnqId);
                    if (!$isUplaoded) {
                        $data = array(
                            'project_id' => $this->input->post('project_id'),
                            'course_id' => $this->input->post('course_id'),
                            'name' => $this->input->post('name'),
                            'father_name' => $this->input->post('father_name'),
                            'mother_name' => $this->input->post('mother_name'),
                            'gender' => $this->input->post('gender'),
                            'address' => $this->input->post('address'),
                            'contact' => $this->input->post('contact'),
                            'email' => $this->input->post('email'),
                            'college' => $this->input->post('college'),
                            'admission' => $this->input->post('admission'),
                            'education' => $this->input->post('education'),
                            'annual_income' => $this->input->post('annual_income'),
                            'state' => $this->input->post('state'),
                            'city' => $this->input->post('city'),
                            '10th' => $this->input->post('tenth'),
                            '12th' => $this->input->post('twelth'),
                            'graduation_passing' => $this->input->post('graduation_passing'),
                            'graduation' => $this->input->post('graduation'),
                            'adhar_no' => $this->input->post('adhar_no'),
                            'isFilledData' => 1
                        );

                        $userFolderPath = "assets/uploads/" . $this->input->post('name');

                        $file2 = $this->uploadFile($userFolderPath . "/Tenth", 'tenth_certificate');
                        $tenth = (($file2['status'] == 1) ? $file2['data']['full_path'] : null);
                        if ($tenth) {
                            $link = $isExistsData['10th_marksheet'];
                            if (!empty($link))
                                unlink($link);
                            $data['10th_marksheet'] = (($tenth == null) ? "" : $tenth);
                        }

                        $file3 = $this->uploadFile($userFolderPath . "/Twelth", 'twelth_certificate');
                        $twelth = (($file3['status'] == 1) ? $file3['data']['full_path'] : null);
                        if ($twelth) {
                            $link = $isExistsData['12th_marksheet'];
                            if (!empty($link))
                                unlink($link);
                            $data['12th_marksheet'] = (($twelth == null) ? "" : $twelth);
                        }

                        $file4 = $this->uploadFile($userFolderPath . "/Income", 'income');
                        $income = (($file4['status'] == 1) ? $file4['data']['full_path'] : null);
                        if ($income) {
                            $link = $isExistsData['income_certificate'];
                            if (!empty($link))
                                unlink($link);
                            $data['income_certificate'] = (($income == null) ? "" : $income);
                        }

                        $file5 = $this->uploadFile($userFolderPath . "/Adharcard", 'adhar');
                        $adhar = (($file5['status'] == 1) ? $file5['data']['full_path'] : null);
                        if ($adhar) {
                            $link = $isExistsData['adhar_card'];
                            if (!empty($link))
                                unlink($link);
                            $data['adhar_card'] = (($adhar == null) ? "" : $adhar);
                        }

                        $file7 = $this->uploadFile($userFolderPath . "/Photograph", 'photograph');
                        $photograduate = (($file7['status'] == 1) ? $file7['data']['full_path'] : null);
                        if ($photograduate) {
                            $link = $isExistsData['photograph'];
                            if (!empty($link))
                                unlink($link);
                            $data['photograph'] = (($photograduate == null) ? "" : $photograduate);
                        }

                        $file8 = $this->uploadFile($userFolderPath . "/Graduate", 'graduate_certificate');
                        $graduate = (($file8['status'] == 1) ? $file8['data']['full_path'] : null);
                        if ($graduate) {
                            $link = $isExistsData['graduate_certificate'];
                            if (!empty($link))
                                unlink($link);
                            $data['graduate_certificate'] = (($graduate == null) ? "" : $graduate);
                        }


                        $update = $this->model_enrollmenttemp->update($data, $tempEnqId);

                        if ($update) {
                            $res['message'] = 'Successfully records uploaded successfully!!!.';
                            $res['status'] = true;
                        } else {
                            $res['message'] = 'Error occurred!!';
                        }
                    } else {
                        $res['message'] = 'You have already attempted!!!.';
                    }
                } else {
                    $res['message'] = 'Invalid Record!, Please try again later.';
                }
            } else {
                $res['message'] = "Please select all documents";
            }
        } else {
            $res['message'] = "All fields are mandatory!!!";
        }
        echo json_encode($res);
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

}
