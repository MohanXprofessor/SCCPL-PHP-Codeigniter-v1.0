<?php 

/*
* Created By: Akash K. Fulari
* On Date: 07-03-2024
*/ 

class Model_appliedjobs extends CI_Model
{
	public function __construct(){
		parent::__construct();
	}
	
	public function getAppliedJobById($id){
	    $query = $this->db->query("SELECT * FROM applied_jobs WHERE id = ? order by id desc", array($id));
		return $query->row_array();   
	}

	public function getAppliedJobData($jobId = null, $studentId = null) {
		if($jobId!=null && $studentId!=null) {
			$query = $this->db->query("SELECT * FROM applied_jobs WHERE job_id = ? and student_id = ? order by id desc", array($jobId, $studentId));
			return $query->result_array();
		}
		else if($jobId!=null){
			$query = $this->db->query("SELECT * FROM applied_jobs WHERE job_id = ? order by id desc", array($jobId));
			return $query->result_array();
		}else{
		    $query = $this->db->query("SELECT * FROM applied_jobs order by id desc");
		    return $query->row_array();
		}
		return array();
	}
	public function getAppliedJobDataByJobIdAndBranchId($jobId, $branchId) {
		$query = $this->db->query("SELECT * FROM applied_jobs WHERE job_id = ? and branch_id = ? order by id desc", array($jobId, $branchId));
		return $query->result_array();
	}
	
	public function getAppliedJobDataByBranchIdAndStatus($branchId, $statusCode = null) {
	    if($branchId && $statusCode!=null)
		    $query = $this->db->query("SELECT * FROM applied_jobs WHERE branch_id = ? and status = ? order by id desc", array($branchId, $statusCode));
		else
		    $query = $this->db->query("SELECT * FROM applied_jobs WHERE branch_id = ? order by id desc", array($branchId));
		return $query->result_array();
	}

	public function getAppliedJobByJobData($jobId) {
		$query = $this->db->query("SELECT * FROM applied_jobs WHERE id = ? order by id desc", array($jobId));
		return $query->result_array();
	}
	
	public function getAppliedJobDataByStudentId($studentId) {
		if($studentId) {
			$query = $this->db->query("SELECT * FROM applied_jobs WHERE student_id = ? order by id desc", array($studentId));
			return $query->result_array();
		}
		return array();
	}
	
	public function getAppliedJobDataByStatus($status, $jobid = null, $student_id = null) {
		if(in_array($status, array(-1,0,1,2)) && $jobid!=null && $student_id!=null) {
			$query = $this->db->query("SELECT * FROM applied_jobs WHERE status = ? and job_id = ? and student_id = ? order by id desc", array($status, $jobid, $student_id));
			return $query->result_array();
		}
		else if(in_array($status, array(-1,0,1,2)) && $jobid!=null) {
			$query = $this->db->query("SELECT * FROM applied_jobs WHERE status = ? and job_id = ? order by id desc", array($status, $jobid));
			return $query->result_array();
		}
		else if(in_array($status,  array(-1,0,1,2)) && $student_id) {
			$query = $this->db->query("SELECT * FROM applied_jobs WHERE status = ? and student_id = ? order by id desc", array($status, $student_id));
			return $query->result_array();
		}
		else if(in_array($status,  array(-1,0,1,2))) {
			$query = $this->db->query("SELECT * FROM applied_jobs WHERE status = ? order by id desc", array($status));
			return $query->result_array();
		}
		return array();
	}
	
	public function isStudentJoined($studentId){
	    if($studentId){
			$query = $this->db->query("SELECT * FROM applied_jobs WHERE status = 2 and student_id = ? order by id desc", array($studentId));
			$data = $query->result_array();
			return ($data!=null);
	    }else
	        return false;
	}

	public function applyJob($data = ''){
		$create = $this->db->insert('applied_jobs', $data);
		return ($create == true) ? true : false;
	}

	public function editJob($data, $id){
		$this->db->where('id', $id);
		$update = $this->db->update('applied_jobs', $data);
		return ($update == true) ? true : false;	
	}

	public function deleteJob($id){
		$this->db->where('id', $id);
		$delete = $this->db->delete('applied_jobs');
		return ($delete == true) ? true : false;
	}
}