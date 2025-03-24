<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductModel extends CI_Model
{
    public function add_product($data)
    {
        // Add timestamp
        $data['added_on'] = date('Y-m-d H:i:s');

        // Make sure description is properly formatted for the database
        if (isset($data['description'])) {
            $data['description'] = htmlspecialchars($data['description'], ENT_QUOTES);
        }

        // Insert data into the database
        $this->db->insert('ec_product', $data);

        // Debug: Check for database errors
        if ($this->db->error()['code'] != 0) {
            log_message('error', 'Database Error: ' . $this->db->error()['message']);
            return false;
        }

        return $this->db->affected_rows() > 0;
    }
}
