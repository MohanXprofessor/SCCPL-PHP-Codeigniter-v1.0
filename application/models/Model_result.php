<?php 

/*
* Created By: Akash K. Fulari
* On Date: 22-04-2024
*/ 

class Model_result extends CI_Model
{
	public function __construct(){
		parent::__construct();
	}
	
	public function getResultById($id){
	    $query = $this->db->query("SELECT * FROM results WHERE id  = ? order by id desc", array($id));
		return $query->row_array();   
	}
	public function isExists($id){
	    $query = $this->db->query("SELECT * FROM results WHERE id  = ? order by id desc", array($id));
		return $query->row_array();   
	}
	public function getResultByDocumentId($qid){
	    $query = $this->db->query("SELECT * FROM results WHERE document_id  = ? order by id desc", array($qid));
		return $query->result_array();   
	}

	public function createResult($data = '')
	{
		$create = $this->db->insert('results', $data);
		return ($create == true) ? true : false;
	}

	public function updateResult($data, $id){
		$this->db->where('id', $id);
		$update = $this->db->update('results', $data);
		return ($update == true) ? true : false;	
	}

	public function deleteResults($id){
		$this->db->where('id', $id);
		$delete = $this->db->delete('results');
		return ($delete == true) ? true : false;
	}
}