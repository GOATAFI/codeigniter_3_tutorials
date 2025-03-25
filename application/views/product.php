<?php
// Get the product ID from controller
$pro_id = isset($pro_id) ? $pro_id : $this->session->userdata('pro_id');
if (empty($pro_id)) {
    $pro_id = mt_rand(11111, 99999);
    $this->session->set_userdata('pro_id', $pro_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Tocly - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <?php $this->load->helper('url'); ?>
    <base href="<?= base_url() ?>" />
    <!-- App favicon -->
    <?php $this->load->view('links'); ?>
</head>
<?php $this->load->view('header'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php } ?>

            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php } ?>

            <form method="post" action="<?= base_url('product') ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="pro_id" name="pro_id" readonly value="<?= $pro_id ?>">
                            <label for="pro_id">Product ID</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="pro_main_image" name="pro_main_image" placeholder="">
                            <label for="pro_main_image">Product Main Image</label>
                            <?= form_error('pro_main_image') ?>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="category" name="category">
                                <option value="" selected>Select</option>
                                <?php if ($categories) {
                                    foreach ($categories as $category) { ?>
                                        <option value="<?= $category->cate_id ?>" <?= set_select('category', $category->cate_id) ?>><?= $category->cate_name ?></option>
                                <?php }
                                } ?>
                            </select>
                            <?= form_error('category') ?>
                            <label for="category">Category</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select subcat" id="sub_category" name="sub_category">
                                <option value="" selected>Select Sub Category</option>
                            </select>
                            <?= form_error('sub_category') ?>
                            <label for="sub_category">Sub Category</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="pro_name" name="pro_name" placeholder="Product Name" value="<?= set_value('pro_name') ?>">
                            <label for="pro_name">Product Name</label>
                            <?= form_error('pro_name') ?>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand" value="<?= set_value('brand') ?>">
                            <label for="brand">Brand</label>
                            <?= form_error('brand') ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="gallery_image" name="gallery_image[]" multiple placeholder="Gallery Images">
                            <label for="gallery_image">Gallery Images</label>
                            <?= form_error('gallery_image[]') ?>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="featured" name="featured">
                                <option value="0" <?= set_select('featured', '0', true) ?>>No</option>
                                <option value="1" <?= set_select('featured', '1') ?>>Yes</option>
                            </select>
                            <?= form_error('featured') ?>
                            <label for="featured">Featured</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" value="<?= set_value('stock') ?>">
                            <label for="stock">Stock</label>
                            <?= form_error('stock') ?>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" step="0.01" class="form-control" id="mrp" name="mrp" placeholder="MRP" value="<?= set_value('mrp') ?>">
                            <label for="mrp">MRP</label>
                            <?= form_error('mrp') ?>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" step="0.01" class="form-control" id="selling_price" name="selling_price" placeholder="Selling Price" value="<?= set_value('selling_price') ?>">
                            <label for="selling_price">Selling Price</label>
                            <?= form_error('selling_price') ?>
                        </div>
                    </div>

                    <!-- Remove this section from product.php -->
                    <!-- <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="<?= set_value('slug') ?>">
                            <label for="slug">Slug</label>
                            <?= form_error('slug') ?>
                        </div>
                         </div> -->

                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="highlights" name="highlights" placeholder="Highlights" value="<?= set_value('highlights') ?>">
                            <label for="highlights">Highlights</label>
                            <?= form_error('highlights') ?>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?= set_value('description') ?></textarea>
                            <?= form_error('description') ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h5 class="mt-3 mb-2">SEO Information</h5>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Meta Title" value="<?= set_value('meta_title') ?>">
                            <label for="meta_title">Meta Title</label>
                            <?= form_error('meta_title') ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Meta Keywords" value="<?= set_value('meta_keywords') ?>">
                            <label for="meta_keywords">Meta Keywords</label>
                            <?= form_error('meta_keywords') ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="meta_desc" name="meta_desc" placeholder="Meta Description" value="<?= set_value('meta_desc') ?>">
                            <label for="meta_desc">Meta Description</label>
                            <?= form_error('meta_desc') ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>