<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_leave extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Manage_time_model', 'mtm');
        $this->load->helper(array('form', 'url'));
    }

    public function show_type_leave (){
        $result = $this->mtm->show_type_leave();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_leave (){
        $result = $this->mtm->show_leave();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function insert_leave() {
        // Retrieve form data
        $data = [
            'sa_id' => $this->input->post('employeeName'),
            'mld_id' => $this->input->post('leaveType'),
            'ild_date_start' => $this->input->post('startDate'),
            'ild_date_end' => $this->input->post('endDate'),
            'ild_leave_kind' => $this->input->post('leaveKind'),
            'ild_remark' => $this->input->post('remark'),
            'ild_created_date' => date('Y-m-d H:i:s'),
        ];
    
        // Handle file upload
        if (!empty($_FILES['medicalCertificate']['name'])) {
            $uploadPath = FCPATH . 'uploads/';
            $config['upload_path'] = $uploadPath; // Use absolute path
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = 2048; // 2MB
    
            $this->load->library('upload', $config);
    
            if ($this->upload->do_upload('medicalCertificate')) {
                $fileData = $this->upload->data();
                $medicalCertificate = $fileData['file_name'];
                $data['ild_file'] = $medicalCertificate; // Add file name to data array
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(['status' => 'error', 'message' => 'File upload failed: ' . $error]);
                return;
            }
        }
    var_dump($data);
        // Insert data into the database
        $insert = $this->mtm->insert_leave($data);
    
        if ($insert) {
            echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit form']);
        }
    }
}