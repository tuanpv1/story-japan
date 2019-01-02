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
                    <span class="page-heading-title"><?= Yii::t('app', 'Top Reading') ?></span>
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
                                        <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                                            <img style="height: 250px" class="img-responsive product_image_<?= $content->id ?>" alt="product"
                                                 src="<?= $content->getFirstImageLinkFE('p14.jpg') ?>"/>
                                        </a>
                                        <div class="add-to-cart">
                                            <a title="<?= $content->display_name ?>" href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                                                <?= Yii::t('app', 'Read more') ?>
                                            </a>
                                        </div>
                                        <div class="price-percent-reduction2">
                                            <?= $content->getTypeName() ?>
                                        </div>
                                        <div class="group-price">
                                            <span class="product-sale"><?= $content->view_count?$content->view_count:0 ?> <i class="glyphicon glyphicon-eye-open"></i></span>
                                        </div>
                                    </div>
                                    <div class="right-block">
                                        <h5 class="product-name">
                                            <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                                                <span id="product_name_<?= $content->id ?>"><?= CUtils::substr($content->display_name, 25) ?></span><br>
                                            </a>
                                        </h5>
                                        <input type="hidden" class="product_amount_<?= $content->id ?>" value="1">
                                        <div class="content_price">
                                            <span class="price product-price"
                                                    id="product_code_<?= $content->id ?>"><?= Yii::t('app', 'Code : ') ?> #<?= $content->code ?></span>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        } else {
                            echo Yii::t('app',"Not content to show");
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Baner bottom -->
        <div class="row banner-bottom">
            <div class="col-sm-6 item-left">
                <div class="banner-boder-zoom">
                    <a href="#"><img alt="ads" class="img-responsive" src="/data/option5/banner1.jpg" /></a>
                </div>
            </div>
            <div class="col-sm-6 item-right">
                <div class="banner-boder-zoom">
                    <a href="#"><img alt="ads" class="img-responsive" src="/data/option5/banner2.jpg" /></a>
                </div>
            </div>
        </div>
        <!-- end banner bottom -->
    </div>
</div>
