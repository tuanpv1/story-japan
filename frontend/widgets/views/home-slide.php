<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/21/2016
 * Time: 9:57 PM
 */
use common\models\Slide;

?>
<!-- Home slideder-->
<div id="home-slider">
    <div class="container">
        <div class="row">
            <div class="header-top-right">
                <div class="homeslider">
                    <ul id="contenhomeslider">
                        <?php
                        if(isset($slide)){
                            foreach($slide as $item){
                                /** @var  $item \common\models\Slide*/
                                ?>
                                <li><img class="fix-width" alt="<?= $item->des ?>" src="<?= Slide::getSlideHomeFe($item->content_id) ?>" title="<?= $item->des ?>" /></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
