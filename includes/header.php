<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';
include 'includes/mail_functions.php';
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Udlåns System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Computer Udlånssystem</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=computers">Computere</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=users">Brugere</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=new_loan">Nyt Udlån</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=loans">Aktive Udlån</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=overdue">Overskredet</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
