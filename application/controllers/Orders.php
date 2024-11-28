<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'NIIT';

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
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Completed List';
		$this->render_template('orders/index', $this->data);		
	}

public function data_wagholi()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage ';
		$this->render_template('orders/data_wagholi', $this->data);		
	}
	public function data_shivajinagar()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage ';
		$this->render_template('orders/data_shivajinagar', $this->data);		
	}

	public function today_list()
	{
		// if(!in_array('viewOrder', $this->permission)) {
    //         redirect('dashboard', 'refresh');
    //     }

		$this->data['page_title'] = 'Manage ';
		$this->render_template('orders/today_list', $this->data);		
	}
	public function today_list_wagholi()
	{
		// if(!in_array('viewOrder', $this->permission)) {
    //         redirect('dashboard', 'refresh');
    //     }

		$this->data['page_title'] = 'Manage ';
		$this->render_template('orders/today_list_wagholi', $this->data);		
	}




//New added date wise load data
	public function date_wise()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Orders';
		$this->render_template('orders/date_wise', $this->data);		
	}
	public function date_wise_report()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Reports';
		$this->render_template('reports/date_wise', $this->data);		
	}
	
// 	/*
// 	* Fetches the orders data from the orders table 
// 	* this function is called from the datatable ajax function
// 	*/
// 	public function fetchOrdersData()
// 	{
// 		$result = array('data' => array());

// 		$data = $this->model_orders->getOrdersData();

// 		foreach ($data as $key => $value) {

// 			$count_total_item = $this->model_orders->countOrderItem($value['id']);
		
// 			// $date = date('d-m-Y', $value['date_time']);
// 			// $time = date('h:i a', $value['date_time']);

// 			// $date_time = $date . ' ' . $time;
	
// 				 $package_data= $this->model_orders->getPackage($value['id']);
		
				 
// 				 foreach($package_data as $val)
// 				 {
//           $courses=$val['imei'];
// 					$pakage=$this->model_orders->getPackagename($val['product_id']);
// 					foreach($pakage as $val)				
// 				  $package_name=$val['name'];
// 				 }
	
				 
// 			$buttons = '';

// 			if(in_array('viewOrder', $this->permission)) {
// 				$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-money"></i></a>';
// 			}
// 			if(in_array('viewOrder', $this->permission)) {
// 				$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
// 			}
// 			if(in_array('updateOrder', $this->permission)) {
// 				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
// 			}

// 			if(in_array('deleteOrder', $this->permission)) {
// 				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
// 			}

// 			if($value['remain'] == 0) {
// 				$paid_status = '<span class="label label-success">Paid</span>';	
// 			}
// 			else {
// 				$paid_status = '<span class="label label-warning">Not Paid</span>';
// 			}
// //Change paid state from paid state to remain state
// 			$result['data'][$key] = array(
// 				$value['branch'],
// 				$value['education'],				
// 				$value['customer_name'],
// 				$value['customer_phone'],
// 		     	$value['date_time'],			
// 				$package_name,
// 				$courses,
// 				$value['net_amount'],
// 				$value['remain'],
// 				$value['pay'],
// 				$paid_status,
// 				$buttons
// 			);
// 		} // /foreach

