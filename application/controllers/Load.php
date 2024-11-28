<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Load extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'STUD';

		$this->load->model('model_orders');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_category');
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		// if(in_array('viewOrder', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		
		$this->render_template('loadview/load_stud',$this->data);	
	}

	public function load_sap()
	{
	// 	if(in_array('viewOrder', $this->permission)) {
    //         redirect('dashboard', 'refresh');
    //     }

		
		$this->render_template('loadview/load_sap',$this->data);	
	}

	//new dg mk
	
	public function load_Digitalmarketing()
	{
	// 	if(in_array('viewOrder', $this->permission)) {
    //         redirect('dashboard', 'refresh');
    //     }

		
		$this->render_template('loadview/load_dgmkt',$this->data);	
	}

	public function load_electrical()
	{
		// if(in_array('viewOrder', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		
		$this->render_template('loadview/load_electrical',$this->data);	
	}
	public function load_civil()
	{
		// if(in_array('viewOrder', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		
		$this->render_template('loadview/load_civil',$this->data);	
	}

	/*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
	public function fetchOrdersData()
	{
	
  //NEW ADDED FOR WAGHOLI BRANCH 16/4/2019 BY RAMIZ
		$branch="Mechanical";//$this->input->get('val');
		$result = array('data' => array());

		  $branch_id=$_SESSION['branch_id'];
				if($branch_id==2)
				{
					$data = $this->model_orders->getFranchiseData($branch,$branch_id);
				
				} 
				else  {					
		     	 $data = $this->model_orders->getBranchWise($branch);
	        	}
		// $count_total_item = $this->model_orders->countBranchWise($branch);

		foreach ($data as $key => $value) {

			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			// $date = date('d-m-Y', $value['date_time']);
			// $time = date('h:i a', $value['date_time']);

			// $date_time = $date . ' ' . $time;

			$package_data= $this->model_orders->getPackage($value['id']);
				 if($value['branch_id']==1)
				 {
					 $location="SHIVAJINAGAR";
				 }
				 elseif($value['branch_id']==2)
				 {
					 $location="KHARADI";
				 }
				 else
				 {
					 $location="NULL";
				 }
				 if($package_data)
				 {
			foreach($package_data as $val)
			{
	           $courses=$val['imei'];
			     $pakage= $this->model_orders->getPackagename($val['product_id']);
			    foreach($pakage as $val)				
			    $package_name=$val['name'];
			}  }
			else 
			{
				$courses="null";
				$package_name="null";
			}


			// // button
			$buttons = '';

			//if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			//}
			//if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			//}
			//if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			//}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['remain'] == 0) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
			}
//Change paid state from paid state to remain state
			$result['data'][$key] = array(
			  $location,
				$value['branch'],
				$value['education'],				
				$value['customer_name'],
				$value['customer_phone'],
				$value['date_time'],
				$package_name,
				$courses,
				$value['course_completed'],
				$value['net_amount'],
				$value['remain'],
				$paid_status,
				$buttons
				
			);
		} // /foreach

		echo json_encode($result);
	}

	public function fetch_sap()
	{
	
  //NEW ADDED FOR WAGHOLI BRANCH 16/4/2019 BY RAMIZ
	$branch="SAP";//$this->input->get('val');
	$result = array('data' => array());
	$courses="null";
	$package_name="null";

		$branch_id=$_SESSION['branch_id'];
			if($branch_id==2)
			{
				$data = $this->model_orders->getFranchiseData($branch,$branch_id);
			
			} 
			else  {					
					$data = $this->model_orders->getBranchWise($branch);
					}
	// $count_total_item = $this->model_orders->countBranchWise($branch);

	foreach ($data as $key => $value) {

		$count_total_item = $this->model_orders->countOrderItem($value['id']);
		// $date = date('d-m-Y', $value['date_time']);
		// $time = date('h:i a', $value['date_time']);

		// $date_time = $date . ' ' . $time;

		$package_data= $this->model_orders->getPackage($value['id']);
			 if($value['branch_id']==1)
			 {
				 $location="SHIVAJINAGAR";
			 }
			 elseif($value['branch_id']==2)
			 {
				 $location="KHARADI";
			 }
			 else
			 {
				 $location="NULL";
			 }
			 if($package_data)
			 {
		foreach($package_data as $val)
		{
					 $courses=$val['imei'];
				 $pakage= $this->model_orders->getPackagename($val['product_id']);
				foreach($pakage as $val)				
				$package_name=$val['name'];
		}  }
		else 
		{
			$courses="null";
			$package_name="null";
		}


		// // button
		$buttons = '';

		//if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		//}
		//if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
		//}
		//if(in_array('updateOrder', $this->permission)) {
			$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		//}

		if(in_array('deleteOrder', $this->permission)) {
			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		}

		if($value['remain'] == 0) {
			$paid_status = '<span class="label label-success">Paid</span>';	
		}
		else {
			$paid_status = '<span class="label label-warning">Not Paid</span>';
		}
//Change paid state from paid state to remain state
		$result['data'][$key] = array(
			$location,
			$value['branch'],
			$value['education'],				
			$value['customer_name'],
			$value['customer_phone'],
			$value['date_time'],
			$package_name,
			$courses,
			$value['course_completed'],
			$value['net_amount'],
			$value['remain'],
			$paid_status,
			$buttons
			
		);
	} // /foreach

	echo json_encode($result);
	}

	public function fetch_electrical()
	{
	

	  //NEW ADDED FOR WAGHOLI BRANCH 16/4/2019 BY RAMIZ
		$branch="Electrical";//$this->input->get('val');
		$result = array('data' => array());

		  $branch_id=$_SESSION['branch_id'];
				if($branch_id==2)
				{
					$data = $this->model_orders->getFranchiseData($branch,$branch_id);
				
				} 
				else  {					
		     	 $data = $this->model_orders->getBranchWise($branch);
	        	}
		// $count_total_item = $this->model_orders->countBranchWise($branch);

		foreach ($data as $key => $value) {

			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			// $date = date('d-m-Y', $value['date_time']);
			// $time = date('h:i a', $value['date_time']);

			// $date_time = $date . ' ' . $time;

			$package_data= $this->model_orders->getPackage($value['id']);
				 if($value['branch_id']==1)
				 {
					 $location="SHIVAJINAGAR";
				 }
				 elseif($value['branch_id']==2)
				 {
					 $location="KHARADI";
				 }
				 else
				 {
					 $location="NULL";
				 }
				 if($package_data)
				 {
			foreach($package_data as $val)
			{
	           $courses=$val['imei'];
			     $pakage= $this->model_orders->getPackagename($val['product_id']);
			    foreach($pakage as $val)				
			    $package_name=$val['name'];
			}  }
			else 
			{
				$courses="null";
				$package_name="null";
			}


			// // button
			$buttons = '';

			//if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			//}
			//if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			//}
			//if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			//}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['remain'] == 0) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
			}
//Change paid state from paid state to remain state
			$result['data'][$key] = array(
			  $location,
				$value['branch'],
				$value['education'],				
				$value['customer_name'],
				$value['customer_phone'],
				$value['date_time'],
				$package_name,
				$courses,
				$value['course_completed'],
				$value['net_amount'],
				$value['remain'],
				$paid_status,
				$buttons
				
			);
		} // /foreach

		echo json_encode($result);
	}
	public function fetch_civil()
	{
	

		$branch="Civil";//$this->input->get('val');
		$result = array('data' => array());

		$branch_id=$_SESSION['branch_id'];
		if($branch_id==2)
		{
			$data = $this->model_orders->getFranchiseData($branch,$branch_id);
		
		} 
		else  {					
				$data = $this->model_orders->getBranchWise($branch);
				}
// $count_total_item = $this->model_orders->countBranchWise($branch);

foreach ($data as $key => $value) {

	$count_total_item = $this->model_orders->countOrderItem($value['id']);
	// $date = date('d-m-Y', $value['date_time']);
	// $time = date('h:i a', $value['date_time']);

	// $date_time = $date . ' ' . $time;

	$package_data= $this->model_orders->getPackage($value['id']);
		 if($value['branch_id']==1)
		 {
			 $location="SHIVAJINAGAR";
		 }
		 elseif($value['branch_id']==2)
		 {
			 $location="KHARADI";
		 }
		 else
		 {
			 $location="NULL";
		 }
		 if($package_data)
		 {
	foreach($package_data as $val)
	{
				 $courses=$val['imei'];
			 $pakage= $this->model_orders->getPackagename($val['product_id']);
			foreach($pakage as $val)				
			$package_name=$val['name'];
	}  }
	else 
	{
		$courses="null";
		$package_name="null";
	}
		
			if($value['remain'] == 0) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
				
			}
			// // button
			$buttons = '';
				//if(in_array('viewOrder', $this->permission)) {
					$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
					//}
					//if(in_array('viewOrder', $this->permission)) {
						$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
					//}
					//if(in_array('updateOrder', $this->permission)) {
						$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
					//}
		
					if(in_array('deleteOrder', $this->permission)) {
						$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
					}
		
//Change paid state from paid state to remain state
			$result['data'][$key] = array(
				$location,
				$value['branch'],
				$value['education'],				
				$value['customer_name'],
				$value['customer_phone'],
				$value['date_time'],
				$package_name,
				$courses,
				$value['course_completed'],
				$value['net_amount'],
				$value['remain'],
				$paid_status,
				$buttons
			
			);
		} // /foreach

		echo json_encode($result);
	}


//added new Branch
	public function fetch_digitalmarketing()
	{
	
  //NEW ADDED FOR WAGHOLI BRANCH 16/4/2019 BY RAMIZ
	$branch="DigitalMarketing";//$this->input->get('val');
	$result = array('data' => array());

		$branch_id=$_SESSION['branch_id'];
			if($branch_id==2)
			{
				$data = $this->model_orders->getFranchiseData($branch,$branch_id);
			
			} 
			else  {					
					$data = $this->model_orders->getBranchWise($branch);
					}
	// $count_total_item = $this->model_orders->countBranchWise($branch);

	foreach ($data as $key => $value) {

		$count_total_item = $this->model_orders->countOrderItem($value['id']);
		// $date = date('d-m-Y', $value['date_time']);
		// $time = date('h:i a', $value['date_time']);

		// $date_time = $date . ' ' . $time;

		$package_data= $this->model_orders->getPackage($value['id']);
			 if($value['branch_id']==1)
			 {
				 $location="SHIVAJINAGAR";
			 }
			 elseif($value['branch_id']==2)
			 {
				 $location="KHARADI";
			 }
			 else
			 {
				 $location="NULL";
			 }
			 if($package_data)
			 {
		foreach($package_data as $val)
		{
					 $courses=$val['imei'];
				 $pakage= $this->model_orders->getPackagename($val['product_id']);
				foreach($pakage as $val)				
				$package_name=$val['name'];
		}  }
		else 
		{
			$courses="null";
			$package_name="null";
		}


		// // button
		$buttons = '';

		//if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		//}
		//if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
		//}
		//if(in_array('updateOrder', $this->permission)) {
			$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		//}

		if(in_array('deleteOrder', $this->permission)) {
			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		}

		if($value['remain'] == 0) {
			$paid_status = '<span class="label label-success">Paid</span>';	
		}
		else {
			$paid_status = '<span class="label label-warning">Not Paid</span>';
		}
//Change paid state from paid state to remain state
		$result['data'][$key] = array(
			$location,
			$value['branch'],
			$value['education'],				
			$value['customer_name'],
			$value['customer_phone'],
			$value['date_time'],
			$package_name,
			$courses,
			$value['course_completed'],
			$value['net_amount'],
			$value['remain'],
			$paid_status,
			$buttons
			
		);
	} // /foreach

	echo json_encode($result);
	}


}