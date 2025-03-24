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
        // Load the upload library
        $this->load->library('upload');
    }

    public function index()
    {
        // Set validation rules
        $this->form_validation->set_rules('cate_name', 'Category Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        // Run validation
        if ($this->form_validation->run()) {
            // Validation passed, handle file upload
            $post = $this->input->post();

            // Image upload configuration
            $config['upload_path'] = './uploads/category/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Max 2MB
            $config['file_name'] = time() . '_' . $_FILES['image']['name'];

            // Initialize upload
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                // Image uploaded successfully
                $uploadData = $this->upload->data();
                $post['image'] = $uploadData['file_name']; // Add image name to POST data
            } else {
                // Failed to upload image, use a default or set to null
                $post['image'] = null; // You can set a default value if needed
            }

            // Call model to save category with image
            $check = $this->CategoryModel->add_category($post);
            if ($check) {
                $this->session->set_flashdata('success', 'Category added successfully');
                redirect('category');
            }
        } else {
            // Validation failed, load the view with errors
            $data['categories'] = $this->CategoryModel->all_category();
            $this->load->view('category', $data);
        }
    }

    public function get_sub_cate()
    {
        $cate_id = $this->input->post('cate_id');
        $sub_categories = $this->CategoryModel->get_sub_category($cate_id);
        $output = '<option value="" selected>Select Sub Category</option>';

        if ($sub_categories) {
            foreach ($sub_categories as $sub_category) {
                $output .= '<option value="' . $sub_category->cate_id . '">' . $sub_category->cate_name . '</option>';
            }
        }

        echo $output;
    }
}