// 		echo json_encode($result);
// 	}

	public function fetchOrdersData(){
	$result = array('data' => array());
		$branch_id= $_SESSION['branch_id'];
		$email= $_SESSION['email'];
		$admin = $this->model_users->getSingleUserData($email);
		// var_dump($admin);
		// die();
		if($branch_id!=2)
		{
		// foreach($admin as $val)
		// {
		// 	if($val['group_id']==1)
		// 	{		
		  $data = $this->model_orders->getOrdersData();
		//	}
		}
			else
			{ 	
				$data = $this->model_orders->getBranchData($branch_id);			
			}		
		foreach($data as $key => $value)
		 {
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
		
			// $date = date('d-m-Y', $value['date_time']);
			// $time = date('h:i a', $value['date_time']);

			// $date_time = $date . ' ' . $time;
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
	
				 $package_data= $this->model_orders->getPackage($value['id']);
		
				 if($package_data){
				 foreach($package_data as $val)
				 {
           $courses=$val['imei'];
					$pakage=$this->model_orders->getPackagename($val['product_id']);
					foreach($pakage as $val)				
				  $package_name=$val['name'];
				 }
				}
				else{
					$courses= $package_name="null";
				}
				 
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-money"></i></a>';
			}
			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			}
			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

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
				$value['pay'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


    /*
        Created By: Akash K Fulari
        On Date: 01-03-2024
    */
	public function fetchOnogoingBatch(){
	  
	    $result = array('data' => array());
	    
        $bid = $this->input->post("bid");
        $bname = $this->input->post("bname");
        
        if(!empty($bid) && !empty($bname)){
		    $data = $this->model_orders->getOrdersDataByBranchIdAndName($bid, $bname);
		    foreach($data as $key => $value){
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
		
			// $date = date('d-m-Y', $value['date_time']);
			// $time = date('h:i a', $value['date_time']);

			// $date_time = $date . ' ' . $time;
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
	
				 $package_data= $this->model_orders->getPackage($value['id']);
		
				 if($package_data){
				 foreach($package_data as $val)
				 {
          $courses=$val['imei'];
					$pakage=$this->model_orders->getPackagename($val['product_id']);
					foreach($pakage as $val)				
				  $package_name=$val['name'];
				 }
				}
				else{
					$courses= $package_name="null";
				}
				 
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-money"></i></a>';
			}
			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			}
			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

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
				$value['pay'],
				$paid_status,
				$buttons
			);
		}
        }

		echo json_encode($result);
	}

    /*
    * Created By: Akash K. Fulari
    * Created On: 21-03-2024
    */ 
    public function fetchBatchByStatus($bid, $status){
	  
	    $result = array('data' => array());
        
        if($bid!=null && $status!=null){
		    $data = $this->model_orders->getOrdersDataByBranchIdAndStatus($bid, $status);
		    foreach($data as $key => $value){
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
		
			// $date = date('d-m-Y', $value['date_time']);
			// $time = date('h:i a', $value['date_time']);

			// $date_time = $date . ' ' . $time;
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
	
				 $package_data= $this->model_orders->getPackage($value['id']);
		
				 if($package_data){
				 foreach($package_data as $val)
				 {
          $courses=$val['imei'];
					$pakage=$this->model_orders->getPackagename($val['product_id']);
					foreach($pakage as $val)				
				  $package_name=$val['name'];
				 }
				}
				else{
					$courses= $package_name="null";
				}
				 
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-money"></i></a>';
			}
			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			}
			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

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
				$value['pay'],
				$paid_status,
				$buttons
			);
		}
        }

		echo json_encode($result);
	}


//list today fetch 23/4/19
public function todaylist()
{
	$result = array('data' => array());
	$branch_id= $_SESSION['branch_id'];
	$email= $_SESSION['email'];
	$admin = $this->model_users->getSingleUserData($email);

		
			$data = $this->model_orders->today_list();			

	foreach($data as $key => $value)
	 {
		$count_total_item = $this->model_orders->countOrderItem($value['id']);
	
		// $date = date('d-m-Y', $value['date_time']);
		// $time = date('h:i a', $value['date_time']);

		// $date_time = $date . ' ' . $time;
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

			 $package_data= $this->model_orders->getPackage($value['id']);
	
			 if($package_data){
			 foreach($package_data as $val)
			 {
				 $courses=$val['imei'];
				$pakage=$this->model_orders->getPackagename($val['product_id']);
				foreach($pakage as $val)				
				$package_name=$val['name'];
			 }
			}
			else{
				$courses= $package_name="null";
			}
			 
		$buttons = '';

		if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		}
		if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
		}
		if(in_array('updateOrder', $this->permission)) {
			$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		}

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
			$value['pay'],
			$paid_status,
			$buttons
		);
	} // /foreach

	echo json_encode($result);
}



