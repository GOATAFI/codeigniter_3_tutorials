<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from themesdesign.in/tocly/layouts/5.3.1/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Nov 2023 08:52:23 GMT -->

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Tocly - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
        content="Premium Multipurpose Admin & Dashboard Template"
        name="description" />
    <meta content="Themesdesign" name="author" />
    <?php $this->load->helper('url'); ?>
    <base href="<?= base_url() ?>" />
    <!-- App favicon -->
    $this->load->helper('url');
    <?php $this->load->view('links'); ?>

</head>
<?php $this->load->view('header'); ?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-xl-7">
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="card">
                                <div
                                    class="card-header border-0 align-items-center d-flex pb-0">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        Banner Image
                                    </h4>
                                    <a
                                        href="javascript: void(0);"
                                        class="btn btn-primary waves-effect waves-light btn-sm">View More <i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Floating labels</h5>
                                    <p class="card-title-desc">Create beautifully simple form labels that float over your input fields.</p>

                                    <?= form_open_multipart() ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="file" class="form-control" id="" name="bann_image" placeholder="">
                                                <label for="floatingFirstnameInput">Banner Image</label>
                                                <?= form_error('bann_image') ?>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="" name="status">
                                                    <option value="" selected>Select</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>

                                                </select>
                                                <?= form_error('status') ?>
                                                <label for="floatingSelectGrid">Status</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    </div>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ROW -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

</html>

<?php $this->load->view('footer'); ?>