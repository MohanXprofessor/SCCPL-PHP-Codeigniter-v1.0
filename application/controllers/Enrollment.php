<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Enrollment extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Enrollment';

		$this->load->model('model_enrollment');
		$this->load->model('model_enrollmenttemp');
		$this->load->model('model_screeningtest');
		$this->load->model('model_enquiry');
		$this->load->model('model_batch');
		$this->load->model('model_brands');
		$this->load->model('model_subjectnew');
		$this->load->model('model_allocated_batch');
	}

	/*
	 * Fetches the orders data from the orders table 
	 * this function is called from the datatable ajax function
	 */
	public function fetchOrdersData()
	{

		$result = array('data' => array());

		$data = $this->model_enrollment->fetchEnrollmentData();

		$i = 0;
		foreach ($data as $key => $value) {
			//echo $value['id'];die();
			$pdata = $this->model_stores->getStoresData($value['project_id']);
			$cdata = $this->model_brands->getBrandData($value['course_id']);
			$buttons = "";
			if ($value['isAllocated'] == 0)

				$buttons .= ' <button class="btn btn-sm btn-info d-block" data-toggle="modal" data-target="#addModal" onclick="createFunc(' . $value['id'] . ')">Allocate Batch</button>';

			$buttons .= '<a href="' . base_url('enrollment/print_form/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			$buttons .= ' <a href="' . base_url('enrollment/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';





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
	 * Code added by: Akash Fulari On Date: 06-06-2024 05:25PM
	 * */
	public function fetchOrderRequestsData()
	{

		$result = array('data' => array());
		$data = $this->model_enrollmenttemp->fetchEnrollmentData();
		$i = 0;
		foreach ($data as $key => $value) {
			//echo $value['id'];die();
			$pdata = $this->model_stores->getStoresData($value['project_id']);
			$cdata = $this->model_brands->getBrandData($value['course_id']);
			$buttons = "";
			if ($value['isFilledData'] == 1)
				$buttons .= ' <a href="' . base_url('enrollment/confirmEnrollement/' . $value['id']) . '" class="btn btn-sm btn-success m-1"><i class="fa fa-check"></i> Accept</a>';
			$buttons .= '<a href="' . base_url('enrollment/viewRequestDetails/' . $value['id']) . '" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>';
			$buttons .= ' <button type="button" class="btn btn-sm btn-danger" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

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
				(($value['isFilledData'] == 1) ? "<label class='label label-success text-light'>Data Filled</label>" : "<label class='label label-warning text-light'>Pending</label>"),
				$buttons
			);
			$i++;
		}
		echo json_encode($result);
	}

	public function allocate_batch()
	{
		$enid = $this->input->post('enid');
		$batch_id = $this->input->post('batch_id');
		$existingAllocation = $this->model_enrollment->checkExistingAllocation($enid);
		//  print_r($enid);die();
		if ($existingAllocation == $enid) {
			$response['success'] = false;
			$response['messages'] = "Enrollment ID is already allocated to a batch.";
			echo json_encode($response);
			return;
		} else {
			$response = array();
			$en_data = $this->model_enrollment->insertEnrollmentDataById($enid, $batch_id);
			if ($en_data == true) {
				$data = array(
					"isAllocated" => 1
				);
				$this->model_enrollment->update($data, $enid);
				$response['success'] = true;
				$response['en_data'] = $en_data;
				$response['messages'] = "Batch successfully allocated";
			} else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while inserting the information";
			}
		}
		echo json_encode($response);
	}

	/**
	 * Code updated By: Akash K. Fulari
	 * On Date: 06-05-2024
	 * As per: Raj Kolhe Sir
	 * Description:
	 * Here 2 file removed peremnently(Cast Certificate, Leaving Certificate)
	 * And removed madatory file fields
	 * */
	public function create($screenTestId)
	{

		if (!in_array('createOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Create Enquiry';
		if ($screenTestId) {
			//$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
			//$this->form_validation->set_rules('customer_gst', 'Email', 'trim|required|is_unique[orders.customer_gst]');

			$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
			$this->form_validation->set_rules('name', 'name', 'trim|required');
			$this->form_validation->set_rules('father_name', 'father_name', 'trim|required');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
			$this->form_validation->set_rules('address', 'address', 'trim|required');
			$this->form_validation->set_rules('tenth', ' 12th', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
			$this->form_validation->set_rules('contact', 'contact', 'trim|required|numeric');
			$this->form_validation->set_rules('twelth', '12th', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
			$this->form_validation->set_rules('graduation', 'graduation', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
			$this->form_validation->set_rules('graduation_passing', 'graduation passing', 'trim|required');
			$this->form_validation->set_rules('admission', 'admission', 'trim|required');
			$this->form_validation->set_rules('annual_income', 'annual_income', 'trim|required|numeric');
			$this->form_validation->set_rules('state', 'state', 'trim|required|alpha');
			$this->form_validation->set_rules('adhar_no', 'adhar', 'trim|required|numeric');

			if ($this->form_validation->run() == true) {

				//$bill_no = 'BILPR-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
				//$courses=implode(',',$this->input->post('sku'));
				$data = array(
					'project_id' => $this->input->post('project_id'),
					'course_id' => $this->input->post('course_id'),
					'name' => $this->input->post('name'),
					'father_name' => $this->input->post('father_name'),
					'mother_name' => $this->input->post('mother_name'),
					'gender' => $this->input->post('gender'),
					'address' => $this->input->post('address'),
					'contact' => $this->input->post('contact'),
					'email' => $this->input->post('email'), //instead opf email
					'college' => $this->input->post('college_name'),
					'education' => $this->input->post('education'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'adhar' => $this->input->post('adhar_no'),
					'10th' => $this->input->post('tenth'),
					'12th' => $this->input->post('twelth'),
					'graduation' => $this->input->post('graduation'),
					'graduation_passing' => $this->input->post('graduation_passing'),
					'admission' => $this->input->post('admission'),
					'annual_income' => $this->input->post('annual_income'),
				);
				$userFolderPath = "assets/uploads/" . $this->userData['firstname'];

				if ($this->validateFormFile("tenth_certificate")) {
					$file2 = $this->uploadFile($userFolderPath . "/Tenth", 'tenth_certificate');
					$tenth = (($file2['status'] == 1) ? $file2['data']['full_path'] : null);
					if ($tenth)
						$data['10th_marksheet'] = $tenth;
				}

				if ($this->validateFormFile("twelth_certificate")) {
					$file3 = $this->uploadFile($userFolderPath . "/Twelth", 'twelth_certificate');
					$twelth = (($file3['status'] == 1) ? $file3['data']['full_path'] : null);
					if ($twelth)
						$data['12th_marksheet'] = $twelth;
				}

				if ($this->validateFormFile("income")) {
					$file4 = $this->uploadFile($userFolderPath . "/Income", 'income');
					$income = (($file4['status'] == 1) ? $file4['data']['full_path'] : null);
					if ($income)
						$data['income_certificate'] = $income;
				}

				if ($this->validateFormFile("adhar")) {
					$file5 = $this->uploadFile($userFolderPath . "/Adharcard", 'adhar');
					$adhar = (($file5['status'] == 1) ? $file5['data']['full_path'] : null);
					if ($adhar)
						$data['adhar_card'] = $adhar;
				}

				if ($this->validateFormFile("photograph")) {
					$file7 = $this->uploadFile($userFolderPath . "/Photograph", 'photograph');
					$photograduate = (($file7['status'] == 1) ? $file7['data']['full_path'] : null);
					if ($photograduate)
						$data['photograph'] = $photograduate;
				}

				if ($this->validateFormFile("graduate_certificate")) {
					$file8 = $this->uploadFile($userFolderPath . "/Graduate", 'graduate_certificate');
					$graduate = (($file8['status'] == 1) ? $file8['data']['full_path'] : null);
					if ($graduate)
						$data['graduate_certificate'] = $graduate;
				}

				$order_id = $this->model_enrollment->create($data);
				if ($order_id) {
					$this->model_screeningtest->update(array("isEnrolled" => 1), $screenTestId);

					$this->session->set_flashdata('success', 'Successfully created');
					redirect('enrollment/index', 'refresh');
				} else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('enrollment/create/', 'refresh');
				}
			} else {

				$stData = $this->model_screeningtest->getScreeningTestDataById($screenTestId);
				$enqData = $this->model_enquiry->getEnquiryDataById($stData['enquiry_id']);

				$this->data['edata'] = $enqData;

				$this->render_template('enrollment/create', $this->data);
			}
		} else {
			// $this->session->set_flashdata('errors', 'Invalid screening test record!!');
			$this->session->set_flashdata('error', 'Please Select document files!!');
			redirect('screeningtest/manage', 'refresh');
		}
	}

	/**
	 * Code updated By: Akash Fulari
	 * On Date: 06-05-2024
	 * As per: Raj Kolhe Sir
	 * Description:
	 * Here 2 file removed peremnently(Cast Certificate, Leaving Certificate)
	 * And removed madatory file fields
	 * */
	public function update($id)
	{

		if (!in_array('updateOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if (!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Enrollment';

		$this->form_validation->set_rules('project_id', 'Project Id', 'trim|required');
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('father_name', 'father_name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('address', 'address', 'trim|required');
		$this->form_validation->set_rules('tenth', ' 10th', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
		$this->form_validation->set_rules('contact', 'contact', 'trim|required');
		$this->form_validation->set_rules('twelth', '12th', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
		$this->form_validation->set_rules('graduation', 'graduation', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
		$this->form_validation->set_rules('graduation_passing', 'graduation_passing', 'trim|required');
		$this->form_validation->set_rules('admission', 'admission', 'trim|required');
		$this->form_validation->set_rules('annual_income', 'annual_income', 'trim|required');
		$this->form_validation->set_rules('state', 'state', 'trim|required');
		$this->form_validation->set_rules('adhar_no', 'adhar', 'trim|required');



		if ($this->form_validation->run() == true) {
			$isExistsData = $this->model_enrollment->getOrdersData($id);
			if ($isExistsData) {
				$data = array(
					'project_id' => $this->input->post('project_id'),
					'course_id' => $this->input->post('course_id'),
					'name' => $this->input->post('name'),
					'father_name' => $this->input->post('father_name'),
					'gender' => $this->input->post('gender'),
					'address' => $this->input->post('address'),
					'contact' => $this->input->post('contact'),
					'email' => $this->input->post('email'),
					'college' => $this->input->post('college'),
					'admission' => $this->input->post('admission'),
					'education' => $this->input->post('education'),
					'annual_income' => $this->input->post('annual_income'),
					'state' => $this->input->post('state'),
					'10th' => $this->input->post('tenth'),
					'12th' => $this->input->post('twelth'),
					'graduation_passing' => $this->input->post('graduation_passing'),
					'graduation' => $this->input->post('graduation'),
					'adhar' => $this->input->post('adhar_no'),
				);

				$userFolderPath = "assets/uploads/" . $this->userData['firstname'];

				if ($this->validateFormFile("tenth_certificate")) {
					$file2 = $this->uploadFile($userFolderPath . "/Tenth", 'tenth_certificate');
					$tenth = (($file2['status'] == 1) ? $file2['data']['full_path'] : null);
					if ($tenth) {
						$link = $isExistsData['10th_marksheet'];
						if (!empty($link))
							unlink($link);
						$data['10th_marksheet'] = $tenth;
					}
				}

				if ($this->validateFormFile("twelth_certificate")) {
					$file3 = $this->uploadFile($userFolderPath . "/Twelth", 'twelth_certificate');
					$twelth = (($file3['status'] == 1) ? $file3['data']['full_path'] : null);
					if ($twelth) {
						$link = $isExistsData['12th_marksheet'];
						if (!empty($link))
							unlink($link);
						$data['12th_marksheet'] = $twelth;
					}
				}

				if ($this->validateFormFile("income")) {
					$file4 = $this->uploadFile($userFolderPath . "/Income", 'income');
					$income = (($file4['status'] == 1) ? $file4['data']['full_path'] : null);
					if ($income) {
						$link = $isExistsData['income_certificate'];
						if (!empty($link))
							unlink($link);
						$data['income_certificate'] = $income;
					}
				}

				if ($this->validateFormFile("adhar")) {
					$file5 = $this->uploadFile($userFolderPath . "/Adharcard", 'adhar');
					$adhar = (($file5['status'] == 1) ? $file5['data']['full_path'] : null);
					if ($adhar) {
						$link = $isExistsData['adhar_card'];
						if (!empty($link))
							unlink($link);
						$data['adhar_card'] = $adhar;
					}
				}

				if ($this->validateFormFile("photograph")) {
					$file7 = $this->uploadFile($userFolderPath . "/Photograph", 'photograph');
					$photograduate = (($file7['status'] == 1) ? $file7['data']['full_path'] : null);
					if ($photograduate) {
						$link = $isExistsData['photograph'];
						if (!empty($link))
							unlink($link);
						$data['photograph'] = $photograduate;
					}
				}

				if ($this->validateFormFile("graduate_certificate")) {
					$file8 = $this->uploadFile($userFolderPath . "/Graduate", 'graduate_certificate');
					$graduate = (($file8['status'] == 1) ? $file8['data']['full_path'] : null);
					if ($graduate) {
						$link = $isExistsData['graduate_certificate'];
						if (!empty($link))
							unlink($link);
						$data['graduate_certificate'] = $graduate;
					}
				}

				$update = $this->model_enrollment->update($data, $id);

				if ($update) {
					$this->session->set_flashdata('success', 'Successfully updated');
					redirect('enrollment/viewEnrollment', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('enrollment/update/' . $id, 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid Record!, Please try again later.');
				redirect('enrollment/update/' . $id, 'refresh');
			}
		} else {
			if ($id) {
				$this->data['enrollment'] = $this->model_enrollment->getJobDataByJobId($id);
				$this->render_template('enrollment/edit', $this->data);
			} else {
				$this->render_template('enrollment/index', $this->data);
			}
		}
	}

	public function viewEnrollment()
	{
		$this->render_template('enrollment/index', $this->data);
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


	public function remove()
	{
		if (!in_array('deleteOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$order_id = $this->input->post('order_id');

		$response = array();
		if ($order_id) {
			$delete = $this->model_enrollment->remove($order_id);
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

	/**
	 * Code added by: Akash Fulari On Date: 06-06-2024 05:39PM
	 * */
	public function removeRequest()
	{
		if (!in_array('deleteOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$order_id = $this->input->post('order_id');

		$response = array();
		if ($order_id) {
			$delete = $this->model_enrollmenttemp->remove($order_id);
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

	public function print_form($id)
	{

		$this->data['page_title'] = 'Update Enrollment';

		$data['h'] = $this->model_enrollment->single_student($id);

		$this->load->view('templates/header');

		$this->load->view("enrollment/studentinfo", $data);
	}

	/**
	 * Code added by: Akash Fulari On Date: 07-06-2024 02:20PM
	 * */
	public function viewRequestDetails($temp_enrollid)
	{

		$this->data['page_title'] = 'View Enrollment Request Details';

		$data['h'] = $this->model_enrollmenttemp->single_student($temp_enrollid);

		$this->load->view('templates/header');

		$this->load->view("enrollment/requestinfo", $data);
	}
	public function index()
	{
		if (!in_array('viewOrder', $this->permission)) {

			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Completed List';
		$this->render_template('enrollment/index', $this->data);
	}

	/**
	 * Code added by: Akash Fulari On Date: 07-06-2024 02:20PM
	 * */
	public function enrollment_requests()
	{

		if (!in_array('viewOrder', $this->permission)) {

			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Manage Enrollment Requests';
		$this->render_template('enrollment/requests', $this->data);
	}

	/**
	 * Code updated By: Akash K. Fulari
	 * On Date: 10-05-2024
	 * As per: Raj Kolhe Sir
	 * Description:
	 * Here I created method for to confirm the temporary enrollment
	 * For student enrollement request data get store into enrollement table
	 * CODE STARTS HERE: 10052024
	 * */
	public function confirmEnrollement($tmpEnqId)
	{
		if ($tmpEnqId) {
			$isExistsData = $this->model_enrollmenttemp->getOrdersData($tmpEnqId);
			if ($isExistsData) {
				$data = array(
					'project_id' => $isExistsData['project_id'],
					'course_id' => $isExistsData['course_id'],
					'name' => $isExistsData['name'],
					'father_name' => $isExistsData['father_name'],
					'mother_name' => $isExistsData['mother_name'],
					'gender' => $isExistsData['gender'],
					'address' => $isExistsData['address'],
					'contact' => $isExistsData['contact'],
					'email' => $isExistsData['email'],
					'college' => $isExistsData['college'],
					'education' => $isExistsData['education'],
					'city' => $isExistsData['city'],
					'state' => $isExistsData['state'],
					'adhar' => $isExistsData['adhar_no'],
					'10th' => $isExistsData['10th'],
					'12th' => $isExistsData['12th'],
					'graduation' => $isExistsData['graduation'],
					'graduation_passing' => $isExistsData['graduation_passing'],
					'admission' => $isExistsData['admission'],
					'annual_income' => $isExistsData['annual_income'],
					'10th_marksheet' => $isExistsData['10th_marksheet'],
					'12th_marksheet' => $isExistsData['12th_marksheet'],
					'income_certificate' => $isExistsData['income_certificate'],
					'adhar_card' => $isExistsData['adhar_card'],
					'photograph' => (($isExistsData['photograph'] == null) ? "" : $isExistsData['photograph']),
					'graduate_certificate' => $isExistsData['graduate_certificate']
				);

				$order_id = $this->model_enrollment->create($data);
				if ($order_id) {
					$this->model_enrollmenttemp->remove($tmpEnqId);
					$this->model_screeningtest->update(array("isEnrolled" => 1), $isExistsData['screenTestId']);
					$this->session->set_flashdata('success', 'Successfully Enrollement Created');
				} else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
				}
			}
		}
		redirect('enrollment/enrollment_requests', 'refresh');
	}
	/**
	 * CODE STARTS HERE: 10052024
	 */

	/**
	 * Code added by: Akash Fulari On Date: 07-06-2024 02:20PM
	 * */
	public function loadcountEnrollmentCount()
	{
		$data = $this->model_enrollmenttemp->fetchEnrollmentDataFlagWise();
		echo sizeof($data);
	}
	/**
	 * CODE STARTS HERE: 10052024
	 */
	public function isActive()
	{
		$result = array('data' => array());

		$data = $this->model_enrollment->getEnrollement();

		foreach ($data as $value) {
			$projectData = $this->model_stores->getStoresData($value['project_id']);
			$courseData = $this->model_brands->getBrandData($value['course_id']);

			//$buttons .= '<a href="' . base_url('enrollment/print_form/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			// $buttons .= ' <a href="' . base_url('enrollment/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			// $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			if ($projectData && $courseData) {
				if ($value['isAllocated'] == 1) {
					$result['data'][] = array(
						$projectData['name'],
						$courseData['name'],
						$value['name'],
						$value['father_name'],
						$value['email'],
						$value['contact'],
						$value['address'],
						$value['college'],
					);
				}
			} else {
				// Handle the case where data retrieval fails
				$result['data'][] = array(
					'Error' => 'Project or Course data not found for enrollment ID ' . $value['id']
				);
			}
		}

		echo json_encode($result);
	}

	public function fetchTrainerWiseStudent()
	{
		$result = array('data' => array());

		// Use input method correctly, assuming 'counseller_id' is from POST or GET
		$faculty_id = $this->input->get('counseller_id'); // or $this->input->post('counseller_id');

		// Get faculty data
		$sub_data = $this->model_subjectnew->getFaculty($faculty_id);

		// Initialize index
		$i = 0;

		// Iterate through each subject data
		foreach ($sub_data as $value) {
			// Get allocated enrollment IDs
			$allocated_data = $this->model_allocated_batch->getEnrollmentId($value['bid']);

			// Check if allocated_data is not empty
			if (!empty($allocated_data)) {
				foreach ($allocated_data as $alloc) {
					// Get enrollment data
					$en_data = $this->model_enrollment->getEnrollments($alloc['enid']);

					// Check if enrollment data is allocated
					if ($en_data['isAllocated'] == 1) {
						// Populate result data
						$result['data'][$i] = array(
							'name' => $en_data['name'],
							'father_name' => $en_data['father_name'],
							'mother_name' => $en_data['mother_name'],
							'email' => $en_data['email'],
							'contact' => $en_data['contact'],
							'address' => $en_data['address'],
							'college' => $en_data['college'],
						);
						// Increment index
						$i++;
					}
				}
			}
		}

		// Return the result
		echo json_encode($result);
	}
}
