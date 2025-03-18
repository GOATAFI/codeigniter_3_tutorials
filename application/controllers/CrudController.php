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
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|numeric');
        $this->form_validation->set_rules('language[]', 'Language', 'required', array('required' => 'Please select at least one language.'));
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');

        // Check if a file is uploaded
        if (empty($_FILES['image']['name'])) {
            // No file uploaded, set validation rule for the image
            $this->form_validation->set_rules('image', 'Image', 'required', array('required' => 'Please select an image file (JPG or PNG).'));
        } else {
            // File uploaded, set validation rule for the image
            $this->form_validation->set_rules('image', 'Image', 'callback_validate_image');
        }

        if ($this->form_validation->run()) {
            // Form validation passed, process the data
            $post = $this->input->post();

            // Handle file upload if a file is selected
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = 2048; // 2MB max size
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $post['image'] = $data['file_name']; // Save the file name to the database
                } else {
                    // File upload failed, show custom error message
                    $error = $this->upload->display_errors();
                    if (strpos($error, 'filetype') !== false) {
                        $this->session->set_flashdata('upload_error', 'Please provide images with PNG and JPG files only.');
                    } else {
                        $this->session->set_flashdata('upload_error', $error);
                    }
                    $this->session->set_flashdata('swal_error', 'Please provide images with PNG and JPG files only.');
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
                $this->session->set_flashdata('swal_success', 'Data added successfully!');
                redirect('CrudController/all_data');
            } else {
                $this->session->set_flashdata('swal_error', 'Error adding data');
                echo "Form submitted successfully!";
            }
        } else {
            // Form validation failed, set error for SweetAlert
            $this->session->set_flashdata('validation_errors', validation_errors());
            // Form validation failed, reload the form with errors
            $this->load->view('insert');
        }
    }
    public function all_data($id = "")
    {
        $data['current_timestamp'] = date('Y-m-d H:i:s');
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
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|numeric');
        $this->form_validation->set_rules('language[]', 'Language', 'required', array('required' => 'Please select at least one language.'));
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');

        // Fetch the existing record to get the previous image
        $post = $this->input->post();
        $existing_record = $this->homeModel->all_data($post['id']);

        // Check if a new file is uploaded
        if (empty($_FILES['image']['name'])) {
            // No new file uploaded, retain the previous image
            $post['image'] = $existing_record->image;
        } else {
            // New file uploaded, set validation rule for the image
            $this->form_validation->set_rules('image', 'Image', 'callback_validate_image');
        }

        if ($this->form_validation->run()) {
            // Convert language array to a comma-separated string
            if (isset($post['language']) && is_array($post['language'])) {
                $post['language'] = implode(', ', $post['language']);
            } else {
                $post['language'] = ''; // Set to empty string if no language is selected
            }

            // Handle file upload if a new file is selected
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = 2048; // 2MB max size
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
                    // File upload failed, show custom error message
                    $error = $this->upload->display_errors();
                    if (strpos($error, 'filetype') !== false) {
                        $this->session->set_flashdata('upload_error', 'Please provide images with PNG and JPG files only.');
                    } else {
                        $this->session->set_flashdata('upload_error', $error);
                    }
                    $this->session->set_flashdata('swal_error', 'Please provide images with PNG and JPG files only.');
                    $this->load->view('insert');
                    return;
                }
            }

            // Convert qualification array to a comma-separated string
            if (isset($post['qualification']) && is_array($post['qualification'])) {
                $post['qualification'] = implode(', ', $post['qualification']);
            } else {
                $post['qualification'] = ''; // Set to empty string if no qualification is selected
            }

            // Add the current date
            $post['updated_on'] = date('Y-m-d H:i:s');

            // Remove the 'existing_image' field from the $post array
            unset($post['existing_image']);

            // Save data to the database
            $check = $this->homeModel->update_data($post);
            if ($check) {
                $this->session->set_flashdata('success', 'Data updated successfully!');
                $this->session->set_flashdata('swal_success', 'Data updated successfully!');
                redirect('CrudController/all_data');
            } else {
                $this->session->set_flashdata('swal_error', 'Error updating data');
                redirect('CrudController/all_data');
            }
        } else {
            // Form validation failed, set error for SweetAlert
            $this->session->set_flashdata('validation_errors', validation_errors());
            // Form validation failed, reload the form with errors
            $id = $this->input->post('id');
            $data['arr'] = $this->homeModel->all_data($id);
            $this->load->view('insert', $data);
        }
    }

    // Custom callback function to validate the image
    public function validate_image($str)
    {
        if (empty($_FILES['image']['name'])) {
            // No file uploaded, skip validation
            return true;
        } else {
            // File uploaded, check if it's a valid image
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 2048; // 2MB max size
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $error = $this->upload->display_errors();
                if (strpos($error, 'filetype') !== false) {
                    $this->form_validation->set_message('validate_image', 'Please provide images with PNG and JPG files only.');
                } else {
                    $this->form_validation->set_message('validate_image', $error);
                }
                return false;
            } else {
                return true;
            }
        }
    }

    // Custom callback function to validate the image
    public function delete_data($id)
    {
        $check = $this->homeModel->delete_data($id);
        if ($check) {
            $this->session->set_flashdata('success', 'Data deleted successfully!');
            $this->session->set_flashdata('swal_success', 'Data deleted successfully!');
            redirect('CrudController/all_data');
        } else {
            $this->session->set_flashdata('swal_error', 'Error deleting data');
            redirect('CrudController/all_data');
        }
    }
}
