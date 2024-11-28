<?php

/*
 * Created By: Akash K. Fulari
 * On Date: 22-04-2024
 */

class Model_documents extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function createDocument($data = '')
	{
		$create = $this->db->insert('documents', $data);
		return ($create == true) ? true : false;
	}

	public function getDocumentById($id)
	{
		$query = $this->db->query("SELECT * FROM documents WHERE id  = ? order by id desc", array($id));
		return $query->row_array();
	}
	public function isItCreatedAlready($bid, $sid, $type)
	{
		$query = $this->db->query("SELECT * FROM documents WHERE batch_id = ? and subject_id = ? and type  = ? order by id desc", array($bid, $sid, $type));
		return $query->row_array();
	}
	public function isExists($qid)
	{
		$query = $this->db->query("SELECT * FROM documents WHERE id  = ? order by id desc", array($qid));
		return $query->row_array();
	}

	public function getDocuments()
	{
		$query = $this->db->query("SELECT * FROM documents order by id desc");
		return $query->result_array();
	}

	public function getDocumentsByUserId($user_id)
	{
		$query = $this->db->query("SELECT * FROM documents where added_by  = ? and `type` =1 or `type`=2 or `type`=3
				or `type`=4 or `type`= 5 or `type`= 6 or `type`=7
		 order by id desc", array($user_id));
		return $query->result_array();
	}

	//public function getDocumentsByUserId($user_id)
	// {
	// 	$query = $this->db->query("SELECT * FROM documents where added_by  = ? order by id desc", array($user_id));
	// 	return $query->result_array();
	// }

	public function updateDocument($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('documents', $data);
		return ($update == true) ? true : false;
	}

	public function deleteDocument($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('documents');
		return ($delete == true) ? true : false;
	}

	

	public function getProjectByUserBatchAndType($bid,$uid,$type)
	{
		$query = $this->db->query("SELECT * FROM documents where batch_id=? and added_by  = ? and `type`= ? order by id desc", array($bid,$uid,$type));
		return $query->result_array();	
	}

	public function getStudyMaterialByUserBatchAndType($bid,$uid,$type)
	{
		$query = $this->db->query("SELECT * FROM documents where batch_id=? and added_by  = ? and `type`= ? order by id desc", array($bid,$uid,$type));
		return $query->result_array();	
	}

	public function getSyllabusByUserBatchAndType($bid,$uid,$type)
	{
		$query = $this->db->query("SELECT * FROM documents where batch_id=? and added_by  = ? and `type`= ? order by id desc", array($bid,$uid,$type));
		return $query->result_array();	
	}

	public function getOtherDocsByUserBatchAndType($bid,$uid,$type)
	{
		$query = $this->db->query("SELECT * FROM documents where batch_id=? and added_by  = ? and `type`= ? order by id desc", array($bid,$uid,$type));
		return $query->result_array();	
	}
}