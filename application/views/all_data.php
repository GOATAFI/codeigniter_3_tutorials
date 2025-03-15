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
</head>

<body>
    <div class="container">
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
                            <td> <a href="all-data/<?= $data->id ?>" class="btn btn-outline-primary"> Update </a></td>
                            <td>Delete</td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="9" class="text-center">No records found</td>
                    </tr>
                <?php } ?>


            </tbody>
        </table>
    </div>
</body>

</html>