<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_stock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Manage_stock_model', 'msm');
        $this->load->helper(array('form', 'url'));
    }

    public function show_stock (){
        $result = $this->msm->show_stock();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_das (){
        $result = $this->msm->show_das();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_stock_cou (){
        $result = $this->msm->show_stock_cou();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_edit_stock (){
        $id = $this->input->post('id');
        $result = $this->msm->show_edit_stock($id);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_stock_in (){
        $result = $this->msm->show_stock_in();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_product() {
        $id = $this->input->get('mp_id');
    
        if ($id === null) {
            $result2 = $this->msm->show_product();
            $result = array(
                'result' => $result2,
                'result1' => []  // Return an empty array if no specific product is requested
            );
        } else {
            $result1 = $this->msm->show_product_byid($id);
            $result2 = $this->msm->show_product();
            $result = array(
                'result' => $result2,
                'result1' => $result1
            );
        }
    
        echo json_encode($result);
    }

    public function insertStock() {
        $this->load->helper('url');
        $this->load->library('form_validation');
    
        $this->form_validation->set_rules('company', 'Company', 'required');
        $this->form_validation->set_rules('product', 'Product', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|integer');
    
        if ($this->form_validation->run() === FALSE) {
          $response = array('status' => 'error', 'message' => validation_errors());
        } else {
          $data = array(
            'isd_company' => $this->input->post('company'),
            'mp_id' => $this->input->post('product'),
            'isd_qty' => $this->input->post('quantity'),
            'isd_status' => '1',
          );

          $mp_id = $this->input->post('product');
          $quantity = $this->input->post('quantity');
          $note = $this->input->post('notes');
          // Save the data to the database (example)
          $result = $this->msm->insertStock($data);
          $result1 = $this->msm->insertProduct($note,$quantity,$mp_id);
    
          if ($result && $result1) {
            $response = array('status' => 'success', 'message' => 'Stock added successfully');
          } else {
            $response = array('status' => 'error', 'message' => 'Failed to add stock');
          }
        }
    
        echo json_encode($response);
      }

    public function updateStock() {

          $mp_id = $this->input->post('product');
          $quantity = $this->input->post('quantity');
          $note = $this->input->post('notes');
          $company = $this->input->post('company');
          // Save the data to the database (example)
        $data = [
            'isd_company' => $company,
            'mp_id' => $mp_id,
            'isd_qty' => $quantity,
            'isd_status' => '0',
            'isd_create_date' => date('Y-m-d H:i:s'),
        ];
          $result = $this->msm->insertStock($data);
          $result1 = $this->msm->updateProduct($note,$quantity,$mp_id);
    
          if ($result1) {
            $response = array('status' => 'success', 'message' => 'Stock added successfully');
          } else {
            $response = array('status' => 'error', 'message' => 'Failed to add stock');
          }
        echo json_encode($response);
      }
    

    public function show_leave(){
        $result = $this->mtm->show_leave();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_leave_approve(){
        $result = $this->mtm->show_leave_approve();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function approve_leave(){
        $id = $this->input->post('ild_id');
        $data = [
            'ild_status' => 1
        ];
        $result = $this->mtm->approve_leave($id,$data);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_leave_view(){
        $id = $this->input->post('id');
        $result = $this->mtm->show_leave_view($id);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function show_product_all(){
        $result = $this->msm->show_product();
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 
    public function show_product_byid(){
        $id = $this->input->post('id');
        $result = $this->msm->show_product_byid($id);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    } 

    public function updateProduct() {
        $data = [
            'mp_name' => $this->input->post('product'),
            'mp_indicator' => $this->input->post('indicator'),
            'mp_price' => $this->input->post('unit')
        ];

        $insert = $this->msm->insert_product($data);

        if ($insert) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        echo json_encode($response);

    }

    public function insertProduct() {
        $mp_name = $this->input->post('product');
        $check = $this->msm->check_exits_product($mp_name);

        if ($check) {
            $response = array('status' => 'Exits');
            echo json_encode($response);
            return;
        }
        $data = [
            'mp_name' => $this->input->post('product'),
            'mp_indicator' => $this->input->post('indicator'),
            'mp_price' => $this->input->post('unit'),
            'mp_qty' => '0'
        ];

        $insert = $this->msm->insert_product($data);

        if ($insert) {
            $response = array('status' => 'success');
        }

        echo json_encode($response);

    }
    public function insert_leave() {
        // Retrieve form data
        $data = [
            'sa_id' => $this->input->post('employeeName'),
            'mld_id' => $this->input->post('leaveType'),
            'ild_date_start' => $this->input->post('startDate'),
            'ild_date_end' => $this->input->post('endDate'),
            'ild_time_start' => $this->input->post('timeStart'),
            'ild_time_end' => $this->input->post('timeEnd'),
            'ild_type_leave' => $this->input->post('HalfDayValue'),
            'ild_remark' => $this->input->post('remark'),
            'ild_created_date' => date('Y-m-d H:i:s'),
            'ild_status' => '0'
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
        // Insert data into the database
        $insert = $this->mtm->insert_leave($data);
    
        if ($insert) {
            echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit form']);
        }

    }

    public function deleteLeave() {
        $id = $this->input->post('ild_id');
        $result = $this->mtm->deleteLeave($id);
        echo json_encode($result);
    }
    
    
}