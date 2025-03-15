<?php
defined('BASEPATH') or exit('No direct script access allowed');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php $attr = array('type' => 'text', 'name' => 'username', 'style' => 'background:violet') ?>
            <?php echo form_open('homecontroller/my_func', ['method' => 'post']); ?>
            <?php echo form_input($attr); ?>
            <?php echo form_close(); ?>
            <!-- <form action="" method="post">
                <input type="text" name="name" placeholder="Enter your name">
                <input type="email" name="email" placeholder="Enter your email">
                <input type="password" name="password" placeholder="Enter your password">
                <input type="submit" name="submit" value="Submit">
            </form> -->
            <?php echo form_submit('submit', 'Submit'); ?>
        </div>
    </div>
</body>

</html>