<?php
/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

?>

<html>

<head>
    <?php require 'frontend-head.php';?>
</head>

<body>
    <h1>Super Easy Stock Manager</h1>
    <?php require 'frontend-content.php';?>
</body>

</html>