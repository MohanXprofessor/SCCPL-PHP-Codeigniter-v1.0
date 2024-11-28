<?php

class Model_attendance extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function create($data)
	{
		$this->db->insert('attendance', $data);
		$id = $this->db->insert_id();
		return ($id) ? $id : false;
	}

	public function update($data, $id)
	{
		$this->db->where('id', $id);
		$id = $this->db->update("attendance", $data);
		return ($id) ? $id : false;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('attendance');
		return ($delete == true) ? true : false;
	}

	public function getAttendanceData($id = null)
	{
		if ($id != null) {
			$sql = "SELECT * FROM attendance where id = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM attendance ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getAttendanceDataByUserId($user_id)
	{
		$sql = "SELECT * FROM attendance where user_id = ? order by id desc";
		$query = $this->db->query($sql, array($user_id));
		return $query->result_array();
	}

	public function getAttendanceDataByUserIdAndBatch_id($user_id, $batch_id)
	{
		$sql = "SELECT * FROM attendance where user_id = ? and batch_id = ? order by id desc";
		$query = $this->db->query($sql, array($user_id, $batch_id));
		return $query->result_array();
	}

	public function getAttendanceDataById($event_id)
	{
		$sql = "SELECT * FROM attendance where id  = ? order by id desc";
		$query = $this->db->query($sql, array($event_id));
		return $query->result_array();
	}

	public function isAttendanceExists($id, $date)
	{
		$sql = "SELECT * FROM `attendance` where `user_id` = ? and `date`  = ? order by id desc";
		$query = $this->db->query($sql, array($id, $date));
		return $query->row_array();
	}

	public function getAttendanceUIDDateAndBID($user_id, $date, $batch_id = null)
	{
		if ($user_id != null && $date != null && $batch_id != null) {
			$sql = "SELECT * FROM `attendance` where `user_id` = ? and `batch_id` = ? and `date`  = ? order by id desc";
			$query = $this->db->query($sql, array($user_id, $batch_id, $date));
			return $query->row_array();
		}
		else{
			$sql = "SELECT * FROM `attendance` where `user_id` = ? and `date`  = ? order by id desc";
			$query = $this->db->query($sql, array($user_id, $date));
			return $query->row_array();
		}
	}

	public function getFirstAttendedDate($uid){
		$sql = "SELECT MIN(`date`) as attended_date FROM `attendance` where `user_id`  = ? order by id desc";
		$query = $this->db->query($sql, array($uid));
		return $query->row_array();
	}
}