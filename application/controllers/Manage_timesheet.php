<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_timesheet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Manage_time_model', 'mtm');
    }

    
    public function show_timesheet (){
        $result = $this->mtm->show_timesheet();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 
    
    public function show_timesheet_view (){
        $id = $this->input->get('id');
        $result = $this->mtm->show_timesheet_view($id);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 
    
    public function show_username (){
        $result = $this->mtm->show_username();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 
    
    public function show_time_edit (){
        $result1 = $this->mtm->show_username();
        $result2 = $this->mtm->show_time_edit();
    
        // Combine both results into an associative array
        $combinedResults = [
            'result1' => $result1,
            'result2' => $result2
        ];
    
        // Echo the combined results as JSON
        echo json_encode($combinedResults);
    }
    
    public function insert_timesheet (){
        $data = [
        'sa_id' => $this->input->post('username'),
        'its_date' => $this->input->post('date'),
        'its_time_in' => $this->input->post('timeStart'),
        'its_time_out' => $this->input->post('timeEnd'),
        'its_remark' => $this->input->post('remark'),
        'its_ot' => $this->input->post('inpOt')
        ];
        $result = $this->mtm->insert_timesheet($data);
        echo json_encode($result);
    } 

    public function show_submenu(){
        $data = unserialize($this->input->post('data'));
        $result = $this->mang->show_submenu($data);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function insert_sub_menu(){
        $data = unserialize($this->input->post('data'));
        $sess = unserialize($this->input->post('session'));
        $result = $this->mang->insert_sub_menu($data, $sess);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function update_flg(){
        $sess = unserialize($this->input->post('session'));
        $data = unserialize($this->input->post('data'));
        $result = $this->mang->update_flg($data,$sess);
       
        echo json_encode($result);
    }



    public function show_show_smm(){
        $data = $this->input->post();
       
        // $data = unserialize($this->input->post('data'));
        $result = $this->mang->show_show_smm($data);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 


    public function edit_sub_menu(){

        $data = unserialize($this->input->post('data'));
        $sess = unserialize($this->input->post('session'));

        $result = $this->mang->edit_sub_menu($data, $sess);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    }
}