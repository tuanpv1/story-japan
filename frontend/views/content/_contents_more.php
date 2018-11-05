<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 11/3/2018
 * Time: 11:14 PM
 */
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

?>
<?php if (!empty($contents)) { ?>
    <?php
    /** @var Content $item */
    foreach ($contents as $item) { ?>
        <li class="col-sx-12 col-sm-4">
            <div class="left-block">
                <a href="<?= Url::to(['content/detail', 'id' => $item->id]) ?>">
                    <img style="height: 366px" class="img-responsive product_image_<?= $item->id ?>"
                         alt="product"
                         src="<?= $item->getFirstImageLinkFE('p35.jpg') ?>"/>
                </a>
                <div class="quick-view">
                    <a title="Quick view" class="search"
                       href="<?= Url::to(['content/detail', 'id' => $item->id]) ?>"></a>
                </div>
                <div class="add-to-cart">
                    <a title="Add to Cart" href="javascript:void(0)"
                       onclick="addCart(<?= $item->id ?>)">Mua</a>
                </div>
                <div class="group-price">
                    <?php if ($item->price != $item->price_promotion && $item->price_promotion != 0) { ?>
                        <span class="product-sale">Sale</span>
                    <?php }
                    if ($item->type == Content::TYPE_NEWEST) { ?>
                        <span class="product-new">NEW</span>
                    <?php } ?>
                </div>
            </div>
            <div class="right-block">
                <h5 class="product-name">
                    <a href="<?= Url::to(['content/detail', 'id' => $item->id]) ?>">
                        <span id="product_name_<?= $item['id'] ?>"><?= CUtils::substr($item->display_name, 25) ?></span><br>
                        Mã SP: #<span id="product_code_<?= $item->id ?>"><?= $item->code ?></span>
                    </a>
                </h5>
                <input type="hidden" class="product_amount_<?= $item->id ?>" value="1">
                <div class="content_price">
                                                <span id="product_price_promotion_<?= $item->id ?>"
                                                      class="price product-price"><?= CUtils::formatNumber($item->price_promotion) ?>
                                                    Đ</span>
                    <span id="product_price_<?= $item->id ?>"
                          class="price old-price"><?= CUtils::formatNumber($item->price) ?>
                        Đ</span>
                </div>
                <div class="product-star">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                </div>
            </div>
        </li>
    <?php } ?>
<?php } ?>