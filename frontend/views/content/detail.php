<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/17/2017
 * Time: 8:45 AM
 */
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

?>
<?php /** @var \common\models\Content $content*/ ?>
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <?php if(isset($content)){ ?>
        <?= \frontend\widgets\FindBreadcrumb::getBreadcrumb($content->id) ?>
        <?php } ?>
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">
            <!-- Left colunm -->
            <div class="column col-xs-12 col-sm-3" id="left_column">
                <!-- block category -->
                <!-- ./block category  -->
                <!-- block best sellers -->
                <?= \frontend\widgets\WidgetNewContent::widget() ?>
                <!-- ./block best sellers  -->
                <!-- left silide -->
                <?= \frontend\widgets\SlideLeft::getSlideLeft($content->id) ?>
                <!--./left silde-->
                <!-- block best sellers -->
                <?= \frontend\widgets\WidgetSaleContent::widget() ?>
                <!-- ./block best sellers  -->
                <!-- left silide -->
                <div class="col-left-slide left-module">
                    <div class="banner-opacity">
                        <a href="#"><img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/data/ads-banner.jpg" alt="ads-banner"></a>
                    </div>
                </div>
                <!--./left silde-->
            </div>
            <!-- ./left colunm -->
            <!-- Center colunm-->
            <div class="center_column col-xs-12 col-sm-9" id="center_column">
                <!-- Product -->
                <?php if(isset($content)){ ?>
                <div id="product">
                    <div class="primary-box row">
                        <div class="pb-left-column col-xs-12 col-sm-6">
                            <!-- product-imge-->
                            <div class="product-image">
                                <div class="product-full text-center">
                                    <img class="product_image_<?= $content->id ?>" style="height: 512px" id="product-zoom" src='<?= $content->getFirstImageLinkFE('product-s3-850x1036.jpg') ?>' data-zoom-image="<?= $content->getFirstImageLinkFE('product-s3-850x1036.jpg') ?>"/>
                                </div>
                                <div class="product-img-thumb" id="gallery_01">
                                    <ul class="owl-carousel" data-items="3" data-nav="true" data-dots="false" data-margin="20" data-loop="true">
                                        <?php if(isset($link)){ $i = 0; $n = count($link);while($i < $n){ ?>
                                        <li>
                                            <a href="#" data-image="<?= $link[$i] ?>" data-zoom-image="<?= $link[$i] ?>">
                                                <img id="product-zoom"  src="<?= $link[$i] ?>" />
                                            </a>
                                        </li>
                                        <?php $i++;}} ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- product-imge-->
                        </div>
                        <div class="pb-right-column col-xs-12 col-sm-6">
                            <h1 id="product_name_<?= $content->id ?>" class="product-name"><?= $content->display_name ?></h1>
                            <div class="product-comments">
                                <div class="product-star">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                                <div class="comments-advices">
                                    <a href="#">Based  on 3 ratings</a>
                                    <a href="#"><i class="fa fa-pencil"></i> write a review</a>
                                </div>
                            </div>
                            <div class="product-price-group">
                                <span id="product_price_promotion_<?= $content->id ?>" class="price"><?= CUtils::formatNumber($content->price_promotion) ?> Đ</span>
                                <span id="product_price_<?= $content->id ?>" class="old-price"><?= CUtils::formatNumber($content->price) ?> Đ</span>
                                <span class="discount"><?= round (((($content->price - $content->price_promotion)/($content->price))*100),1) ?> %</span>
                            </div>
                            <div class="info-orther">
                                <p id="product_code_<?= $content->id ?>"><?= Yii::t('app','Mã sản phẩm: #') ?><span><?= $content->code ?></span></p>
                                <p><?= Yii::t('app','Tình trạng: ') ?><span class="in-stock"><?= Content::$listAvailability[$content->availability] ?></span></p>
                                <p><?= Yii::t('app','Kiểu hàng: ') ?><?= Content::$list_type[$content->type] ?></p>
                            </div>
                            <div class="product-desc">
                                <?= $content->short_description?$content->short_description:Yii::t('app','Đang cập nhật') ?>
                            </div>
                            <div class="form-option">
<!--                                <p class="form-option-title">Available Options:</p>-->
                                <div class="attributes">
                                    <div class="attribute-label"><?= Yii::t('app','SL:') ?></div>
                                    <div class="attribute-list product-qty">
                                        <div class="qty">
                                            <input  class="product_amount_<?= $content->id ?>" id="option-product-qty" type="text" value="1">
                                        </div>
                                        <div class="btn-plus">
                                            <a onclick="addition_detail(<?= $content->id ?>)" href="javascript:void(0)" class="btn-plus-up">
                                                <i class="fa fa-caret-up"></i>
                                            </a>
                                            <a onclick="subtraction_detail(<?= $content->id ?>)" href="javascript:void(0)" class="btn-plus-down">
                                                <i class="fa fa-caret-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-action">
                                <div class="button-group">
                                    <a class="btn-add-cart" href="javascript:void(0)" onclick="addCart(<?= $content->id ?>)">Mua</a>
                                </div>
                                <div class="button-group">
                                    <a class="wishlist" href="#"><i class="fa fa-heart-o"></i>
                                        <br>Wishlist</a>
                                    <a class="compare" href="#"><i class="fa fa-signal"></i>
                                        <br>
                                        Compare</a>
                                </div>
                            </div>
                            <div class="form-share">
                                <div class="sendtofriend-print">
                                    <a href="javascript:print();"><i class="fa fa-print"></i> Print</a>
                                    <a href="#"><i class="fa fa-envelope-o fa-fw"></i>Send to a friend</a>
                                </div>
                                <div class="network-share">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tab product -->
                    <div class="product-tab">
                        <ul class="nav-tab">
                            <li class="active">
                                <a aria-expanded="false" data-toggle="tab" href="#product-detail"><?= Yii::t('app','Mô tả sản phẩm') ?></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#reviews"><?= Yii::t('app','Nhận xét') ?></a>
                            </li>
                        </ul>
                        <div class="tab-container">
                            <div id="product-detail" class="tab-panel active">
                                <?= $content->description?$content->description:Yii::t('app','Đang cập nhật') ?>
                            </div>
                            <div id="reviews" class="tab-panel">
                                <div class="product-comments-block-tab">
                                    <div class="comment row">
                                        <div class="col-sm-3 author">
                                            <div class="grade">
                                                <span>Grade</span>
                                                    <span class="reviewRating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                            </div>
                                            <div class="info-author">
                                                <span><strong>Jame</strong></span>
                                                <em>04/08/2015</em>
                                            </div>
                                        </div>
                                        <div class="col-sm-9 commnet-dettail">
                                            Phasellus accumsan cursus velit. Pellentesque egestas, neque sit amet convallis pulvinar
                                        </div>
                                    </div>
                                    <div class="comment row">
                                        <div class="col-sm-3 author">
                                            <div class="grade">
                                                <span>Grade</span>
                                                    <span class="reviewRating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                            </div>
                                            <div class="info-author">
                                                <span><strong>Author</strong></span>
                                                <em>04/08/2015</em>
                                            </div>
                                        </div>
                                        <div class="col-sm-9 commnet-dettail">
                                            Phasellus accumsan cursus velit. Pellentesque egestas, neque sit amet convallis pulvinar
                                        </div>
                                    </div>
                                    <p>
                                        <a class="btn-comment" href="#">Write your review !</a>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- ./tab product -->
                    <!-- box product -->
                    <?= \frontend\widgets\ProductLike::getProductLike($content->id) ?>
                    <!-- ./box product -->
                </div>
                <?php } ?>
                <!-- Product -->
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>

<?= \frontend\widgets\CartBox::getModal() ?>
