<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/15/2017
 * Time: 10:16 PM
 */
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

?>
<div class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <h2 class="page-heading">
                    <span class="page-heading-title">Sản phẩm vừa đặt hàng</span>
                </h2>
                <div class="latest-deals-product">
                    <ul class="product-list owl-carousel" data-dots="false" data-loop="true" data-nav="true"
                        data-margin="10" data-autoplayTimeout="1000" data-autoplayHoverPause="true"
                        data-responsive='{"0":{"items":1},"600":{"items":3},"1000":{"items":5}}'>
                        <?php if ($contents) {
                            /** @var Content $content */
                            foreach ($contents as $content) {
                                ?>
                                <li>
                                    <div class="left-block">
                                        <a href="<?= \yii\helpers\Url::to(['content/detail', 'id' => $content->id]) ?>">
                                            <img class="img-responsive product_image_<?= $content->id ?>" alt="product"
                                                 src="<?= $content->getFirstImageLinkFE('ld9.jpg') ?>"/>
                                        </a>
                                        <div class="quick-view">
                                            <a title="Quick view" class="search" href="<?= Url::to(['content/detail','id' => $content->id]) ?>"></a>
                                        </div>
                                        <div class="add-to-cart">
                                            <a title="Add to Cart" href="javascript:void(0)"
                                               onclick="addCart(<?= $content->id ?>)">Mua</a>
                                        </div>
                                        <?php if ($content->getPercentSale()) {
                                            ?>
                                            <div class="price-percent-reduction2">
                                                -<?= $content->getPercentSale() ?>% OFF
                                            </div>
                                            <?php
                                        } ?>
                                    </div>
                                    <div class="right-block">
                                        <h5 class="product-name">
                                            <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                                                <span id="product_name_<?= $content->id ?>"><?= CUtils::substr($content->display_name, 25) ?></span><br>
                                                Mã SP: #<span id="product_code_<?= $content->id ?>"><?= $content->code ?></span>
                                            </a>
                                        </h5>
                                        <input type="hidden" class="product_amount_<?= $content->id ?>" value="1">
                                        <div class="content_price">
                                            <?php if ($content->price_promotion) { ?>
                                                <span id="product_price_promotion_<?= $content->id ?>" class="price product-price"><?= CUtils::formatNumber($content->price_promotion) ?>
                                                    Đ</span>
                                                <span id="product_price_<?= $content->id ?>" class="price old-price"><?= CUtils::formatNumber($content->price) ?>
                                                    Đ</span>
                                            <?php } else { ?>
                                                <span id="product_price_promotion_<?= $content->id ?>"  class="price product-price"><?= CUtils::formatNumber($content->price) ?>
                                                    Đ</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        } else {
                            echo "Hiện chưa có sản phẩm vừa đặt";
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
