<?php 

class Model_screeningtest extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function create($data){
		$this->db->insert('screening_test', $data);
		$id = $this->db->insert_id();
		return ($id) ? $id : false;
	}

	public function update($data, $id){
		$this->db->where('id', $id);
		$id = $this->db->update("screening_test", $data);
		return ($id) ? $id : false;
	}

	public function delete($id){
		$this->db->where('id', $id);
		$delete = $this->db->delete('screening_test');
		return ($delete == true) ? true : false;
	}

	public function getScreeningTestDataById($id){
		$query = $this->db->query("SELECT * FROM screening_test WHERE id  = ? order by id desc", array($id));
		return $query->row_array();
	}
	
	public function getScreeningTestData(){
		$query = $this->db->query("SELECT * FROM screening_test order by id desc");
		return $query->result_array();
	}
	public function getScreeningTestDataByEnquiryId($enqId){
		$query = $this->db->query("SELECT * FROM screening_test WHERE enquiry_id  = ? order by id desc", array($enqId));
		return $query->row_array();
	}

}