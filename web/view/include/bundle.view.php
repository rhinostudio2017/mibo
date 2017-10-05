<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<!--
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


<script src="lib/jquery-3.2.1.min.js"></script>

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<?php
if (defined('ENV') && ENV === 'test') {
?>
<!-- each detailed external asset -->
    <link rel="stylesheet" href="<?php echo $asset?>css/basic.css">
    <link rel="stylesheet" href="<?php echo $asset?>css/header.css">
    <link rel="stylesheet" href="<?php echo $asset?>css/footer.css">

    <link rel="stylesheet" href="<?php echo $asset?>css/admin.css">
    <link rel="stylesheet" href="<?php echo $asset?>css/home.css">
    <link rel="stylesheet" href="<?php echo $asset?>css/search.css">
    <link rel="stylesheet" href="<?php echo $asset?>css/play.css">

    <script rel="text/javascript" src="<?php echo $asset?>js/common.js"></script>
    <script rel="text/javascript" src="<?php echo $asset?>js/admin.js"></script>
    <script rel="text/javascript" src="<?php echo $asset?>js/home.js"></script>
    <script rel="text/javascript" src="<?php echo $asset?>js/search.js"></script>
<?php
} else {
?>
<!-- bundled minimum external asset -->
    <link rel="stylesheet" href="<?php echo $asset?>css/bundle.min.css">
    <script rel="text/javascript" src="<?php echo $asset?>js/bundle.min.js"></script>
<?php
}
?>

<!-- global ad -->
<!-- ad-maven(not work - deprecated synchronize for xmlhttprequest)
<script data-cfasync="false" src="//d3oep4gb91kpuv.cloudfront.net/?gpeod=684851"></script>
-->