public function todaylist_wagholi()
{
	$result = array('data' => array());
	$branch_id= $_SESSION['branch_id'];
	$email= $_SESSION['email'];
	$admin = $this->model_users->getSingleUserData($email);

		
			$data = $this->model_orders->today_list_wagholi();			

	foreach($data as $key => $value)
	 {
		$count_total_item = $this->model_orders->countOrderItem($value['id']);
	
		// $date = date('d-m-Y', $value['date_time']);
		// $time = date('h:i a', $value['date_time']);

		// $date_time = $date . ' ' . $time;
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

			 $package_data= $this->model_orders->getPackage($value['id']);
	
			 if($package_data){
			 foreach($package_data as $val)
			 {
				 $courses=$val['imei'];
				$pakage=$this->model_orders->getPackagename($val['product_id']);
				foreach($pakage as $val)				
				$package_name=$val['name'];
			 }
			}
			else{
				$courses= $package_name="null";
			}
			 
		$buttons = '';

		if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		}
		if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
		}
		if(in_array('updateOrder', $this->permission)) {
			$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		}

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
			$value['pay'],
			$paid_status,
			$buttons
		);
	} // /foreach

	echo json_encode($result);
}





	public function fetchOrdersDataw()
	{
		$result = array('data' => array());
		$branch_id=2;
		$email= $_SESSION['email'];
		$admin = $this->model_users->getSingleUserData($email);
		// var_dump($admin);
		// die();
		if($branch_id!=2)
		{
		// foreach($admin as $val)
		// {
		// 	if($val['group_id']==1)
		// 	{		
		  $data = $this->model_orders->getOrdersData();
		//	}
		}
			else
			{ 	
				$data = $this->model_orders->getBranchData($branch_id);			
			}		
		foreach($data as $key => $value)
		 {
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
		
			// $date = date('d-m-Y', $value['date_time']);
			// $time = date('h:i a', $value['date_time']);

			// $date_time = $date . ' ' . $time;
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
	
				 $package_data= $this->model_orders->getPackage($value['id']);
		
				 if($package_data){
				 foreach($package_data as $val)
				 {
           $courses=$val['imei'];
					$pakage=$this->model_orders->getPackagename($val['product_id']);
					foreach($pakage as $val)				
				  $package_name=$val['name'];
				 }
				}
				else{
					$courses= $package_name="null";
				}
				 
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			}
			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}
			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

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
				$value['pay'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	public function fetchOrdersDataS()
	{
		$result = array('data' => array());
		$branch_id=1;
		$email= $_SESSION['email'];
		$admin = $this->model_users->getSingleUserData($email);
		// var_dump($admin);
		// die();
		if($branch_id!=1)
		{
		// foreach($admin as $val)
		// {
		// 	if($val['group_id']==1)
		// 	{		
		  $data = $this->model_orders->getOrdersData();
		//	}
		}
			else
			{ 	
				$data = $this->model_orders->getBranchData($branch_id);			
			}		
		foreach($data as $key => $value)
		 {
			$count_total_item = $this->model_orders->countOrderItem($value['id']);
		
			// $date = date('d-m-Y', $value['date_time']);
			// $time = date('h:i a', $value['date_time']);

			// $date_time = $date . ' ' . $time;
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
	
				 $package_data= $this->model_orders->getPackage($value['id']);
		
				 if($package_data){
				 foreach($package_data as $val)
				 {
           $courses=$val['imei'];
					$pakage=$this->model_orders->getPackagename($val['product_id']);
					foreach($pakage as $val)				
				  $package_name=$val['name'];
				 }
				}
				else{
					$courses= $package_name="null";
				}
				 
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			}
			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}
			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

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
				$value['pay'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}




	
	public function fetch_datewise()
	{
	 $sdate= $this->input->post('start_date');
	 $edate= $this->input->post('end_date');
	 $data= $this->model_orders->fetch_datewise($sdate,$edate);


  if($data){

	  foreach($data as $key => $value) {
	      
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
			$package_data= $this->model_orders->getPackage($value['id']);
		
			if($package_data){
			foreach($package_data as $val)
			{
				$courses=$val['imei'];
			 $pakage=$this->model_orders->getPackagename($val['product_id']);
			 foreach($pakage as $val)				
			 $package_name=$val['name'];
			}
		 }
		 else{
			 $courses= $package_name="null";
		 }
			
	   $buttons = '';

	    if(in_array('viewOrder', $this->permission)) {
		     $buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
	     }
	    if(in_array('viewOrder', $this->permission)) {
	     	 $buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
	      }
	    if(in_array('updateOrder', $this->permission)) {
		    $buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
	     }

	    if(in_array('deleteOrder', $this->permission)) {
		      $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
	     }

	   if($value['remain'] == 0) {
	     	 $paid_status = '<span class="label label-success">Paid</span>';	
	      }
	  else {
		      $paid_status = '<span class="label label-warning">Not Paid</span>';
	     }
	$this->data['order_data'][$key]  = array(	
	    $location,
		$value['branch'],
		$value['education'],				
		$value['customer_name'],
		$value['customer_phone'],
		$value['date_time'],			
		$package_name,
		$courses,
		$value['net_amount'],
		$value['remain'],
		$value['pay'],
		$paid_status,
	
	);
// /foreach
	}} 
		else
	{
		$this->data['order_data']=null;
	}

// 	var_dump($this->data['order_data']);
// die();

$this->render_template('orders/order_date', $this->data);
}



public function fetch_datewise_report()
{
 $sdate= $this->input->post('start_date');
 $edate= $this->input->post('end_date');
 $franchise= $this->input->post('franchise');
 
 $data= $this->model_orders->fetch_datewise($sdate,$edate,$franchise);
 $total=0;
 $pay=0;
 $remain=0;


if($data){

  foreach($data as $key => $value) {
	  
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
		$package_data= $this->model_orders->getPackage($value['id']);
	
		if($package_data){
		foreach($package_data as $val)
		{
			$courses=$val['imei'];
		 $pakage=$this->model_orders->getPackagename($val['product_id']);
		 foreach($pakage as $val)				
		 $package_name=$val['name'];
		}
	 }
	 else{
		 $courses= $package_name="null";
	 }
		
   $buttons = '';

	if(in_array('viewOrder', $this->permission)) {
		 $buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
	 }
	if(in_array('viewOrder', $this->permission)) {
		  $buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
	  }
	if(in_array('updateOrder', $this->permission)) {
		$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
	 }

	if(in_array('deleteOrder', $this->permission)) {
		  $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
	 }

   if($value['remain'] == 0) {
		  $paid_status = '<span class="label label-success">Paid</span>';	
	  }
  else {
		  $paid_status = '<span class="label label-warning">Not Paid</span>';
	 }
	 $total= $total + $value['net_amount'];
	 $remain=$remain + $value['remain'];
	 $pay=$pay + $value['pay'];

$this->data['order_data'][$key]  = array(	
	$location,					
	$value['customer_name'],
	$value['customer_phone'],
	$value['date_time'],
	$value['net_amount'],
	$value['remain'],
	$value['pay'],
	$paid_status,

);


// /foreach
}} 
	else
{
	$this->data['order_data']=null;
}

$this->data['total']=array($total,$remain,$pay);

// 	var_dump($this->data['order_data']);
// die();

$this->render_template('reports/dateview_report', $this->data);
}

	
	
	
	
	
	
	
	
	
	
	
	
	

	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation for each input field is valid then it inserts the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Add Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		$this->form_validation->set_rules('customer_gst', 'Email', 'trim|required|is_unique[orders.customer_gst]');

		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$order_id = $this->model_orders->create();
        	
        	if($order_id) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('orders/update/'.$order_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/create/', 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/create', $this->data);
        }	
	}

	




