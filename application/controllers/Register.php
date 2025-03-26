<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('RegisterModel');
    }

    public function index()
    {
        $this->form_validation->set_rules('name', 'full name', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|is_unique[ec_users.email]', ['is_unique' => 'This email is already exist']);
        $this->form_validation->set_rules('password', 'password', 'required|trim|min_length[6]');

        if ($this->form_validation->run()) {
            $post = $this->input->post();
            $this->RegisterModel->register($post);
            // echo "yes";
        } else {
            $this->load->view('front/register');
        }
    }
}
