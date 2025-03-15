<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeModel extends CI_Model
{
    public function sum()
    {
        $a = 10;
        $b = 20;
        $c = $a + $b;
        return $c;
    }
    public function sub()
    {
        $a = 20;
        $b = 10;
        $c = $a - $b;
        return $c;
    }
    public function queries()
    {
        // $q = $this->db->query('select * from data where id = 2'); //eta hoilo manual query
        $q = $this->db->select('name')->where('id', 2)->get('data'); //eta hoilo codeigniter query
        // return $q->row(); //row() te object return korbe
        return $q->result(); //result() te array return korbe
    }
    public function add_data($post)
    {
        print_r($post);
        $post['added_on'] = date('d M, Y');
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
        print_r($post);
        $post['updated_on'] = date('d M, Y');
        $post['status'] = 1;
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
}
