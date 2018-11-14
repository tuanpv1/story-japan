<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 1/5/2017
 * Time: 8:27 AM
 */
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

?>
<ul class="product-list row">
    <?php
    if ($contents) {
        /** @var Content $content */
        foreach ($contents as $content) {
            ?>
            <li class="col-sm-4">
                <div class="right-block">
                    <h5 class="product-name text-center">
                        <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                            <span id="product_name_<?= $content->id ?>"><?= ucfirst(CUtils::substr($content->display_name, 15)) ?></span><br>
                            <span style="font-size: small" id="product_code_<?= $content->id ?>">Mã SP: #<?= $content->code ?></span><br>
                            <input type="hidden" class="product_amount_<?= $content->id ?>" value="1">
                            <?php if($content->price_promotion && $content->price_promotion != $content->price){ ?>
                                <span id="product_price_<?= $content->id ?>" class="price old-price"><?= CUtils::formatNumber($content->price) ?>
                                    Đ</span>
                            <?php }else{ ?> <br><?php } ?>
                        </a>
                    </h5>
                    <div class="text-center">
                        <?php if ($content->price_promotion && $content->price_promotion != $content->price) { ?>
                            <span id="product_price_promotion_<?= $content->id ?>" class="price product-price"><?= CUtils::formatNumber($content->price_promotion) ?>
                                Đ</span>
                        <?php } else { ?>
                            <span id="product_price_<?= $content->id ?>" class="price product-price"><?= CUtils::formatNumber($content->price) ?>
                                Đ</span>
                        <?php } ?>
                    </div>
                </div>
                <div class="left-block">
                    <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                        <img style="height:170px" class="img-responsive product_image_<?= $content->id ?>" alt="<?= $content->display_name ?>"
                             src="<?= $content->getFirstImageLinkFE('p48.jpg') ?>"/>
                    </a>
                    <div class="quick-view">
                        <a title="Quick view" class="search" href="#"></a>
                    </div>
                    <div class="add-to-cart" style="padding-bottom: 0px">
                        <a title="Add to Cart" href="javascript:void(0)" onclick="addCart(<?= $content->id ?>)">Thêm giỏ
                            hàng</a>
                    </div>
                </div>
            </li>
            <?php
        }
    }else{
        echo "Đang cập nhật";
    }
    ?>
</ul>
