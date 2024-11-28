<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LoadPlacement extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Placement';

		$this->load->model('Model_placement');
	}

	public function index()
	{
        if(!in_array('viewPlacement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('loadplacement/loadPlacementCivil', $this->data);	
    }

    
	public function load_sap()
	{
        if(!in_array('viewPlacement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('loadplacement/loadplacementsap', $this->data);	
    }
       
	public function load_electrical()
	{
        if(!in_array('viewPlacement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('loadplacement/loadplacementelectrical', $this->data);	
    }


    public function load_mechanical()
	{
        if(!in_array('viewPlacement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('loadplacement/loadplacementmechanical', $this->data);	
	}
	
	public function load_digitalmarketing()
	{
        if(!in_array('viewPlacement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('loadplacement/loadplacemetntdigital', $this->data);	
    }

    //
    

    //Fetch database value and pass index of placement // Edited By ramiz-3/25/2019
	public function fetchPlacementsDataCivil()
	{
		$result = array('data' => array());

		 $branch="Civil";
		 $branch_id=$_SESSION['branch_id'];
		 if($branch_id==2)
		 {
		   $data = $this->Model_placement->placementFranchiseData($branch,$branch_id);
		 }
		 else
		 {
			$data = $this->Model_placement->placementBranchData($branch);	 
		 }

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
	

		//	$count_total_item = $this->model_orders->countOrderItem($value['id']);
		
			

			// // button
			$buttons = '';


			//if(in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="'.base_url('placement/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			//}

			//if(in_array('viewPlacement', $this->permission)) {
			$buttons .= ' <a href="'.base_url('placement/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			//}

				$buttons .= ' <a href="'.base_url('placement/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			if(in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

			}

	
			$result['data'][$key] = array(
				$location,
				$value['student_name'],
				// $value['address'],
                $value['mobile'],
				$value['email'],
			    $value['qualification'],
                $value['college_name'],             
				$value['company_applied'],
				$value['branch'],
				$buttons
				
			);
		} // /foreach
     
     
		echo json_encode($result);
	}
	

	public function fetchPlacementsDigitamarketing()
	{
		$result = array('data' => array());

		 $branch="DigitalMarketing";
		 $branch_id=$_SESSION['branch_id'];
		 if($branch_id==2)
		 {
		   $data = $this->Model_placement->placementFranchiseData($branch,$branch_id);
		 }
		 else
		 {
			$data = $this->Model_placement->placementBranchData($branch);	 
		 }

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
	

		//	$count_total_item = $this->model_orders->countOrderItem($value['id']);
		
			

			// // button
			$buttons = '';


			//if(in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="'.base_url('placement/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			//}

			//if(in_array('viewPlacement', $this->permission)) {
			$buttons .= ' <a href="'.base_url('placement/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			//}

				$buttons .= ' <a href="'.base_url('placement/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			if(in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

			}

	
			$result['data'][$key] = array(
				$location,
				$value['student_name'],
				// $value['address'],
                $value['mobile'],
				$value['email'],
			    $value['qualification'],
                $value['college_name'],             
				$value['company_applied'],
				$value['branch'],
				$buttons
				
			);
		} // /foreach
     
     
		echo json_encode($result);
    }

    public function fetchsap()
	{
		$result = array('data' => array());

       $branch="SAP";
	   $branch_id=$_SESSION['branch_id'];
	   if($branch_id==2)
	   {
		 $data = $this->Model_placement->placementFranchiseData($branch,$branch_id);
	   }
	   else
	   {
		  $data = $this->Model_placement->placementBranchData($branch);	 
	   }

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
	

		  $buttons = '';


		 // if(in_array('updatePlacement', $this->permission)) {
			  $buttons .= ' <a href="'.base_url('placement/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		  //}

		  //if(in_array('viewPlacement', $this->permission)) {
		  $buttons .= ' <a href="'.base_url('placement/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		  //}

			  $buttons .= ' <a href="'.base_url('placement/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


		  if(in_array('deletePlacement', $this->permission)) {
			  $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

		 }
	
			$result['data'][$key] = array(
				$location,
				$value['student_name'],
				// $value['address'],
                $value['mobile'],
				$value['email'],
			    $value['qualification'],
                $value['college_name'],             
				$value['company_applied'],
				$value['branch'],
				$buttons
			);
		} // /foreach
     
     
		echo json_encode($result);
    }
    public function fetchelectrical()
	{
		$result = array('data' => array());

       $branch="Electrical";
	   $branch_id=$_SESSION['branch_id'];
	   if($branch_id==2)
	   {
		 $data = $this->Model_placement->placementFranchiseData($branch,$branch_id);
	   }
	   else
	   {
		  $data = $this->Model_placement->placementBranchData($branch);	 
	   }

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
		  $buttons = '';


		//   if(in_array('updatePlacement', $this->permission)) {
			  $buttons .= ' <a href="'.base_url('placement/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
		//   }

		  //if(in_array('viewPlacement', $this->permission)) {
		  $buttons .= ' <a href="'.base_url('placement/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
		  //}

			  $buttons .= ' <a href="'.base_url('placement/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


		 if(in_array('deletePlacement', $this->permission)) {
			  $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

		  }
	
			$result['data'][$key] = array(
				$location,
				$value['student_name'],
				// $value['address'],
                $value['mobile'],
				$value['email'],
			    $value['qualification'],
                $value['college_name'],             
				$value['company_applied'],
				$value['branch'],
				$buttons
			);
		} // /foreach
     
     
		echo json_encode($result);
    }
    public function fetchmechanical()
	{
		$result = array('data' => array());

       $branch="Mechanical";
	   $branch_id=$_SESSION['branch_id'];
	   if($branch_id==2)
	   {
		 $data = $this->Model_placement->placementFranchiseData($branch,$branch_id);
	   }
	   else
	   {
		  $data = $this->Model_placement->placementBranchData($branch);	 
	   }

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


		  
			// button
			$buttons = '';


			//if(in_array('updatePlacement', $this->permission)) {
				$buttons .= ' <a href="'.base_url('placement/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			//}

			//if(in_array('viewPlacement', $this->permission)) {
			$buttons .= ' <a href="'.base_url('placement/view/'.$value['id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			//}

				$buttons .= ' <a href="'.base_url('placement/download/'.$value['id']).'" class="btn btn-default" ><i class="fa fa-download"></i></a>';


			if(in_array('deletePlacement', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

			}
		
	
			$result['data'][$key] = array(
				$location,
				$value['student_name'],
				// $value['address'],
                $value['mobile'],
				$value['email'],
			    $value['qualification'],
                $value['college_name'],             
				$value['company_applied'],
				$value['branch'],
				$buttons
				
			);
		} // /foreach
     
     
		echo json_encode($result);
    }






}