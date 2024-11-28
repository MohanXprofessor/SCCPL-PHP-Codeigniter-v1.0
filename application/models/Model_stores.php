<?php 

// this class is used for Project
class Model_stores extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the active store data */
	public function getActiveStore()
	{
		$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getStoresData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM stores where id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stores order by id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
    /*
    * Code By: Akash Fulari 
    * On Date: 27-06-2024 02:24PM
    * Description: Updated for get only single
    * Otherwise it should be return null
    * Code Starts here
    * Update Code : 270620240224PM
    */
	public function getStoresDataSingle($id = null){
		if($id) {
			$sql = "SELECT * FROM stores where id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
        return null;
	}
	/*
	* Code Ends Here
    * Update Code : 270620240224PM
	*/

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('stores', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('stores', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('stores');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalStores()
	{
		$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

}