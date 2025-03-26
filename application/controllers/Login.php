<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('LoginModel');
        $this->load->library('session');
        if (!empty($this->session->userdata('login_id'))) {
            redirect('checkout');
        }
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'password', 'required|trim|min_length[6]');

        if ($this->form_validation->run()) {
            $post = $this->input->post();
            $check =    $this->LoginModel->auth($post);
            if ($check) {
                redirect('checkout');
            } else {
                $this->session->set_flashdata('errmsg', 'Invalid email or password');
                redirect('login');
            }
            // echo "yes";
        } else {
            $this->load->view('front/login');
        }
    }
}
