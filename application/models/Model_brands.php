<?php
// this class used for Course
class Model_brands extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	public function getActiveBrands()
	{
		$sql = "SELECT * FROM brands WHERE active  = ? order by id desc";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getBrandData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM brands WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM brands order by id desc";
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
    public function getBrandDataSingle($id = null){
		if ($id) {
			$sql = "SELECT * FROM brands WHERE id  = ? order by id desc";
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
		if ($data) {
			$insert = $this->db->insert('brands', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if ($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('brands', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('brands');
			return ($delete == true) ? true : false;
		}
	}

	/*
	 * Created By: Akash K. Fulari
	 * On Date: 04-05-2024
	 */
	public function loadCoursesByProjectId($pid)
	{
		if ($pid) {
			$sql = "SELECT * FROM brands WHERE active = ? and project_id  = ? order by id desc";
			$query = $this->db->query($sql, array(1, $pid));
			return $query->result_array();
		}
		return array();
	}
}