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

    <title>Document</title>
</head>

<body>
    <!-- <?php print_r($arr); ?> -->
    <div class="container">
        <a href="<?= site_url('CrudController/all_data') ?>" class="btn btn-primary">View Data</a>

        <?php
        // Determine the form action based on whether $arr->id is set
        if (!empty($arr->id)) {
            echo form_open_multipart('CrudController/update_data');
        } else {
            echo form_open_multipart('CrudController/add_data');
        }
        ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?= set_value('name', (!empty($arr->name) ? $arr->name : '')) ?>" class="form-control" placeholder="Enter your name">
                    <?= form_error('name') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="<?= set_value('email', (!empty($arr->email) ? $arr->email : '')) ?>" class="form-control" placeholder="Enter your email">
                    <?= form_error('email') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" value="<?= set_value('phone', (!empty($arr->phone) ? $arr->phone : '')) ?>" class="form-control" placeholder="Enter your phone number">
                    <?= form_error('phone') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="language">Language</label>
                    <select name="language" class="form-control">
                        <option value="">Select Language</option>
                        <option value="Java" <?= (!empty($arr->language) && $arr->language == 'Java') ? 'selected' : '' ?>>Java</option>
                        <option value="Python" <?= (!empty($arr->language) && $arr->language == 'Python') ? 'selected' : '' ?>>Python</option>
                        <option value="PHP" <?= (!empty($arr->language) && $arr->language == 'PHP') ? 'selected' : '' ?>>PHP</option>
                    </select>
                    <?= form_error('language') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender">Gender</label><br>
                    <input name="gender" type="radio" value="Male" <?= (!empty($arr->gender) && $arr->gender == 'Male') ? 'checked' : '' ?>> Male
                    <input name="gender" type="radio" value="Female" <?= (!empty($arr->gender) && $arr->gender == 'Female') ? 'checked' : '' ?>> Female
                    <?= form_error('gender') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="qualification">Qualification</label><br>
                    <input name="qualification[]" type="checkbox" value="HSC" <?= (!empty($arr->qualification) && in_array('HSC', explode(', ', $arr->qualification))) ? 'checked' : '' ?>> HSC
                    <input name="qualification[]" type="checkbox" value="BSC" <?= (!empty($arr->qualification) && in_array('BSC', explode(', ', $arr->qualification))) ? 'checked' : '' ?>> BSC
                    <?= form_error('qualification') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Image/Document</label>
                    <input type="file" name="image" class="form-control">
                    <?php if (!empty($arr->id)) : ?>
                        <img src="<?= base_url('uploads/' . $arr->image) ?>" alt="" width="100">
                    <?php endif; ?>
                    <?= form_error('image') ?>
                </div>
            </div>
            <!-- Hidden input for ID -->
            <input type="hidden" name="id" value="<?= $arr->id ?? '' ?>">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</body>

</html>