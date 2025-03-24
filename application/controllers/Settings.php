<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the form validation library
        $this->load->library('form_validation');
        $this->load->model('SettingsModel');
    }

    public function pincode()
    {
        // Set validation rules
        $this->form_validation->set_rules('pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('deliver_charge', 'Delivery Charge', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        // Run validation
        if ($this->form_validation->run()) {
            // Validation passed, do something here
            $post = $this->input->post();
            $check =  $this->SettingsModel->add_pincode($post);
            if ($check) {
                $this->session->set_flashdata('success', 'Pincode added successfully');
                redirect('settings/pincode');
            }
        } else {
            // Validation failed, load the view with errors
            $this->load->view('pincode');
        }
    }

    public function banner()
    {
        // Set validation rules
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        // Check if the form has been submitted (POST request)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the form validation passed
            if ($this->form_validation->run()) {
                // Check if a file was uploaded
                if (!empty($_FILES['bann_image']['name'])) {
                    // Configure upload settings
                    $config = array(
                        'upload_path'   => "./uploads/banner/", // Ensure this directory exists and is writable
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'max_size'      => 2048, // 2MB max size
                    );

                    // Load the upload library
                    $this->load->library('upload', $config);

                    // Attempt to upload the file
                    if ($this->upload->do_upload('bann_image')) {
                        // Get the uploaded file data
                        $image_data = $this->upload->data();
                        $image_name = $image_data['file_name'];

                        // Prepare the data to be saved
                        $post = $this->input->post();
                        $post['bann_image'] = $image_name; // Add the image file name to the POST data

                        // Save the data using the model
                        $check = $this->SettingsModel->add_banner($post);

                        if ($check) {
                            // Set success message and redirect
                            $this->session->set_flashdata('success', 'Banner added successfully');
                            redirect('settings/banner');
                        } else {
                            // Handle database error
                            $this->session->set_flashdata('error', 'Failed to add banner');
                            redirect('settings/banner');
                        }
                    } else {
                        // Handle file upload error
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect('settings/banner');
                    }
                } else {
                    // Handle case where no file was uploaded
                    $this->session->set_flashdata('error', 'Banner image is required');
                    redirect('settings/banner');
                }
            } else {
                // Validation failed, reload the form with errors
                $this->load->view('banner');
            }
        } else {
            // Form not submitted, load the view
            $this->load->view('banner');
        }
    }
}
