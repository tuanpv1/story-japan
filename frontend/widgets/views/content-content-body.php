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
                    <h5 class="product-name">
                        <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                            <?= ucfirst(CUtils::substr($content->display_name, 25)) ?>
                            <span style="font-size: small"
                                  id="product_code_<?= $content->id ?>">Mã SP: #<?= $content->code ?></span>&nbsp;&nbsp;
                            <input type="hidden" class="product_amount_<?= $content->id ?>" value="1">
                        </a>
                    </h5>
                    <div class="content_price">
                        <?php if ($content->price_promotion) { ?>
                            <span class="price product-price"><?= CUtils::formatNumber($content->price_promotion) ?>
                                VND</span>
                            <span class="price old-price"><?= CUtils::formatNumber($content->price) ?>
                                VND</span>
                        <?php } else { ?>
                            <span class="price product-price"><?= CUtils::formatNumber($content->price) ?>
                                VND</span>
                        <?php } ?>
                    </div>
                </div>
                <div class="left-block">
                    <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                        <img class="img-responsive" alt="<?= $content->display_name ?>"
                             src="<?= $content->getFirstImageLinkFE() ?>"/>
                    </a>
                    <div class="quick-view">
                        <a title="Add to my wishlist" class="heart" href="#"></a>
                        <a title="Add to compare" class="compare" href="#"></a>
                        <a title="Quick view" class="search" href="#"></a>
                    </div>
                    <div class="add-to-cart">
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
