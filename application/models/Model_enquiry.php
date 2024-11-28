<?php

class Model_enquiry extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function create($data)
	{
		$this->db->insert('enquiry', $data);
		$id = $this->db->insert_id();
		return ($id) ? $id : false;
	}

	public function update($data, $id)
	{
		$this->db->where('id', $id);
		$id = $this->db->update("enquiry", $data);
		return ($id) ? $id : false;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('enquiry');
		return ($delete == true) ? true : false;
	}

	public function getEnquiryDataById($id)
	{
		$query = $this->db->query("SELECT * FROM enquiry WHERE id  = ? order by id desc", array($id));
		return $query->row_array();
	}

	public function getEnquiryDataByIdForScreeningTest($id)
	{
		$query = $this->db->query("SELECT * FROM enquiry WHERE id = ? and isTestSubmited  = ? order by id desc", array($id, 0));
		return $query->row_array();
	}

	public function getEnquiryData()
	{
		$query = $this->db->query("SELECT * FROM enquiry order by id desc");
		return $query->result_array();
	}

	public function getFilteredEnquiryData($startDate, $endDate, $project_id, $course_id, $counseller_id)
	{
		if ($startDate && $endDate) {
			if (!empty($project_id) && !empty($course_id) && !empty($counseller_id)) {
				$query = $this->db->query("SELECT * FROM enquiry where project_id = '$project_id' and course_id = '$course_id' and counseller_id = '$counseller_id' and created_at between '$startDate' and '$endDate' order by id desc");
				return $query->result_array();
			} else if (!empty($project_id) && !empty($course_id)) {
				$query = $this->db->query("SELECT * FROM enquiry where project_id = '$project_id' and course_id = '$course_id' and created_at between '$startDate' and '$endDate' order by id desc");
				return $query->result_array();
			} else if (!empty($project_id) && !empty($counseller_id)) {
				$query = $this->db->query("SELECT * FROM enquiry where project_id = '$project_id' and counseller_id = '$counseller_id' and created_at between '$startDate' and '$endDate' order by id desc");
				return $query->result_array();
			} else if (!empty($project_id)) {
				$query = $this->db->query("SELECT * FROM enquiry where project_id = '$project_id' and created_at between '$startDate' and '$endDate' order by id desc");
				return $query->result_array();
			} else if (!empty($course_id)) {
				$query = $this->db->query("SELECT * FROM enquiry where course_id = '$course_id' and created_at between '$startDate' and '$endDate' order by id desc");
				return $query->result_array();
			} else if (!empty($counseller_id)) {
				$query = $this->db->query("SELECT * FROM enquiry where counseller_id = '$counseller_id' and created_at between '$startDate' and '$endDate' order by id desc");
				return $query->result_array();
			}
		} else {
			return array();
		}
	}

	public function getFilteredEnquiryDataById($id, $startDate, $endDate, $project_id, $course_id, $counseller_id)
	{
		$query = $this->db->query("SELECT * FROM enquiry where id = '$id' and project_id = '$project_id' and course_id = '$course_id' and counseller_id = '$counseller_id' and created_at between '$startDate' and '$endDate' order by id desc");
		return $query->result_array();
	}

}