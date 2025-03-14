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
}
