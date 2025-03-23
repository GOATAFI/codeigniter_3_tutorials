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
        $this->form_validation->set_rules('banner', 'Banner Image', 'required');
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
}
