<?php

class Model_allocated_batch extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');

        $this->load->model('model_allocated_batch');
        $this->load->model('model_groups');
    }
    public function getEnrollmentId($id)
    {
        if($id)
        {
            $sql="SELECT * FROM allocated_batch WHERE bid = ?";
            $query=$this->db->query($sql,array($id));
            return $query->result_array();
        }
    }

    public function getEnrollmentIdsByBatchId($batch_id) {
        // Assuming enrollment IDs are stored in 'allocated_batches' table with batch_id
        $this->db->where('id', $batch_id);
        $query = $this->db->get('allocated_batch');
        return $query->result_array();
    }
}


?>