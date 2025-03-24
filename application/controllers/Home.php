<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the form validation library
        $this->load->library('form_validation');
        // Load the HomeModel
        $this->load->model('HomeModel');
    }

    public function index()
    {
        // Get the banner data
        $data['banner'] = $this->HomeModel->get_banner();
        $data['categories'] = $this->HomeModel->get_categ();
        $data['products'] = $this->HomeModel->get_products();
        $this->load->view('front/index', $data);
    }
}
