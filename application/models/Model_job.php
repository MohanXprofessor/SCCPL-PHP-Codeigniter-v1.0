<?php 

/*
* Created By: Akash K. Fulari
* On Date: 07-03-2024
*/ 

class Model_job extends CI_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getJobData($jobId = null, $addedById = null) {
		if($jobId!=null && $addedById!=null) {
			$query = $this->db->query("SELECT * FROM jobs WHERE id = ? and added_by  = ? order by id desc", array($jobId, $addedById));
			return $query->row_array();
		}
		else if($jobId!=null){
			$query = $this->db->query("SELECT * FROM jobs WHERE id  = ? order by id desc", array($jobId));
			return $query->row_array();
		}else{
		    $query = $this->db->query("SELECT * FROM jobs order by id desc");
		    return $query->result_array();
		}
		return array();
	}
	
	public function getJobDataByBranchId($branchId) {
		$query = $this->db->query("SELECT * FROM jobs WHERE branch_id  = ? order by id desc", array($branchId));
	    return $query->result_array();
	}

	public function getJobDataById($jobId) {
		if($jobId) {
			$query = $this->db->query("SELECT * FROM jobs WHERE id  = ? order by id desc", array($jobId));
			return $query->row_array();
		}
		return array();
	}

	public function getJobDataByJobId($jobId) {
		if($jobId) {
			$query = $this->db->query("SELECT * FROM jobs WHERE job_id  = ? order by id desc", array($jobId));
			return $query->row_array();
		}
		return array();
	}

	public function createJob($data = ''){
		$create = $this->db->insert('jobs', $data);
		return ($create == true) ? true : false;
	}

	public function editJob($data, $id){
		$this->db->where('id', $id);
		$update = $this->db->update('jobs', $data);
		return ($update == true) ? true : false;	
	}

	public function deleteJob($id){
		$this->db->where('id', $id);
		$delete = $this->db->delete('jobs');
		return ($delete == true) ? true : false;
	}
}