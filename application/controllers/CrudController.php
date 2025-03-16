<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrudController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the Form Validation Library
        $this->load->library('form_validation');
        // Load the Form Helper
        $this->load->helper('form');
        $this->load->model('homeModel');
        // Load the URL Helper
        $this->load->helper('url');
    }

    public function index()
    {
        // Set error delimiters
        $this->form_validation->set_error_delimiters('<div class="text-danger mt-1 mb-3">', '</div>');

        // Load the view
        $this->load->view('insert');
    }

    public function add_data()
    {
        // Set validation rules
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('language', 'Language', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');

        // Check if a file is uploaded
        if (empty($_FILES['image']['name'])) {
            $this->form_validation->set_rules('image', 'Image', 'required');
        }

        if ($this->form_validation->run()) {
            // Form validation passed, process the data
            $post = $this->input->post();

            // Handle file upload if a file is selected
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $post['image'] = $data['file_name']; // Save the file name to the database
                } else {
                    // File upload failed, show error
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('upload_error', $error);
                    $this->load->view('insert');
                    return;
                }
            } else {
                $post['image'] = ''; // No file uploaded
            }

            // Convert qualification array to a comma-separated string
            if (isset($post['qualification']) && is_array($post['qualification'])) {
                $post['qualification'] = implode(', ', $post['qualification']);
            } else {
                $post['qualification'] = ''; // Set to empty string if no qualification is selected
            }

            // Add the current date
            $post['added_on'] = date('d M, Y');

            // Save data to the database
            $check = $this->homeModel->add_data($post);
            if ($check) {
                $this->session->set_flashdata('success', 'Data added successfully!');
                redirect('CrudController/all_data');
            } else {
                echo "Form submitted successfully!";
            }
        } else {
            // Form validation failed, reload the form with errors
            $this->load->view('insert');
        }
    }

    public function all_data($id = "")
    {
        if ($id != "") {
            $data['arr'] = $this->homeModel->all_data($id);
            $this->load->view('insert', $data);
        } else {
            $data['arr'] = $this->homeModel->all_data();
            $this->load->view('all_data', $data);
        }
    }

    public function update_data()
    {
        // Set validation rules
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('language', 'Language', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');

        if ($this->form_validation->run()) {
            // Form validation passed, process the data
            $post = $this->input->post();

            // Fetch the existing record to get the previous image
            $existing_record = $this->homeModel->all_data($post['id']);

            // Handle file upload if a file is selected
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $post['image'] = $data['file_name']; // Save the new file name to the database

                    // Delete the previous image file if it exists
                    if (!empty($existing_record->image)) {
                        $previous_image_path = './uploads/' . $existing_record->image;
                        if (file_exists($previous_image_path)) {
                            unlink($previous_image_path); // Delete the previous image file
                        }
                    }
                } else {
                    // File upload failed, show error
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('upload_error', $error);
                    $this->load->view('insert');
                    return;
                }
            } else {
                // No new image uploaded, retain the previous image
                $post['image'] = $existing_record->image;
            }

            // Convert qualification array to a comma-separated string
            if (isset($post['qualification']) && is_array($post['qualification'])) {
                $post['qualification'] = implode(', ', $post['qualification']);
            } else {
                $post['qualification'] = ''; // Set to empty string if no qualification is selected
            }

            // Add the current date
            $post['updated_on'] = date('d M, Y');

            // Save data to the database
            $check = $this->homeModel->update_data($post);
            if ($check) {
                redirect('CrudController/all_data');
            }
        } else {
            // Form validation failed, reload the form with errors
            $id = $this->input->post('id');
            $data['arr'] = $this->homeModel->all_data($id);
            $this->load->view('insert', $data);
        }
    }

    public function delete_data($id)
    {
        $check = $this->homeModel->delete_data($id);
        if ($check) {
            redirect('CrudController/all_data');
        }
    }
}
