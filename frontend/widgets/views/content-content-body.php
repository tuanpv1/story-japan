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
                            <?= ucfirst(CUtils::substr($content->display_name, 15)) ?><br>
                            <span style="font-size: small" id="product_code_<?= $content->id ?>">Mã SP: #<?= $content->code ?></span><br>
                            <input type="hidden" class="product_amount_<?= $content->id ?>" value="1">
                            <?php if($content->price_promotion && $content->price_promotion != $content->price){ ?>
                                <span class="price old-price"><?= CUtils::formatNumber($content->price) ?>
                                    Đ</span>
                            <?php }else{ ?> <br><?php } ?>
                        </a>
                    </h5>
                    <div class="text-center">
                        <?php if ($content->price_promotion && $content->price_promotion != $content->price) { ?>
                            <span class="price product-price"><?= CUtils::formatNumber($content->price_promotion) ?>
                                Đ</span>
                        <?php } else { ?>
                            <span class="price product-price"><?= CUtils::formatNumber($content->price) ?>
                                Đ</span>
                        <?php } ?>
                    </div>
                </div>
                <div class="left-block">
                    <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                        <img style="height:170px" class="img-responsive" alt="<?= $content->display_name ?>"
                             src="<?= $content->getFirstImageLinkFE('p48.jpg') ?>"/>
                    </a>
                    <div class="quick-view">
                        <a title="Add to my wishlist" class="heart" href="#"></a>
                        <a title="Add to compare" class="compare" href="#"></a>
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
