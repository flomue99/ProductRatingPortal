<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <title>SCR4 Book Shop</title>
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary mb-3" data-bs-theme="dark">
    <div class="container">
        <?php $link('Product rating Portal', 'Home', 'Index', cssClass: 'navbar-brand'); ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <nav class="navbar-nav me-auto">
                <?php $link('Products', 'Products', 'Index', cssClass: 'nav-link'); ?>
                <?php if (isset($data['user'])): ?>
                    <?php $link('My ratings', 'Ratings', 'Index', cssClass: 'nav-link'); ?>
                <?php endif; ?>
            </nav>
            <?php $render('partial/user', $data['user']); ?>
        </div>
    </div>
</nav>
<div class="container mb-3 mt-3">
<?php if (isset($data['errors'])) {
    $render('partial/errors', $data['errors']);
} ?>