<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shopping Cart</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('front/links'); ?>
</head>

<body>
    <?php $this->load->view('front/header'); ?>

    <main>
        <!-- breadcrumb area start -->
        <section class="breadcrumb__area include-bg pt-95 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="breadcrumb__content p-relative z-index-1">
                            <h3 class="breadcrumb__title">Shopping Cart</h3>
                            <div class="breadcrumb__list">
                                <span><a href="<?= base_url() ?>">Home</a></span>
                                <span>Shopping Cart</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb area end -->

        <!-- cart area start -->
        <section class="tp-cart-area pb-120">
            <div class="container">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success mb-30">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger mb-30">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <?php if (!empty($cart_items)): ?>
                            <div class="tp-cart-list mb-25 mr-30">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="tp-cart-header-product">Product</th>
                                            <th class="tp-cart-header-price">Price</th>
                                            <th class="tp-cart-header-quantity">Quantity</th>
                                            <th class="tp-cart-header-subtotal">Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cart_items as $item): ?>
                                            <tr>
                                                <td class="tp-cart-img">
                                                    <a href="<?= base_url('product/' . $item->slug) ?>">
                                                        <img src="<?= base_url('uploads/products/' . $item->pro_image) ?>" alt="<?= html_escape($item->pro_name) ?>" style="max-width: 80px;">
                                                    </a>
                                                </td>
                                                <td class="tp-cart-title">
                                                    <a href="<?= base_url('product/' . $item->slug) ?>"><?= html_escape($item->pro_name) ?></a>
                                                </td>
                                                <td class="tp-cart-price">
                                                    <span>$<?= number_format($item->pro_price, 2) ?></span>
                                                </td>
                                                <!-- Update the quantity input section -->
                                                <td class="tp-cart-quantity">
                                                    <div class="tp-product-quantity mt-10 mb-10">
                                                        <span class="tp-cart-minus" onclick="updateQuantity(<?= $item->cart_id ?>, -1)">
                                                            <!-- minus icon -->
                                                        </span>
                                                        <input class="tp-cart-input"
                                                            id="qty-<?= $item->cart_id ?>"
                                                            type="number"
                                                            value="<?= $item->pro_qty ?>"
                                                            min="1"
                                                            onchange="updateQuantity(<?= $item->cart_id ?>, 0, this.value)">
                                                        <span class="tp-cart-plus" onclick="updateQuantity(<?= $item->cart_id ?>, 1)">
                                                            <!-- plus icon -->
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="tp-cart-subtotal" id="subtotal-<?= $item->cart_id ?>">
                                                    $<?= number_format($item->pro_price * $item->pro_qty, 2) ?>
                                                </td>



                                                <!-- Update the remove button -->
                                                <td class="tp-cart-action">
                                                    <a href="<?= base_url('cart/remove_item/' . $item->cart_id) ?>" class="tp-cart-action-btn" onclick="return confirm('Are you sure you want to remove this item?')">
                                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z" fill="currentColor" />
                                                        </svg>
                                                        <span>Remove</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">Your cart is empty</div>
                        <?php endif; ?>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="tp-cart-checkout-wrapper">
                            <div class="tp-cart-checkout-top d-flex align-items-center justify-content-between">
                                <span class="tp-cart-checkout-top-title">Total</span>
                                <span class="tp-cart-checkout-top-price">$<?= isset($cart_total) ? number_format($cart_total, 2) : '0.00' ?></span>
                            </div>
                            <!-- <div class="tp-cart-checkout-shipping">
                                <h4 class="tp-cart-checkout-shipping-title">Shipping</h4>
                                <div class="tp-cart-checkout-shipping-option-wrapper">
                                    <div class="tp-cart-checkout-shipping-option">
                                        <input id="flat_rate" type="radio" name="shipping" checked>
                                        <label for="flat_rate">Flat rate: <span>$20.00</span></label>
                                    </div>
                                    <div class="tp-cart-checkout-shipping-option">
                                        <input id="local_pickup" type="radio" name="shipping">
                                        <label for="local_pickup">Local pickup: <span>$25.00</span></label>
                                    </div>
                                    <div class="tp-cart-checkout-shipping-option">
                                        <input id="free_shipping" type="radio" name="shipping">
                                        <label for="free_shipping">Free shipping</label>
                                    </div>
                                </div>
                            </div>
                            <div class="tp-cart-checkout-total d-flex align-items-center justify-content-between">
                                <span>Total</span>
                                <span>$<?= isset($cart_total) ? number_format($cart_total + 20, 2) : '20.00' ?></span>
                            </div> -->
                            <div class="tp-cart-checkout-proceed">
                                <a href="<?= base_url('checkout') ?>" class="tp-cart-checkout-btn w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- cart area end -->
    </main>

    <?php $this->load->view('front/footer'); ?>

    <script>
        async function updateQuantity(cartId, change, manualValue = null) {
            const input = document.getElementById(`qty-${cartId}`);
            let newQty = manualValue !== null ? parseInt(manualValue) : parseInt(input.value) + change;

            // Validate minimum quantity
            if (newQty < 1) newQty = 1;

            try {
                const response = await fetch('<?= base_url('cart/update_cart') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `cart_id=${cartId}&quantity=${newQty}`
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Update failed');
                }

                // Update UI on success
                input.value = newQty;
                document.getElementById(`subtotal-${cartId}`).textContent = `$${data.item_subtotal}`;
                document.querySelector('.tp-cart-checkout-top-price').textContent = `$${data.cart_total}`;

            } catch (error) {
                console.error('Error:', error);
                // Don't show alert for successful updates that return false
                if (!error.message.includes('Update failed')) {
                    alert('Error updating quantity: ' + error.message);
                }
                // Reset to previous value
                input.value = input.value;
            }
        }

        // Remove item function remains the same
        async function removeItem(cartId) {
            if (!confirm('Are you sure you want to remove this item?')) return;

            try {
                const response = await fetch(`<?= base_url('cart/remove_item/') ?>${cartId}`);
                if (response.ok) {
                    window.location.reload();
                } else {
                    throw new Error('Failed to remove item');
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message);
            }
        }
    </script>
</body>

</html>