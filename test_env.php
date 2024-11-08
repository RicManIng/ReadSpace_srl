<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once('head.php');
    ?>
    <title>Centro Sportivo Home</title> 
    <link rel="stylesheet" href="resources/css/home.min.css">
</head>
<body>
    <?php
        require_once('common.php');
        require_once('header.php');
    ?>

    <main>
    <?php
        echo $user->get_username();
    ?>
    </main>
    <?php
        require_once('footer.php');
    ?>
</body>
</html>