<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-31 17:22:54
 Last Modification Date: 2024-05-04 12:24:09
*
**/

class Model_subjectnew extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function createSubject($data = '')
	{
		$create = $this->db->insert('subjectnew', $data);
		return ($create == true) ? true : false;
	}

	public function updateSubject($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('subjectnew', $data);
		return ($update == true) ? true : false;
	}

	public function removeSubject($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('subjectnew');
		return ($delete == true) ? true : false;
	}
	public function getSubjectData()
	{
		$query = $this->db->query("SELECT * FROM subjectnew");
		return $query->result_array();
	}
	public function fetchSubjectnewDataById($id)
	{
		$sql = "SELECT * FROM subjectnew WHERE id  = ? order by id desc";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}

	public function fetchSubjectDataById($id)
	{
		$sql = "SELECT * FROM subjectnew WHERE bid  = ? order by id desc";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}
	/**
	 * @author Akash K. Fulari
	 * @date 23-04-2023 
	 * This is new functionality for questionpaper module.
	 **/
	public function getSubjectByFacultyId($faculty_id)
	{
		$sql = "SELECT * FROM subjectnew WHERE faculty_id = ? group by id";
		$query = $this->db->query($sql, array($faculty_id));
		return $query->result_array();
	}
	public function getAllocatedBatchesByFacultyId($faculty_id)
	{
		$sql = "SELECT * FROM subjectnew WHERE faculty_id = ? group by id";
		$query = $this->db->query($sql, array($faculty_id));
		return $query->result_array();
	}

	public function getInProgressAllocatedBatchesByFacultyId($faculty_id)
	{
		$sql = "SELECT * FROM subjectnew sub INNER JOIN batch bt ON bt.id = sub.bid WHERE sub.faculty_id = ? and bt.progress <> ? group by sub.id";
		$query = $this->db->query($sql, array($faculty_id, 10));
		return $query->result_array();
	}

	public function getPastAllocatedBatchesByFacultyId($faculty_id)
	{
		$sql = "SELECT * FROM subjectnew sub INNER JOIN batch bt ON bt.id = sub.bid WHERE sub.faculty_id = ? and bt.progress = ? group by sub.id";
		$query = $this->db->query($sql, array($faculty_id, 10));
		return $query->result_array();
	}

	public function getSubjectByBatchId($bid, $faculty_id)
	{
		$sql = "SELECT * FROM subjectnew WHERE bid = ? and faculty_id = ? group by bid";
		$query = $this->db->query($sql, array($bid, $faculty_id));
		return $query->result_array();
	}

	public function getFaculty($faculty_id)
	{
		$sql = "SELECT * FROM subjectnew WHERE faculty_id = ?";
		$query = $this->db->query($sql, array($faculty_id));
		return $query->result_array();
	}
}
