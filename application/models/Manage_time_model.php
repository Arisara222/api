<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_time_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    public function show_timesheet()
    {
        $sql_group_per = "SELECT
        sa_firstname,
        sa_lastname,
        its_date,
        its_time_in,
        its_time_out,
        its_ot,
        its_remark
         
    FROM
        `info_time_sheet`
        LEFT JOIN sys_account ON sys_account.sa_id = info_time_sheet.sa_id";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }
    public function show_username()
    {
        $sql_group_per = "SELECT
        sa_id,
        sa_firstname,
        sa_lastname
         
    FROM
        `sys_account`";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }
    public function show_time_edit()
    {
        $sql_group_per = "SELECT
        *
         
    FROM
        `info_time_sheet`";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function insert_timesheet($data)
    {
        $this->db->insert('info_time_sheet', $data);
        return $this->db->affected_rows() > 0 ? true : false;
        
    }


  
}