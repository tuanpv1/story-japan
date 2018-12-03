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
                <?= \frontend\widgets\SearchPriceWidget::widget() ?>
                <?= \frontend\widgets\WidgetSaleContent::widget() ?>
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
                            <?php if (!empty($contents)) { ?>
                                <?php foreach ($contents as $item) { ?>
                                    <li class="col-sx-12 col-sm-4">
                                        <div class="left-block">
                                            <a href="<?= Url::to(['content/detail', 'id' => $item['id']]) ?>">
                                                <img style="height: 366px"
                                                     class="img-responsive product_image_<?= $item['id'] ?>"
                                                     alt="product"
                                                     src="<?= Content::getFirstImageLinkFeStatic($item['images'], 'p35.jpg') ?>"/>
                                            </a>
                                            <div class="quick-view">
                                                <a title="Quick view" class="search"
                                                   href="<?= Url::to(['content/detail', 'id' => $item['id']]) ?>"></a>
                                            </div>
                                            <div class="add-to-cart">
                                                <a title="Add to Cart" href="javascript:void(0)"
                                                   onclick="addCart(<?= $item['id'] ?>)">Thêm vào giỏ hàng</a>
                                            </div>
                                            <div class="group-price">
                                                <?php if ($item['price'] != $item['price_promotion'] && $item['price_promotion'] != 0) { ?>
                                                    <span class="product-sale">Sale</span>
                                                <?php }
                                                if ($item['type'] == Content::TYPE_NEWEST) { ?>
                                                    <span class="product-new">NEW</span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <h5 class="product-name">
                                                <a href="<?= Url::to(['content/detail', 'id' => $item['id']]) ?>">
                                                    <span id="product_name_<?= $item['id'] ?>"><?= CUtils::substr($item['display_name'], 25) ?></span><br>
                                                    Mã SP: #<span
                                                            id="product_code_<?= $item['id'] ?>"><?= $item['code'] ?></span>
                                                </a>
                                            </h5>
                                            <input type="hidden" class="product_amount_<?= $item['id'] ?>"
                                                   value="1">
                                            <div class="content_price">
                                                <span id="product_price_promotion_<?= $item['id'] ?>"
                                                      class="price product-price"><?= CUtils::formatNumber($item['price_promotion']) ?>
                                                    Đ</span>
                                                <span id="product_price_<?= $item['id'] ?>"
                                                      class="price old-price"><?= CUtils::formatNumber($item['price']) ?>
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
<?= \frontend\widgets\CartBox::getModal() ?>
