<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SettingsModel extends CI_Model
{
    public function add_pincode($post)
    {

        $q = $this->db->insert('ec_pincode', $post);
        if ($q) {
            return true;
        } else {
            return false;
        }
    }

    public function all_category()
    {
        $q = $this->db->where(['status' => 1, 'parent_id' => null])->get('ec_category');
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            return false;
        }
    }
}
