<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Placement extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Placement';

		$this->load->model('Model_placement');
		$this->load->model('model_orders');
	}
	public function load()
	{
		// if(!in_array('viewPlacement', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }

		$this->render_template('placement/create', $this->data);
	}

	public function index()
	{
		// if(!in_array('viewPlacement', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }

		$this->render_template('placement/index', $this->data);
	}

	//New for sort out placement data by RMZ 23/4/19
	public function placement_wagholi()
	{
		// if(!in_array('viewPlacement', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }

		$this->render_template('placement/placement_wagholi', $this->data);
	}
	public function placement_shivajinagar()
	{
		// if(!in_array('viewPlacement', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }

		$this->render_template('placement/placement_shivajinagar', $this->data);
	}


	//

	public function create()
	{
		// if(!in_array('createOrder', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }

		$this->data['page_title'] = 'Add Placement';

		$this->form_validation->set_rules('student_name', 'Name', 'trim|required');


		if ($this->form_validation->run() == TRUE) {

			$id = $this->Model_placement->create();

			if ($id) {
				if (in_array('viewStudent', $this->permission)) {
					$this->session->set_flashdata('success', 'Successfully Placement Added');
					redirect('dashboard', 'refresh');
				} else {
					$this->session->set_flashdata('success', 'Successfully created');
					redirect('placement/index/' . $id, 'refresh');
				}
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('placement/create/', 'refresh');
			}
		} else {
			// false case


			$this->load();
		}
	}
	//Fetch database value and pass index of placement // Edited By ramiz-3/25/2019
	public function fetchPlacementsData()
	{
		$result = array('data' => array());


		$branch_id = $_SESSION['branch_id'];


		if ($branch_id == '2') {

			$data = $this->Model_placement->getBranchtData($branch_id);
			//$data = $this->Model_placement->getPlacementData($branch_id);
		} else {
			$data = $this->Model_placement->getPlacementData();
			//$data = $this->Model_placement->getBranchPlacementData($branch_id);
		}

		foreach ($data as $key => $value) {

			//	$count_total_item = $this->model_orders->countOrderItem($value['id']);
			//New added PACKAGE and Courses
			$orderid = $this->Model_placement->getOrderId($value['email']);

			if ($value['branch_id'] == 1) {
				$location = "SHIVAJINAGAR";
			} elseif ($value['branch_id'] == 2) {
				$location = "KHARADI";
			} else {
				$location = "NULL";
			}

			if ($orderid) {
				foreach ($orderid as  $row) {
					$id = $row['id'];
					$compl_course = $row['course_completed'];
					$package_data = $this->model_orders->getPackage($id);
					if ($package_data) {
						foreach ($package_data as $val) {
							$courses = $val['imei'];

							$pakage = $this->model_orders->getPackagename($val['product_id']);

							foreach ($pakage as $val)
								$package_name = $val['name'];
						}
					} else {
						$courses = "null";
						$package_name = "null";
					}
				}
			} else {
				$courses = "null";
				$package_name = "null";
				$compl_course = "null";
			}

			// button
			$buttons = '';


			if (in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="' . base_url('placement/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if (in_array('viewPlacement', $this->permission)) {
				$buttons .= ' <a href="' . base_url('placement/view/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			}

			$buttons .= ' <a href="' . base_url('placement/download/' . $value['id']) . '" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			if (in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}


			$result['data'][$key] = array(
				$location,
				$value['student_name'],
				// $value['address'],
				$value['mobile'],
				$value['email'],
				$value['qualification'],
				$value['college_name'],
				$courses,
				$package_name,
				$compl_course,
				$value['company_applied'],
				$value['branch'],
				$buttons
			);
		} // /foreach


		echo json_encode($result);
	}

	//Added By ramiz new plmt data sort 23/4/19

	public function fetchPlacementsDataW()
	{
		$result = array('data' => array());

		$branch_id = 2;


		if ($branch_id == '2') {

			$data = $this->Model_placement->getBranchtData($branch_id);
			//$data = $this->Model_placement->getPlacementData($branch_id);
		} else {
			$data = $this->Model_placement->getPlacementData();
			//$data = $this->Model_placement->getBranchPlacementData($branch_id);
		}

		foreach ($data as $key => $value) {

			//	$count_total_item = $this->model_orders->countOrderItem($value['id']);
			//New added PACKAGE and Courses
			$orderid = $this->Model_placement->getOrderId($value['email']);

			if ($value['branch_id'] == 1) {
				$location = "SHIVAJINAGAR";
			} elseif ($value['branch_id'] == 2) {
				$location = "KHARADI";
			} else {
				$location = "NULL";
			}

			if ($orderid) {
				foreach ($orderid as  $row) {
					$id = $row['id'];
					$compl_course = $row['course_completed'];
					$package_data = $this->model_orders->getPackage($id);
					if ($package_data) {
						foreach ($package_data as $val) {
							$courses = $val['imei'];

							$pakage = $this->model_orders->getPackagename($val['product_id']);

							foreach ($pakage as $val)
								$package_name = $val['name'];
						}
					} else {
						$courses = "null";
						$package_name = "null";
					}
				}
			} else {
				$courses = "null";
				$package_name = "null";
				$compl_course = "null";
			}

			// $courses="null";
			// 	$package_name="null";
			// button
			$buttons = '';


			if (in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="' . base_url('placement/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if (in_array('viewPlacement', $this->permission)) {
				$buttons .= ' <a href="' . base_url('placement/view/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			}

			$buttons .= ' <a href="' . base_url('placement/download/' . $value['id']) . '" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			if (in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}


			$result['data'][$key] = array(
				$location,
				$value['student_name'],
				// $value['address'],
				$value['mobile'],
				$value['email'],
				$value['qualification'],
				$value['college_name'],
				$courses,
				$package_name,
				$compl_course,
				$value['company_applied'],
				$value['branch'],
				$buttons
			);
		} // /foreach


		echo json_encode($result);
	}
	public function fetchPlacementsDataS()
	{
		$result = array('data' => array());

		$branch_id = 1;


		if ($branch_id == '1') {

			$data = $this->Model_placement->getBranchtData($branch_id);
			//$data = $this->Model_placement->getPlacementData($branch_id);
		} else {
			$data = $this->Model_placement->getPlacementData();
			//$data = $this->Model_placement->getBranchPlacementData($branch_id);
		}

		foreach ($data as $key => $value) {

			//	$count_total_item = $this->model_orders->countOrderItem($value['id']);
			//New added PACKAGE and Courses
			$orderid = $this->Model_placement->getOrderId($value['email']);

			if ($value['branch_id'] == 1) {
				$location = "SHIVAJINAGAR";
			} elseif ($value['branch_id'] == 2) {
				$location = "KHARADI";
			} else {
				$location = "NULL";
			}

			if ($orderid) {
				foreach ($orderid as  $row) {
					$id = $row['id'];
					$compl_course = $row['course_completed'];
					$package_data = $this->model_orders->getPackage($id);
					if ($package_data) {
						foreach ($package_data as $val) {
							$courses = $val['imei'];

							$pakage = $this->model_orders->getPackagename($val['product_id']);

							foreach ($pakage as $val)
								$package_name = $val['name'];
						}
					} else {
						$courses = "null";
						$package_name = "null";
					}
				}
			} else {
				$courses = "null";
				$package_name = "null";
				$compl_course = "null";
			}

			// $courses="null";
			// 	$package_name="null";
			// button
			$buttons = '';


			if (in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="' . base_url('placement/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if (in_array('viewPlacement', $this->permission)) {
				$buttons .= ' <a href="' . base_url('placement/view/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			}

			$buttons .= ' <a href="' . base_url('placement/download/' . $value['id']) . '" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			if (in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}


			$result['data'][$key] = array(
				$location,
				$value['student_name'],
				// $value['address'],
				$value['mobile'],
				$value['email'],
				$value['qualification'],
				$value['college_name'],
				$courses,
				$package_name,
				$compl_course,
				$value['company_applied'],
				$value['branch'],
				$buttons
			);
		} // /foreach


		echo json_encode($result);
	}

	public function update($id)
	{
		$id = $id;

		if (!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('student_name', 'name', 'trim|required');


		if ($this->form_validation->run() == TRUE) {


			$update = $this->Model_placement->update($id);

			if ($update == true) {
				$this->session->set_flashdata('success', 'Successfully updated');
				redirect('placement/update/' . $id, 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('placement/update/' . $id, 'refresh');
			}
		} else {
			// false case
			$result = array();
			$orders_data = $this->Model_placement->getPlacementData($id);

			$result['order'] = $orders_data;
			//$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

			// foreach($orders_item as $k => $v) {
			// 	$result['order_item'][] = $v;
			// }

			$this->data['order_data'] = $result;

			//$this->data['products'] = $this->model_products->getActiveProductData();      	

			$this->render_template('placement/edit', $this->data);
		}
	}


	// 	public function view($id)
	// 	{
	// 		$orders_data = $this->Model_placement->getPlacementData($id);
	// 		$result['order']=$orders_data;
	// 		$this->data['order_data'] = $result;
	// 		$this->render_template('placement/view', $this->data);


	// 	}
	public function view($id)
	{
		$orders_data = $this->Model_placement->getPlacementData($id);

		$orderid = $this->Model_placement->getOrderId($orders_data['email']);

		if ($orderid) {
			foreach ($orderid as  $row) {
				$id = $row['id'];
				$package_data = $this->model_orders->getPackage($id);

				foreach ($package_data as $val) {
					$courses = $val['imei'];
					$pakage = $this->model_orders->getPackagename($val['product_id']);
					foreach ($pakage as $val)
						$package_name = $val['name'];
				}
			}
		} else {
			$courses = "null";
			$package_name = "null";
		}
		$result['order'] = $orders_data;
		$course['course'] = $courses;
		$package['package'] = $package_name;
		$this->data['order_data'] = $result;
		$this->data['course'] = $course;
		$this->data['package'] = $package;
		// var_dump($this->data);
		// die();
		$this->render_template('placement/view', $this->data);
	}



	public function remove()
	{
		// if(!in_array('createPlacement', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }

		$id = $this->input->post('id');

		$response = array();
		if ($id) {
			$data = $this->Model_placement->getAllFilename($id);
			$file = 'assets/images/product_image/' . $data->file;
			$ssc = 'assets/images/product_image/' . $data->ssc;
			$lc = 'assets/images/product_image/' . $data->lc;
			$cast = 'assets/images/product_image/' . $data->cast;



			if (file_exists($file) && $data->file)
				unlink($file);

			if (file_exists($ssc) && $data->ssc)
				unlink($ssc);

			if (file_exists($lc) && $data->lc)
				unlink($lc);

			if (file_exists($cast) && $data->cast)
				unlink($cast);


			$delete = $this->Model_placement->remove($id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";
			} else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the product information";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}


	public function download($id = NULL)
	{

		$this->load->helper('download');
		if ($id) {
			$sql = "SELECT file FROM placement where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			$arr = $query->row_array();
			foreach ($arr as $key => $val) {
				$a = 'assets/images/product_image/' . $val;
				if ($val != "<p>You did not select a file to upload.</p>" && $val != null && file_exists($a)) {


					force_download($a, NULL);
				} else {
					$this->session->set_flashdata('error', 'You did not select a Resume to upload.');
					echo "<script>
           
             window.history.go(-1);
     </script>";
				}
			}
		} else {
			$this->session->set_flashdata('error', 'You did not select a Resume  to upload.');
			echo "<script>
           
		window.history.go(-2);
</script>";
		}
	}

	//new for download lc and ssc 

	public function download_ssc($id = NULL)
	{

		$this->load->helper('download');
		if ($id) {
			$sql = "SELECT ssc FROM placement where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			$arr = $query->row_array();
			foreach ($arr as $key => $val) {
				$a = 'assets/images/product_image/' . $val;


				if ($val != "<p>You did not select a file to upload.</p>" && $val != null) {


					force_download($a, NULL);
				} else {
					$this->session->set_flashdata('error', 'You did not select  document to upload.');
					echo "<script>
           
             window.history.go(-2);
     </script>";
				}
			}
		} else {
			$this->session->set_flashdata('error', 'You did not select  document to upload.');
			echo "<script>
           
		window.history.go(-1);
</script>";
		}
	}


	public function download_lc($id = NULL)
	{

		$this->load->helper('download');
		if ($id) {
			$sql = "SELECT lc FROM placement where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			$arr = $query->row_array();
			foreach ($arr as $key => $val) {
				$a = 'assets/images/product_image/' . $val;


				if ($val != "<p>You did not select a file to upload.</p>" && $val != null) {


					force_download($a, NULL);
				} else {
					$this->session->set_flashdata('error', 'You did not select document to upload.');
					echo "<script>
           
             window.history.go(-2);
     </script>";
				}
			}
		} else {
			$this->session->set_flashdata('error', 'You did not select  document to upload.');
			echo "<script>
           
		window.history.go(-2);
</script>";
		}
	}

	public function download_cast($id = NULL)
	{

		$this->load->helper('download');
		if ($id) {
			$sql = "SELECT cast FROM placement where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			$arr = $query->row_array();
			foreach ($arr as $key => $val) {
				$a = 'assets/images/product_image/' . $val;


				if ($val != "<p>You did not select a file to upload.</p>" && $val != null) {


					force_download($a, NULL);
				} else {
					$this->session->set_flashdata('error', 'You did not select document to upload.');
					echo "<script>
           
             window.history.go(-2);
     </script>";
				}
			}
		} else {
			$this->session->set_flashdata('error', 'You did not select  document to upload.');
			echo "<script>
           
		window.history.go(-2);
</script>";
		}
	}






	//single uploaded resume student

	public function resume($id = null)
	{
		// if(!in_array('createPlacement', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }
		//$id = $this->input->get('id');

		if ($id) {

			$this->render_template('placement/upload_resume', $this->data);
		}
	}

	public function upload_res()
	{
		$emt = $_SESSION['email'];

		$sql = "SELECT * FROM placement WHERE  email='$emt'";
		$query = $this->db->query($sql);
		$data = $query->result_array();

		foreach ($data as  $value) {
			$id = $value['id'];
		}
		$uploads_dir = 'assets/images/product_image';
		$images_name = "";
		$uniq = uniqid();
		$tmp_name = $_FILES["image"]["tmp_name"];
		$name = $uniq . $_FILES["image"]["name"];

		//    $lct_name = $_FILES["lc"]["tmp_name"];
		//    $lc = $_FILES["lc"]["name"];

		//    $ssc_name = $_FILES["ssc"]["tmp_name"];
		//    $ssc = $_FILES["ssc"]["name"];


		//    echo uniqid().$lc."<br>";

		//    echo $name;
		//    die();	  


		move_uploaded_file($tmp_name, "$uploads_dir/$name");
		if ($images_name == "") {
			$images_name = $images_name . $name;
		} else  $images_name = $images_name . "," . $name;
		// echo $images_name;
		// die(); 

		$this->db->set('file', $images_name);
		$this->db->where('id', $id);
		$a =  $this->db->update('placement');






		if ($a) {
			$this->session->set_flashdata('success', 'Successfully uploaded resume');

			echo "<script>
           
             window.history.go(-2);
     </script>";
			// $this->render_template('dashboard', $this->data);
		} else {
			$this->session->set_flashdata('error', 'You did not select a Resume to upload.');
			echo "<script>
           
             window.history.go(-2);
     </script>";
		}
	}

	public function upload_ssc()
	{
		$emt = $_SESSION['email'];

		$sql = "SELECT * FROM placement WHERE  email='$emt'";
		$query = $this->db->query($sql);
		$data = $query->result_array();

		foreach ($data as  $value) {
			$id = $value['id'];
		}
		$uploads_dir = 'assets/images/product_image';
		$images_name = "";
		$uniq = uniqid();
		$tmp_name = $_FILES["ssc"]["tmp_name"];
		$name = $uniq . $_FILES["ssc"]["name"];

		//    $lct_name = $_FILES["lc"]["tmp_name"];
		//    $lc = $_FILES["lc"]["name"];

		//    $ssc_name = $_FILES["ssc"]["tmp_name"];
		//    $ssc = $_FILES["ssc"]["name"];


		//    echo uniqid().$lc."<br>";

		//    echo $name;
		//    die();	  


		move_uploaded_file($tmp_name, "$uploads_dir/$name");
		if ($images_name == "") {
			$images_name = $images_name . $name;
		} else  $images_name = $images_name . "," . $name;
		// echo $images_name;
		// die(); 

		$this->db->set('ssc', $images_name);
		$this->db->where('id', $id);
		$a =  $this->db->update('placement');






		if ($a) {
			$this->session->set_flashdata('success', 'Successfully uploaded ssc document');

			echo "<script>
           
             window.history.go(-2);
     </script>";
			// $this->render_template('dashboard', $this->data);
		} else {
			$this->session->set_flashdata('error', 'You did not select marksheet to upload.');
			echo "<script>
           
             window.history.go(-2);
     </script>";
		}
	}

	public function upload_lc()
	{
		$emt = $_SESSION['email'];

		$sql = "SELECT * FROM placement WHERE  email='$emt'";
		$query = $this->db->query($sql);
		$data = $query->result_array();

		foreach ($data as  $value) {
			$id = $value['id'];
		}
		$uploads_dir = 'assets/images/product_image';
		$images_name = "";
		$uniq = uniqid();

		$tmp_name = $_FILES["lc"]["tmp_name"];
		$name = $uniq . $_FILES["lc"]["name"];


		//    $lct_name = $_FILES["lc"]["tmp_name"];
		//    $lc = $_FILES["lc"]["name"];

		//    $ssc_name = $_FILES["ssc"]["tmp_name"];
		//    $ssc = $_FILES["ssc"]["name"];


		//    echo uniqid().$lc."<br>";

		//    echo $name;
		//    die();	  


		move_uploaded_file($tmp_name, "$uploads_dir/$name");
		if ($images_name == "") {
			$images_name = $images_name . $name;
		} else  $images_name = $images_name . "," . $name;
		// echo $images_name;
		// die(); 

		$this->db->set('lc', $images_name);
		$this->db->where('id', $id);
		$a =  $this->db->update('placement');






		if ($a) {
			$this->session->set_flashdata('success', 'Successfully uploaded LC');

			echo "<script>
           
             window.history.go(-2);
     </script>";
			// $this->render_template('dashboard', $this->data);
		} else {
			$this->session->set_flashdata('error', 'You did not select a LC to upload.');
			echo "<script>
           
             window.history.go(-2);
     </script>";
		}
	}



	public function upload_cast()
	{
		$emt = $_SESSION['email'];

		$sql = "SELECT * FROM placement WHERE  email='$emt'";
		$query = $this->db->query($sql);
		$data = $query->result_array();

		foreach ($data as  $value) {
			$id = $value['id'];
		}
		$uploads_dir = 'assets/images/product_image';
		$images_name = "";
		$uniq = uniqid();

		$tmp_name = $_FILES["cast_cert"]["tmp_name"];
		$name = $uniq . $_FILES["cast_cert"]["name"];
		move_uploaded_file($tmp_name, "$uploads_dir/$name");
		if ($images_name == "") {
			$images_name = $images_name . $name;
		} else  $images_name = $images_name . "," . $name;
		$this->db->set('cast', $images_name);
		$this->db->where('id', $id);
		$a =  $this->db->update('placement');
		if ($a) {
			$this->session->set_flashdata('success', 'Successfully uploaded Cast Certificate');

			echo "<script>
           
             window.history.go(-2);
     </script>";
			// $this->render_template('dashboard', $this->data);
		} else {
			$this->session->set_flashdata('error', 'You did not select a LC to upload.');
			echo "<script>
           
             window.history.go(-2);
     </script>";
		}
	}




	public function student_detail($ord)
	{

		$data['h'] = $this->model_orders->single_student($ord);

		$this->load->view('templates/header');
		//	$this->load->view('templates/header_menu');
		//	$this->load->view('templates/side_menubar');
		//	$this->load->view($page, $data);		
		// $this->load->view('templates/footer');
		//	$this->load->view('templates/');
		// var_dump($data['h']);
		// die();
		$this->load->view("placement/std_pkg_info", $data);
	}

	//New for course update student 	
	public function course_status($ord)
	{

		$this->data['h'] = $this->model_orders->single_student($ord);

		$this->load->view('templates/header');
		//	$this->load->view('templates/header_menu');
		//	$this->load->view('templates/side_menubar');
		//	$this->load->view($page, $data);		
		// $this->load->view('templates/footer');
		//	$this->load->view('templates/');
		// var_dump($data['h']);
		// die();
		$this->load->view("placement/course_status", $this->data);
	}

	public function course_status_update()
	{
		$id = $this->input->post('id');

		if ($this->input->post('course_completed')) {
			$data =	array('course_completed' => implode(',', $this->input->post('course_completed')));




			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);
			if ($update) {
				$this->session->set_flashdata('success', 'Successfully course stutus updated');

				echo "<script>
				
				  window.history.go(-1);
		  </script>";
				// $this->render_template('dashboard', $this->data);
			} else {
				$this->session->set_flashdata('error', 'something wrong.');
				echo "<script>
				
				  window.history.go(-1);
		  </script>";
			}
		} else {

			$data =	array('course_completed' => null);
			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);
			$this->session->set_flashdata('error', 'Course Not  Selected');
			echo "<script>
			   
				 window.history.go(-1);
		 </script>";
		}
	}

	/*
        Created By: Akash K Fulari
        On Date: 03-03-2024
	*/
	public function sortPlacements()
	{
		$bid = $this->input->get('b');
		$bname = $this->input->get('name');
		$by = $this->input->get("by");

		$this->data['branch_id'] = $bid;
		$this->data['branch_name'] = $bname;
		$this->data['by'] = $by;

		$this->render_template('placement/sortPlacements', $this->data);
	}

	/*
        Created By: Akash K Fulari
        On Date: 03-03-2024
	*/
	public function loadSortedPlacements()
	{
		$result = array("data" => []);

		$bid = $this->input->post('bid');
		$bname = $this->input->post('bname');
		$by = $this->input->post("by");

		if (!empty($bid) && !empty($bname) && !empty($by)) {
			$data = $this->Model_placement->getPlacementDataByBranchIdAndName($bid, $bname, $by);

			foreach ($data as $key => $value) {

				//	$count_total_item = $this->model_orders->countOrderItem($value['id']);
				//New added PACKAGE and Courses
				$orderid = $this->Model_placement->getOrderId($value['email']);

				if ($value['branch_id'] == 1) {
					$location = "SHIVAJINAGAR";
				} elseif ($value['branch_id'] == 2) {
					$location = "KHARADI";
				} else {
					$location = "NULL";
				}

				if ($orderid) {
					foreach ($orderid as  $row) {
						$id = $row['id'];
						$compl_course = $row['course_completed'];
						$package_data = $this->model_orders->getPackage($id);
						if ($package_data) {
							foreach ($package_data as $val) {
								$courses = $val['imei'];

								$pakage = $this->model_orders->getPackagename($val['product_id']);

								foreach ($pakage as $val)
									$package_name = $val['name'];
							}
						} else {
							$courses = "null";
							$package_name = "null";
						}
					}
				} else {
					$courses = "null";
					$package_name = "null";
					$compl_course = "null";
				}

				// button
				$buttons = '';


				if (in_array('updatePlacement', $this->permission)) {
					$buttons .= ' <a href="' . base_url('placement/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
				}

				if (in_array('viewPlacement', $this->permission)) {
					$buttons .= ' <a href="' . base_url('placement/view/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-eye"></i></a>';
				}

				$buttons .= ' <a href="' . base_url('placement/download/' . $value['id']) . '" class="btn btn-default" ><i class="fa fa-download"></i></a>';


				if (in_array('deletePlacement', $this->permission)) {
					$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
				}


				$result['data'][$key] = array(
					$location,
					$value['student_name'],
					// $value['address'],
					$value['mobile'],
					$value['email'],
					$value['qualification'],
					$value['college_name'],
					$courses,
					$package_name,
					$compl_course,
					$value['company_applied'],
					$value['branch'],
					$buttons
				);
			} // /foreach
		}

		echo json_encode($result);
	}
}
