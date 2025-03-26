<?php

require_once 'includes/header.php';?>

<div class="container mt-4">

    <?php
    if (file_exists($page)) {
    require_once $page;
    } else {
    require_once 'pages/404.php';
    }

    require_once 'includes/footer.php';
    ?>

</div>