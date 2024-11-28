<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-31 20:01:18
 Last Modification Date: 2024-05-10 17:07:58
*
**/

class Model_enrollmenttemp extends CI_Model
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

		$insert = $this->db->insert('enrollment_temp', $data);

		if ($insert) {
			return true;
		} else {
			return false;
		}

	}

	public function getOrdersData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM enrollment_temp WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM enrollment_temp ORDER BY id DESC";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function fetchEnrollmentData()
	{
		$query = $this->db->query("SELECT * FROM enrollment_temp order by id desc");
		return $query->result_array();
	}
	
	public function fetchEnrollmentDataFlagWise($flag = 1)
	{
		$query = $this->db->query("SELECT * FROM enrollment_temp where isFilledData = $flag order by id desc");
		return $query->result_array();
	}
	
	public function single_student($id)
	{
		if ($id) {
			$sql = "SELECT * FROM enrollment_temp where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			return $query->result_array();
		}
	}
	
    /*
    * Code By: Akash Fulari
    * On Date: 13-07-2024 12:21PM
    * Update code: 130720241221pm
    * Code STARTS here
    */ 
	public function findByScreenTestId($screnId)
	{
		if ($screnId) {
			$sql = "SELECT * FROM enrollment_temp where screentest_id =? order by id desc";
			$query = $this->db->query($sql, $screnId);
			return $query->result_array();
		}
	}
    /*
    * Update code: 130720241221pm
    * Code ENDS here
    */ 
    
	public function remove($id)
	{
		if ($id) {

			// 4/12/19 by ramiz delete data from paid info of user 


			$this->db->where('id', $id);
			$delete = $this->db->delete('enrollment_temp');


		}
		return ($delete == true) ? true : false;
	}

	public function getJobDataByJobId($id)
	{
		//echo $id;die();
		if ($id) {
			$query = $this->db->query("SELECT * FROM enrollment_temp WHERE id  = ? order by id desc", $id);
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
			$update = $this->db->update('enrollment_temp', $data);
			return ($update == true) ? true : false;
		}
	}
	public function checkExistingUploadedData($enid)
	{
		$this->db->select('*');
		$this->db->from('enrollment_temp');
		$this->db->where('id', $enid);
		$this->db->where('isFilledData', 1); // Check if already allocated
		$query = $this->db->get();
		return $query->num_rows() > 0;
	}
}

?>