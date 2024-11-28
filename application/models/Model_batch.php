<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-31 19:29:06
 Last Modification Date: 2024-05-04 18:40:45
*
**/

class Model_batch extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getProductData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM batch where id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));

			// print_r($query);
			// die();
			return $query->row_array();
		}

		$sql = "SELECT * FROM batch ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function single_batch($id)
	{


		if ($id) {
			$sql = "SELECT * FROM batch where id =? order by id desc";
			$query = $this->db->query($sql, $id);

			return $query->row_array();
		}
		return array();
	}
	public function getBatchDataById($id)
	{
		$query = $this->db->query("SELECT * FROM batch WHERE id  = ? order by id desc", array($id));

		return $query->row_array();
	}



	public function getActiveProductData()
	{
		$sql = "SELECT * FROM batch WHERE availability = ? ORDER BY id DESC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}


	public function getcolor()
	{
		$sql = "SELECT * FROM attribute_value WHERE attribute_value_id=2 order by id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{

		if ($data) {

			$insert = $this->db->insert('batch', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('batch', $data);
			
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('batch');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM batch";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	//  find project data
	public function getStoresData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM stores where id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stores";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//find course data
	public function getBrandData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM brands WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM brands";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//find subject data
	public function getSubjectData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM 'subjectnew' WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM 'subjectnew' order by id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_batch_data($bid)
	{
		if ($bid) {
			$sql = "SELECT * FROM allocated_batch WHERE bid =? order by id desc";
			$query = $this->db->query($sql, array($bid));
			return $query->result_array();
		}

	}

	public function getBatchData()
	{
		$sql="SELECT * FROM batch";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	
	

}