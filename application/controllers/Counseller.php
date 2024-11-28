<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Counseller extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Counseller';

		$this->load->model('Model_counseller');
		
		$this->load->model('model_orders');
		$this->load->helper('url');
	}
	public function load()
	{
        // if(!in_array('viewPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		$this->render_template('counseller/create', $this->data);	
	}

	public function index()
	{
        // if(!in_array('viewPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		$this->render_template('counseller/index', $this->data);	
    }

	public function today_wagholi()
	{
        // if(!in_array('viewPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		$this->render_template('counseller/today_wagholi', $this->data);	
    }
    public function all_lead()
	{
        // if(!in_array('viewPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		$this->render_template('counseller/all_lead', $this->data);	
	}
	
	public function lead_wagholi()
	{
        // if(!in_array('viewPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		$this->render_template('counseller/lead_wagholi', $this->data);	
	}
	
	public function all_lead_Ignore()
	{
        // if(!in_array('viewPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		$this->render_template('counseller/all_lead_Ignore', $this->data);	
	}
	
	public function lead_wagholi_Ignore()
	{
        // if(!in_array('viewPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		$this->render_template('counseller/lead_wagholi_Ignore', $this->data);	
    }


    //
    
	public function create()
	{
		if(!in_array('createPlacement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Add Placement';

		$this->form_validation->set_rules('student_name', 'Name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
			$id = $this->Model_counseller->create();
			  
			$status=$this->input->post('status');
			
			if($status=="Confirm")
			{

				redirect('orders/create/', 'refresh');

			}	
			else
			{

				
        	
        	if($id) {
				// if(in_array('viewStudent', $this->permission)) {
				// 	$this->session->set_flashdata('success', 'Successfully created');
				// 	redirect('dashboard', 'refresh');
				// }
				// else
				// {
        		$this->session->set_flashdata('success', 'Successfully created');
                redirect('counseller/create/', 'refresh');
				//}
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('counseller/create/', 'refresh');
        	}
        }}
        else {
            // false case
            $this->load();
          
        }	
    }	
	//Fetch database value and pass index of placement // Edited By ramiz-3/25/2019
	//today lead 
	public function fetchLeadData()
	{
		$result = array('data' => array());
     $branch_id=1;
        
		$data = $this->Model_counseller->getleadData($branch_id);
	

		foreach ($data as $key => $value) {

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


			$counseller_name= $this->Model_counseller->get_counseller($value['cname']);

 
			foreach($counseller_name as $name)
			{
			$cname=$name['firstname'];	
			}
			// button
			$buttons = '';


			// if(in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="'.base_url('counseller/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			// }

			// if(in_array('viewPlacement', $this->permission)) {
			// $buttons .= ' <a href="'.base_url('counseller/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			// }

			// 	$buttons .= ' <a href="'.base_url('counseller/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			// if(in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

			// }

             

	
			$result['data'][$key] = array(
				$location,
				$cname,				
                $value['name'],
                $value['email'],
                $value['mobile'],
                $value['address'],
                $value['college'], 		
			    $value['follow_date'],					          
				$value['remark'],				
				$buttons
			);
		} // /foreach
     
     
		echo json_encode($result);
		
    }
    

    public function fetchallLead()
	{
		$result = array('data' => array());
  $branch_id=1;	

          
      
		$data = $this->Model_counseller->allLeadData($branch_id);
	

		foreach ($data as $key => $value) {

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
	
			$counseller_name= $this->Model_counseller->get_counseller($value['cname']);


			foreach($counseller_name as $name)
			{
			$cname=$name['firstname'];	
		
			}
	
			// button
			$buttons = '';


			// if(in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="'.base_url('counseller/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			// }

			// if(in_array('viewPlacement', $this->permission)) {
			// $buttons .= ' <a href="'.base_url('counseller/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			// }

			// 	$buttons .= ' <a href="'.base_url('counseller/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			// if(in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

			// }

	
			$result['data'][$key] = array(
				$location,
				$cname,				
                $value['name'],
                $value['email'],
                $value['mobile'],
                $value['address'],
                $value['college'], 		
			    $value['follow_date'],					          
				$value['remark'],				
				$buttons
			);
		} // /foreach
     
 
		echo json_encode($result);
		
	}
	



	
    public function fetchallLeadIgnore()
	{
		$result = array('data' => array());
  $branch_id=1;	

          
      
		$data = $this->Model_counseller->allLeadDataIgnore($branch_id);
		
	

		foreach ($data as $key => $value) {

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
	
			$counseller_name= $this->Model_counseller->get_counseller($value['cname']);


			foreach($counseller_name as $name)
			{
			$cname=$name['firstname'];	
		
			}
	
			// button
			$buttons = '';


			// if(in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="'.base_url('counseller/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			// }

			// if(in_array('viewPlacement', $this->permission)) {
			// $buttons .= ' <a href="'.base_url('counseller/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			// }

			// 	$buttons .= ' <a href="'.base_url('counseller/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			// if(in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

			// }

	
			$result['data'][$key] = array(
				$location,
				$cname,				
                $value['name'],
                $value['email'],
                $value['mobile'],
                $value['address'],
                $value['college'], 		
			    $value['follow_date'],					          
				$value['remark'],				
				$buttons
			);
		} // /foreach
     
 
		echo json_encode($result);
		
    }

//New for sort data wagholi and shivajnagar lead 29/4/19 today lead
public function fetchLeadDataWagholi()
{
	$result = array('data' => array());
 $branch_id=2;
	
	$data = $this->Model_counseller->getleadData($branch_id);


	foreach ($data as $key => $value) {

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

		$counseller_name= $this->Model_counseller->get_counseller($value['cname']);

 
		foreach($counseller_name as $name)
		{
		$cname=$name['firstname'];	
		}


		// button
		$buttons = '';


		// if(in_array('updatePlacement', $this->permission)) {
			$buttons .= ' <a href="'.base_url('counseller/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		// }

		// if(in_array('viewPlacement', $this->permission)) {
		// $buttons .= ' <a href="'.base_url('counseller/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		// }

		// 	$buttons .= ' <a href="'.base_url('counseller/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


		// if(in_array('deletePlacement', $this->permission)) {
			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

		// }


		$result['data'][$key] = array(
			$location,
			$cname,				
			$value['name'],
			$value['email'],
			$value['mobile'],
			$value['address'],
			$value['college'], 		
			$value['follow_date'],					          
			$value['remark'],				
			$buttons
		);
	} // /foreach
 
 
	echo json_encode($result);
	
}


public function fetchallLeadwagholi()
{
	$result = array('data' => array());
$branch_id=2;
	  
  
	$data = $this->Model_counseller->allLeadData($branch_id);


	foreach ($data as $key => $value) {

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

		$counseller_name= $this->Model_counseller->get_counseller($value['cname']);

 
		foreach($counseller_name as  $name)
		{
		$cname=$name['firstname'];	
		}
		// button
		$buttons = '';


		// if(in_array('updatePlacement', $this->permission)) {
			$buttons .= ' <a href="'.base_url('counseller/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		// }

		// if(in_array('viewPlacement', $this->permission)) {
		// $buttons .= ' <a href="'.base_url('counseller/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		// }

		// 	$buttons .= ' <a href="'.base_url('counseller/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


		// if(in_array('deletePlacement', $this->permission)) {
			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

		// }


		$result['data'][$key] = array(
			$location,
			$cname,					
			$value['name'],
			$value['email'],
			$value['mobile'],
			$value['address'],
			$value['college'], 		
			$value['follow_date'],					          
			$value['remark'],				
			$buttons
		);
	} // /foreach
 
 
	echo json_encode($result);
	
}


public function fetchallLeadwagholiIgnore()
{
	$result = array('data' => array());
$branch_id=2;
	  
  
	$data = $this->Model_counseller->allLeadDataWagholiIgnore($branch_id);


	foreach ($data as $key => $value) {

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

		$counseller_name= $this->Model_counseller->get_counseller($value['cname']);

 
		foreach($counseller_name as  $name)
		{
		$cname=$name['firstname'];	
		}
		// button
		$buttons = '';


		// if(in_array('updatePlacement', $this->permission)) {
			$buttons .= ' <a href="'.base_url('counseller/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		// }

		// if(in_array('viewPlacement', $this->permission)) {
		// $buttons .= ' <a href="'.base_url('counseller/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		// }

		// 	$buttons .= ' <a href="'.base_url('counseller/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


		// if(in_array('deletePlacement', $this->permission)) {
			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

		// }


		$result['data'][$key] = array(
			$location,
			$cname,					
			$value['name'],
			$value['email'],
			$value['mobile'],
			$value['address'],
			$value['college'], 		
			$value['follow_date'],					          
			$value['remark'],				
			$buttons
		);
	} // /foreach
 
 
	echo json_encode($result);
	
}



    public function update($id)
	{
    $id=$id;

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Lead';

		$this->form_validation->set_rules('student_name', 'name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
			
			
			$update = $this->Model_counseller->update($id);
			
			$status=$this->input->post('status');
			
			if($status=="Confirm")
			{

				redirect('orders/create/', 'refresh');

			}	
        	else{
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('counseller/update/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('counseller/update/'.$id, 'refresh');
        	}
        }}
        else {
            // false case
       	$result = array();
        	$orders_data = $this->Model_counseller->getleadDatasingle($id);

    		$result['order'] = $orders_data;
    		//$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		// foreach($orders_item as $k => $v) {
    		// 	$result['order_item'][] = $v;
    		// }

    		$this->data['order_data'] = $result;

//$this->data['products'] = $this->model_products->getActiveProductData();      	

    $this->render_template('counseller/edit', $this->data);

        }
	}


	public function view($id)
	{
		$orders_data = $this->Model_placement->getPlacementData($id);	
		
		$orderid=$this->Model_placement->getOrderId($orders_data['email']);
		
		 if($orderid)
		 {
		foreach($orderid as  $row) 
		{
          $id=$row['id'];
		  $package_data= $this->model_orders->getPackage($id);		
				 
	     	foreach($package_data as $val)
	        	{
				$courses=$val['imei'];
				
		        $pakage=$this->model_orders->getPackagename($val['product_id']);
		      foreach($pakage as $val)				
		        $package_name=$val['name'];
		    }
		}
	}
	else{
		$courses="null";
		$package_name="null";
	}
		
	   
	   
		$result['order']=$orders_data;
		$course['course']=$courses;
		$package['package']=$package_name;
		$this->data['order_data'] = $result;
		$this->data['course']=$course;
		$this->data['package']=$package;
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
        if($id) {
            $delete = $this->Model_counseller->remove($id);
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

	
	public function download($id=NULL)
	{

		$this->load->helper('download');
		if($id) {
			$sql = "SELECT file FROM placement where id =? order by id desc";
			$query = $this->db->query($sql,$id);
			$arr= $query->row_array();
		  foreach ($arr as $key => $val) {
			 $a= 'assets/images/product_image/'.$val;


			 if($val!="<p>You did not select a file to upload.</p>" && $val!=null)
			 {
			

			 force_download($a,NULL); 

			 }
			 
			else
			{
			$this->session->set_flashdata('error', 'You did not select a Resume to upload.');
			$this->index();		
		    }  }		

		}
		else 
		$this->index();		


	
	}

	//new for download lc and ssc 

	public function download_ssc($id=NULL)
	{

		$this->load->helper('download');
		if($id) {
			$sql = "SELECT ssc FROM placement where id =? order by id desc";
			$query = $this->db->query($sql,$id);
			$arr= $query->row_array();
		  foreach ($arr as $key => $val) {
			 $a= 'assets/images/product_image/'.$val;


			 if($val!="<p>You did not select a file to upload.</p>" && $val!=null)
			 {
			

			 force_download($a,NULL); 

			 }
			 
			else
			{
			$this->session->set_flashdata('error', 'You did not select  document to upload.');
			$this->index();		
		    }  }		

		}
		else 
		$this->index();		


	
	}


	public function download_lc($id=NULL)
	{

		$this->load->helper('download');
		if($id) {
			$sql = "SELECT lc FROM placement where id =? order by id desc";
			$query = $this->db->query($sql,$id);
			$arr= $query->row_array();
		  foreach ($arr as $key => $val) {
			 $a= 'assets/images/product_image/'.$val;


			 if($val!="<p>You did not select a file to upload.</p>" && $val!=null)
			 {
			

			 force_download($a,NULL); 

			 }
			 
			else
			{
			$this->session->set_flashdata('error', 'You did not select document to upload.');
			$this->index();		
		    }  }		

		}
		else 
		$this->index();		


	
	}




	// public function resume()
	// {
	// 	$this->render_template('placement/upload_resume', $this->data);
	// }

	



//For upload Resume by student

	public function resume($id=null)
	{				// if(!in_array('createPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
		// }
		//$id = $this->input->get('id');
		
		if($id)
		{
	
	 $this->render_template('placement/upload_resume', $this->data);	
		}     
       
	}

	public function upload_res()
	{  		
		$emt= $_SESSION['email'];  
	       
	   $sql = "SELECT * FROM placement WHERE  email='$emt'";
	   $query = $this->db->query($sql);
	  $data=$query->result_array();
	  
	  foreach ($data as  $value)
	   {
		$id=$value['id'];
			  }       
		$uploads_dir = 'assets/images/product_image';
		$images_name =""; 
		$uniq=uniqid();
		   $tmp_name = $_FILES["image"]["tmp_name"];
		   $name = $uniq.$_FILES["image"]["name"];

		//    $lct_name = $_FILES["lc"]["tmp_name"];
		//    $lc = $_FILES["lc"]["name"];

		//    $ssc_name = $_FILES["ssc"]["tmp_name"];
		//    $ssc = $_FILES["ssc"]["name"];

	
		//    echo uniqid().$lc."<br>";
		   
		//    echo $name;
		//    die();	  

       
		   move_uploaded_file($tmp_name, "$uploads_dir/$name");
		   if($images_name==""){
		   $images_name =$images_name.$name;
		   }else  $images_name =$images_name.",".$name;   
		// echo $images_name;
		// die(); 

		 $this->db->set('file',uniqid().$images_name);
         $this->db->where('id', $id);
	     $a=  $this->db->update('placement');
		

	



	   if($a)
	   {
		$this->session->set_flashdata('success', 'Successfully uploaded resume');
    
		echo "<script>
           
             window.history.go(-2);
     </script>";
		// $this->render_template('dashboard', $this->data);
	   } 
	   else{
		$this->session->set_flashdata('error', 'You did not select a Resume to upload.');
		echo "<script>
           
             window.history.go(-2);
     </script>";
	   }
	}
	
	public function upload_ssc()
	{  		
		$emt= $_SESSION['email'];  
	       
	   $sql = "SELECT * FROM placement WHERE  email='$emt'";
	   $query = $this->db->query($sql);
	  $data=$query->result_array();
	  
	  foreach ($data as  $value)
	   {
		$id=$value['id'];
			  }       
		$uploads_dir = 'assets/images/product_image';
		$images_name =""; 
		$uniq=uniqid();
		   $tmp_name = $_FILES["ssc"]["tmp_name"];
		   $name = $uniq.$_FILES["ssc"]["name"];

		//    $lct_name = $_FILES["lc"]["tmp_name"];
		//    $lc = $_FILES["lc"]["name"];

		//    $ssc_name = $_FILES["ssc"]["tmp_name"];
		//    $ssc = $_FILES["ssc"]["name"];

	
		//    echo uniqid().$lc."<br>";
		   
		//    echo $name;
		//    die();	  

       
		   move_uploaded_file($tmp_name, "$uploads_dir/$name");
		   if($images_name==""){
		   $images_name =$images_name.$name;
		   }else  $images_name =$images_name.",".$name;   
		// echo $images_name;
		// die(); 

		 $this->db->set('ssc',$images_name);
         $this->db->where('id', $id);
	     $a=  $this->db->update('placement');
		

	



	   if($a)
	   {
		$this->session->set_flashdata('success', 'Successfully uploaded ssc document');
    
		echo "<script>
           
             window.history.go(-2);
     </script>";
		// $this->render_template('dashboard', $this->data);
	   } 
	   else{
		$this->session->set_flashdata('error', 'You did not select marksheet to upload.');
		echo "<script>
           
             window.history.go(-2);
     </script>";
	   }
	}
	
	public function upload_lc()
	{  		
		$emt= $_SESSION['email'];  
	       
	   $sql = "SELECT * FROM placement WHERE  email='$emt'";
	   $query = $this->db->query($sql);
	  $data=$query->result_array();
	  
	  foreach ($data as  $value)
	   {
		$id=$value['id'];
			  }       
		$uploads_dir = 'assets/images/product_image';
		$images_name =""; 
		$uniq=uniqid();
	   
		   $tmp_name = $_FILES["lc"]["tmp_name"];
		   $name = $uniq.$_FILES["lc"]["name"];
		

		//    $lct_name = $_FILES["lc"]["tmp_name"];
		//    $lc = $_FILES["lc"]["name"];

		//    $ssc_name = $_FILES["ssc"]["tmp_name"];
		//    $ssc = $_FILES["ssc"]["name"];

	
		//    echo uniqid().$lc."<br>";
		   
		//    echo $name;
		//    die();	  

       
		   move_uploaded_file($tmp_name, "$uploads_dir/$name");
		   if($images_name==""){
		   $images_name =$images_name.$name;
		   }else  $images_name =$images_name.",".$name;   
		// echo $images_name;
		// die(); 

		 $this->db->set('lc',$images_name);
         $this->db->where('id', $id);
	     $a=  $this->db->update('placement');
		

	



	   if($a)
	   {
		$this->session->set_flashdata('success', 'Successfully uploaded LC');
    
		echo "<script>
           
             window.history.go(-2);
     </script>";
		// $this->render_template('dashboard', $this->data);
	   } 
	   else{
		$this->session->set_flashdata('error', 'You did not select a LC to upload.');
		echo "<script>
           
             window.history.go(-2);
     </script>";
	   }
    }






	public function do_upload() { 
		$uploads_dir = 'assets/images/product_image';
          $images_name ="";
	
		 
			 $tmp_name = $_FILES["image"]["tmp_name"];
			 $name = $_FILES["image"]["name"];
			 move_uploaded_file($tmp_name, "$uploads_dir/$name");
			 if($images_name==""){
			 $images_name =$images_name.$name;
			 }else  $images_name =$images_name.",".$name;
	
	
			 
		  return $images_name;
		//   die(); 
		   
		   
		   
		  
	   } 

	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png|doc|docx|csv';
        $config['max_size'] = '10000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file_name'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['file_name']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

	
	public function student_detail($ord)
	{
	
	$data['h']=$this->model_orders->single_student($ord);
	
		$this->load->view('templates/header');
	//	$this->load->view('templates/header_menu');
	//	$this->load->view('templates/side_menubar');
	//	$this->load->view($page, $data);		
		// $this->load->view('templates/footer');
	//	$this->load->view('templates/');
		// var_dump($data['h']);
		// die();
		$this->load->view("orders/std_pkg_info",$data);
	}

	//New for course update student 	
	public function course_status($ord)
	{
	
	$this->data['h']=$this->model_orders->single_student($ord);
	
		$this->load->view('templates/header');
	//	$this->load->view('templates/header_menu');
	//	$this->load->view('templates/side_menubar');
	//	$this->load->view($page, $data);		
		// $this->load->view('templates/footer');
	//	$this->load->view('templates/');
		// var_dump($data['h']);
		// die();
		$this->load->view("placement/course_status",$this->data);
	}
	
	public function course_status_update()
	{
			$id=$this->input->post('id');
	
		if($this->input->post('course_completed'))
		{
	$data=	array('course_completed'=>implode(',',$this->input->post('course_completed')));
	
		

     
	       $this->db->where('id', $id);
			$update = $this->db->update('orders', $data);
			if($update)
			{
			 $this->session->set_flashdata('success', 'Successfully course stutus updated');
		 
			 echo "<script>
				
				  window.history.go(-1);
		  </script>";
			 // $this->render_template('dashboard', $this->data);
			} 
			else{
			 $this->session->set_flashdata('error', 'something wrong.');
			 echo "<script>
				
				  window.history.go(-1);
		  </script>";
			}
		}
		else
		{

			$data=	array('course_completed'=>null);
			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);
			$this->session->set_flashdata('error', 'Course Not  Selected');
			echo "<script>
			   
				 window.history.go(-1);
		 </script>";	
		}
	
		
	}
	
	//test function for o/p
	public function fetchData()
	{
		$result = array('data' => array());

		$branch_id= $_SESSION['branch_id'];
		

		if($branch_id==2)		
		{	  
			
			$data = $this->Model_placement->getBranchtData($branch_id);
			var_dump($data);
			die();
			//$data = $this->Model_placement->getPlacementData($branch_id);
		}
       else{
		//$data = $this->Model_placement->getPlacementData();
		 }}
		 
		 
		 public function c_report()
	{        // if(!in_array('viewPlacement', $this->permission)) {
        //     redirect('dashboard', 'refresh');
        // }

		$this->render_template('counseller/c_report', $this->data);	
	}
	
	public function report_counseller()
	{
	 $sdate= $this->input->post('start_date');
	 $edate= $this->input->post('end_date');
	 $data= $this->Model_counseller->report_counseller($sdate,$edate);
	$count = $this->Model_counseller->count_counseller(); //
	
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
		
			
	//    $buttons = '';

	//     if(in_array('viewOrder', $this->permission)) {
	// 	     $buttons .= '<a href="'.base_url('orders/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
	//      }
	//     if(in_array('viewOrder', $this->permission)) {
	//      	 $buttons .= '<a href="'.base_url('orders/print_form/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
	//       }
	//     if(in_array('updateOrder', $this->permission)) {
	// 	    $buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
	//      }

	//     if(in_array('deleteOrder', $this->permission)) {
	// 	      $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
	//      }

	//    if($value['remain'] == 0) {
	//      	 $paid_status = '<span class="label label-success">Paid</span>';	
	//       }
	//   else {
	// 	      $paid_status = '<span class="label label-warning">Not Paid</span>';
	//      }
	$this->data['order_data'][$key]  = array(	
		$value['name'],
		$value['email'],
		$value['mobile'],
		$value['address'],
		$value['college'], 		
		$value['follow_date'],	
		$value['status'],	
		$value['remark'],			          
			
	
	);
// /foreach
	}
	$this->data['count'][$key]=$count;
} 
		else
	{
		$this->data['order_data']=null;
		$this->data['count']=null;
	}

// 	var_dump($this->data['order_data']);
// die();

$this->render_template('counseller/counseller_report', $this->data);
}
		 


			
	}


	

