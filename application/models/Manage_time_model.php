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
        sys_account.sa_id,
        its_id,
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

    public function show_leave_request()
    {
        $sql_group_per = "SELECT
        count(*) as cou
    FROM
        `info_leave_detail`
        where ild_status = '0'";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function show_late()
    {
        $sql_group_per = "SELECT
        count(*) as tim
    FROM
        `info_time_sheet`
        where its_time_in > '08:00:00' AND its_time_in < '12:00:00'";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function show_timesheet_view($id)
    {
        $sql_group_per = "SELECT
        sys_account.sa_id,
        sa_firstname,
        sa_lastname,
        its_date,
        its_time_in,
        its_time_out,
        its_ot,
        its_remark
         
    FROM
        `info_time_sheet`
        LEFT JOIN sys_account ON sys_account.sa_id = info_time_sheet.sa_id
        WHERE sys_account.sa_id = '$id'
        ";
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
    public function show_username_all($id)
    {
        $sql_group_per = "SELECT
        sa_firstname,
        sa_lastname,
          sad_picture,
          mp_name,
          sad_leave_balance
      FROM
          `sys_account` as sa
          
          LEFT JOIN sys_account_detail sad ON sad.sa_id = sa.sa_id
          LEFT JOIN mst_position mp ON mp.mp_id = sa.mp_id
        WHERE sa.sa_id = '$id'";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function show_type_leave()
    {
        $sql_group_per = "SELECT
        *
         
    FROM
        `mst_leave_detail`";
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

    public function show_leave()
    {
        $sql_group_per = "SELECT
	* 
        FROM
        	`info_leave_detail`
        INNER JOIN sys_account ON info_leave_detail.sa_id = sys_account.sa_id
        INNER JOIN mst_leave_detail ON info_leave_detail.mld_id = mst_leave_detail.mld_id";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function show_leave_approve()
    {
        $sql_group_per = "SELECT
	* 
        FROM
        	`info_leave_detail`
        INNER JOIN sys_account ON info_leave_detail.sa_id = sys_account.sa_id
        INNER JOIN mst_leave_detail ON info_leave_detail.mld_id = mst_leave_detail.mld_id
        WHERE info_leave_detail.ild_status = '0'
        ";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function show_leave_view($id)
    {
        $sql_group_per = "SELECT
	* 
                            FROM
                            	`info_leave_detail`
                            LEFT JOIN sys_account ON info_leave_detail.sa_id = sys_account.sa_id
                            LEFT JOIN mst_leave_detail ON info_leave_detail.mld_id = mst_leave_detail.mld_id
                            WHERE info_leave_detail.ild_id = '$id'";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function insert_timesheet($data)
    {
        $this->db->insert('info_time_sheet', $data);
        return $this->db->affected_rows() > 0 ? true : false;
        
    }
    public function update_timesheet($data, $id) {
        // Assuming `$this->db` refers to your database connection object
    
        // Update the timesheet record based on the provided $id
        $this->db->where('its_id', $id); // Assuming 'timesheet_id' is the primary key column name
        $this->db->update('info_time_sheet', $data); // Assuming 'timesheet_table' is your timesheet table name
    
        // Check if the update was successful
        if ($this->db->affected_rows() > 0) {
            return array('success' => true, 'message' => 'Timesheet updated successfully.');
        } else {
            return array('success' => false, 'message' => 'Failed to update timesheet.');
        }
    }

    public function insert_leave($data)
    {
        $this->db->insert('info_leave_detail', $data);
        return $this->db->affected_rows() > 0 ? true : false;
        
    }

    public function deleteLeave($id)
    {
        $this->db->where('ild_id', $id);
        $this->db->delete('info_leave_detail');
    
        // Check if any rows were affected
        return $this->db->affected_rows() > 0;
        
    }

    public function approve_leave($id, $data) {
        $this->db->where('ild_id', $id);
        return $this->db->update('info_leave_detail', $data);
    }


  
}