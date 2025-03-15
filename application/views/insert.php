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
    <div class="container">
        <?= form_open_multipart('CrudController/add_data') ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your name">
                    <?= form_error('name') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter your email">
                    <?= form_error('email') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter your phone number">
                    <?= form_error('phone') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="language">Language</label>
                    <select name="language" class="form-control">
                        <option value="">Select Language</option>
                        <option value="Java">Java</option>
                        <option value="Python">Python</option>
                        <option value="PHP">PHP</option>
                    </select>
                    <?= form_error('language') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender">Gender</label><br>
                    <input name="gender" type="radio" value="Male"> Male
                    <input name="gender" type="radio" value="Female"> Female
                    <?= form_error('gender') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="qualification">Qualification</label><br>
                    <input name="qualification[]" type="checkbox" value="HSC"> HSC
                    <input name="qualification[]" type="checkbox" value="BSC"> BSC
                    <?= form_error('qualification') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Image/Document</label>
                    <input type="file" name="image" class="form-control">
                    <?= form_error('image') ?>
                </div>
            </div>
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