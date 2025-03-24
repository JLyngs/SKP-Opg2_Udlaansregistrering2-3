<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';
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
    <?php include 'includes/header.php'; ?>
    
    <div class="container mt-4">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        
        switch ($page) {
            case 'dashboard':
                include 'pages/dashboard.php';
                break;
            case 'computers':
                include 'pages/computers.php';
                break;
            case 'users':
                include 'pages/users.php';
                break;
            case 'loans':
                include 'pages/loans.php';
                break;
            case 'new_loan':
                include 'pages/new_loan.php';
                break;
            case 'overdue':
                include 'pages/overdue.php';
                break;
            case 'add_computer':
                include 'pages/add_computer.php';
                break;
            case 'add_user':
                include 'pages/add_user.php';
                break;
            default:
                include 'pages/dashboard.php';
                break;
        }
        ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>