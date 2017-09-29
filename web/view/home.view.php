<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Mibo | Chinese Pink Movie</title>
</head>
<body>
<?php
session_start(['read_and_close' => true]);
require_once(__DIR__ . '/include/header.view.php');
?>

<div class="page">
    <?php
    require_once(__DIR__ . '/include/home-content.view.php');
    ?>
</div>

<?php
require_once(__DIR__ . '/include/footer.view.php');
require_once(__DIR__ . '/include/bundle.view.php');
?>
</body>
</html>