<!-- new released -->
<div class="container-fluid section">
    <div class="row">
        <div class="col-sm-6 section-header text-success">
            <span class="section-label"><?php echo $params['name'];?></span>
        </div>
    </div>
    <div class="row ad-row">
        <div>
            adv-row
        </div>
    </div>
    <div class="row">
        <div class="player col-md-9">
            <div class="player-area mx-auto">
                <iframe class="player-iframe" width="610" height="360" src="<?php echo urldecode($params['video_link']);?>" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="player-info mx-auto">
                <p>Released: <?php echo $params['produce_time'];?></p>
                <p>Views: <i class="fa fa-eye" aria-hidden="true"></i><?php echo $params['views'];?></p>
                <p>Author: <?php echo $params['author'];?></p>
                <p>Description: <?php echo $params['description'];?></p>
            </div>
        </div>
        <div class="col-md-3 ad-col">
            adv-column
        </div>
    </div>
    <div class="row ad-row">
        <div>
            adv-row
        </div>
    </div>
</div>