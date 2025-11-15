<?//Home functions Handler

require("../config/main.php");

function getNews(){
    
    $cr = $db->query('SELECT  * FROM news ORDER BY news_id DESC LIMIT 4')->fetchAll();
        foreach ($cr as $rs) { 
            ?>
                <li class="uk-width-3-3">
                <div class="uk-panel">
                    <img src="<?php print IMG ?>blog/<?php echo $rs['img']; ?>" alt="img" class="lazy img-responsive" width="100%">
                    <div style="padding: 10px;" class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                        <a href="<?php echo 'news/'.$rs['code']; ?>"><h5 class="uk-margin-remove"><?php echo $rs['title'] ?></h5></a>

                    </div>
                </div>
            </li>
            <?
        }
        
}
function getMusic($limit,$order){

}
function getVids($limit,$order){

}