<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_stock_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function show_stock()
    {
        $sql_group_per = "SELECT
                                isd.isd_company,
                                isd.isd_id,
                              mp.mp_id,
                              mp.mp_name,
                              mp.mp_qty AS qty,
                                 mp.mp_indicator,
                              isd.isd_status AS stock_status,
                                mp_price,
                                (mp_price * mp.mp_qty) as total_price,
                              isd.isd_create_date AS created_date
                            FROM info_stock_detail isd
                            LEFT JOIN mst_product mp ON isd.mp_id = mp.mp_id
                            GROUP BY mp.mp_name
                            ORDER BY mp.mp_qty ASC;";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }
    
    public function show_das()
    {
        $sql_group_per = "SELECT
            isd.isd_company,
            isd.isd_id,
          mp.mp_id,
          mp.mp_name,
          isd_qty,
             mp.mp_indicator,
          isd.isd_status AS stock_status,
            mp_price,
            (mp_price * mp.mp_qty) as total_price,
          isd.isd_create_date AS created_date
        FROM info_stock_detail isd
        LEFT JOIN mst_product mp ON isd.mp_id = mp.mp_id
        
        ORDER BY mp.mp_qty ASC;";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }
    public function show_stock_cou()
    {
        $sql_group_per = "SELECT
           SUM(mp_qty) as qty
        FROM mst_product
        
        ORDER BY qty DESC;";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }
    public function show_edit_stock($id)
    {
        $sql_group_per = "SELECT
                                isd.isd_id,
                                isd.isd_company,
                              mp.mp_id,
                              mp.mp_name,
                              mp.mp_price,
                              mp.mp_qty AS qty,
                                 mp.mp_indicator,
                              isd.isd_status AS stock_status,
                              mp.mp_note,
                                mp_price,
                                (mp_price * mp.mp_qty) as total_price,
                              isd.isd_create_date AS created_date
                            FROM info_stock_detail isd
                            LEFT JOIN mst_product mp ON isd.mp_id = mp.mp_id
                            WHERE isd.isd_id = '$id'
                            GROUP BY mp.mp_name
                            ORDER BY mp.mp_qty ASC;";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }
    
    public function show_stock_in()
    {
        $sql_group_per = "SELECT
                            isd.isd_company,
                            mp.mp_name,
                            mp.mp_qty AS qty,
                            mp.mp_indicator,
                            isd.isd_status AS stock_status,
                            isd_price,
                            (isd_price * isd.isd_qty) as total_price,
                            isd.isd_create_date AS created_date
                           FROM info_stock_detail isd
                           LEFT JOIN mst_product mp ON isd.mp_id = mp.mp_id
                           WHERE isd.isd_status = '1'
                           ORDER BY isd.isd_qty ASC;";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function check_exits_product($mp_name){
        $sql_group_per = "SELECT
                           *
                           FROM mst_product
                           WHERE mp_name = '$mp_name'
                           ";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function show_product(){
        $sql_group_per = "SELECT
                           *
                           FROM mst_product";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function show_product_byid($id){
        $sql_group_per = "SELECT
                           *
                           FROM mst_product
                           WHERE mp_id = '$id'
                           ";
        $query = $this->db->query($sql_group_per);
        $data = $query->result();

        return $data;
    }

    public function insertStock($data) {
        return $this->db->insert('info_stock_detail', $data); // 'stock' should be your table name
    }

    public function insert_product($data) {
        return $this->db->insert('mst_product', $data); // 'stock' should be your table name
    }

    public function insertProduct($note, $quantity, $mp_id) {
        $this->db->set('mp_qty', 'mp_qty + ' . $quantity, FALSE); // Increment the unit_price by the new unitPrice
        $this->db->set('mp_note', $note); // Increment the unit_price by the new unitPrice
        $this->db->where('mp_id', $mp_id); // Adjust 'id' to your actual primary key column name
        return $this->db->update('mst_product'); // 'products' should be your table name
    }

    public function updateProduct($note, $quantity, $mp_id) {
        $this->db->set('mp_qty', 'mp_qty - ' . $quantity, FALSE); // Increment the unit_price by the new unitPrice
        $this->db->set('mp_note', $note); // Increment the unit_price by the new unitPrice
        $this->db->where('mp_id', $mp_id); // Adjust 'id' to your actual primary key column name
        return $this->db->update('mst_product'); // 'products' should be your table name
    }
}
