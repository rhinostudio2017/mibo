<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mibo | Chinese Pink Movie</title>
    <link rel="stylesheet" href="<?php echo $asset;?>css/home.css" />
</head>
<body>
<div class="container">
    <?php
    require_once(__DIR__ . '/include/header.view.php');
    ?>

    <div class="content mgt60 mgb60">
        <div id="div_charts" class="section mgb40">
            <a href="javascript:void(0);" class="top_more fr text" data="s">
                watch more>>
            </a>
            <h2 class="text">
                <a href="javascript:void(0);" class="section_title" data="s">Featured</a>
            </h2>
            <ul class="list clear"></ul>
        </div>
        <div id="div_blueray" class="section mgb40">
            <a href="javascript:void(0);" class="top_more fr text" data="s">
                watch more>>
            </a>
            <h2 class="text">
                <a href="javascript:void(0);" class="section_title" data="s">Blu-ray</a>
            </h2>
            <ul class="list clear"></ul>
        </div>
        <div id="div_songs" class="section mgb40">
            <a href="javascript:void(0);" class="top_more fr text" data="s">
                watch more...>>
            </a>
            <h2 class="text">
                <a href="javascript:void(0);" class="section_title" data="s">Newly Released</a>
            </h2>
            <ul class="list clear"></ul>
        </div>
        <div id="div_toprated" class="section mgb40">
            <a href="javascript:void(0);" class="top_more fr text" data="s">
                watch more...>>
            </a>
            <h2 class="text">
                <a href="javascript:void(0);" class="section_title" data="s">Top Rated</a>
            </h2>
            <ul class="list clear"></ul>
        </div>

        <div id="div_asian" class="section mgb40">
            <a href="javascript:void(0);" class="top_more fr text" data="s">
                watch more...>>
            </a>
            <h2 class="text">
                <a href="javascript:void(0);" class="section_title" data="s">Asian [Eng Sub]</a>
            </h2>
            <ul class="list clear"></ul>
        </div>

        <div id="div_youlike" class="section mgb40">
            <a href="javascript:void(0);" class="top_more fr text" data="s">
                watch more...>>
            </a>
            <h2 class="text">
                <a href="javascript:void(0);" class="section_title" data="s">Newly Added</a>
            </h2>
            <ul class="list clear"></ul>
        </div>

    </div>

    <?php
    require_once(__DIR__ . '/include/footer.view.php');
    require_once(__DIR__ . '/include/bundle.view.php');
    ?>
</div>
</body>
</html>
