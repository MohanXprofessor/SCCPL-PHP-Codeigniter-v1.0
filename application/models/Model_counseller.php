<?php 

class Model_counseller extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	
	public function create(){
		$data = array(
			'date'=>$this->input->post('date'),
			'email' =>$this->input->post('email'),
			'cname'=>$this->input->post('cname'),
			'name' =>$this->input->post('student_name'),
			'mobile'=>$this->input->post('mobile'),
    		'address' => $this->input->post('address'),		
			'college'=>$this->input->post('college'),
    		'follow_date' => $this->input->post('follow_date'),    	
			'remark' => $this->input->post('remark'),
			'status'=> $this->input->post('status'),
			'branch_id'=> $this->input->post('branch')			
    		
		);
		$this->db->insert('lead', $data);
		$id = $this->db->insert_id();

		return ($id) ? $id : false;
	}


	public function upload_image(){
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png|doc|docx|csv';
        $config['max_size'] = '1000';

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

 
	public function getleadData($branch_id)
	{
		

// 		$sql = "SELECT * FROM lead where follow_date= DATE(NOW()) and branch_id=$branch_id ";
// 		$query = $this->db->query($sql);
// 		return $query->result_array();

  //New added for 7 days byffer 5/14/19
       	$tdate=date("Y-m-d") ;
		$buffer_date=date('Y-m-d', strtotime('-7 days'));
		$this->db->select('*');
		$this->db->from('lead');
		$this->db->where('branch_id', $branch_id);
		$this->db->where('follow_date >=', $buffer_date);
        $this->db->where('follow_date <=', $tdate);
        $this->db->where('status !=','Ignore');

		$q= $this->db->get();

		return $q->result_array();
	}

	public function get_counseller($id)
	{
		

		$sql = "SELECT firstname FROM users where id=$id order by id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	

	public function getleadDatasingle($id=null)
	{
       if($id){		
 
		$sql = "SELECT * FROM lead where id=$id order by id desc";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
}
	

    public function allLeadData($branch_id)
	{
		

		$sql = "SELECT * FROM lead where branch_id=$branch_id ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function allLeadDataIgnore($branch_id)
	{
		

		$sql = "SELECT * FROM lead where branch_id=$branch_id and status='Ignore' ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function allLeadDataWagholiIgnore($branch_id)
	{
		

		$sql = "SELECT * FROM lead where branch_id=$branch_id and status='Ignore' ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
    



//Added by Ramiz 15/4/19
//wagholi 

// public function getBranchPlacementData($branch_id = null)
// 	{ 
// 		if($branch_id = 3) {
// 			$sql = "SELECT * FROM placement WHERE branch_id = ? ";
// 			$query = $this->db->query($sql, array($branch_id));
// 			return $query->result_array();
// 		  }
// 	}

	public function getBranchtData($branch_id)
	{
		if($branch_id) {
			$sql = "SELECT * FROM placement where branch_id=$branch_id order by id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	
	}


	public function update($id)
	{
	
		
			$data = array(
				'date'=>$this->input->post('date'),
			'email' =>$this->input->post('email'),
			'cname'=>$this->input->post('cname'),
			'name' =>$this->input->post('student_name'),
			'mobile'=>$this->input->post('mobile'),
    		'address' => $this->input->post('address'),		
			'college'=>$this->input->post('college'),
    		'follow_date' => $this->input->post('follow_date'),    	
			'remark' => $this->input->post('remark'),  
			'status'=> $this->input->post('status'),
			'branch_id'=> $this->input->post('branch')  		
 	
    		
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('lead', $data);

			if($update)
			{
				return true;
			}
			else {
			return false;}

		
		
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('lead');

		
			return ($delete == true) ? true : false;
		}
	}


	//Added By Ramiz 2/4/19
	public function placementBranchData($branch = null)
	{
		if($branch) {
			$sql = "SELECT * FROM placement where branch='$branch' order by id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	
	}
	//Branchwise data wagholi 4/16/19 
	public function placementFranchiseData($branch,$branch_id)
	{
		if($branch) {
			$sql = "SELECT * FROM placement where branch='$branch' and branch_id='$branch_id' order by id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
	
	}




	public function getSinglePlacement($id = null)
	{
		
		if($id) {
			$sql = "SELECT file FROM placement where id =? order by id desc";
			$query = $this->db->query($sql,$id);
			return $query->result_array();
		}

		
	}



	//New Added 4/12/19 RAMIZ for view courses and packages in placemanent
	public function getOrderId($email)
	{
		if($email)
		{
    	$sql = "SELECT id FROM orders where customer_gst =? order by id desc";
	    $query = $this->db->query($sql,$email);
	    return $query->result_array();
		}
		else{
			return 0;
		}
	}
	
	
	public function report_counseller($sdate,$edate)
	{   $counseller_id=$this->input->post('cname');
		 $this->db->select('*');
		$this->db->from('lead');
		$this->db->where('cname', $counseller_id);
		$this->db->where('date>=', $sdate);
        $this->db->where('date<=', $edate);

		$q= $this->db->get();

		return $q->result_array();
	
	  
	 }
	
	//  $this->db->select("COUNT(ratting) as v_count, SUM(ratting) as v_sum");
	//  $this->db->where('user_id', $user_id);
	//  $row = $this->db->get('user')->row();

	 public function count_counseller()
	    {   
		  $counseller_id=$this->input->post('cname');
		  $this->db->select('count(id) as id');		
		  $this->db->where('status=', 'Confirm');
		  $this->db->where('cname', $counseller_id);
		  $row0= $this->db->get('lead')->row();

		
		  $this->db->select('count(id) as id');	
		  $this->db->where('cname', $counseller_id);	
		  $this->db->where('status=', 'Ignore');
		  $row1= $this->db->get('lead')->row();

		  $this->db->select('count(id) as id');	
		  $this->db->where('cname', $counseller_id);	
		  $this->db->where('status=', 'Next-date');
		  $row2= $this->db->get('lead')->row();
		  $count=array(0=>$row0->id,1=>$row1->id,2=>$row2->id);
		  return $count;
		   
	    }

}