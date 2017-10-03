<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="mibo48.png">
    <title>Mibo | Chinese Pink Movie</title>
</head>
<body>
<?php
session_start(['read_and_close' => true]);
require_once(__DIR__ . '/include/header.view.php');

// Merge incoming parameters
$params = array_merge($_GET, $_POST);
?>

<div class="page">
    <?php
    require_once(__DIR__ . '/include/play-content.view.php');
    ?>
</div>

<?php
require_once(__DIR__ . '/include/footer.view.php');
require_once(__DIR__ . '/include/bundle.view.php');
?>
<!-- Set search criteria based on incoming parameters -->
<input type="hidden" id="id" value="<?php echo $params['id'] ?? '';?>">

</body>
</html>