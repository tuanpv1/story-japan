<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/17/2017
 * Time: 4:39 PM
 */
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

?>
<?php if(isset($product_sales) && !empty($product_sales)){ ?>
<div class="block left-module">
    <p class="title_block"><?= Content::getListType()[Content::TYPE_NEWEST] ?></p>
    <div class="block_content product-onsale">
        <ul class="product-list owl-carousel" data-loop="true" data-nav = "false" data-margin = "0" data-autoplayTimeout="1000" data-autoplayHoverPause = "true" data-items="1" data-autoplay="true">
            <?php foreach($product_sales as $item){ /** @var  \common\models\Content $item */ ?>
            <li>
                <div class="product-container">
                    <div class="left-block">
                        <a href="<?= Url::to(['content/detail','id'=>$item->id]) ?>">
                            <img class="img-responsive" alt="product" src="<?= $item->getFirstImageLinkFE() ?>" />
                        </a>
                        <div class="price-percent-reduction2">
                            <?= $item->getTypeName() ?>
                        </div>
                        <div class="group-price">
                            <span class="product-sale"><?= $item->view_count?$item->view_count:0 ?> <i class="glyphicon glyphicon-eye-open"></i></span>
                        </div>
                    </div>
                    <div class="right-block">
                        <h5 class="product-name">
                            <a href="<?= Url::to(['content/detail','id'=>$item->id]) ?>">
                                <?= $item->display_name ?>
                            </a>
                        </h5>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>
