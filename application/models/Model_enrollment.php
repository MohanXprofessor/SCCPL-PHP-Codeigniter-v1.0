<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-31 20:01:18
 Last Modification Date: 2024-05-09 17:03:35
*
**/

class Model_enrollment extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');

		$this->load->model('model_users');
		$this->load->model('model_groups');
	}


	public function create($data)
	{
		//$user_id = $this->session->userdata('id');

		$insert = $this->db->insert('enrollment', $data);

		if ($insert) {
			return true;
		} else {
			return false;
		}
	}

	public function getOrdersData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM enrollment WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM enrollment ORDER BY id DESC";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function insertEnrollmentDataById($enid, $batch_id)
	{

		if (!$enid || !$batch_id) {
			return false;
		}
		$data = array(
			'enid' => $enid,
			'bid' => $batch_id
		);
		$insert = $this->db->insert('allocated_batch', $data);

		return $insert;
	}

	public function fetchEnrollmentData()
	{
		$query = $this->db->query("SELECT * FROM enrollment order by id desc");
		return $query->result_array();
	}
	public function single_student($id)
	{
		if ($id) {
			$sql = "SELECT * FROM enrollment where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			return $query->result_array();
		}
	}

	public function remove($id)
	{
		if ($id) {

			// 4/12/19 by ramiz delete data from paid info of user 


			$this->db->where('id', $id);
			$delete = $this->db->delete('enrollment');
		}
		return ($delete == true) ? true : false;
	}

	public function getJobDataByJobId($id)
	{
		//echo $id;die();
		if ($id) {
			$query = $this->db->query("SELECT * FROM enrollment WHERE id  = ? order by id desc", $id);
			// print_r($query);
			// die();
			return $query->row_array();
		}
		return array();
	}

	public function update($data, $id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$update = $this->db->update('enrollment', $data);
			return ($update == true) ? true : false;
		}
	}

	public function projectData($enid)
	{
		if ($enid) {
			$query = $this->db->query("SELECT * FROM stores WHERE id  = ? order by id desc", $enid);
			// print_r($query);
			// die();
			return $query->row_array();
		}
		return array();
	}
	public function checkExistingAllocation($enid)
	{
		$this->db->select('*');
		$this->db->from('enrollment');
		$this->db->where('id', $enid);
		$this->db->where('isAllocated', 1); // Check if already allocated
		$query = $this->db->get();
		return $query->num_rows() > 0;
	}

	public function getEnrollement()
	{
		$sql = "SELECT * FROM enrollment";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getEnrollmentById($enid)
	{
		// Assuming student data is stored in 'enrollments' table
		$this->db->where('id', $enid);
		$query = $this->db->get('enrollment');
		return $query->row_array();
	}
}