// 	public function createp()
// 	{
// $this->load->view("placement/create");
// 	}

	/*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		if($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			echo json_encode($product_data);
		}
	}
	// public function getProductColorById()
	// {
	// 	$product_id = $this->input->post('product_id');
	// 	if($product_id) {
	// 		$product_color = $this->model_products->getProductColor($product_id);
	
	// 		echo json_encode($product_color);
	// 	}
	// }
	/*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		$products = $this->model_products->getActiveProductData();

	// 	$c;
	// array("")
		echo json_encode($products);
		
	}

	public function getcolor()
	{
		$color = $this->model_products->getcolor();
		echo json_encode($color);

	// 	$c;
	// array("")
	
	}

	public function load()
	{
		$this->load->view("orders/load_stud");
	}
	//4-2-2019 added for load student branch wise on dashboard Block
	public function load_stud()
	{
  

		$branch="Computer";//$this->input->get('val');
		$result = array('data' => array());

		$data = $this->model_orders->getBranchWise($branch);
		$count_total_item = $this->model_orders->countBranchWise($branch);
		foreach ($data as $key => $value) {

		
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);

			$date_time = $date . ' ' . $time;

			// button
			// $buttons = '';

			// if(in_array('viewOrder', $this->permission)) {
			// 	$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			// }
			// if(in_array('viewOrder', $this->permission)) {
			// 	$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			// }
			// if(in_array('updateOrder', $this->permission)) {
			// 	$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			// }

			// if(in_array('deleteOrder', $this->permission)) {
			// 	$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			// }

			if($value['remain'] == 0) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
			}
//Change paid state from paid state to remain state
			$result['data'][$key] = array(
				$value['id'],	
				$value['branch'],
				$value['education'],				
				$value['customer_name'],
				$value['customer_phone'],
				$date_time,
			
				$value['net_amount'],
				$value['remain'],
				$paid_status,
			//	$buttons
			);
		} // /foreach

		echo json_encode($result);
	}








	public function getcategoryall()
	{
		$products = $this->model_category->getcategoryall();
		echo json_encode($products);
	}

	function convert_number($number) {
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
    return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
}


	/*
	* If the validation is not valid, then it redirects to the edit orders page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_orders->update($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData($id);

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$this->data['order_data'] = $result;

        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/edit', $this->data);
        }
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$order_id = $this->input->post('order_id');

        $response = array();
        if($order_id) {
            $delete = $this->model_orders->remove($order_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response); 
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		if($id) {
			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);

			$order_date = date('d/m/Y', $order_data['date_time']);
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			  <style>
			  img{
			  	float:left;
			  	width:50%;
			  	height:50%;		  	
			  	
			  }
			  b{
			  	text-align:right;
			  }
			  .head{
			  	text-align:center;
			  }
			   h5{
			  	text-align:center;
			  }
			  </style>
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			     
			      
			      <div class="col-sm-3 col-lg-2 invoice-col">
			           <img src="'.base_url('assets/images/logo.png').'" class="pull-left">
			      </div>
			      <!-- /.col -->
		
			      
			      <div class="col-sm-5 col-lg-6 invoice-col">
			       <H6 style="text-align:center;"><b>TAX INVOICE </b></H5>
			   						
			      <H3 style="text-align:center;" ><b>Graphix Technolgies </b></H3>
				  
				  <div class="row">
				 <H5>   Opp. Indira Shopping Center, Main Road, Kopargaon(Pune)						</H5>			
				   <H5><u><font color="blue">Email - niit_rakesh@niit.com</font></u>						<br>
			    9422792090/9422188881						</H5>
			      </div>
				  </div>
			      
			      		<div class="col-sm-4 col-lg-4 invoice-col">
			      	<br/>		
			        <br/>					    
			    
			        <b>GSTIN:</b> 27ASOPK6578K1ZU<br/>
			         <b>Cash/Credit Memo</b><br/>
			         <br/>	
                     <br/>
			        <b>BILL No:</b> '.$order_data['bill_no'].'<br/>
					 <b>Date:</b> '.$order_date.'
			        
			      </div>      
			     
</div>
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			   
							<h2 class="page-header"><b>Student Name: </b>'.$order_data['customer_name'].'<small class="pull-right">Student Email.: '.$order_data['customer_gst'].'</small> <br/>
							
			       <b>Address:</b> '.$order_data['customer_address'].'<small class="pull-right">Mob. No.: '.$order_data['customer_phone'].'</small></h2>
					 
			      </div>
			      <!-- /.col -->
			    </div>
				
				
			    <!-- info row -->
			 
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Sr.No</th>
			            <th>Course Description</th>		
			            <th>Duration</th>
					
			            <th>Rate</th>		           
			            <th>Amount</th>
			          </tr>
			          </thead>
			          <tbody>'; 
			          $i=1;

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']); 
			          	
			          	$html .= '<tr>
			          	     <td>'.$i.'</td>
				            <td>'.$product_data['name'].'</td> 						
							 <td>'.$v['hsn'].'</td>
					
				            <td>'.$v['rate'].'</td>	          
				          <td>'.$v['amount'].'</td>
			          	</tr>
                        
                         <tr>
                        <td> <td>
                       
                        </tr>
                         <tr>
                        <td> </td>
                  
                        </tr>
                         <tr>
                        <td> </td>
                       
                        </tr>
                          <tr>
                        <td> </td>
                       
                        </tr>
                         <tr>
                        <td> </td>                        
                        </tr>

                       
			          	';
			          	$i++;
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			      
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table" style="margin-left:0px;">

			            <tr>
			              <th style="width:50%">S.G.S.T.('.$order_data['vat_charge_rate'].'%)</th>
			              <td>'.$order_data['vat_charge'].'</td>
			            </tr>';

			            if($order_data['service_charge'] > 0) {
			            	
			            }

			            if($order_data['vat_charge'] > 0) {
			            	$html .= '<tr>
				              <th>C.G.S.T.('.$order_data['vat_charge_rate'].'%)</th>
				              <td>'.$order_data['vat_charge'].'</td>
				            </tr>';
			            }
			            
			            
			            $html .='
									    
						<tr>
									<th> Total: </th>								
										<td><b>'.$order_data['net_amount'].'</b></td>										
										
						</tr>
															
		          
			          </table>
			          
			        </div>
						</div>
						<div class="col-xs-12 table-responsive">
						<table class="table table-striped">
							<thead>
							<tr>
							<tr>									
							<th>Amount Chargeable(in words)Rs:<th>														
							 <td><b>'.$this->convert_number($order_data['net_amount']).'</b></td>
					</tr>								
			
				</table>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
				
				 <div class="row">
			      
										
				<div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Course</th>
			            <th>Taxable Value</th>
			            <th colspan="2">State Tax</th>
			            <th colspan="2">Central Tax</th>
			          </tr>
					  
					  <tr>
			            <th></th>
			            <th></th>
			            <th>Rate</th>
			            <th>Amount</th>
						 <th>Rate</th>
			            <th>Amount</th>
						
			          </tr>
			          </thead>
			          <tbody>'; 

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']); 
											$am=$v['amount'];
											$txam=$am*6/100;
			          	$html .= '<tr>
									<td>'.$product_data['name'].'</td> 	
				            <td>'.$v['amount'].'</td>
				            <td>'.$order_data['vat_charge_rate'].'</td>
							<td>'.$txam.'</td>
				            <td>'.$order_data['vat_charge_rate'].'</td>
							<td>'.$txam.'</td>
									</tr>';
								}
								
			          
								$html .= '
								
								<tr>
								<th>Taxable Amount(in words)Rs:<th>														
								<td ><b>'.$this->convert_number($order_data['vat_charge']).'</b></td>
							</tr>														
							</tbody>
							</table>
							
			      </div>
				
				
				
					
				  
				  <div class="row">
				  
				    <div class="col-sm-10 pull pull-left">
					<p><b>Note:</b>*Goods once sold will not be exchange or returned<br>                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					*For service during warrenty period please contact authorised service center.</p>
					</div>
					
					 <div class="col-sm-2 pull pull-right">
					 <br>
					<p>&nbsp;&nbsp;&nbsp;<b>Signature</b></p>
					</div>
				  
				  </div>
				  
				  
				  
				   </div>
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}

	public function view($id)
	{
			

		$data['h']=$this->model_orders->cash_detail($id);
		$this->load->view('templates/header');
	//	$this->load->view('templates/header_menu');
	//	$this->load->view('templates/side_menubar');
	//	$this->load->view($page, $data);		
		// $this->load->view('templates/footer');
	//	$this->load->view('templates/');
		// var_dump($data['h']);
		// die();
		$this->load->view("orders/orderv",$data);
		
	}
public function print_form($id)
{

$data['h']=$this->model_orders->single_student($id);

	$this->load->view('templates/header');
//	$this->load->view('templates/header_menu');
//	$this->load->view('templates/side_menubar');
//	$this->load->view($page, $data);		
	// $this->load->view('templates/footer');
//	$this->load->view('templates/');
	// var_dump($data['h']);
	// die();
	$this->load->view("orders/studentinfo",$data);
}

public function email()
	{
	
$this->load->view('email/PHPMailerAutoload.php');// it will be in PHPMailer
$this->load->view('email/class.smtp.php');// it will be in PHPMailer
$this->load->view('email/class.phpmailer.php');// it will be in PHPMailer


$response = array();
$email = "ak.rathod0603@gmail.com";
$messageBody="Test Mail";
$subject = "Test ";

if(!empty($email)){

    
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // authentication enabled
        $mail->IsHTML(false); 
        $mail->SMTPSecure = 'tls';//turn on to send html email
        // $mail->Host = "ssl://smtp.zoho.com";
        $mail->Host = "smtp.gmail.com";//you can use gmail 
        $mail->Port = 587;
        $mail->Username = "ak.rathod0603@gmail.com";
        $mail->Password = "ashish@interface11";
        $mail->SetFrom("ak.rathod0603@gmail.com", "Any demo alert");
        $mail->Subject = $subject;

        $mail->Body = $messageBody;
        $mail->AddAddress("careernatinalpharma@gmail.com");
      

        if(!$mail->send()) {
           echo "Mailer Error: " . $mail->ErrorInfo;
       } 
       else {
           echo "Message has been sent successfully";
      }
    }


else{
    $response["valid"] = false;
    $response["message"] = "Required field(s) missing";
    echo json_encode($response);
}
	

	}
	
// new for download	
public function download_ssc()
{
	$email=$_GET['val'];
	$this->load->helper('download');
	if($email) {
		$sql = "SELECT ssc FROM placement where email =? order by id desc";
		$query = $this->db->query($sql,$email);
		$arr= $query->row_array();
		if($arr)
		{
		foreach ($arr as $key => $val) {
		 $a= 'assets/images/product_image/'.$val;


					 if($val!="<p>You did not select a file to upload.</p>" && $val!=null)
		 {
		

		 force_download($a,NULL); 

		 }
		 
		else
		{
		$this->session->set_flashdata('error', 'You did not select  document to upload.');
		echo "<script>
				 
					 window.history.go(-1);
	 </script>";	
			}  }}
			
				else
		{
		$this->session->set_flashdata('error', 'You did not select  document to upload.');
		echo "<script>
				 
					 window.history.go(-1);
	 </script>";	
			} 
			

	}
	else {
	$this->session->set_flashdata('error', 'You did not select  document to upload.');
	echo "<script>
				 
	window.history.go(-1);
</script>";	}



}


public function download_lc()
{

	$this->load->helper('download');
	$email=$_GET['val'];
	if($email) {
		$sql = "SELECT lc FROM placement where email =? order by id desc";
		$query = $this->db->query($sql,$email);
		$arr= $query->row_array();
		if($arr)
		{
		foreach ($arr as $key => $val) {
		 $a= 'assets/images/product_image/'.$val;


					 if($val!="<p>You did not select a file to upload.</p>" && $val!=null)
		 {
		

		 force_download($a,NULL); 

		 }
		 
		else
		{
		$this->session->set_flashdata('error', 'You did not select document to upload.');
		echo "<script>
				 
					 window.history.go(-1);
	 </script>";	
			}  } }	
			
				else
		{
		$this->session->set_flashdata('error', 'You did not select document to upload.');
		echo "<script>
				 
					 window.history.go(-1);
	 </script>";	
			}
			
			

	}
	else {
	$this->session->set_flashdata('error', 'You did not select  document to upload.');
	echo "<script>
				 
	window.history.go(-1);
</script>";	}



}

public function download_cast()
{

	$this->load->helper('download');
	$email=$_GET['val'];
	if($email) {
		$sql = "SELECT cast FROM placement where email =? order by id desc";
		$query = $this->db->query($sql,$email);
		$arr= $query->row_array();
	    if($arr)
	    {
		foreach ($arr as $key => $val) {
		 $a= 'assets/images/product_image/'.$val;


					 if($val!="<p>You did not select a file to upload.</p>" && $val!=null)
		 {
		

		 force_download($a,NULL); 


		 }
		 
		else
		{
		$this->session->set_flashdata('error', 'You did not select document to upload.');
		echo "<script>
				 
					 window.history.go(-1);
	 </script>";	
			}  } }	
			
			else
			{
			   	$this->session->set_flashdata('error', 'You did not select document to upload.');
		echo "<script>
				 
					 window.history.go(-1);
	 </script>"; 
			}

	}
	else {
	$this->session->set_flashdata('error', 'You did not select  document to upload.');
	echo "<script>
				 
	window.history.go(-1);
</script>";	}

}

public function download_res()
{
	$email=$_GET['val'];
	$this->load->helper('download');
	if($email) {
		$sql = "SELECT  file FROM placement where email =? order by id desc";
		$query = $this->db->query($sql,$email);
		$arr= $query->row_array();
		
		if($arr)
		{
		foreach ($arr as $key => $val) {
		 $a= 'assets/images/product_image/'.$val;


					 if($val!="<p>You did not select a file to upload.</p>" && $val!=null)
		 {
		

		 force_download($a,NULL); 

		 }
		 
		else
		{
		$this->session->set_flashdata('error', 'You did not select  document to upload.');
		echo "<script>
				 
					 window.history.go(-1);
	 </script>";	
			}  }		

	}
	 	else
		{
		$this->session->set_flashdata('error', 'You did not select  document to upload.');
		echo "<script>
				 
					 window.history.go(-1);
	 </script>";	
			}   
	    
	}
	else {
	$this->session->set_flashdata('error', 'You did not select  document to upload.');
	echo "<script>
				 
	window.history.go(-1);
</script>";
}

}
// New resned email 29/4/19
	public function load_resend_email()
	{
		

		$this->data['page_title'] = 'Resend Email';
		$this->render_template('orders/resend_email', $this->data);		
	}

public function resend_email()
{

	$email=$this->input->post('email');

	$this->form_validation->set_rules('email', 'Email', 'trim|required');
	

			if ($this->form_validation->run() == TRUE) { 
			    
			    

				
				$id= $this->model_orders->resend_email($email);	
			
				if($id) {
					$this->session->set_flashdata('success', 'Successfully send');
					redirect('orders/load_resend_email', 'refresh');
				}
				else {
					$this->session->set_flashdata('error', 'Email Not Matched');
					redirect('orders/load_resend_email', 'refresh');
				}
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('orders/load_resend_email', 'refresh');
			}	
}

// List student of course completed 

public function course_CompletedList()
{
$result = array('data' => array());
	$branch_id= 1;
	$email= $_SESSION['email'];
	$admin = $this->model_users->getSingleUserData($email);
	// var_dump($admin);
	// die();

			$data = $this->model_orders->getCompletedData($branch_id);			
				
	foreach($data as $key => $value)
	 {
		$count_total_item = $this->model_orders->countOrderItem($value['id']);
	
		// $date = date('d-m-Y', $value['date_time']);
		// $time = date('h:i a', $value['date_time']);

		// $date_time = $date . ' ' . $time;
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

			 $package_data= $this->model_orders->getPackage($value['id']);
	
			 if($package_data){
			 foreach($package_data as $val)
			 {
				 $courses=$val['imei'];
				 $duration=$val['hsn'];
				$pakage=$this->model_orders->getPackagename($val['product_id']);
				foreach($pakage as $val)				
				$package_name=$val['name'];
			 }
			}
			else{
				$duration=$courses= $package_name="null";
			}
			 
		$buttons = '';

		$bill=$value['bill_no'];
	

		$bill_date=$this->model_orders->getLastPayDate($bill); 
		if($bill_date)
		{
	 $pdate=date("Y-m-d",  strtotime($bill_date->date));	 

		$dur = intval(preg_replace('/[^0-9]+/', '', $duration), 10);
		$dur=$dur."months";
		// echo $value['date_time'];

						
	 $complete_Date=date("Y-m-d", strtotime($dur, strtotime($pdate)));
		}
		else 
		{
			$complete_Date=null;
		}


  
		if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		}
		if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
		}
		if(in_array('updateOrder', $this->permission)) {
			$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		}

	

		if($value['remain'] == 0) {
			$paid_status = '<span class="label label-success">Paid</span>';	
		}
		else {
			$paid_status = '<span class="label label-warning">Not Paid</span>';
		}
		$current_date=date('Y-m-d');
	

		if($current_date>$complete_Date && $complete_Date!=0 && $value["remain"]==0 && $duration)
		{
//Change paid state from paid state to remain state
	$this->data['order_data'][$key] = array(	
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
		   	$value['pay'],
		   	$paid_status,
		  	$buttons
		);
	} // /foreach
	else
	{
		$this->data['order_data'][$key] =null;
	}


	 }


	 $this->render_template('orders/course_Completed', $this->data);

}

//view
public function courseCompletedSivajinagar()
{
	if(!in_array('viewOrder', $this->permission)) {
					redirect('dashboard', 'refresh');
			}

	$this->data['page_title'] = 'Course Completed';
	$this->render_template('orders/course_Completed', $this->data);		
}

public function courseCompletedWagholi()
{
	if(!in_array('viewOrder', $this->permission)) {
					redirect('dashboard', 'refresh');
			}

	$this->data['page_title'] = 'Course Completed';
	$this->render_template('orders/course_CompletedWagholi', $this->data);		
}

public function course_CompletedListWagholi()
{
$result = array('data' => array());
	$branch_id= 2;
	$email= $_SESSION['email'];
	$admin = $this->model_users->getSingleUserData($email);
	// var_dump($admin);
	// die();

			$data = $this->model_orders->getCompletedData($branch_id);			
				
	foreach($data as $key => $value)
	 {
		$count_total_item = $this->model_orders->countOrderItem($value['id']);
	
		// $date = date('d-m-Y', $value['date_time']);
		// $time = date('h:i a', $value['date_time']);

		// $date_time = $date . ' ' . $time;
		if($value['branch_id']==1)
		{
			$location="SHIVAJINAGAR";
		}
		elseif($value['branch_id']==2)
		{
			$location="WAGHOLI";
		}
		else
		{
			$location="NULL";
		}

			 $package_data= $this->model_orders->getPackage($value['id']);
	
			 if($package_data){
			 foreach($package_data as $val)
			 {
				 $courses=$val['imei'];
				 $duration=$val['hsn'];
				$pakage=$this->model_orders->getPackagename($val['product_id']);
				foreach($pakage as $val)				
				$package_name=$val['name'];
			 }
			}
			else{
				$duration=$courses= $package_name="null";
			}
			 
		$buttons = '';

		$bill=$value['bill_no'];

		// echo $bill.'<br>';

	

		$bill_date=$this->model_orders->getLastPayDate($bill); 

		// echo $bill_date->date.'<br>';

		if($bill_date->date)
		{
	 $pdate=date("Y-m-d",  strtotime($bill_date->date));
	 
	//  echo $pdate.'<br>';

		$dur = intval(preg_replace('/[^0-9]+/', '', $duration), 10);
	 
		$dur=$dur."months";

		// echo $dur.'<br>';
	
						
	 $complete_Date=date("Y-m-d", strtotime($dur, strtotime($pdate)));
	  // echo $complete_Date.'<br>';
		}
		else 
		{
			$complete_Date=null;
		}

  
		if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		}
		if(in_array('viewOrder', $this->permission)) {
			$buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
		}
		if(in_array('updateOrder', $this->permission)) {
			$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		}

	

		if($value['remain'] == 0) {
			$paid_status = '<span class="label label-success">Paid</span>';	
		}
		else {
			$paid_status = '<span class="label label-warning">Not Paid</span>';
		}
		$current_date=date('Y-m-d');
		// echo $current_date;
		// die();

		if($current_date>$complete_Date && $complete_Date!=0 && $value["remain"]==0 && $duration)
		{
//Change paid state from paid state to remain state
	$this->data['order_data'][$key] = array(	
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
		   	$value['pay'],
		   	$paid_status,
		  	$buttons
		);
	   } // /foreach
else{
	$this->data['order_data'][$key] =null;
}

	 }


	 $this->render_template('orders/course_CompletedWagholi', $this->data);

}

public function pass()
{
   	$sql = "SELECT password FROM users where id=3";
		$query = $this->db->query($sql);
		$a= $query->row_array();
		
		
$p=password_verify('$2y$10$7erGeNVSiA9.LIKAUWEPUOtOS2Pg8AeJ6SXzYIcgOBbRqxSzoLkB2', $a['password']);
if($p==true)
{
    print_r($a);
}
else
{
       print_r("dsfsff");
}

}
/*
* Created By: Akash K. Fulari
* Created On: 27-02-2024
*/ 
 public function view_ongoing_batches(){
    $id=$this->input->get("b");
    $branch=$this->input->get("name");
    $this->data['branch_id'] = $id;
    $this->data['branch_name'] = $branch;
     
	$this->render_template('orders/view_ongoing_batch', $this->data);
 }
 
/*
* Created By: Akash K. Fulari
* Created On: 21-03-2024
*/ 

 public function filter(){
    $id=$this->input->get("b");
    $status=$this->input->get("s");
    $this->data['branch_id'] = $id;
    $this->data['status'] = $status;
     
	$this->render_template('orders/view_completed_incompleted_batches', $this->data);
 }

}