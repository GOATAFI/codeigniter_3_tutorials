<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegisterModel extends CI_Model
{
    public function register($post)
    {
        $data = [
            'username' => $post['name'],
            'email' => $post['email'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
            'status' => 1,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_id' => uniqid(),
            'added_on' => date('Y-m-d h:i:s')
        ];

        $this->db->insert('ec_users', $data);
    }
}
