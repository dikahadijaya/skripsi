<?php 
    session_start();
    define('base_url', 'http://localhost/penjualan/'); 
    require_once 'function/koneksi.php';

    if(!isset($_SESSION['user'])){
        header('Location: login.php');
    } 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url; ?>assets/bootstrap4/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url; ?>assets/vendor/@fontawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url; ?>assets/vendor/@fontawesome/fontawesome-free/css/fontawesome.min.css">
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"> -->
    <style>
        #loader, #tbody-barang, #tbody-pembelian, #tbody-hutang, .dataKosong, #aktif{display: none;}
    </style>
</head>

<!-- <body data-senna-surface="data-senna-surface" data-senna="data-senna"> -->
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container"> 
          <a class="navbar-brand" href="<?= base_url; ?>">Pembelian barang</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                  <a class="nav-item nav-link" id="kasir" href="<?= base_url; ?>order.php">Order</a>
                  <a class="nav-item nav-link" id="laporan" href="<?= base_url; ?>laporan.php">Laporan</a>
                  <a class="nav-item nav-link" href="<?= base_url; ?>logout.php">Logout</a>
            </div>
          </div>
        </div>
    </nav>