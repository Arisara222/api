<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_account extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Manage_model', 'mang');
    }

    public function show_user()
    {

        $result = $this->mang->show_user();
        echo json_encode($result);
    }

    public function showProfile()
    {
        $id = $this->input->get('u_id');
        $result = $this->mang->show_user_profile($id);
        echo json_encode($result);
    }

    public function editProfile()
    {


        $sa_id = $this->input->post('sa_id');
        $pass = $this->input->post('sa_emp_password');
        $pass_old = $this->input->post('sa_emp_password_old');

        if ($pass == $pass_old) {
            echo json_encode(['status' => false, 'message' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
            return;
        }



        
        if ($pass == '') {
            $data_sa = [
                'sa_emp_code' => $this->input->post('sa_emp_code'),
                'sa_firstname' => $this->input->post('sa_firstname'),
                'sa_lastname' => $this->input->post('sa_lastname'),
                'sa_email' => $this->input->post('sa_email')
            ];
        }else{
            $data_sa = [
                'sa_emp_code' => $this->input->post('sa_emp_code'),
                'sa_emp_password' => md5($this->input->post('sa_emp_password')),
                'sa_firstname' => $this->input->post('sa_firstname'),
                'sa_lastname' => $this->input->post('sa_lastname'),
                'sa_email' => $this->input->post('sa_email')
            ];
        }
  

        $data_sad = [
            'sad_birth_date' => $this->input->post('sad_birth_date'),
            'sad_address' => $this->input->post('sad_address'),
        ];

        if (!empty($_FILES['file_image']['name'])) {
            $uploadPath = FCPATH . 'uploads/';
            $config['upload_path'] = $uploadPath; // Use absolute path
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = 2048; // 2MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_image')) {
                $fileData = $this->upload->data();
                $file_image = $fileData['file_name'];
                $data_sad['sad_picture'] = $file_image; // Add file name to data array
            } else {
                // $error = $this->upload->display_errors();
                // echo json_encode(['status' => 'error', 'message' => 'File upload failed: ' . $error]);
                // return;
            }
        }
        $result = $this->mang->editProfile($data_sa, $sa_id);
        $result2 = $this->mang->editProfile2($data_sad, $sa_id);
        echo json_encode($result);
    }

    public function show_drop_down()
    {

        $result = $this->mang->show_drop_down();
        echo json_encode($result);
    }
    public function insert_user()
    {

        $data = unserialize($this->input->post('data'));
        $sess = unserialize($this->input->post('session'));
        $result = $this->mang->insert_user($data, $sess);
        echo json_encode($result);
    }

    public function update_status()
    {
        $data = unserialize($this->input->post('data'));
        $result = $this->mang->update_status($data);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    }

    public function upstatus()
    {
        $data = unserialize($this->input->post('data'));
        $result = $this->mang->update_flg($data);

        echo json_encode($result);
    }

    public function show_show_acc()
    {
        $data = $this->input->post();

        // $data = unserialize($this->input->post('data'));
        $result = $this->mang->show_show_acc($data);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    }

    public function show_update_acc()
    {
        $data = unserialize($this->input->post('data'));
        $sess = unserialize($this->input->post('session'));
        $result = $this->mang->insert_user($data, $sess);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    }
    public function update_user()
    {
        $data = unserialize($this->input->post('data'));
        $sess = unserialize($this->input->post('session'));
        $result = $this->mang->update_user($data, $sess);
        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    }

    public function show_upd_User()
    {
        $data = unserialize($this->input->post('data'));
        $sess = unserialize($this->input->post('session'));
        $result = $this->mang->show_upd_User($data, $sess);
        // echo "<pre>";
        // print_r($result);
        // exit;
        echo json_encode($result);
    }
}
