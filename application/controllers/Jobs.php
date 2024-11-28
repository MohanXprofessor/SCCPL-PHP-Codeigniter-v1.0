<?php

/*
* Created By: Akash K. Fulari
* On Date: 07-03-2024
*/ 

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends Admin_Controller{
	public function __construct(){
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Jobs';

		$this->load->model('model_appliedjobs');
		$this->load->model('model_job');
		$this->load->model('model_users');
	}

    // this function for admin
    public function viewJobs(){
		$this->render_template('jobs/index', $this->data);	
    }
    
    // this function for student
    public function viewAllJobs(){
		$this->render_template('jobs/student_index', $this->data);	
    }
    
    public function viewPendingJobs(){
        $this->data['showType'] = 0;
		$this->render_template('jobs/statusMyJobs', $this->data);	
    }
    
    public function viewRejectedJobs(){
        $this->data['showType'] = -1;
		$this->render_template('jobs/statusMyJobs', $this->data);	
    }
    
    /*
    * Create By: Akash K. Fulari
    * Created On: 23-03-2024
    * Code Starts Here
    **/
    
    /*
    * Its only for admin`s
    */
    public function viewJobDesc($appliedJobId){
        if($this->userGroup!="Student"){
            if($appliedJobId!=null){
                $data = $this->model_appliedjobs->getAppliedJobById($appliedJobId);
                $this->data['appliedjobs'] = null;
                
                if($data!=null){
                    $this->data['jobAppliedId'] = $appliedJobId;
                    $this->data['appliedjob'] = $data;
                    $this->data['job'] = $this->model_job->getJobDataById($data['job_id']);
                    $this->data['branch'] = $this->model_stores->getStoresData($data['branch_id']);
                    $this->data['student'] = $this->model_users->getUserData($data['student_id']);
    			    $this->data['isStudentJoined'] = $this->model_appliedjobs->isStudentJoined($data['student_id']);
                }
    		    $this->render_template('jobs/viewJobDesc', $this->data);	
            }else
		    $this->render_template('jobs/viewJobs', $this->data);
		}else
		    $this->render_template('jobs/viewJobs', $this->data);
    }
    
    /*
    * Its for both admin`s & Student`s as wel
    */
    public function viewJobDetails($JobId){
        $this->data['job'] = null;
        $this->data['branch'] = null;
        $this->data['appliedJobs'] = null;
        $this->data['userId'] = $this->userId;
        if($JobId != null){
            $this->data['job'] = $this->model_job->getJobDataById($JobId);
            $this->data['branch'] = $this->model_stores->getStoresData($this->data['job']['branch_id']);
            $this->data['model_appliedjobs'] = $this->model_appliedjobs;
        }
		$this->render_template('jobs/viewJobDetails', $this->data);	
    }
    
    /*
    * Create By: Akash K. Fulari
    * Created On: 23-03-2024
    * Code Ends Here
    **/
    
    public function jobFilter(){
		$this->data['page_title'] = 'Sorting Job Details';
		
        $this->data['branchId'] = $this->input->get('b');
        $this->data['statusCode'] = $this->input->get('s');
        
		$this->render_template('jobs/viewJobsStatuswise', $this->data);	
    }
    
    public function applyJob($jobId){

        if ($this->validateFormFile("resume") && $this->validateFormFile("marksheet") && $this->validateFormFile("adhar_card") && $this->validateFormFile("leaving_certificate")){
            $userFolderPath = "assets/uploads/".$this->userData['firstname']."_".$this->userData['firstname'];
            
            // do the process for file uploading
            $file1 = $this->uploadFile($userFolderPath."/Resume", 'resume');
            $file2 = $this->uploadFile($userFolderPath."/Marksheet", 'marksheet');
            $file3 = $this->uploadFile($userFolderPath."/Adharcard", 'adhar_card');
            $file4 = $this->uploadFile($userFolderPath."/LeavingCertificate", 'leaving_certificate');
            
            $resumePath = (($file1['status']==1)?$file1['data']['full_path']:null);
            $marksheetPath = (($file2['status']==1)?$file2['data']['full_path']:null);
            $adharCardPath = (($file3['status']==1)?$file3['data']['full_path']:null);
            $leavingCertificatePath = (($file4['status']==1)?$file4['data']['full_path']:null);
            
            if($resumePath && $marksheetPath && $adharCardPath && $leavingCertificatePath){
                $data = array(
        	        'branch_id' => $this->userBranchId,
            	    'job_id'=>$jobId,
            		'student_id' =>$this->userId,
            		'resume' => $resumePath,
            	    'marksheet'=> $marksheetPath,
            		'adhar_card' => $adharCardPath,
            		'leaving_certificate' => $leavingCertificatePath
            	);
                
            	$isCreated = $this->model_appliedjobs->applyJob($data);
            	
            	if($isCreated) {
    				$this->session->set_flashdata('success', 'Successfully Applied for Job');
    				redirect('jobs/viewAllJobs', 'refresh');
            	}
            	else{
    				$this->session->set_flashdata('error', 'Unable to apply job');
    				redirect('jobs/viewAllJobs', 'refresh');
            	}  
            }else{
				$this->session->set_flashdata('error', 'Unable to upload job related documents');
				redirect('jobs/viewAllJobs', 'refresh');
            }
        }
        else{
            if(!empty(form_error("error"))){
				$this->session->set_flashdata('error', form_error("error"));
				redirect('jobs/viewAllJobs', 'refresh');
            }
            
            $this->data['job'] = $this->model_job->getJobDataById($jobId);   
		    $this->render_template('jobs/applyJob', $this->data);	
        }
    }
    
    public function create(){

		$this->data['page_title'] = 'Add Job';

		$this->form_validation->set_rules('branch_id[]', 'Branch Id', 'trim|required');
		$this->form_validation->set_rules('job_id', 'Job Id', 'trim|required');
		$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required');
		$this->form_validation->set_rules('job_email', 'Job Email', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('job_possition', 'Job Possition', 'trim|required');
		$this->form_validation->set_rules('job_description', 'Job Description', 'trim|required');
		$this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
		$this->form_validation->set_rules('submission_date', 'Submission Date', 'trim|required');
		$this->form_validation->set_rules('vacencies', 'Vacencies', 'trim|required');
		
		
        if ($this->form_validation->run() == TRUE){
            $branchIds = $this->input->post('branch_id');
            $counter = 0;
            foreach($branchIds as $bid){
                $data = array(
            	    'branch_id'=> $bid,
            	    'job_id'=>$this->input->post('job_id'),
            		'job_title' =>$this->input->post('job_title'),
            		'job_mail' =>$this->input->post('job_email'),
            		'company_name' =>$this->input->post('company_name'),
            	    'job_possition'=>$this->input->post('job_possition'),
            		'job_description' => $this->input->post('job_description'),
            		'qualification' => $this->input->post('qualification'),
            		'submission_date' => $this->input->post('submission_date'),
            		'no_of_vaccancy'=>$this->input->post('vacencies'),
            		'added_by' => $this->userId,
            		'active' => $this->input->post('active')
            	);
        	    $isCreated = $this->model_job->createJob($data);
        	    if($isCreated)
        	        $counter++;
            }
        	
        	if($counter == sizeof($branchIds)-1) {
				$this->session->set_flashdata('success', 'Branches Job Created Successfully');
				redirect('jobs/viewJobs', 'refresh');
        	}
        	else if($counter>0){
				$this->session->set_flashdata('success', 'Branches Job Created Successfully!!!, But some of branches jobs not created!.');
				redirect('jobs/viewJobs', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('jobs/create', 'refresh');
        	}
            
        }
        else{
            if($this->userGroup!="Student")
		        $this->render_template('jobs/create', $this->data);	
		    else
		        $this->render_template('jobs/viewAllJobs', $this->data);	
        }
    }
    
	public function update($jobId){
		$this->data['page_title'] = 'Update Job';

		$this->form_validation->set_rules('branch_id', 'Branch Id', 'trim|required');
		$this->form_validation->set_rules('job_id', 'Job Id', 'trim|required');
		$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required');
		$this->form_validation->set_rules('job_email', 'Job Email', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('job_possition', 'Job Possition', 'trim|required');
		$this->form_validation->set_rules('job_description', 'Job Description', 'trim|required');
		$this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
		$this->form_validation->set_rules('submission_date', 'Submission Date', 'trim|required');
		$this->form_validation->set_rules('vacencies', 'Vacencies', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');
		
		
        if ($this->form_validation->run() == TRUE){
            $data = array(
        	    'branch_id'=>$this->input->post('branch_id'),
        	    'job_id'=>$this->input->post('job_id'),
        		'job_title' =>$this->input->post('job_title'),
        		'job_mail' =>$this->input->post('job_email'),
        		'company_name' =>$this->input->post('company_name'),
        	    'job_possition'=>$this->input->post('job_possition'),
        		'job_description' => $this->input->post('job_description'),
        		'qualification' => $this->input->post('qualification'),
        		'submission_date' => $this->input->post('submission_date'),
        		'no_of_vaccancy'=>$this->input->post('vacencies'),
        		'added_by' => $this->userId,
        		'active' => $this->input->post('active')
        	);
        	
        	$isUpdated = $this->model_job->editJob($data, $jobId);
        	
        	if($isUpdated) {
				$this->session->set_flashdata('success', 'Job Updated Successfully : '.$this->input->post('active'));
				redirect('jobs/viewJobs', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('jobs/create', 'refresh');
        	}
            
        }
        else{
            if($this->userGroup!="Student"){
                $this->data['job'] = $this->model_job->getJobDataById($jobId);   
    		    $this->render_template('jobs/update', $this->data);	
            }
		    else
		        $this->render_template('jobs/viewAllJobs', $this->data);	
        }
	}
	
	public function view($jobId, $jobAppliedId = null, $status = null){
	    
        if($jobAppliedId!=null && $status!=null){
            $jobData = $this->model_appliedjobs->getAppliedJobByJobData($jobAppliedId);
            if($jobData){
                $data = array("status"=>$status);
                $updated = $this->model_appliedjobs->editJob($data,$jobAppliedId);
                
                $statusCode = "Pending";
                
                if($status==1)
                    $statusCode = "Selected";
                else if($status==-1)
                    $statusCode = "Rejected";
                else 
                    $statusCode = "Joined";
                    
                if($updated){
        		    $this->session->set_flashdata('success', 'Candidate '.$statusCode.' successfully.');
                }
                else{
        		    $this->session->set_flashdata('error', 'Unable to '.$statusCode.' candidate.');
                }
            }else{
        		$this->session->set_flashdata('error', 'Invalid job data.');
            }
        	redirect('jobs/view/'.$jobId, 'refresh');
        }
		$this->data['page_title'] = 'View Job Details';
		
        $this->data['job'] = $this->model_job->getJobDataById($jobId);   
	    $this->render_template('jobs/view', $this->data);	
	}
    
    // This method for student & admins both
    public function fetchJobsData(){
        $result = array('data' => array());
        /*
        * Create By: Akash K. Fulari
        * Created On: 19-03-2024
        * Updated code
        * Code Starts Here
        **/
        $data = $this->model_job->getJobDataByBranchId($this->userBranchId);
        
        if($this->userGroup=="Administrator")
            $data = $this->model_job->getJobData();
            
        /*
        * Create By: Akash K. Fulari
        * Created On: 19-03-2024
        * Updated code
        * Code Ends Here
        **/
        $isShortListed = 0;

		foreach ($data as $key => $value) {
            $buttons = "";
            if($this->userGroup != "Student"){
    			// button
    			$buttons .= ' <a type="button" class="btn btn-sm btn-primary d-block" onclick="mailSend(\''.$value['company_name'].'\', \''.$value['job_mail'].'\')"  data-toggle="modal" data-target="#sendMailModal"><i class="fa fa-send"></i></a>';
    
    			if(in_array('updatePlacement', $this->permission)) {
    				$buttons .= ' <a class="btn btn-sm btn-success d-block" href="'.base_url('jobs/update/'.$value['id']).'"><i class="fa fa-pencil"></i></a>';
    			}
    
    			if(in_array('deletePlacement', $this->permission)) {
    				$buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></a>';
    			}
    
    			if(in_array('viewPlacement', $this->permission)) {
    				$buttons .= ' <a class="btn btn-sm btn-warning d-block" href="'.base_url('jobs/view/'.$value['id']).'"><i class="fa fa-eye"></i></a>';
    				$buttons .= ' <a class="btn btn-sm btn-info d-block" href="'.base_url('jobs/viewJobDetails/'.$value['id']).'">View More</a>';
    			}
    			
    			// this method loads the shortlisted student records by the job id
    			$count = 0;
    			$appliedJobs = $this->model_appliedjobs->getAppliedJobDataByStatus(1, $value['job_id']);
    			if($appliedJobs)
    			    $count = sizeof($appliedJobs);
    			    
    			$status = "";
    			
    			$sts = $value['active'];
    			if($sts == 1)
    			    $status= " <span class='label label-success'>Active</span>";
    			else
    			    $status= " <span class='label label-danger'>Inactive</span>";
    			    
    			 
                $branchData = $this->model_stores->getStoresData($value['branch_id']);
    
    			$result['data'][$key] = array(
    			    /*$value['id'],
    			    $value['job_id'],*/
    			    $value['job_title'],
    			    $value['company_name'],
    			    $branchData['name'],
    			    /*$value['job_description'],*/
    			    $value['job_possition'],
    			    $value['qualification'],
    			    $value['submission_date'],
    			    $value['no_of_vaccancy'],
    			    $count,
    			    $status,
    			    $buttons
    			);
            }else{
    			$status = "";
    			
    			$isStudentJoined = $this->model_appliedjobs->isStudentJoined($this->userId);
    			
    			$appliedJobs = $this->model_appliedjobs->getAppliedJobData($value['id'], $this->userId);
    			$buttons .= ' <a class="btn btn-info btn-sm d-block" href="'.base_url('jobs/viewJobDetails/'.$value['id']).'">View More</a>';
    			if($appliedJobs){
    			    $buttons .= " <span class='label label-success'>Applied</span>";
    			    $appliedJobs = $appliedJobs[0];
    			    
        			if($appliedJobs['status']==-1)
        			    $status = " <span class='label label-danger'>Rejected</span>";
        			else if($appliedJobs['status']==0)
        			    $status = " <span class='label label-primary'>Pending</span>";
        			else if($appliedJobs['status']==1)
        			    $status = " <span class='label label-success'>Shortlisted</span>";
                }
    			else{
    			    $status= " <span class='label label-warning'>Not Applied</span>";
    			    
        			if(!$isStudentJoined && $value['active']==1){
    			        $buttons .= ' <a type="button" class="btn btn-primary btn-sm d-block" href="'.base_url('jobs/applyJob/'.$value['id']).'"><i class="fa fa-send"></i> Apply This Job</a>';
        			}
    			}
    			
    			if($value['active'] == 0){
    			    $buttons = " <span class='label label-danger'>In Activated</span>";
    			}
    			
    			$result['data'][$key] = array(
    			 //   $value['id'],
    			    $value['job_id'],
    			    $value['job_title'],
    			    $value['company_name'],
    			 //   $value['job_description'],
    			    $value['job_possition'],
    			    $value['qualification'],
    			    $value['submission_date'],
    			    $value['no_of_vaccancy'],
    			    $status,
    			    $buttons
    			);
            }
		}
		
        echo json_encode($result);
    }
    
    // This method for student reelated only
    public function fetchJobsDataByStatus($statusCode){
        $result = array('data' => array());
        
        /*
        * Create By: Akash K. Fulari
        * Created On: 19-03-2024
        * Updated code
        * Code Starts Here
        **/
        $data = $this->model_job->getJobDataByBranchId($this->userBranchId);
        
        if($this->userGroup=="Administrator")
            $data = $this->model_job->getJobData();
            
        /*
        * Create By: Akash K. Fulari
        * Created On: 19-03-2024
        * Updated code
        * Code Ends Here
        **/
        
        $isShortListed = 0;

		foreach ($data as $key => $value) {
            $buttons = "";
            if($this->userGroup == "Student"){
    			$isStudentJoined = $this->model_appliedjobs->isStudentJoined($this->userId);
    			
    			$appliedJobs = $this->model_appliedjobs->getAppliedJobDataByStatus($statusCode, $value['id'], $this->userId);
        			if($appliedJobs){
        			    $appliedJobs = $appliedJobs[0];
            			if($appliedJobs['status']=="-1")
            			    $buttons = " <span class='label label-danger'>Rejected</span>";
            			else if($appliedJobs['status']=="0")
            			    $buttons = " <span class='label label-info'>Pending</span>";
            			else if($appliedJobs['status']=="1")
            			    $buttons = " <span class='label label-primary'>Shortlisted</span>";
                			  
        			    if($value['active'] == 0){
                    	    $buttons = " <span class='label label-info'>Pending</span> ";
                    	    $buttons .= " <span class='label label-danger'>In Activated</span>";
            			}
            			
            			$result['data'][$key] = array(
            			 //   $value['id'],
            			    $value['job_id'],
            			    $value['job_title'],
            			    $value['company_name'],
            			 //   $value['job_description'],
            			    $value['job_possition'],
            			    $value['qualification'],
            			    $value['submission_date'],
            			    $value['no_of_vaccancy'],
            			    $buttons
            			);
                    }
            }
		}
		
        echo json_encode($result);
    }
    
    /*
    * Create By: Akash K. Fulari
    * Created On: 19-03-2024
    * Code Starts Here
    **/
    
    // This method call to fetchJobsDataByJobIdWithStatus
    public function fetchJobsDataByJobId($jobId){
        $this->fetchJobsDataByJobIdWithStatus($jobId);
    }
    
    // This method call to fetchJobsDataByJobIdWithStatus
    public function fetchJobsDataByIdAndStatus($jobId, $status){
        $this->fetchJobsDataByJobIdWithStatus($jobId, $status);
    }
    
    // This method is only for admins
    public function fetchJobsDataByJobIdWithStatus($jobId, $status = null){
		$this->data['page_title'] = 'View Job Details';
        $result = array('data' => array());

        if($this->userGroup != "Student"){        
            $jobData = $this->model_job->getJobDataById($jobId); 
            
            /*
            * Create By: Akash K. Fulari
            * Created On: 19-03-2024
            * Updated code
            * Code Starts Here
            **/
            $data = $this->model_appliedjobs->getAppliedJobDataByJobIdAndBranchId($jobData['id'], $this->userBranchId);
            
            if($this->userGroup=="Administrator")
                $data = $this->model_appliedjobs->getAppliedJobData($jobData['id']);
                
            /*
            * Create By: Akash K. Fulari
            * Created On: 19-03-2024
            * Updated code
            * Code Ends Here
            **/
            
            if($status != null)
                $data = $this->model_appliedjobs->getAppliedJobDataByStatus($status, $jobData['id']);
                
            if($data){
        		foreach ($data as $key => $value) {
        		    $jobAppliedId = $value['id'];
        		    
        		    $studentId = $value['student_id'];
        		    $studentData = $this->model_users->getUserData($studentId);
        		    
    			    $isStudentJoined = $this->model_appliedjobs->isStudentJoined($studentId);
        		    
        			$isStudentJoined = $this->model_appliedjobs->isStudentJoined($studentData['id']);
        			
        			$rpFind = "/home/interfa1/";
        			$rpString = "https://";
        			
            	    $resumeBtn = " <a href='".str_replace($rpFind,$rpString,$value['resume'])."' download class='btn btn-sm btn-primary d-block'><i class='fa fa-download'></i> Download</a>";
            	    $marksheetBtn = " <a href='".str_replace($rpFind,$rpString,$value['marksheet'])."' download class='btn btn-sm btn-primary d-block'><i class='fa fa-download'></i> Download</a>";
            	    $adharBtn = " <a href='".str_replace($rpFind,$rpString,$value['adhar_card'])."' download class='btn btn-sm btn-primary d-block'><i class='fa fa-download'></i> Download</a>";
            	    $leavingBtn = " <a href='".str_replace($rpFind,$rpString,$value['leaving_certificate'])."' download class='btn btn-sm btn-primary d-block'><i class='fa fa-download'></i> Download</a>";
            	   
            	    $buttons = "";
            	    $status = "";
            	    
            	    if($value['status']==0){
            	        if(!$isStudentJoined){
                	        $buttons .= " <a href='".base_url('jobs/view/'.$jobId.'/'.$jobAppliedId.'/1')."' class='btn btn-sm btn-warning d-block' >Select</a>";
                	        $buttons .= " <a href='".base_url('jobs/view/'.$jobId.'/'.$jobAppliedId.'/-1')."' class='btn btn-sm btn-danger d-block'>Reject</a>";
            	        }
            	        $status = " <span class='label label-info'>Pending</span>";
            	    }
            	    else if($value['status']==-1){
            	        $status = " <span class='label label-danger'>Rejected</span>";
            	    }
            	    else if($value['status']==1){
            	        $status = " <span class='label label-warning'>Selected</span>";
            	        if(!$isStudentJoined){
            	            $buttons .= " <a href='".base_url('jobs/view/'.$jobId.'/'.$jobAppliedId.'/2')."' class='btn btn-sm btn-success d-block'>Join</a>";
                	        $buttons .= " <a href='".base_url('jobs/view/'.$jobId.'/'.$jobAppliedId.'/-1')."' class='btn btn-sm btn-danger d-block'>Reject</a>";
            	        }
            	    }
            	    else if($value['status']==2){
            	        $status = " <span class='label label-success'>Joined</span>";
            	    }
            	    
    				$buttons .= ' <a class="btn btn-info btn-sm d-block" href="'.base_url('jobs/viewJobDesc/'.$jobAppliedId).'">View More</a>';
        			
        			$result['data'][$key] = array(
        			 //   $value['id'],
        			    $jobData['job_id'],
        			 //   $studentData['id'],
        			    $studentData['firstname']." ".$studentData['lastname'],
        			    $studentData['email'],
        			    $studentData['phone'],
        			    $jobData['company_name'],
        			 //   $jobData['job_possition'],
        			 //   $jobData['qualification'],
        			    $resumeBtn,
        			    $marksheetBtn,
        			    $adharBtn,
        			    $leavingBtn,
        			    $buttons,
        			    $status,
        			);
        		}
            }
    		
            echo json_encode($result);
        }
    }
    
    // This method is only for admins
    public function fetchJobsDataByBranchAndStatus($branchId, $statusCode){
        // echo $branchId.">>". $statusCode .">>". $this->userGroup .">>". strcmp($this->userGroup, "Administrator") .">>". $this->userBranchId .">>".$branchId;
        
        $result = array('data' => array());

        if($this->userGroup != "Student"){        
            /*
            * Create By: Akash K. Fulari
            * Created On: 19-03-2024
            * Updated code
            * Code Starts Here
            **/
            $data = $this->model_appliedjobs->getAppliedJobDataByBranchIdAndStatus($this->userBranchId, $statusCode);
            
            if(strcmp($this->userGroup, "Administrator") === 0)
                $data = $this->model_appliedjobs->getAppliedJobDataByBranchIdAndStatus($branchId, $statusCode);
                
            /*
            * Create By: Akash K. Fulari
            * Created On: 19-03-2024
            * Updated code
            * Code Ends Here
            **/
            
                
            if($data){
        		foreach ($data as $key => $value) {
        		    $jobAppliedId = $value['id'];
        		    
        		    $jobId =  $value['job_id'];
                    $jobData = $this->model_job->getJobDataById($jobId); 
        		    
        		    $studentId = $value['student_id'];
        		    $studentData = $this->model_users->getUserData($studentId);
        		    
    			    $isStudentJoined = $this->model_appliedjobs->isStudentJoined($studentId);
        		    
        			$isStudentJoined = $this->model_appliedjobs->isStudentJoined($studentData['id']);
        			
        			$rpFind = "/home/interfa1/";
        			$rpString = "https://";
        			
            	    $resumeBtn = " <a href='".str_replace($rpFind,$rpString,$value['resume'])."' download class='btn btn-sm btn-primary d-block'><i class='fa fa-download'></i> Download</a>";
            	    $marksheetBtn = " <a href='".str_replace($rpFind,$rpString,$value['marksheet'])."' download class='btn btn-sm btn-primary d-block'><i class='fa fa-download'></i> Download</a>";
            	    $adharBtn = " <a href='".str_replace($rpFind,$rpString,$value['adhar_card'])."' download class='btn btn-sm btn-primary d-block'><i class='fa fa-download'></i> Download</a>";
            	    $leavingBtn = " <a href='".str_replace($rpFind,$rpString,$value['leaving_certificate'])."' download class='btn btn-sm btn-primary d-block'><i class='fa fa-download'></i> Download</a>";
            	   
            	    $buttons = "";
            	    $status = "";
            	    
            	    if($value['status']==0){
            	        if(!$isStudentJoined){
                	        $buttons .= " <a href='".base_url('jobs/view/'.$jobId.'/'.$jobAppliedId.'/1')."' class='btn btn-sm btn-warning d-block' >Select</a><br>";
                	        $buttons .= " <a href='".base_url('jobs/view/'.$jobId.'/'.$jobAppliedId.'/-1')."' class='btn btn-sm btn-danger d-block'>Reject</a>";
            	        }
            	        $status = " <span class='label label-info'>Pending</span>";
            	    }
            	    else if($value['status']==-1){
            	        $status = " <span class='label label-danger'>Rejected</span>";
            	    }
            	    else if($value['status']==1){
            	        $status = " <span class='label label-warning'>Selected</span>";
            	        if(!$isStudentJoined){
            	            $buttons .= " <a href='".base_url('jobs/view/'.$jobId.'/'.$jobAppliedId.'/2')."' class='btn btn-sm btn-success d-block'>Join</a>";
                	        $buttons .= " <a href='".base_url('jobs/view/'.$jobId.'/'.$jobAppliedId.'/-1')."' class='btn btn-sm btn-danger d-block'>Reject</a>";
            	        }
            	    }
            	    else if($value['status']==2){
            	        $status = " <span class='label label-success'>Joined</span>";
            	    }
        			
    				$buttons .= ' <a class="btn btn-info btn-sm d-block" href="'.base_url('jobs/viewJobDesc/'.$jobAppliedId).'">View More</a>';
    				
        			$result['data'][$key] = array(
        			 //   $value['id'],
        			    $jobData['job_id'],
        			 //   $studentData['id'],
        			    $studentData['firstname']." ".$studentData['lastname'],
        			    $studentData['email'],
        			    $studentData['phone'],
        			    $jobData['company_name'],
        			 //   $jobData['job_possition'],
        			 //   $jobData['qualification'],
        			    $resumeBtn,
        			    $marksheetBtn,
        			    $adharBtn,
        			    $leavingBtn,
        			    $buttons,
        			    $status,
        			);
        		}
            }
    		
            echo json_encode($result);
        }
		   
    }
    
    /*
    * Code End Here
    **/
    
    public function remove(){
        
        if(!in_array('deletePlacement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('job_id');

        $response = array();
        if($product_id) {
            $delete = $this->model_job->remove($product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Job Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the job information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
    }
    
    public function toggleStatus(){
        
        if(!in_array('deletePlacement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $jobId = $this->input->post('job_id');
        $statusCode = $this->input->post('status');

        $response = array();
        if($jobId !=null && $statusCode!=null) {
            
            $data = array(
        		'active' => $statusCode
        	);
        	
        	$isUpdated = $this->model_job->editJob($data, $jobId);
            if($isUpdated == true) {
                $response['success'] = true;
                $response['messages'] = "Job "." Successfully."; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the job information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
    }

    public function sendMailTo(){
		$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'E-Mail ID', 'trim|required');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		
        if ($this->form_validation->run() == TRUE && $this->validateFormFile('attachement')){
            $userFolderPath = "assets/uploads/mail/attachement";
            
            $file = $this->uploadFile($userFolderPath, 'attachement');
            if($file['status']==1){
                
                $rpFind = "/home/interfa1/";
        		$rpString = "https://";
                $fullPath = str_replace($rpFind,$rpString,$file['data']['full_path']);
                
                $to = $this->input->post("email");
                $name = $this->input->post("name");
                $subject = $this->input->post("subject");
                $message = $this->input->post("message");
                $message = "Dear $name, <br> $message";
                
                $mail = $this->sendMail($to, $subject, $message, $fullPath);
                
                if($mail){
            		$this->session->set_flashdata('success', 'You mail sent successfully!!!.');
            		redirect('jobs/viewJobs', 'refresh');
                }else{
            		$this->session->set_flashdata('error', 'Unable to send mail');
            		redirect('jobs/viewJobs', 'refresh');
                }
            }else{
        		$this->session->set_flashdata('error', 'Unable to process your attachement');
        	    redirect('jobs/viewJobs', 'refresh');
            }
        }
        else{
    		$this->session->set_flashdata('error', 'All fields are mendatory!!.');
    		redirect('jobs/viewJobs', 'refresh');
        }
    }
    
    public function validateFormFile($field_name) {
        if (empty($_FILES[$field_name]['name'])) {
            $this->form_validation->set_message('error', 'The '.$field_name.' field is required.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}