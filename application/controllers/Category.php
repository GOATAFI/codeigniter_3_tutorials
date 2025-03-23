<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the form validation library
        $this->load->library('form_validation');
        $this->load->model('CategoryModel');
    }

    public function index()
    {
        // Set validation rules
        $this->form_validation->set_rules('cate_name', 'Category Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        // Run validation
        if ($this->form_validation->run()) {
            // Validation passed, do something here
            $post = $this->input->post();
            $check =  $this->CategoryModel->add_category($post);
            if ($check) {
                $this->session->set_flashdata('success', 'Category added successfully');
                redirect('category');
            }
        } else {
            $data['categories'] = $this->CategoryModel->all_category();
            // Validation failed, load the view with errors
            $this->load->view('category', $data);
        }
    }
}
