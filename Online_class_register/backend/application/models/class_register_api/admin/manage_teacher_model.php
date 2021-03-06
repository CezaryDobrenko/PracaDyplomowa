<?php

class manage_teacher_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_teacher($teacher_data){
        return $this->db->insert("tbl_teachers",$teacher_data);
    }

    public function get_all_teachers(){
        $this->db->select("a.teacher_id, a.teacher_email, a.teacher_password, a.teacher_name, a.teacher_surname, a.teacher_is_active, a.teacher_role, b.group_short_name");
        $this->db->from("tbl_teachers as a");
		$this->db->join('tbl_groups as b', 'teacher_group = group_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_teacher($teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_teacher($teacher_id, $teacher_data){
        $this->db->where("teacher_id", $teacher_id);
        return $this->db->update("tbl_teachers",$teacher_data);
    }

    public function delete_teacher($teacher_id){
        $this->db->where("teacher_id", $teacher_id);
        return $this->db->delete("tbl_teachers");
    }

    // HELPER METHODS

    public function is_email_exists($email){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_email",$email);
        $query = $this->db->get();
        return $query->row();
    }

    public function find_by_id($teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_id", $teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_group_exists($group_id){
        $this->db->select("*");
        $this->db->from("tbl_groups");
        $this->db->where("group_id",$group_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_email_unique($email, $id){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_email",$email);
        $this->db->where("teacher_id !=",$id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>