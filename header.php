<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>
        <?php 
        $filename = basename($_SERVER['PHP_SELF'], ".php");
        $page_title = ucfirst(str_replace("_", " ", $filename));
        echo ($page_title === "Index") ? "Dashboard" : $page_title;
        ?>
    </title>
</head>
<body>
    <?php
    // Hide navbar on login and register pages
    $current_page = basename($_SERVER['PHP_SELF']);
    if (isset($_SESSION['is_login']) && !in_array($current_page, ['login_user.php', 'register.php'])) {
        include("./includes/gen_navbar.php");
    }
    ?>
