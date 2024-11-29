<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_assessment extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }





    public function save_assessment($data)
    {


        // Insert assessment data into the database
        return $this->db->insert('assessments', $data);
    }


    public function get_subjectName()
    {
        $this->db->select('id, subject_title'); // Include 'id' if needed for value
        $this->db->from('subject');
        $query = $this->db->get();
        return $query->result(); // Returns as an array of objects
    }

    // get all record 
    public function get_all_assessments()
    {
        // Fetch all rows from the assessments table
        $query = $this->db->get('assessments');

        return $query->result(); // Returns as an array of objects





    }


    // DELETE ASSESSMENTS 
    public function delete_assessment($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('assessments'); // 'assessments' is your table name
    }
}
