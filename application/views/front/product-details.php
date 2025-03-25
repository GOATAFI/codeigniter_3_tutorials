<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo isset($product['pro_name']) ? html_escape($product['pro_name']) : 'Product Details'; ?></title>
    <meta name="description" content="<?php echo isset($product['meta_desc']) ? html_escape($product['meta_desc']) : ''; ?>">
    <meta name="keywords" content="<?php echo isset($product['meta_keywords']) ? html_escape($product['meta_keywords']) : ''; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('front/links'); ?>
</head>

<body>
    <?php $this->load->view('front/header'); ?>

    <main>
        <!-- breadcrumb area start -->
        <section class="breadcrumb__area breadcrumb__style-2 include-bg pt-50 pb-20">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="breadcrumb__content p-relative z-index-1">
                            <div class="breadcrumb__list has-icon">
                                <span class="breadcrumb-icon">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.42393 16H15.5759C15.6884 16 15.7962 15.9584 15.8758 15.8844C15.9553 15.8104 16 15.71 16 15.6054V6.29143C16 6.22989 15.9846 6.1692 15.9549 6.11422C15.9252 6.05923 15.8821 6.01147 15.829 5.97475L8.75305 1.07803C8.67992 1.02736 8.59118 1 8.5 1C8.40882 1 8.32008 1.02736 8.24695 1.07803L1.17098 5.97587C1.11791 6.01259 1.0748 6.06035 1.04511 6.11534C1.01543 6.17033 0.999976 6.23101 1 6.29255V15.6063C1.00027 15.7108 1.04504 15.8109 1.12451 15.8847C1.20398 15.9585 1.31165 16 1.42393 16ZM10.1464 15.2107H6.85241V10.6202H10.1464V15.2107ZM1.84866 6.48977L8.4999 1.88561L15.1517 6.48977V15.2107H10.9946V10.2256C10.9946 10.1209 10.95 10.0206 10.8704 9.94654C10.7909 9.87254 10.683 9.83096 10.5705 9.83096H6.42848C6.316 9.83096 6.20812 9.87254 6.12858 9.94654C6.04904 10.0206 6.00435 10.1209 6.00435 10.2256V15.2107H1.84806L1.84866 6.48977Z" fill="#55585B" stroke="#55585B" stroke-width="0.5" />
                                    </svg>
                                </span>
                                <span><a href="<?php echo base_url(); ?>">Home</a></span>
                                <?php if (isset($product['category'])): ?>
                                    <span><?php echo html_escape($product['category']); ?></span>
                                <?php endif; ?>
                                <span><?php echo isset($product['pro_name']) ? html_escape($product['pro_name']) : ''; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- product details area start -->
        <section class="tp-product-details-area">
            <div class="tp-product-details-top pb-115">
                <div class="container">
                    <?php if (isset($product)): ?>
                        <div class="row">
                            <!-- Previous code remains the same until the product image section -->

                            <div class="col-xl-7 col-lg-6">
                                <div class="tp-product-details-thumb-wrapper">
                                    <!-- Main Product Image (Large) -->
                                    <div class="tp-product-details-main-image mb-3">
                                        <?php if (isset($product['pro_main_image'])): ?>
                                            <img src="<?php echo base_url('uploads/products/' . html_escape($product['pro_main_image'])); ?>"
                                                alt="<?php echo isset($product['pro_name']) ? html_escape($product['pro_name']) : 'Product Image'; ?>"
                                                class="img-fluid w-100 rounded" style="max-height: 500px; object-fit: contain;">
                                        <?php else: ?>
                                            <img src="<?php echo base_url('assets/img/no-image.jpg'); ?>"
                                                alt="No Image Available"
                                                class="img-fluid w-100 rounded" style="max-height: 500px; object-fit: contain;">
                                        <?php endif; ?>
                                    </div>

                                    <!-- Gallery Thumbnails (Small) -->
                                    <div class="tp-product-gallery-thumbnails d-flex flex-wrap gap-2">
                                        <!-- Include main image as first thumbnail -->
                                        <?php if (isset($product['pro_main_image'])): ?>
                                            <div class="gallery-thumbnail" style="width: 80px; height: 80px; cursor: pointer;">
                                                <img src="<?php echo base_url('uploads/products/' . html_escape($product['pro_main_image'])); ?>"
                                                    alt="Thumbnail"
                                                    class="img-thumbnail w-100 h-100"
                                                    style="object-fit: cover;"
                                                    onclick="changeMainImage(this)">
                                            </div>
                                        <?php endif; ?>

                                        <!-- Gallery images -->
                                        <?php
                                        if (isset($product['gallery_image']) && !empty($product['gallery_image'])):
                                            $gallery_images = unserialize($product['gallery_image']);
                                            if (is_array($gallery_images)):
                                                foreach ($gallery_images as $key => $image):
                                                    if (!empty($image)):
                                        ?>
                                                        <div class="gallery-thumbnail" style="width: 80px; height: 80px; cursor: pointer;">
                                                            <img src="<?php echo base_url('uploads/products/' . html_escape($image)); ?>"
                                                                alt="Thumbnail"
                                                                class="img-thumbnail w-100 h-100"
                                                                style="object-fit: cover;"
                                                                onclick="changeMainImage(this)">
                                                        </div>
                                        <?php
                                                    endif;
                                                endforeach;
                                            endif;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Add this JavaScript before closing body tag -->
                            <script>
                                function changeMainImage(thumb) {
                                    const mainImg = document.querySelector('.tp-product-details-main-image img');
                                    mainImg.src = thumb.src;
                                    mainImg.alt = thumb.alt;

                                    // Update active thumbnail
                                    document.querySelectorAll('.gallery-thumbnail').forEach(el => {
                                        el.classList.remove('active-thumbnail');
                                    });
                                    thumb.parentElement.classList.add('active-thumbnail');
                                }

                                function updateQuantity(element, change) {
                                    const input = element.closest('.tp-product-quantity').querySelector('.tp-cart-input');
                                    let currentValue = parseInt(input.value);
                                    let newValue = currentValue + change;

                                    // Ensure quantity doesn't go below 1
                                    if (newValue < 1) newValue = 1;

                                    input.value = newValue;
                                }

                                // Also add this to prevent manual input of values less than 1
                                document.getElementById('quantity-input').addEventListener('change', function() {
                                    if (this.value < 1) {
                                        this.value = 1;
                                    }
                                });

                                function submitCartForm() {
                                    const form = document.getElementById('add-to-cart-form');
                                    const formData = new FormData(form);

                                    fetch('<?= site_url('cart/add_to_cart') ?>', {
                                            method: 'POST',
                                            body: formData
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === 'success') {
                                                alert(data.message);
                                                // Optional: Update cart counter in header
                                            } else {
                                                alert(data.message);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            alert('An error occurred while adding to cart');
                                        });
                                }
                            </script>

                            <!-- Add this CSS in your head section or stylesheet -->
                            <style>
                                .tp-product-details-main-image {
                                    border: 1px solid #eee;
                                    padding: 10px;
                                    margin-bottom: 15px;
                                    text-align: center;
                                }

                                .gallery-thumbnail {
                                    border: 2px solid #ddd;
                                    transition: all 0.3s ease;
                                }

                                .gallery-thumbnail:hover {
                                    border-color: #333;
                                }

                                .active-thumbnail {
                                    border-color: #0066cc !important;
                                }

                                .img-thumbnail {
                                    padding: 2px;
                                }
                            </style>

                            <!-- Rest of the code remains the same -->

                            <div class="col-xl-5 col-lg-6">
                                <div class="tp-product-details-wrapper">
                                    <div class="tp-product-details-category">
                                        <span><?php echo isset($product['category']) ? html_escape($product['category']) : ''; ?></span>
                                    </div>
                                    <h3 class="tp-product-details-title"><?php echo isset($product['pro_name']) ? html_escape($product['pro_name']) : ''; ?></h3>

                                    <!-- inventory details -->
                                    <div class="tp-product-details-inventory d-flex align-items-center mb-10">
                                        <div class="tp-product-details-stock mb-10">
                                            <span><?php echo (isset($product['stock']) && $product['stock'] > 0) ? 'In Stock' : 'Out of Stock'; ?></span>
                                        </div>
                                        <div class="tp-product-details-rating-wrapper d-flex align-items-center mb-10">
                                            <div class="tp-product-details-rating">
                                                <span><i class="fa-solid fa-star"></i></span>
                                                <span><i class="fa-solid fa-star"></i></span>
                                                <span><i class="fa-solid fa-star"></i></span>
                                                <span><i class="fa-solid fa-star"></i></span>
                                                <span><i class="fa-solid fa-star"></i></span>
                                            </div>
                                            <div class="tp-product-details-reviews">
                                                <span>(36 Reviews)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (isset($product['highlights'])): ?>
                                        <p><?php echo html_escape($product['highlights']); ?>... <span>See more</span></p>
                                    <?php endif; ?>

                                    <!-- price -->
                                    <div class="tp-product-details-price-wrapper mb-20">
                                        <?php if (isset($product['mrp']) && isset($product['selling_price']) && $product['mrp'] > $product['selling_price']): ?>
                                            <span class="tp-product-details-price old-price">$<?php echo number_format($product['mrp'], 2); ?></span>
                                        <?php endif; ?>
                                        <?php if (isset($product['selling_price'])): ?>
                                            <span class="tp-product-details-price new-price">$<?php echo number_format($product['selling_price'], 2); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- actions -->
                                    <div class="tp-product-details-action-wrapper">
                                        <h3 class="tp-product-details-action-title">Quantity</h3>
                                        <div class="tp-product-details-action-item-wrapper d-flex align-items-center">
                                            <?= form_open('cart/add_to_cart') ?>
                                            <input type="hidden" name="pro_id" value="<?= $product['pro_id'] ?>">
                                            <div class="tp-product-details-quantity">
                                                <div class="tp-product-quantity mb-15 mr-15">
                                                    <span class="tp-cart-minus" onclick="updateQuantity(this, -1)">
                                                        <svg width="11" height="2" viewBox="0 0 11 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 1H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                    <input class="tp-cart-input" type="number" name="pro_qty" id="quantity-input" value="1" min="1">
                                                    <span class="tp-cart-plus" onclick="updateQuantity(this, 1)">
                                                        <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 6H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M5.5 10.5V1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="tp-product-details-add-to-cart mb-15 w-100">
                                                <button type="submit" class="tp-product-details-add-to-cart-btn w-100">Add To Cart</button>
                                            </div>
                                            <?= form_close() ?>
                                        </div>
                                        <button class="tp-product-details-buy-now-btn w-100">Buy Now</button>
                                    </div>

                                    <div class="tp-product-details-query">
                                        <?php if (isset($product['pro_id'])): ?>
                                            <div class="tp-product-details-query-item d-flex align-items-center">
                                                <span>SKU: </span>
                                                <p><?php echo html_escape($product['pro_id']); ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (isset($product['category'])): ?>
                                            <div class="tp-product-details-query-item d-flex align-items-center">
                                                <span>Category: </span>
                                                <p><?php echo html_escape($product['category']); ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (isset($product['brand'])): ?>
                                            <div class="tp-product-details-query-item d-flex align-items-center">
                                                <span>Brand: </span>
                                                <p><?php echo html_escape($product['brand']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="tp-product-details-msg mb-15">
                                        <ul>
                                            <li>30 days easy returns</li>
                                            <li>Order yours before 2.30pm for same day dispatch</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger">Product not found</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="tp-product-details-bottom pb-140">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="tp-product-details-tab-nav tp-tab">
                                <nav>
                                    <div class="nav nav-tabs justify-content-center p-relative tp-product-tab" id="navPresentationTab" role="tablist">
                                        <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">Description</button>
                                        <button class="nav-link" id="nav-addInfo-tab" data-bs-toggle="tab" data-bs-target="#nav-addInfo" type="button" role="tab" aria-controls="nav-addInfo" aria-selected="false">Additional information</button>
                                        <span id="productTabMarker" class="tp-product-details-tab-line"></span>
                                    </div>
                                </nav>
                                <div class="tab-content" id="navPresentationTabContent">
                                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" tabindex="0">
                                        <div class="tp-product-details-desc-wrapper pt-80">
                                            <div class="row justify-content-center">
                                                <div class="col-xl-10">
                                                    <div class="tp-product-details-desc-item pb-105">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="tp-product-details-desc-content pt-25">
                                                                    <h3 class="tp-product-details-desc-title">Product Description</h3>
                                                                    <?php if (isset($product['description'])): ?>
                                                                        <p><?php echo nl2br(html_escape($product['description'])); ?></p>
                                                                    <?php else: ?>
                                                                        <p>No description available.</p>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="nav-addInfo" role="tabpanel" aria-labelledby="nav-addInfo-tab" tabindex="0">
                                        <div class="tp-product-details-additional-info">
                                            <div class="row justify-content-center">
                                                <div class="col-xl-10">
                                                    <table class="table">
                                                        <tbody>
                                                            <?php if (isset($product['brand'])): ?>
                                                                <tr>
                                                                    <td>Brand</td>
                                                                    <td><?php echo html_escape($product['brand']); ?></td>
                                                                </tr>
                                                            <?php endif; ?>

                                                            <?php if (isset($product['category'])): ?>
                                                                <tr>
                                                                    <td>Category</td>
                                                                    <td><?php echo html_escape($product['category']); ?></td>
                                                                </tr>
                                                            <?php endif; ?>

                                                            <?php if (isset($product['stock'])): ?>
                                                                <tr>
                                                                    <td>Stock</td>
                                                                    <td><?php echo html_escape($product['stock']); ?> units available</td>
                                                                </tr>
                                                            <?php endif; ?>

                                                            <?php if (isset($product['mrp'])): ?>
                                                                <tr>
                                                                    <td>MRP</td>
                                                                    <td>$<?php echo number_format($product['mrp'], 2); ?></td>
                                                                </tr>
                                                            <?php endif; ?>

                                                            <?php if (isset($product['selling_price'])): ?>
                                                                <tr>
                                                                    <td>Selling Price</td>
                                                                    <td>$<?php echo number_format($product['selling_price'], 2); ?></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php $this->load->view('front/footer'); ?>
</body>

</html>