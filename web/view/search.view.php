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
    require_once(__DIR__ . '/include/search-content.view.php');
    ?>
</div>

<?php
require_once(__DIR__ . '/include/footer.view.php');
require_once(__DIR__ . '/include/bundle.view.php');

// Merge incoming parameters
$params = array_merge($_GET, $_POST);
?>
<!-- Set search criteria based on incoming parameters -->
<input type="hidden" id="ipt_startTime" value="<?php echo $params['startTime'] ?? '';?>">
<input type="hidden" id="ipt_endTime" value="<?php echo $params['endTime'] ?? '';?>">
<input type="hidden" id="ipt_offset" value="<?php echo $params['offset'] ?? '';?>">
<input type="hidden" id="ipt_limit" value="<?php echo $params['limit'] ?? '';?>">
<input type="hidden" id="ipt_keyword" value="<?php echo $params['keyword'] ?? '';?>">
<input type="hidden" id="ipt_order" value="<?php echo $params['order'] ?? '';?>">

</body>
</html>