<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-05-06 17:09:01
 Last Modification Date: 2024-05-06 17:13:32
*
**/
class Model_studentDocMail extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getStudentdocumentmailById($id)
    {
        $query = $this->db->query("SELECT * FROM studentdocumentmail WHERE id  = ? order by id desc", array($id));
        return $query->row_array();
    }
    public function isExists($id)
    {
        $query = $this->db->query("SELECT * FROM studentdocumentmail WHERE id  = ? order by id desc", array($id));
        return $query->row_array();
    }

    public function getStudentdocumentmailByEmail($email, $enroll_id = null)
    {
        if ($email && $enroll_id) {
            $query = $this->db->query("SELECT * FROM studentdocumentmail WHERE email  = ? and enroll_id = ? order by id desc", array($email, $enroll_id));
            return $query->result_array();
        } else if ($email) {
            $query = $this->db->query("SELECT * FROM studentdocumentmail WHERE email  = ? order by id desc", array($email));
            return $query->result_array();
        }
        return array();
    }

    public function createStudentdocumentmail($data = '')
    {
        $create = $this->db->insert('studentdocumentmail', $data);
        return ($create == true) ? true : false;
    }

    public function updateStudentdocumentmail($data, $id)
    {
        $this->db->where('id', $id);
        $update = $this->db->update('studentdocumentmail', $data);
        return ($update == true) ? true : false;
    }

    public function deleteStudentdocumentmail($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete('studentdocumentmail');
        return ($delete == true) ? true : false;
    }
}