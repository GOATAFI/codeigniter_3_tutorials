<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CartModel extends CI_Model
{
    public function add_to_cart($post)
    {
        // Validate required fields
        if (!isset($post['pro_id']) || !isset($post['pro_qty'])) {
            return false;
        }

        $user_id = $this->session->userdata('user_id');

        // Check if product already exists in cart
        $exist = $this->db->where([
            'pro_id' => $post['pro_id'],
            'user_id' => $user_id
        ])->get('ec_cart');

        if ($exist->num_rows() > 0) {
            // Update quantity if product exists
            $cart_item = $exist->row();
            $new_qty = $cart_item->pro_qty + $post['pro_qty'];

            $this->db->where('cart_id', $cart_item->cart_id)
                ->update('ec_cart', [
                    'pro_qty' => $new_qty,
                    'updated_on' => date('Y-m-d H:i:s')
                ]);

            return true;
        } else {
            // Add new item to cart - now selecting selling_price instead of mrp
            $product = $this->db->select('pro_name, mrp, selling_price, slug, pro_main_image, stock')
                ->where('pro_id', $post['pro_id'])
                ->get('ec_product');

            if ($product->num_rows() > 0) {
                $prod = $product->row();

                $data = [
                    'cart_id' => mt_rand(11111, 99999),
                    'user_id' => $user_id,
                    'pro_id' => $post['pro_id'],
                    'pro_qty' => $post['pro_qty'],
                    'pro_name' => $prod->pro_name,
                    'pro_price' => $prod->selling_price, // Using selling_price here
                    'mrp' => $prod->mrp, // Storing mrp for reference
                    'slug' => $prod->slug,
                    'pro_image' => $prod->pro_main_image,
                    'added_on' => date('Y-m-d H:i:s'),
                    'updated_on' => date('Y-m-d H:i:s')
                ];

                return $this->db->insert('ec_cart', $data);
            }

            return false;
        }
    }

    public function update_cart_item($cart_id, $quantity)
    {
        return $this->db->where('cart_id', $cart_id)
            ->update('ec_cart', [
                'pro_qty' => $quantity,
                'updated_on' => date('Y-m-d H:i:s')
            ]);
    }

    public function remove_cart_item($cart_id)
    {
        return $this->db->where('cart_id', $cart_id)
            ->delete('ec_cart');
    }

    public function get_cart_items($user_id)
    {
        $this->db->select('ec_cart.*, ec_product.stock');
        $this->db->join('ec_product', 'ec_product.pro_id = ec_cart.pro_id', 'left');
        return $this->db->where('user_id', $user_id)->get('ec_cart')->result();
    }

    public function calculate_cart_total($user_id)
    {
        $items = $this->get_cart_items($user_id);
        $total = 0;

        foreach ($items as $item) {
            $total += $item->pro_price * $item->pro_qty;
        }

        return $total;
    }
}
