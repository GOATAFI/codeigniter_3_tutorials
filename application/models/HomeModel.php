<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Consider adding error reporting here if needed
    }

    public function get_banner()
    {
        try {
            $this->db->where('status', 1);
            $this->db->order_by('id', 'desc');
            $q = $this->db->get('ec_banner');

            if ($q->num_rows() > 0) {
                $result = $q->result();
                return $result;
            }
        } catch (Exception $e) {
            log_message('error', 'Banner query failed: ' . $e->getMessage());
            return [];
        }
    }
    public function get_categ()
    {
        try {
            $this->db->where('status', 1);
            $this->db->order_by('id', 'desc');
            $q = $this->db->get('ec_category');

            if ($q->num_rows() > 0) {
                $result = $q->result();
                return $result;
            }
        } catch (Exception $e) {
            log_message('error', 'Category query failed: ' . $e->getMessage());
            return [];
        }
    }
    public function get_products()
    {
        try {
            $this->db->order_by('id', 'desc');
            $q = $this->db->get('ec_product');

            if ($q->num_rows() > 0) {
                $result = $q->result();
                return $result;
            }
        } catch (Exception $e) {
            log_message('error', 'Product query failed: ' . $e->getMessage());
            return [];
        }
    }

    public function category_name($cate_id)
    {
        // Debug: show the incoming category ID
        error_log("Looking for category ID: " . $cate_id);

        $q = $this->db->where('cate_id', $cate_id)->get('ec_category');

        // Debug: show the last query
        error_log("Category query: " . $this->db->last_query());

        if ($q->num_rows() > 0) {
            $result = $q->row();
            return $result->cate_name;
        } else {
            error_log("Category not found for ID: " . $cate_id);
            return 'No Category';
        }
    }
}
