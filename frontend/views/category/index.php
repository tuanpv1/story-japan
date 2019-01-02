<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/20/2017
 * Time: 8:22 AM
 */
use common\helpers\CUtils;
use common\models\Category;
use common\models\Content;
use yii\helpers\Url;

/** @var Category $cat */

?>
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <?= \frontend\widgets\FindBreadcrumb::getBreadcrumbCate($cat->id) ?>
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">
            <!-- Left colunm -->
            <div class="column col-xs-12 col-sm-3" id="left_column">
                <?= \frontend\widgets\WidgetSaleContent::widget(['id' => 0]) ?>
            </div>
            <!-- ./left colunm -->
            <!-- Center colunm-->
            <div class="center_column col-xs-12 col-sm-9" id="center_column">
                <!-- category-slider -->
                <?php if (isset($banner)) { ?>
                    <div class="category-slider">
                        <ul class="owl-carousel owl-style2" data-dots="false"
                            data-loop="<?= count($banner) > 1 ? 'true' : false ?>" data-nav="true"
                            data-autoplayTimeout="1000" data-autoplayHoverPause="true" data-items="1">
                            <?php foreach ($banner as $item) {
                                /** @var Slide $item */ ?>
                                <li>
                                    <img style="height:288px;" src="<?= $item->getSlideImage() ?>"
                                         alt="<?= $item->id ?>">
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <!-- ./category-slider -->
                <!-- subcategories -->
                <div class="subcategories">
                    <ul>
                        <?php
                        $child = Category::findAll(['status' => Category::STATUS_ACTIVE, 'parent_id' => $cat->id]);
                        if (!empty($child)) {
                            ?>
                            <li class="current-categorie">
                                <a href="<?= Url::to(['category/index', 'id' => $cat->id]) ?>"><?= $cat->display_name ?></a>
                            </li>
                            <?= \frontend\widgets\CateRow::getCateRow($cat->id); ?>
                            <?php
                        } else {
                            $cat_parent = Category::findOne($cat->parent_id);
                            if(!empty($cat_parent)){
                                ?>
                                <li class="current-categorie">
                                    <a href="<?= Url::to(['category/index', 'id' => $cat_parent->id]) ?>"><?= $cat_parent->display_name ?></a>
                                </li>
                                <?php
                                echo \frontend\widgets\CateRow::getCateRow($cat_parent->id);
                            }else{
                                ?>
                                <li class="current-categorie">
                                    <a href="<?= Url::to(['category/index', 'id' => $cat->id]) ?>"><?= $cat->display_name ?></a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!-- ./subcategories -->
                <div id="replaceHtmlContents">
                    <!-- view-product-list-->
                    <div id="view-product-list" class="view-product-list">
                        <h2 class="page-heading">
                            <span class="page-heading-title"><?= $cat->display_name ?></span>
                            <input type="hidden" id="idCategorySearch" value="<?= $cat->id ?>">
                        </h2>
                        <ul class="display-product-option">
                            <li class="view-as-grid selected">
                                <span>grid</span>
                            </li>
                        </ul>
                        <!-- PRODUCT LIST -->
                        <ul class="row product-list grid">
                            <?php if (!empty($contents)) { /** @var $item Content  */ ?>
                                <?php foreach ($contents as $item) { ?>
                                    <li class="col-sx-12 col-sm-4">
                                        <div class="left-block">
                                            <a href="<?= Url::to(['content/detail', 'id' => $item->id]) ?>">
                                                <img style="height: 366px"
                                                     class="img-responsive product_image_<?= $item->id ?>"
                                                     alt="product"
                                                     src="<?= $item->getFirstImageLinkFE('p35.jpg') ?>"/>
                                            </a>
                                            <div class="add-to-cart">
                                                <a title="<?= Yii::t('app','Read more') ?>" href="<?= Url::to(['content/detail', 'id' => $item->id]) ?>"><?= Yii::t('app','Read more') ?></a>
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
                                                <?= Yii::t('app','Code: ') ?>#<span
                                                        id="product_code_<?= $item->id ?>"><?= $item->code ?></span>
                                                <span class="price old-price">
                                                    <?= Yii::t('app','Author:') ?> <?= $item->author?$item->author:Yii::t('app','updating...') ?>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } else {
                                echo "<br>Không có kết quả phù hợp";
                            } ?>
                            <div id="last-mark"></div>
                        </ul>
                        <!-- ./PRODUCT LIST -->
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
                                            onclick="loadMore('<?= Url::to(['category/get-more-contents']) ?>');">Xem
                                        thêm
                                    </button>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>
