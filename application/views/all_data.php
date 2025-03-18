<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>All Data</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <div class="container">
        <p>Current Timestamp: <?= ($current_timestamp) ?></p>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php } ?>

        <!-- Add Data Button -->
        <a href="<?= site_url('CrudController/index') ?>" class="btn btn-primary mb-3">Add Data</a>

        <h2>All Data</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Language</th>
                    <th>Gender</th>
                    <th>Qualification</th>
                    <th>Image</th>
                    <th>Added On</th>
                    <th>Status</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($arr)) {
                    foreach ($arr as $data) {
                        if ($data->status == 1) {
                            $status = "<span class='badge bg-success'> Active </span>";
                        } else {
                            $status = "<span class='badge bg-danger'> Inactive </span>";
                        }
                ?>
                        <tr>
                            <td><?= $data->id ?></td>
                            <td><?= $data->name ?></td>
                            <td><?= $data->email ?></td>
                            <td><?= $data->phone ?></td>
                            <td><?= $data->language ?></td>
                            <td><?= $data->gender ?></td>
                            <td><?= $data->qualification ?></td>
                            <td><img src="<?= base_url('uploads/' . $data->image) ?>" alt="Image" width="50"></td>
                            <td><?= $data->added_on ?></td>
                            <td><?= $status ?></td>
                            <td><a href="all-data/<?= $data->id ?>" class="btn btn-outline-primary">Update</a></td>
                            <td><a href="delete-data/<?= $data->id ?>" class="btn btn-outline-danger">Delete</a></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="11" class="text-center">No records found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            <?php if ($this->session->flashdata('swal_error') && strpos($this->session->flashdata('swal_error'), 'JPG and PNG') !== false) { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Format',
                    text: '<?php echo $this->session->flashdata("swal_error"); ?>',
                    confirmButtonText: 'OK'
                });
            <?php } elseif ($this->session->flashdata('swal_error')) { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?php echo $this->session->flashdata("swal_error"); ?>',
                    confirmButtonText: 'OK'
                });
            <?php } ?>

            <?php if ($this->session->flashdata('swal_success')) { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?php echo $this->session->flashdata("swal_success"); ?>',
                    confirmButtonText: 'OK'
                });
            <?php } ?>

            // Add confirmation for delete action
            $('a[href*="delete-data"]').on('click', function(e) {
                e.preventDefault();
                const href = $(this).attr('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
</body>

</html>