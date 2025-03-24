<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CategoryModel extends CI_Model
{
    public function add_category($post)
    {
        $post['added_on'] = date('Y-m-d H:i:s');
        $post['cate_id'] = mt_rand(11111, 99999);
        if ($post['parent_id'] == "") {
            $post['parent_id'] = null;
        }
        $q = $this->db->insert('ec_category', $post);
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

    public function get_sub_category($cate_id)
    {
        $q = $this->db->where(['status' => 1, 'parent_id' => $cate_id])->get('ec_category');
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            return false;
        }
    }
}
