<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            $this->session->set_userdata('user_id', mt_rand(11111, 99999));
        }
        $this->load->model('CartModel');
    }

    public function get_userid()
    {
        return $this->session->userdata('user_id');
    }

    public function get_cart()
    {
        $user_id = $this->get_userid();
        $this->db->select('ec_cart.*, ec_product.stock');
        $this->db->join('ec_product', 'ec_product.pro_id = ec_cart.pro_id', 'left');
        $q = $this->db->where(['user_id' => $user_id])->get('ec_cart');
        return $q->result();
    }

    public function add_to_cart()
    {
        $post = $this->input->post();

        // Validate required fields
        if (empty($post['pro_id']) || empty($post['pro_qty'])) {
            $this->session->set_flashdata('error', 'Product ID and quantity are required');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $result = $this->CartModel->add_to_cart($post);

        if ($result) {
            $this->session->set_flashdata('success', 'Product added to cart');
            redirect('cart');
        } else {
            $this->session->set_flashdata('error', 'Failed to add product to cart');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function update_cart()
    {
        // Set header first
        header('Content-Type: application/json');

        $post = $this->input->post();
        if (!isset($post['cart_id']) || !isset($post['quantity'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $cart_id = $post['cart_id'];
        $quantity = max(1, (int)$post['quantity']); // Ensure minimum quantity is 1

        $result = $this->CartModel->update_cart_item($cart_id, $quantity);

        if ($result) {
            // Get updated cart data
            $item = $this->db->where('cart_id', $cart_id)->get('ec_cart')->row();
            $cart_total = $this->calculate_cart_total($this->get_cart());

            echo json_encode([
                'success' => true,
                'item_subtotal' => number_format($item->pro_price * $quantity, 2),
                'cart_total' => number_format($cart_total, 2)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
        }
    }

    public function remove_item($cart_id)
    {
        $result = $this->CartModel->remove_cart_item($cart_id);

        if ($result) {
            $this->session->set_flashdata('success', 'Item removed from cart');
        } else {
            $this->session->set_flashdata('error', 'Failed to remove item');
        }
        redirect('cart');
    }

    public function index()
    {
        $data['cart_items'] = $this->get_cart();
        $data['cart_total'] = $this->calculate_cart_total($data['cart_items']);
        $this->load->view('front/cart', $data);
    }

    private function calculate_cart_total($cart_items)
    {
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item->pro_price * $item->pro_qty;
        }
        return $total;
    }
}
