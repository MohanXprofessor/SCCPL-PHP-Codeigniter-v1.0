<?php

class Model_placement extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function create()
	{

		$fname = $this->upload_image();


		$ssc = $this->upload_ssc();



		$lc = $this->upload_lc();



		$cast = $this->upload_cast();

		$data = array(
			'branch_id' => $this->input->post('branch_id'),
			'branch' => $this->input->post('branch'),
			'student_name' => $this->input->post('student_name'),
			'qualification' => $this->input->post('qualification'),
			'address' => $this->input->post('address'),
			'mobile' => $this->input->post('mobile'),
			'email' => $this->input->post('email'),
			'college_name' => $this->input->post('college'),
			'10th' => $this->input->post('ten'),
			'12th' => $this->input->post('twl'),
			'graduate' => $this->input->post('graduate'),
			'gender' => $this->input->post('gender'),
			'company_applied' => $this->input->post('company'),
			'file' => $fname,
			'ssc' => $ssc,
			'lc' => $lc,
			'cast' => $cast

		);

		$this->db->insert('placement', $data);
		$id = $this->db->insert_id();

		return ($id) ? $id : false;

	}



	public function upload_lc()
	{
		if (!empty($_FILES['lc']['name'])) {

			$_FILES['file']['name'] = $_FILES['lc']['name'];
			$_FILES['file']['type'] = $_FILES['lc']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['lc']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['lc']['error'];
			$_FILES['file']['size'] = $_FILES['lc']['size'];

			// File upload configuration
			$uploadPath = 'assets/images/product_image';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|jpeg|png|gif|doc|docs|csv|docx';

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			// Upload file to server
			if ($this->upload->do_upload('file')) {
				// Uploaded file data
				$fileData = $this->upload->data();

				$uploadData = $fileData['file_name'];
				return $uploadData;
			}
		}

	}

	public function upload_ssc()
	{
		if (!empty($_FILES['ssc']['name'])) {

			$_FILES['file']['name'] = $_FILES['ssc']['name'];
			$_FILES['file']['type'] = $_FILES['ssc']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['ssc']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['ssc']['error'];
			$_FILES['file']['size'] = $_FILES['ssc']['size'];

			// File upload configuration
			$uploadPath = 'assets/images/product_image';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|jpeg|png|gif|doc|docs|csv|docx';

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			// Upload file to server
			if ($this->upload->do_upload('file')) {
				// Uploaded file data
				$fileData = $this->upload->data();

				$uploadData = $fileData['file_name'];
				return $uploadData;
			}
		}


	}
	public function upload_cast()
	{
		if (!empty($_FILES['cast']['name'])) {

			$_FILES['file']['name'] = $_FILES['cast']['name'];
			$_FILES['file']['type'] = $_FILES['cast']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['cast']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['cast']['error'];
			$_FILES['file']['size'] = $_FILES['cast']['size'];

			// File upload configuration
			$uploadPath = 'assets/images/product_image';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|jpeg|png|gif|doc|docs|csv|docx';

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			// Upload file to server
			if ($this->upload->do_upload('file')) {
				// Uploaded file data
				$fileData = $this->upload->data();

				$uploadData = $fileData['file_name'];
				return $uploadData;
			}
		}


	}

	public function upload_image()
	{
		if (!empty($_FILES['file_name']['name'])) {

			$_FILES['file']['name'] = $_FILES['file_name']['name'];
			$_FILES['file']['type'] = $_FILES['file_name']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['file_name']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['file_name']['error'];
			$_FILES['file']['size'] = $_FILES['file_name']['size'];

			// File upload configuration
			$uploadPath = 'assets/images/product_image';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|jpeg|png|gif|doc|docs|csv|docx';

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			// Upload file to server
			if ($this->upload->do_upload('file')) {
				// Uploaded file data
				$fileData = $this->upload->data();

				$uploadData = $fileData['file_name'];
				return $uploadData;
			}
		}
	}


	public function getPlacementData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM placement where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			return $query->row_array();
		}

		$sql = "SELECT * FROM placement ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/*
		   Created By: Akash K Fulari
		   On Date: 03-03-2024
	   */
	public function getPlacementDataByBranchIdAndName($bid, $bname, $by)
	{
		if ($bid && $bname && $by) {
			$query = $this->db->query("SELECT * FROM placement WHERE branch_id = '$bid' and branch = '$bname' order by id desc");
			return $query->result_array();
		}
		return array();
	}

	public function getBranchtData($branch_id)
	{
		if ($branch_id) {
			$sql = "SELECT * FROM placement where branch_id=$branch_id order by id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}


	}

	public function getAllFilename($id)
	{
		if ($id) {
			$sql = "SELECT file ,ssc , lc , cast FROM placement where id=$id order by id desc";
			$query = $this->db->query($sql);
			return $query->row();
		}


	}




	public function update($id)
	{
		$data = $this->getAllFilename($id);
		$image_name = "";

		$tmp_name = $_FILES["file_name"]["tmp_name"];

		$ssc_name = $_FILES["ssc"]["tmp_name"];
		$lc_name = $_FILES["lc"]["tmp_name"];
		$cast_name = $_FILES["cast"]["tmp_name"];



		if ($tmp_name) {
			$image_name = $this->upload_image();
			$file = 'assets/images/product_image/' . $data->file;
			if (file_exists($file) && $data->file)
				unlink($file);
		} else
			$image_name = $data->file;



		if ($ssc_name) {
			$ssc = $this->upload_ssc();
			$ssc_d = 'assets/images/product_image/' . $data->ssc;
			if (file_exists($ssc_d) && $data->ssc)
				unlink($ssc_d);
		} else
			$ssc = $data->ssc;

		if ($lc_name) {
			$lc = $this->upload_lc();
			$lc_d = 'assets/images/product_image/' . $data->lc;
			if (file_exists($lc_d) && $data->lc)
				unlink($lc_d);
		} else
			$lc = $data->lc;


		if ($cast_name) {
			$cast = $this->upload_cast();
			$cast_d = 'assets/images/product_image/' . $data->cast;
			if (file_exists($cast_name) && $data->ssc)
				unlink($cast_d);
		} else
			$cast = $data->cast;





		$data = array(
			'branch_id' => $this->input->post('branch_id'),
			'branch' => $this->input->post('branch'),
			'student_name' => $this->input->post('student_name'),
			'qualification' => $this->input->post('qualification'),
			'address' => $this->input->post('address'),
			'mobile' => $this->input->post('mobile'),
			'email' => $this->input->post('email'),
			'college_name' => $this->input->post('college'),
			'10th' => $this->input->post('ten'),
			'12th' => $this->input->post('twl'),
			'graduate' => $this->input->post('graduate'),
			'gender' => $this->input->post('gender'),
			'company_applied' => $this->input->post('company'),
			'file' => $image_name,
			'ssc' => $ssc,
			'lc' => $lc,
			'cast' => $cast
		);

		$this->db->where('id', $id);
		$update = $this->db->update('placement', $data);

		if ($update) {
			return true;
		} else {
			return false;
		}

	}

	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('placement');


			return ($delete == true) ? true : false;
		}
	}

	//Added By Ramiz 2/4/19
	public function placementBranchData($branch = null)
	{
		if ($branch) {
			$sql = "SELECT * FROM placement where branch='$branch' order by id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}


	}
	//Branchwise data wagholi 4/16/19 
	public function placementFranchiseData($branch, $branch_id)
	{
		if ($branch) {
			$sql = "SELECT * FROM placement where branch='$branch' and branch_id='$branch_id' order by id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	}




	public function getSinglePlacement($id = null)
	{

		if ($id) {
			$sql = "SELECT file FROM placement where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			return $query->result_array();
		}


	}

	//New Added 4/12/19 RAMIZ for view courses and packages in placemanent
	public function getOrderId($email)
	{
		if ($email) {
			$sql = "SELECT id , course_completed FROM orders where customer_gst =? order by id desc";
			$query = $this->db->query($sql, $email);
			return $query->result_array();
		} else {
			return 0;
		}
	}





}