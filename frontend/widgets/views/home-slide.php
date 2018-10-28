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
                                        <li><img style="height: 450px" alt="<?= $item->des ?>" src="<?= Slide::getSlideHomeFe($item->content_id) ?>" title="<?= $item->des ?>" /></li>
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
<!-- servives -->
<div class="container">
    <div class="service ">
        <div class="col-xs-6 col-sm-3 service-item">
            <div class="icon">
                <img alt="services" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/data/s1.png" />
            </div>
            <div class="info">
                <a href="#"><h3>Free Shipping</h3></a>
                <span>On order over $200</span>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 service-item">
            <div class="icon">
                <img alt="services" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/data/s2.png" />
            </div>
            <div class="info">
                <a href="#"><h3>30-day return</h3></a>
                <span>Moneyback guarantee</span>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 service-item">
            <div class="icon">
                <img alt="services" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/data/s3.png" />
            </div>

            <div class="info" >
                <a href="#"><h3>24/7 support</h3></a>
                <span>Online consultations</span>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 service-item">
            <div class="icon">
                <img alt="services" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/data/s4.png" />
            </div>
            <div class="info">
                <a href="#"><h3>SAFE SHOPPING</h3></a>
                <span>Safe Shopping Guarantee</span>
            </div>
        </div>
    </div>
</div>
<!-- end services -->
