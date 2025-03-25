<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the form validation library
        $this->load->library('form_validation');
        $this->load->model('CategoryModel');
        $this->load->model('ProductModel');
    }

    public function index()
    {
        // Generate a new product ID every time the page loads
        $pro_id = mt_rand(11111, 99999);
        $this->session->set_userdata('pro_id', $pro_id);

        // Check if the form is submitted
        if ($this->input->post()) {
            // Set validation rules
            $this->form_validation->set_rules('pro_name', 'Product Name', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            // $this->form_validation->set_rules('sub_category', 'Sub Category', 'required');
            $this->form_validation->set_rules('brand', 'Brand', 'required');
            $this->form_validation->set_rules('stock', 'Stock', 'required|numeric');
            $this->form_validation->set_rules('mrp', 'MRP', 'required|numeric');
            $this->form_validation->set_rules('selling_price', 'Selling Price', 'required|numeric');

            // Only validate images if files were selected
            if (!empty($_FILES['pro_main_image']['name'])) {
                $this->form_validation->set_rules('pro_main_image', 'Product Main Image', 'callback_validate_main_image');
            }

            if (!empty($_FILES['gallery_image']['name'][0])) {
                $this->form_validation->set_rules('gallery_image[]', 'Gallery Images', 'callback_validate_gallery_images');
            }

            if ($this->form_validation->run()) {
                $post_data = $this->input->post();
                if (!empty($post_data['pro_name'])) {
                    $post_data['slug'] = $this->generate_slug($post_data['pro_name']);
                }
                // Handle file uploads
                $upload_data = $this->handle_upload();

                if ($upload_data === false) {
                    // If there was an error during upload, don't proceed
                    $this->session->set_flashdata('error', 'Failed to upload images');
                    $data['categories'] = $this->CategoryModel->all_category();
                    $this->load->view('product', $data);
                    return;
                }

                // Add file names to the post data
                if (!empty($upload_data['pro_main_image'])) {
                    $post_data['pro_main_image'] = $upload_data['pro_main_image'];
                }

                if (!empty($upload_data['gallery_image'])) {
                    $post_data['gallery_image'] = serialize($upload_data['gallery_image']);
                }

                // Insert data into the database
                if ($this->ProductModel->add_product($post_data)) {
                    $this->session->set_flashdata('success', 'Product added successfully');

                    // Generate a new product ID for the next submission
                    $new_pro_id = mt_rand(11111, 99999);
                    $this->session->set_userdata('pro_id', $new_pro_id);

                    redirect('product');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add product');
                    redirect('product');
                }
            }
        }

        // If validation fails or form is not submitted, load the view with errors
        $data['categories'] = $this->CategoryModel->all_category();
        $data['pro_id'] = $this->session->userdata('pro_id');
        $this->load->view('product', $data);
    }

    private function generate_slug($string)
    {
        // Convert to lowercase
        $string = strtolower($string);

        // Replace spaces with dashes
        $string = preg_replace('/\s+/', '-', $string);

        // Remove special characters
        $string = preg_replace('/[^a-z0-9\-]/', '', $string);

        // Remove multiple dashes
        $string = preg_replace('/-+/', '-', $string);

        // Trim dashes from beginning and end
        $string = trim($string, '-');

        return $string;
    }


    // Custom validation callback for the main image
    public function validate_main_image()
    {
        if (empty($_FILES['pro_main_image']['name'])) {
            $this->form_validation->set_message('validate_main_image', 'The {field} is required.');
            return false;
        }

        // Check if the file is an image
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($_FILES['pro_main_image']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_extension), $allowed_types)) {
            $this->form_validation->set_message('validate_main_image', 'The {field} must be a valid image (jpg, jpeg, png, gif).');
            return false;
        }

        return true;
    }

    // Custom validation callback for gallery images
    public function validate_gallery_images()
    {
        if (empty($_FILES['gallery_image']['name'][0])) {
            $this->form_validation->set_message('validate_gallery_images', 'At least one {field} is required.');
            return false;
        }

        // Check if all files are images
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        foreach ($_FILES['gallery_image']['name'] as $file) {
            $file_extension = pathinfo($file, PATHINFO_EXTENSION);
            if (!in_array(strtolower($file_extension), $allowed_types)) {
                $this->form_validation->set_message('validate_gallery_images', 'All {field} must be valid images (jpg, jpeg, png, gif).');
                return false;
            }
        }

        return true;
    }

    // Handle file uploads
    private function handle_upload()
    {
        $upload_data = [];

        // Make sure upload directory exists
        if (!is_dir('./uploads/products/')) {
            mkdir('./uploads/products/', 0777, TRUE);
        }

        // Upload configuration
        $config['upload_path'] = './uploads/products/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        // Upload main image
        if (!empty($_FILES['pro_main_image']['name'])) {
            if ($this->upload->do_upload('pro_main_image')) {
                $uploaded_data = $this->upload->data();
                $upload_data['pro_main_image'] = $uploaded_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                return false;
            }
        }

        // Upload gallery images
        if (!empty($_FILES['gallery_image']['name'][0])) {
            $gallery_images = [];

            // Save current config
            $main_config = $this->upload->initialize($config);

            foreach ($_FILES['gallery_image']['name'] as $key => $file) {
                $_FILES['userfile']['name'] = $_FILES['gallery_image']['name'][$key];
                $_FILES['userfile']['type'] = $_FILES['gallery_image']['type'][$key];
                $_FILES['userfile']['tmp_name'] = $_FILES['gallery_image']['tmp_name'][$key];
                $_FILES['userfile']['error'] = $_FILES['gallery_image']['error'][$key];
                $_FILES['userfile']['size'] = $_FILES['gallery_image']['size'][$key];

                // Re-initialize the upload class for each file
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userfile')) {
                    $uploaded_data = $this->upload->data();
                    $gallery_images[] = $uploaded_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    return false;
                }
            }

            $upload_data['gallery_image'] = $gallery_images;
        }

        return $upload_data;
    }
}
