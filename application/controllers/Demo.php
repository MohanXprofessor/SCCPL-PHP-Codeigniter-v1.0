<?php

class Demo extends Admin_Controller
{
    
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('upload');
	}
	
    /**
     * Code updated By: Akash K. Fulari
     * On Date: 05-07-2024 03:35PM
     * CODE STARTS HERE: 050720240335
     * */
    public function mailsend(){
        $mail = $this->input->post("mail");
        $msg = $this->input->post("msg");
        $sub = $this->input->post("sub");
        
        $bool = $this->sendMail($mail, $sub, $msg);
        if($bool)
            echo "Sent Successfuly!";
        else
            echo "Unable to sent mail";
    }

    /**
     * CODE ENDS HERE: 050720240335
     * */
}