<?php

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');

		$this->load->model('model_users');
		$this->load->model('model_groups');
	}

	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM orders WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM orders ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/*
		   Created By: Akash K Fulari
		   On Date: 01-03-2024
	   */
	public function getOrdersDataByBranchIdAndName($bid, $bname)
	{
		if ($bid && $bname) {
			$query = $this->db->query("SELECT * FROM orders WHERE branch_id = '$bid' and branch = '$bname' order by id desc");
			return $query->result_array();
		}

		return array();
	}
	/*
		   Created By: Akash K Fulari
		   On Date: 21-03-2024
	   */
	public function getOrdersDataByBranchIdAndStatus($bid, $status)
	{
		if ($bid != null && $status != null) {
			if ($status == 1) {
				$query = $this->db->query("SELECT * FROM orders WHERE branch_id = '$bid' and course_completed IS NOT null order by id desc");
				return $query->result_array();
			} else if ($status == 0) {
				$query = $this->db->query("SELECT * FROM orders WHERE branch_id = '$bid' and course_completed IS null order by id desc");
				return $query->result_array();
			}
		}

		return array();
	}


	// New generate payament list current date by rmz 4/23/19
	public function today_list($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM orders WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM orders where fdate= DATE(NOW()) and branch_id=1 ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function today_list_wagholi($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM orders WHERE id  = ? order by id desc";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM orders where fdate= DATE(NOW()) and branch_id=2 ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}








	//New for branch wise data
	public function getBranchData($branch_id)
	{
		if ($branch_id) {
			$sql = "SELECT * FROM orders WHERE branch_id = ? order by id desc";
			$query = $this->db->query($sql, array($branch_id));
			return $query->result_array();
		}
	}


	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if (!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM orders_item WHERE order_id  = ? order by id desc";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function create()
	{
		$user_id = $this->session->userdata('id');
		$bill_no = 'BILPR-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
		$data = array(
			'bill_no' => $bill_no,
			'branch_id' => $this->input->post('franchise'),
			'branch' => $this->input->post('branch'),
			'customer_name' => $this->input->post('customer_name'),
			'father_name' => $this->input->post('father_name'),
			'customer_address' => $this->input->post('customer_address'),
			'customer_phone' => $this->input->post('customer_phone'),
			'customer_gst' => $this->input->post('customer_gst'),//instead opf email
			'caste' => $this->input->post('caste'),
			'password' => $this->input->post('password'),
			'date_time' => $this->input->post('date'),
			'gross_amount' => $this->input->post('gross_amount'),
			'service_charge_rate' => $this->input->post('service_charge_rate'),
			'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
			'vat_charge_rate' => $this->input->post('vat_charge_rate'),
			'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
			'net_amount' => $this->input->post('net_amount'),
			'pay_mode' => $this->input->post('pay_mode'),
			'cheque_number' => $this->input->post('cheque_number'),
			'discount' => $this->input->post('discount'),
			'pay' => $this->input->post('pay'),
			'remain' => $this->input->post('remain'),
			'warrenty' => $this->input->post('warrenty'),
			'paid_status' => 2,
			'college' => $this->input->post('college'),
			'prof_status' => $this->input->post('status'),
			'education' => $this->input->post('education'),
			'programe' => null,
			'organization' => $this->input->post('organization'),
			'cust_program' => null,
			'timing' => $this->input->post('time'),
			'user_id' => $user_id,
			'fdate' => $this->input->post('fdate'),
			'remark' => $this->input->post('remark')
		);

		$insert = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();

		//email send added 3-29-19 by RMZ
		$email = $this->input->post('customer_gst');
		$name = $this->input->post('customer_name');
		$courses = implode(',', $this->input->post('sku'));

		$password = $this->input->post('password');
		$product_id = $this->input->post('product');


		$sql = "SELECT name FROM products WHERE id ='$product_id[0]' order by id desc";
		$query = $this->db->query($sql);
		$pdata = $query->result_array();

		foreach ($pdata as $r) {
			foreach ($r as $v) {
				$pname = $v;
			}

		}


		$date = $this->input->post('date');

		$em = $this->send_email($email, $password, $name, $order_id, $courses, $pname, $date);


		//30-3-19 RMZ added For user in user field for access placement
		$password = $this->password_hash($this->input->post('password'));
		$data = array(
			'username' => $this->input->post('customer_name'),
			'password' => $password,
			'email' => $this->input->post('customer_gst'),
			'firstname' => $this->input->post('customer_name'),
			//'lastname' =>$this->input->post('customer_name'),
			'phone' => $this->input->post('customer_phone'),
			'gender' => 0,
			'branch_id' => $this->input->post('franchise'),
		);

		$create = $this->model_users->create($data, 5);

		$this->load->model('model_products');

		$count_product = count($this->input->post('product'));
		for ($x = 0; $x < $count_product; $x++) {
			$items = array(
				'order_id' => $order_id,
				'product_id' => $this->input->post('product')[$x],
				'qty' => $this->input->post('qty')[$x],
				'rate' => $this->input->post('rate')[$x],
				'amount' => $this->input->post('amount')[$x],
				'imei' => implode(',', $this->input->post('sku')),
				'hsn' => $this->input->post('hsn')[$x],
				'color' => $this->input->post('color')[$x],
				's_no' => $this->input->post('sno')[$x],
				'battery_no' => $this->input->post('batteryno')[$x],
				'charger_no' => $this->input->post('chargerno')[$x],

			);

			$this->db->insert('orders_item', $items);
			//$order_id = $this->db->insert_id();

			$pay = $this->input->post('pay');
			if ($pay > 0) {

				//paid recursion data 3-27-19
				$data2 = array(
					'bill_no' => $bill_no,
					'order_id' => $order_id,
					'pay' => $this->input->post('pay'),
					'pay_mode' => $this->input->post('pay_mode'),
					'date' => date('Y-m-d h:i:s a'),
					'cheque_number' => $this->input->post('cheque_number')


				);
				$this->db->insert('paid', $data2);
			}


			// now decrease the stock from the product
			$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
			$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

			$update_product = array('qty' => $qty);


			$this->model_products->update($update_product, $this->input->post('product')[$x]);
		}

		return ($order_id) ? $order_id : false;
	}



	//Email send Added

	public function send_email($email, $password, $name, $order_id, $courses, $pname, $date)
	{


		$this->load->library('email');

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gmail.com',
			'smtp_port' => 587,
			'smtp_user' => 'technologiesgraphix@gmail.com',
			'smtp_pass' => 'admin_gt@2019',
			'smtp_crypto' => 'tls',
			'mailtype' => 'html',
			'charset' => 'utf-8'
		);



		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");



		$from_email = "technologiesgraphix@gmail.com";
		$to_email = $email;
		$password = $password;
		$name = $name;
		$pname = $pname;
		$order_id = $order_id;
		$courses = $courses;
		$date = $date;

		$data = array();
		$data['name'] = $name;
		$data['rdate'] = $date;
		$data['user'] = $to_email;
		$data['password'] = $password;
		$data['courses'] = $courses;
		$data['pname'] = $pname;


		$this->email->from('technologiesgraphix@gmail.com', 'GRAPHIX TECHNOLOGIES');
		$this->email->to($to_email);
		$this->email->subject('Registration Password');


		$message = $this->load->view('email_page', $data, true);
		$this->email->message($message);

		if ($this->email->send()) {

			return true;

		} else {

			return false;
		}
	}

	public function countOrderItem($order_id)
	{
		if ($order_id) {
			$sql = "SELECT * FROM orders_item WHERE order_id  = ? order by id desc";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function update($id)
	{
		if ($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 
			if ($this->input->post('course_completed')) {
				$course_completed = implode(',', $this->input->post('course_completed'));
			} else {
				$course_completed = null;
			}

			$data = array(
				'branch_id' => $this->input->post('franchise'),
				'course_completed' => $course_completed,
				'branch' => $this->input->post('branch'),
				'customer_name' => $this->input->post('customer_name'),
				'father_name' => $this->input->post('father_name'),
				'customer_address' => $this->input->post('customer_address'),
				'customer_phone' => $this->input->post('customer_phone'),
				'customer_gst' => $this->input->post('customer_gst'),//email instead
				'caste' => $this->input->post('caste'),
				'password' => $this->input->post('password'),
				'date_time' => $this->input->post('date'),
				'gross_amount' => $this->input->post('gross_amount'),
				'service_charge_rate' => $this->input->post('service_charge_rate'),
				'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
				'vat_charge_rate' => $this->input->post('vat_charge_rate'),
				'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
				'net_amount' => $this->input->post('net_amount'),
				'pay_mode' => $this->input->post('pay_mode'),
				'cheque_number' => $this->input->post('cheque_number'),
				'discount' => $this->input->post('discount'),
				'pay' => $this->input->post('pay'),
				'remain' => $this->input->post('remain'),
				'warrenty' => $this->input->post('warrenty'),
				//'hsn' => $this->input->post('hsn'),

				'paid_status' => $this->input->post('paid_status'),
				'college' => $this->input->post('college'),
				'prof_status' => $this->input->post('status'),
				'education' => $this->input->post('education'),
				'programe' => null,
				'organization' => $this->input->post('organization'),
				'cust_program' => null,
				'timing' => $this->input->post('time'),
				'user_id' => $user_id,
				'fdate' => $this->input->post('fdate'),
				'remark' => $this->input->post('remark')
			);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);



			$email = $this->input->post('email_hidden');
			$password = $this->password_hash($this->input->post('password'));
			$data_user = array(
				'username' => $this->input->post('customer_name'),
				'password' => $password,
				'email' => $this->input->post('customer_gst'),
				'firstname' => $this->input->post('customer_name'),
				//'lastname' =>$this->input->post('customer_name'),
				'phone' => $this->input->post('customer_phone'),
				'gender' => 0,
				'branch_id' => $this->input->post('franchise'),
			);

			$update_user = $this->model_users->update_user($data_user, 5, $email);


			$this->db->select('bill_no');
			$this->db->from('orders');
			$this->db->where('id', $id);
			$d = $this->db->get();

			foreach ($d->result() as $row) {
				$bill = $row->bill_no;
			}
			$npay = $this->input->post('npay');
			if ($npay > 0) {
				$data2 = array(
					'bill_no' => $bill,
					'order_id' => $id,
					'pay' => $this->input->post('npay'),
					'pay_mode' => $this->input->post('pay_mode'),
					'date' => date('Y-m-d h:i:s a'),
					'cheque_number' => $this->input->post('cheque_number')
				);
				$this->db->insert('paid', $data2);
			}

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			$this->load->model('model_products');
			$get_order_item = $this->getOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
				$product_id = $v['product_id'];
				$qty = $v['qty'];
				// get the product 
				$product_data = $this->model_products->getProductData($product_id);
				$update_qty = $qty + $product_data['qty'];
				$update_product_data = array('qty' => $update_qty);

				// update the product qty
				$this->model_products->update($update_product_data, $product_id);
			}

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');

			// now decrease the product qty
			$count_product = count($this->input->post('product'));
			for ($x = 0; $x < $count_product; $x++) {
				$items = array(
					'order_id' => $id,
					'product_id' => $this->input->post('product')[$x],
					'qty' => $this->input->post('qty')[$x],
					'rate' => $this->input->post('rate')[$x],
					'amount' => $this->input->post('amount')[$x],
					'imei' => implode(",", $this->input->post('sku')),
					'hsn' => $this->input->post('hsn')[$x],
					'color' => $this->input->post('color')[$x],
					's_no' => $this->input->post('sno')[$x],
					'battery_no' => $this->input->post('batteryno')[$x],
					'charger_no' => $this->input->post('chargerno')[$x],
				);
				$this->db->insert('orders_item', $items);


				// now decrease the stock from the product
				$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
				$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

				$update_product = array('qty' => $qty);
				$this->model_products->update($update_product, $this->input->post('product')[$x]);
			}

			return true;
		}
	}



	// 	public function remove($id)
// 	{
// 		if($id) {
// 			$this->db->where('id', $id);
// 			$delete = $this->db->delete('orders');

	// 			$this->db->where('order_id', $id);
// 			$delete_item = $this->db->delete('orders_item');
// 			return ($delete == true && $delete_item) ? true : false;
// 		}
// 	}


	public function remove($id)
	{
		if ($id) {

			// 4/12/19 by ramiz delete data from paid info of user 
			$sql = "SELECT  customer_gst FROM orders where id =? order by id desc";
			$query = $this->db->query($sql, array($id));
			$email_data = $query->result_array();
			foreach ($email_data as $em) {
				$email = $em['customer_gst'];
			}


			$this->db->where('email', $email);
			$det = $this->db->delete('users');

			$this->db->where('id', $id);
			$delete = $this->db->delete('orders');

			$this->db->where('order_id', $id);
			$delete_paid = $this->db->delete('paid');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('orders_item');
			return ($delete == true && $delete_item) ? true : false;
		}
	}


	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM orders ";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
	//cash detail added by ramiz 3-30-2019  
	public function cash_detail($id)
	{
		if ($id) {
			$sql = "SELECT * FROM paid where order_id=? and pay>0 order by id desc";
			$query = $this->db->query($sql, $id);
			return $query->result_array();
		}
	}
	//Single User Print Data
	public function single_student($id)
	{
		if ($id) {
			$sql = "SELECT * FROM orders where id =? order by id desc";
			$query = $this->db->query($sql, $id);
			return $query->result_array();
		}
	}


	//Fopr password hash Function  3-30-19 RMZ
	public function password_hash($pass = '')
	{
		if ($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}




	//NEW FOR FRANCHISE DATA 16/4/19
	public function getFranchiseData($branch, $branch_id)
	{
		if ($branch && $branch_id) {
			$sql = "SELECT * FROM orders WHERE branch = ? and branch_id =? order by id desc";
			$query = $this->db->query($sql, array($branch, $branch_id));
			return $query->result_array();
		}

		// $sql = "SELECT * FROM orders ORDER BY id DESC";
		// $query = $this->db->query($sql);
		// return $query->result_array();
	}





	// load stud detail branch wise and send index page 2/4/19
	public function getBranchWise($branch = null)
	{
		if ($branch) {
			$sql = "SELECT * FROM orders WHERE branch  = ? order by id desc";
			$query = $this->db->query($sql, array($branch));
			return $query->result_array();
		}

		// $sql = "SELECT * FROM orders ORDER BY id DESC";
		// $query = $this->db->query($sql);
		// return $query->result_array();
	}

	//Count Branch Wise details 2/4/19

	public function countBranchWise($branch = null)
	{
		if ($branch) {
			$sql = "SELECT * FROM orders WHERE branch = ? order by id desc";
			$query = $this->db->query($sql, array($branch));
			return $query->num_rows();
		}
	}

	public function getPackage($idf)
	{
		if ($idf) {
			$sql = "SELECT distinct product_id,imei,hsn FROM orders_item where order_id =? order by id desc";
			$query = $this->db->query($sql, array($idf));
			return $query->result_array();
		}
	}


	public function getPackagename($idf)
	{
		if ($idf) {
			$sql = "SELECT  name FROM products where id =? order by id desc";
			$query = $this->db->query($sql, array($idf));
			return $query->result_array();
		}
	}

	//new data return datewise 
	public function fetch_datewise($sdate, $edate, $franchise = null)
	{
		$branch_id = $this->session->userdata('branch_id');
		if ($franchise) {

			$this->db->select('*');
			$this->db->from('orders');
			$this->db->where('date_time >=', $sdate);
			$this->db->where('date_time <=', $edate);
			$this->db->where('branch_id=', $franchise);
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('*');
			$this->db->from('orders');
			$this->db->where('date_time >=', $sdate);
			$this->db->where('date_time <=', $edate);
			$q = $this->db->get();
			return $q->result_array();
		}


	}

	//New email resend 
	public function resend_email($email)
	{

		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('customer_gst', $email);
		$q = $this->db->get();


		if ($q->result()) {

			foreach ($q->result() as $key => $r) {
				$name = $r->customer_name;
				$email = $r->customer_gst;
				$password = $r->password;
				$date = $r->date_time;
				$order_id = $r->id;

				$package_data = $this->getPackage($order_id);

				if ($package_data) {
					foreach ($package_data as $val) {
						$courses = $val['imei'];
						$pakage = $this->getPackagename($val['product_id']);
						foreach ($pakage as $val)
							$pname = $val['name'];
					}
				} else {
					$courses = $pname = "null";
				}

			}

			$res = $this->send_email($email, $password, $name, $order_id, $courses, $pname, $date);
			return $res;

		} else {
			return false;
		}

	}

	// Student course comleted data 

	public function getCompletedData($branch_id = null)
	{
		if ($branch_id) {
			$sql = "SELECT * FROM orders WHERE branch_id = ? order by id desc";
			$query = $this->db->query($sql, array($branch_id));
			return $query->result_array();
		}

	}

	public function getLastPayDate($bill)
	{
		if ($bill) {
			$sql = "SELECT  id, date FROM paid where bill_no=? and pay>0 order by id desc limit 1";
			$query = $this->db->query($sql, array($bill));
			return $query->row();
		}
	}



}