<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeModel extends CI_Model
{
    public function add_data($post)
    {
        $post['added_on'] = date('Y-m-d H:i:s');
        $post['status'] = 1;
        $q = $this->db->insert('register', $post);
        if ($q) {
            return true;
        } else {
            return false;
        }
    }

    public function update_data($post)
    {
        $post['updated_on'] = date('Y-m-d H:i:s');
        $q = $this->db->where('id', $post['id'])->update('register', $post);
        if ($q) {
            return true;
        } else {
            return false;
        }
    }

    public function all_data($id = "")
    {
        if ($id != "") {
            $q = $this->db->where("id", $id)->get('register');
            if ($q->num_rows() > 0) {
                return $q->row();
            } else {
                return false;
            }
        } else {
            $q = $this->db->order_by('id', 'asc')->get('register');
            if ($q->num_rows() > 0) {
                return $q->result();
            } else {
                return false;
            }
        }
    }

    public function delete_data($id)
    {
        $q = $this->db->where('id', $id)->delete('register');
        if ($q) {
            return true;
        } else {
            return false;
        }
    }
}
