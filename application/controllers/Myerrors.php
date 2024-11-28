<?php
/*
 *
 * Author: Akash K Fulari
 * Contact-mail: akashfulari31@gmail.com
 * Description: ________________your_description_here_________________
 * Created: 2024-04-11 13:27:04
 Last Modification Date: 2024-04-11 13:33:12
 *
 **/


defined('BASEPATH') or exit('No direct script access allowed');

class Myerrors extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
    }
    public function remove()
    {
        unset($_SESSION['success']);
        unset($_SESSION['error']);
        unset($_SESSION['errors']);

        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
        $this->session->unset_userdata('errors');
    }
}
?>