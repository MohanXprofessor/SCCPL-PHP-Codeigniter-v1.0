<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-05-09 14:56:36
 Last Modification Date: 2024-05-09 14:56:44
*
**/
class Model_subject extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function createSubject($data = '')
	{
		$create = $this->db->insert('subject', $data);
		return ($create == true) ? true : false;
	}

	public function updateSubject($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('subject', $data);
		return ($update == true) ? true : false;
	}

	public function removeSubject($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('subject');
		return ($delete == true) ? true : false;
	}
	public function getSubjectData()
	{
		$query = $this->db->query("SELECT * FROM subject");
		return $query->result_array();
	}
	public function fetchSubjectDataById($id)
	{
		$sql = "SELECT * FROM subject WHERE id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}
}
