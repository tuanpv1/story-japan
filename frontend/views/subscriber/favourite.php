<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/2/2016
 * Time: 11:20 PM
 */
use common\helpers\CUtils;
use common\models\Content;
use frontend\widgets\UserWidget;
use yii\helpers\Url;

/* @var $model common\models\Subscriber */
?>
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="<?= Url::to(['site/index']) ?>"
               title="Return to Home"><?= Yii::t('app', 'Home') ?></a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page"><?= $model->full_name ? $model->full_name : $model->username ?></span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading">
            <span class="page-heading-title2"><?= Yii::t('app', 'information') ?></span>
        </h2>
        <!-- ../page heading-->
        <div class="page-content">
            <div class="row">
                <div class="col-sm-3">
                    <?= UserWidget::widget(['model' => $model]) ?>
                </div>
                <div class="col-sm-9">
                    <div class="page-content page-order">
                        <div class="subcategories">
                            <ul>
                                <li class="current-categorie">
                                    <a href="#"><?= Yii::t('app', 'Favourite') ?></a>
                                </li>
                                <li>
                                    <a href="#"><?= Yii::t('app', 'Favourite of ') ?><?= $model->username ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="heading-counter warning"><?= Yii::t('app', 'Total favourite') ?>:
                            <span><?= $contents ? count($contents) : '0' ?></span>
                        </div>
                        <!-- ./category-slider -->
                        <div id="replaceHtmlContents">
                            <!-- view-product-list-->
                            <div id="view-product-list" class="view-product-list">
                                <ul class="display-product-option">
                                    <li class="view-as-grid selected">
                                        <span><?= Yii::t('app', 'grid') ?></span>
                                    </li>
                                </ul>
                                <?php if (!empty($contents)) { ?>
                                    <!-- PRODUCT LIST -->
                                    <ul class="row product-list grid">
                                        <?php
                                        /** @var Content $item */
                                        foreach ($contents as $item) { ?>
                                            <li class="col-sx-12 col-sm-4">
                                                <div class="left-block">
                                                    <a href="<?= Url::to(['content/detail', 'id' => $item->id]) ?>">
                                                        <img style="height: 366px"
                                                             class="img-responsive product_image_<?= $item->id ?>"
                                                             alt="product"
                                                             src="<?= $item->getFirstImageLinkFE('p35.jpg') ?>"/>
                                                    </a>
                                                    <div class="add-to-cart">
                                                        <a title="<?= Yii::t('app', 'Read more') ?>"
                                                           href="<?= Url::to(['content/detail', 'id' => $item->id]) ?>"><?= Yii::t('app', 'Read more') ?></a>
                                                    </div>
                                                    <div class="price-percent-reduction2">
                                                        <?= $item->getTypeName() ?>
                                                    </div>
                                                    <div class="group-price">
                                                        <span class="product-sale"><?= $item->view_count?$item->view_count:0 ?> <i class="glyphicon glyphicon-eye-open"></i></span>
                                                    </div>
                                                </div>
                                                <div class="right-block">
                                                    <h5 class="product-name">
                                                        <a href="<?= Url::to(['content/detail', 'id' => $item->id]) ?>">
                                                            <span id="product_name_<?= $item['id'] ?>"><?= CUtils::substr($item->display_name, 25) ?></span><br>
                                                        </a>
                                                    </h5>
                                                    <div class="content_price">
                                                        <?= Yii::t('app', 'Code: ') ?>#<span
                                                                id="product_code_<?= $item->id ?>"><?= $item->code ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        <div id="last-mark"></div>
                                    </ul>
                                    <!-- ./PRODUCT LIST -->
                                <?php } else {
                                    echo "<br>Không có kết quả phù hợp";
                                } ?>
                            </div>
                            <!-- ./view-product-list-->
                            <div class="sortPagiBar">
                                <div class="bottom-pagination">
                                    <?php
                                    if (!empty($contents)) { ?>
                                        <input type="hidden" name="page" id="page"
                                               value="<?= sizeof($contents) - 1 ?>">
                                        <input type="hidden" name="numberCount" id="numberCount"
                                               value="<?= sizeof($contents) ?>">
                                        <input type="hidden" name="total" id="total" value="<?= $pages->totalCount ?>">
                                        <?php if (count($contents) >= 9) { ?>
                                            <button class="button" id="more"
                                                    onclick="loadMore('<?= Url::to(['content/get-more-contents']) ?>');">
                                                Xem
                                                thêm
                                            </button>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./page wapper-->
