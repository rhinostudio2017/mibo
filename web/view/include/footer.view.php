<!-- footer bar -->
<div class="container-fluid bg-inverse div-footer">
    <div class="row">
        <div class="col-sm-3">
            <script type="text/javascript" src="http://widget.supercounters.com/online_i.js"></script>
            <script type="text/javascript">sc_online_i(1446107, "ffffff", "e61c1c");</script>
            <noscript><a href="http://www.supercounters.com/">Free Tumblr Online Counter</a></noscript>
        </div>
        <div class="col-sm-9">
            <div class="copyright">
                <span>
                    &copy;&ensp;2017 RhinoStudio<br>
                    <small>
                        Disclaimer: Videos embedded on this site are hosted in YouTube.com, docs.google.com, googlevideo.com, dailymotion.com, vk.com, ... etc. Please report to the hosting website or email us (rhinotudio@ymail.com) if any video we embedded is unauthorized.
                    </small>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- loading panel -->
<div id="loading_panel">
    <div id="loading_icon">
        <img src="<?php echo $asset;?>/images/page-loader.gif" width="100px" height="100px">
    </div>
</div>

<!-- config settings -->
<?php
$token = defined('TOKEN') ? TOKEN : '';
if ($view == 'admin' && isset($_SESSION['admin'])) {
    $token = $_SESSION['admin'];
}
?>
<input type="hidden" id="api" value="<?php echo API; ?>">
<input type="hidden" id="token" value="<?php echo $token; ?>">
<input type="hidden" id="page" value="<?php echo $view; ?>">