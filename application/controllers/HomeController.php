<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeController extends CI_Controller
{
    public function index($name = null)
    {
        // echo "Hello World!";
        // $arr['name'] = "Nahid Parvez";
        // $data['names'] = array("mafi", "buddhiman", "businessman");
        // // $arr['age'] = 25;'
        // $data['name'] = $name;
        // $this->load->model('homemodel');
        // $data['sum'] =  $this->homemodel->sum();
        // $data['sub'] =  $this->homemodel->sub();
        // $this->load->view('homepage', $data);
        // $data = $this->homemodel->queries();
        // echo "<pre>";
        // echo "Name: " . $data->name;
        // echo "Profession: " . $data->profession;
        // print_r($data);
        // foreach ($data as $d) {
        //     echo "Name: : " . $d->name;
        //     echo "<br>";
        //     // echo "Profession: " . $d->profession;
        //     // echo "<br>";
        // }


        // $this->load->helper('test');
        // $array = array(
        //     'name' => 'Mafi',
        //     'profession' => 'Businessman'
        // );
        // $array2 = array(
        //     'name' => 'Nahid',
        //     'profession' => 'Student'
        // );
        // echo "<pre>";
        // print_r($array2);
        // print_r($array);
        // clean($array);
        // clean($array2);
        // $this->load->library('custom');
        // $this->custom->sum();
        $this->load->helper('form');
        $this->load->view('form');
    }


    // public function about()
    // {
    //     echo "This is about page";
    //     echo "<br>";
    //     $var = "Mafi";
    //     echo "My name is $var";
    // }

}
