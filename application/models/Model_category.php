<?php 

class Model_category extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get active brand infromation */
	public function getActiveCategroy()
	{
		$sql = "SELECT * FROM categories WHERE active  = ? order by id desc";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getCategoryData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM categories WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM categories order by id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getcategory($postc)
	{  $response = array();


		$sql = "SELECT * FROM products where (FIND_IN_SET('$postc', category_id)) order by id desc";
		$query = $this->db->query($sql);

		$response=$query->result_array();			
			return $response;

		// if($postc) {
		// 	$this->db->select('products.id products.name');
		// 	$this->db->from('products');
		// 	$this->db->where('category_id',$postc);
		// 	$q=$this->db->get();
		// 	$response=$q->result_array();			
		// 	return $response;

		// }
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('categories', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('categories', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('categories');
			return ($delete == true) ? true : false;
		}
	}






}