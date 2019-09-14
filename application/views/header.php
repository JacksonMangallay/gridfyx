<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $params['title']; ?></title>
    <link rel="stylesheet" href="<?php url('/assets/css/chunk-vendors.css'); ?>">
    <link rel="stylesheet" href="<?php url('/assets/css/app.css'); ?>">
</head>
<body class="loading">

<div id="app"><!-- START APP -->

<?php component('loader'); ?>
