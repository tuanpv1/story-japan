<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 11/2/2018
 * Time: 7:53 AM
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/20/2017
 * Time: 8:22 AM
 */
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

/** @var \common\models\Category $category */

?>
<div class="columns-container">
    <div class="container" id="columns">
        <div class="breadcrumb clearfix">
            <a class="home" href="<?= Url::to(['site/index']) ?>" title="<?= Yii::$app->name ?>">
                <?= Yii::t('app', 'Home') ?>
            </a>
            <span class="navigation-pipe">&nbsp;</span>
            <a href="#" title="<?= Yii::t('app','Search manga') ?>"><?= Yii::t('app','Search manga') ?></a>
        </div>
        <!-- row -->
        <div class="row">
            <!-- Left colunm -->
            <div class="column col-xs-12 col-sm-3" id="left_column">
                <?= \frontend\widgets\SearchPriceWidget::widget() ?>
            </div>
            <!-- ./left colunm -->
            <!-- Center colunm-->
            <div class="center_column col-xs-12 col-sm-9" id="center_column">
                <!-- ./category-slider -->
                <div id="replaceHtmlContents">
                    <!-- subcategories -->
                    <div class="subcategories">
                        <ul>
                            <li class="current-categorie">
                                <a href="#"><?= Yii::t('app','Search') ?></a>
                            </li>
                            <?php if (!empty($category)) { ?>
                                <li>
                                    <a href="<?= Url::to(['category/index', 'id' => $category->id]) ?>"><?= $category->display_name ?> </a>
                                    <input type="hidden" id="idCategorySearch" value="<?= $category->id ?>">
                                </li>
                            <?php } ?>
                            <li>
                                <a href="#"><?= Yii::t('app','Keyword input ') ?> "<?= $keyword ?>"</a>
                                <input type="hidden" id="keywordSearch" value="<?= $keyword ?>">
                            </li>
                        </ul>
                    </div>
                    <!-- ./subcategories -->
                    <!-- view-product-list-->
                    <div id="view-product-list" class="view-product-list">
                        <h2 class="page-heading">
                            <span class="page-heading-title"><?= Yii::t('app','Result for keyword ') ?> "<?= $keyword ?>"</span>
                        </h2>
                        <ul class="display-product-option">
                            <li class="view-as-grid selected">
                                <span><?= Yii::t('app','grid') ?></span>
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
                                                <span class="price old-price"><?= Yii::t('app','Author:') ?> <?= $item->author?$item->author:Yii::t('app','updating...') ?></span>
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
                                            onclick="loadMore('<?= Url::to(['content/get-more-contents']) ?>');">Xem
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
