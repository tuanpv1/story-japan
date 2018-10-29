<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 1/5/2017
 * Time: 8:27 AM
 */
use common\models\Content;
use yii\helpers\Url;

?>
<?php
if($content){
    ?>
    <div class="tab-panel active" id="tab-0">
        <ul class="product-list owl-carousel" data-dots="false" data-loop="true"
            data-nav="true" data-margin="0" data-autoplayTimeout="1000"
            data-autoplayHoverPause="true"
            data-responsive='{"0":{"items":1},"600":{"items":3},"1000":{"items":4}}'>
            <?php
            foreach($content as $item) {
                /** @var $item \common\models\Content */
                ?>
                    <li>
                        <div class="left-block">
                            <a href="<?= Url::to(['content/detail','id'=>$item->id]) ?>">
                                <img style="height: 300px" class="img-responsive product_image_<?= $item->id ?>" alt="product"
                                     src="<?= $item->getFirstImageLinkFE() ?>"/></a>
                            <div class="quick-view">
                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                <a title="Add to compare" class="compare" href="#"></a>
                                <a title="Quick view" class="search" href="#"></a>
                            </div>
                            <div class="add-to-cart">
                                <a title="Add to Cart" href="javascript:void(0)" onclick="addCart(<?= $item->id ?>)">Mua</a>
                            </div>
                            <div class="group-price">
                                <?php if($item->price != $item->price_promotion && $item->price_promotion != 0){ ?>
                                    <span class="product-sale">Sale</span>
                                <?php } if($item->type == Content::TYPE_NEWEST){ ?>
                                    <span class="product-new">NEW</span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="right-block">
                            <h5>
                                <a id="product_name_<?= $item->id ?>" href="<?= Url::to(['content/detail','id'=>$item->id]) ?>">
                                    <?= ucfirst(Content::substr($item->display_name,25)) ?>
                                </a>
                            </h5>
                            <div class="content_price">
                                <span id="product_price_promotion_<?= $item->id ?>" style="font-size: 13px" class="price product-price"><?= Content::formatNumber($item->price_promotion) ?> Đ</span>
                                <span style="font-size: small" id="product_price_<?= $item->id ?>" class="price old-price"><?= Content::formatNumber($item->price) ?> Đ</span><br>
                                <span style="font-size: small" id="product_code_<?= $item->id ?>">Mã SP: #<?= $item->code ?></span>&nbsp;&nbsp;
                                <input type="hidden" class="product_amount_<?= $item->id ?>" value="1">
                                <div class="product-star">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <?php
}
?>
<div class="col-sm-6 col-right-tab">
    <div class="product-featured-tab-content">
        <div class="tab-container">
            <div class="tab-panel active" id="tab-4">
                <ul class="product-list row">
                    <li class="col-sm-4">
                        <div class="right-block">
                            <h5 class="product-name"><a href="#">Sexy Red Dress</a></h5>
                            <div class="content_price">
                                <span class="price product-price">$138,95</span>
                            </div>
                        </div>
                        <div class="left-block">
                            <a href="#"><img class="img-responsive" alt="product"
                                             src="assets/data/p48.jpg"/></a>
                            <div class="quick-view">
                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                <a title="Add to compare" class="compare" href="#"></a>
                                <a title="Quick view" class="search" href="#"></a>
                            </div>
                            <div class="add-to-cart">
                                <a title="Add to Cart" href="#">Add to Cart</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tab-panel" id="tab-5">
                <ul class="product-list row">
                    <li class="col-sm-4">
                        <div class="right-block">
                            <h5 class="product-name"><a href="#">Headphone & earphone</a></h5>
                            <div class="content_price">
                                <span class="price product-price">$38,95</span>
                            </div>
                        </div>
                        <div class="left-block">
                            <a href="#">
                                <img class="img-responsive" alt="product"
                                     src="assets/data/p53.jpg"/></a>
                            <div class="quick-view">
                                <a title="Add to my wishlist" class="heart" href="#"></a>
                                <a title="Add to compare" class="compare" href="#"></a>
                                <a title="Quick view" class="search" href="#"></a>
                            </div>
                            <div class="add-to-cart">
                                <a title="Add to Cart" href="#">Add to Cart</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
