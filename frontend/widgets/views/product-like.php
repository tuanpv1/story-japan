<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/17/2017
 * Time: 12:15 PM
 */
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

?>
<div class="page-product-box">
    <h3 class="heading"><?= Yii::t('app','Sản phẩm tương tự') ?></h3>
    <ul class="product-list owl-carousel" data-dots="false" data-loop="true" data-nav = "true" data-margin = "30" data-autoplayTimeout="1000" data-autoplayHoverPause = "true" data-responsive='{"0":{"items":1},"600":{"items":3},"1000":{"items":3}}'>
        <?php if(isset($content)){ ?>
        <?php foreach($content as $item){ /** @var \common\models\Content $item */ ?>
        <li>
            <div class="product-container">
                <div class="left-block">
                    <a href="<?= Url::to(['content/detail','id'=>$item->id]) ?>">
                        <img style="height: 300px" class="img-responsive" alt="product" src="<?= $item->getFirstImageLinkFE() ?>" />
                    </a>
                    <div class="quick-view">
                        <a title="Quick view" class="search" href="<?= Url::to(['content/detail','id'=>$item->id]) ?>"></a>
                    </div>
                    <div class="add-to-cart">
                        <a title="Xem chi tiết" href="<?= Url::to(['content/detail','id'=>$item->id]) ?>"><?= Yii::t('app','Xem chi tiết') ?></a>
                    </div>
                </div>
                <div class="right-block">
                    <h5 class="product-name">
                        <a href="<?= Url::to(['product/detail','id'=>$item->id]) ?>">
                            <?= CUtils::substr($item->display_name,25) ?>
                        </a>
                    </h5>
                    <div class="content_price">
                        <?php if($item->price_promotion && $item->price_promotion != $item->price){ ?>
                        <span class="price product-price"><?= CUtils::formatNumber($item->price_promotion) ?> VND</span>
                        <span class="price old-price"><?= CUtils::formatNumber($item->price) ?> VND</span>
                        <?php } else { ?>
                        <span class="price product-price"><?= CUtils::formatNumber($item->price) ?> VND</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </li>
        <?php }?>
        <?php }?>
    </ul>
</div>
