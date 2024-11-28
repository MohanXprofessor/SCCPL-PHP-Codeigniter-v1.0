<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Reports';
		$this->load->model('model_reports');
		$this->load->model('model_batch');
		$this->load->model('model_stores');
		$this->load->model('model_brands');
		$this->load->model('model_users');
		$this->load->model('model_subjectnew');
	}

	/* 
	 * It redirects to the report page
	 * and based on the year, all the orders data are fetch from the database.
	 */
	public function index()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('reports/index', $this->data);
	}

	/**
	 * All views methods here
	 * On date: 21-05-2024
	 * By: Akash K Fulari
	 * */
	public function batch_wise_student()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->data['batchs'] = $this->model_batch->getProductData();

		$this->render_template('reports/batch_wise_student', $this->data);
	}

	public function batch_wise_completion()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['batchs'] = $this->model_batch->getProductData();

		$this->render_template('reports/batch_wise_completion', $this->data);
	}

	public function trainer_wise_student()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->data['trainers'] = $this->model_users->getStaffData();

		$this->render_template('reports/trainer_wise_student', $this->data);
	}
	public function total_active_student()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('reports/total_active_student', $this->data);
	}

	public function total_completed_student()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('reports/total_completed_student', $this->data);
	}

	public function project_wise_enrollment()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['projects'] = $this->model_stores->getActiveStore();

		$this->render_template('reports/project_wise_enrollment', $this->data);
	}

	public function palcement_eligible_students()
	{
		if (!in_array('viewReports', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('reports/palcement_eligible_students', $this->data);
	}

	/**
	 * All ajax methods here
	 * On date: 21-05-2024
	 * By: Akash K Fulari
	 * */
	public function fetchBatchwisedata($bid)
	{
		$result = array('data' => array());
		if ($bid) {
			$sql = "SELECT * FROM enrollment e INNER JOIN allocated_batch a ON e.id = a.enid and a.bid = $bid and e.isAllocated = 1";
			$query = $this->db->query($sql);
			$enrolls = $query->result_array();
			$i = 0;
			foreach ($enrolls as $enroll) {
				$projectData = $this->model_stores->getStoresData($enroll['project_id']);
				$courseData = $this->model_brands->getBrandData($enroll['course_id']);
				$result['data'][] = [
					$i + 1,
					$projectData['name'],
					$courseData['name'],
					$enroll['name'],
					$enroll['contact'],
					$enroll['email'],
					$enroll['address'],
					$enroll['college'],
				];
				$i++;
			}
		}

		echo json_encode(($result));
	}

	public function fetchTrainerwisedata($tid)
	{
		$result = array('data' => array());
		if ($tid) {
			$sql = "SELECT * FROM enrollment e  INNER JOIN subjectnew s ON s.faculty_id = $tid INNER JOIN allocated_batch a ON e.id = a.enid and a.bid = s.bid and e.isAllocated = 1";
			$query = $this->db->query($sql);
			$enrolls = $query->result_array();
			$i = 0;
			foreach ($enrolls as $enroll) {
				$projectData = $this->model_stores->getStoresData($enroll['project_id']);
				$courseData = $this->model_brands->getBrandData($enroll['course_id']);
				$result['data'][] = [
					$i + 1,
					$projectData['name'],
					$courseData['name'],
					$enroll['name'],
					$enroll['contact'],
					$enroll['email'],
					$enroll['address'],
					$enroll['college'],
				];
				$i++;
			}
		}

		echo json_encode(($result));
	}

	public function fetchCompletedStuentdata($status)
	{

		$result = array('data' => array());
		if ($status != "" && $status != null) {
			$sql = "SELECT * FROM enrollment e INNER JOIN batch b ON b.progress <> '100' INNER JOIN allocated_batch a ON e.id = a.enid and a.bid = b.id and e.isAllocated = 1";
			if ($status == 1)
				$sql = "SELECT * FROM enrollment e INNER JOIN batch b ON b.progress = '100' INNER JOIN allocated_batch a ON e.id = a.enid and a.bid = b.id and e.isAllocated = 1";
			$query = $this->db->query($sql);
			$enrolls = $query->result_array();
			$i = 0;
			foreach ($enrolls as $enroll) {
				$projectData = $this->model_stores->getStoresData($enroll['project_id']);
				$courseData = $this->model_brands->getBrandData($enroll['course_id']);
				$result['data'][] = [
					$i + 1,
					$projectData['name'],
					$courseData['name'],
					$enroll['name'],
					$enroll['contact'],
					$enroll['email'],
					$enroll['address'],
					$enroll['college'],
				];
				$i++;
			}
		}

		echo json_encode(($result));
	}

	public function fetchBatchwiseEnrollment($bid)
	{
		$result = array('data' => array());
		if ($bid) {
			$sql = "SELECT * FROM enrollment e INNER JOIN allocated_batch a ON e.id = a.enid and a.bid = $bid and e.isAllocated = 1";
			$query = $this->db->query($sql);
			$enrolls = $query->result_array();
			$i = 0;
			foreach ($enrolls as $enroll) {
				$projectData = $this->model_stores->getStoresData($enroll['project_id']);
				$courseData = $this->model_brands->getBrandData($enroll['course_id']);
				$result['data'][] = [
					$i + 1,
					$projectData['name'],
					$courseData['name'],
					$enroll['education'],
					$enroll['name'],
					$enroll['father_name'],
					$enroll['mother_name'],
					(($enroll['gender'] == 0) ? "Female" : (($enroll['gender'] == 1) ? "Male" : "Other")),
					$enroll['contact'],
					$enroll['address'],
					$enroll['email'],
					$enroll['city'],
					$enroll['state'],
					$enroll['annual_income'],
				];
				$i++;
			}
		}

		echo json_encode(($result));
	}

	public function fetchProjectwiseEnrollment($pid)
	{
		$result = array('data' => array());
		if ($pid) {
			$sql = "SELECT * FROM enrollment where project_id = $pid";
			$query = $this->db->query($sql);
			$enrolls = $query->result_array();
			$i = 0;
			foreach ($enrolls as $enroll) {
				$projectData = $this->model_stores->getStoresData($enroll['project_id']);
				$courseData = $this->model_brands->getBrandData($enroll['course_id']);
				$status = "<span class='label label-danger'>Batch Not Allocated</span>";
				if ($enroll['isAllocated'] == 1)
					$status = " <span class='label label-success'>Allocated to batch</span>";
				$result['data'][] = [
					$i + 1,
					$projectData['name'],
					$courseData['name'],
					$enroll['education'],
					$enroll['name'],
					$enroll['father_name'],
					$enroll['mother_name'],
					(($enroll['gender'] == 0) ? "Female" : (($enroll['gender'] == 1) ? "Male" : "Other")),
					$enroll['contact'],
					$enroll['address'],
					$enroll['email'],
					$enroll['city'],
					$enroll['state'],
					$enroll['annual_income'],
					$status,
				];
				$i++;
			}
		}

		echo json_encode(($result));
	}

	public function fetchPlacementEligibleStudents()
	{
		$result = array('data' => array());
		$sql = "SELECT * FROM enrollment e INNER JOIN batch b ON b.progress >= '75' INNER JOIN allocated_batch a ON e.id = a.enid and a.bid = b.id and e.isAllocated = 1";
		$query = $this->db->query($sql);
		$enrolls = $query->result_array();
		$i = 0;
		foreach ($enrolls as $enroll) {
			$projectData = $this->model_stores->getStoresData($enroll['project_id']);
			$courseData = $this->model_brands->getBrandData($enroll['course_id']);
			$result['data'][] = [
				($i + 1),
				$projectData['name'],
				$courseData['name'],
				$enroll['name'],
				$enroll['contact'],
				$enroll['email'],
				$enroll['address'],
				$enroll['college'],
			];
			$i++;
		}

		echo json_encode(($result));
	}

	public function fetchTotalActiveStudents()
	{
		$result = array('data' => array());
		$sql = "SELECT * FROM enrollment e INNER JOIN batch b ON b.progress < '100' INNER JOIN allocated_batch a ON e.id = a.enid and a.bid = b.id and e.isAllocated = 1";
		$query = $this->db->query($sql);
		$enrolls = $query->result_array();
		$i = 0;
		foreach ($enrolls as $enroll) {
			$projectData = $this->model_stores->getStoresData($enroll['project_id']);
			$courseData = $this->model_brands->getBrandData($enroll['course_id']);
			$result['data'][] = [
				($i + 1),
				$projectData['name'],
				$courseData['name'],
				$enroll['name'],
				$enroll['contact'],
				$enroll['email'],
				$enroll['address'],
				$enroll['college'],
			];
			$i++;
		}

		echo json_encode(($result));
	}

	/**
	 * Needs to update this thing
	 * */ 
	public function fetchBatchwiseCompletion($bid)
	{
		$result = array('data' => array());
		if ($bid) {
			$sql = "SELECT * FROM enrollment e INNER JOIN batch b ON b.progress < '100' INNER JOIN allocated_batch a ON e.id = a.enid and a.bid = b.id and e.isAllocated = 1";
			$query = $this->db->query($sql);
			$enrolls = $query->result_array();
			$i = 0;
			foreach ($enrolls as $enroll) {
				$projectData = $this->model_stores->getStoresData($enroll['project_id']);
				$courseData = $this->model_brands->getBrandData($enroll['course_id']);
				$result['data'][] = [
					($i + 1),
					$projectData['name'],
					$courseData['name'],
					$enroll['name'],
					$enroll['contact'],
					$enroll['email'],
					$enroll['address'],
					$enroll['college'],
				];
				$i++;
			}
		}

		echo json_encode(($result));
	}

}





