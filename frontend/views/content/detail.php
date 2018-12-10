<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/17/2017
 * Time: 8:45 AM
 */
use common\models\InfoPublic;
use yii\helpers\Url;

$info = InfoPublic::findOne(InfoPublic::ID_DEFAULT);
?>
<?php /** @var \common\models\Content $content */ ?>
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <?php if (isset($content)) { ?>
            <?= \frontend\widgets\FindBreadcrumb::getBreadcrumb($content->id) ?>
        <?php } ?>
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">
            <!-- Center colunm-->
            <div class="center_column col-xs-12 col-sm-12" id="center_column">
                <!-- Product -->
                <?php if (isset($content)) { ?>
                    <div id="product">
                        <div id="replaceContentChapter">
                            <div class="primary-box row">
                                <div class="pb-left-column col-xs-12 col-sm-6">
                                    <!-- product-imge-->
                                    <div class="product-image">
                                        <img style="height: 200px; width: auto;"
                                             src="<?= $content->getFirstImageLinkFE('product-s3-850x1036.jpg') ?>"
                                             alt="<?= $content->display_name ?>">
                                    </div>
                                    <!-- product-imge-->
                                </div>
                                <div class="pb-right-column col-xs-12 col-sm-6">
                                    <h1 id="product_name_<?= $content->id ?>"
                                        class="product-name"><?= $content->display_name ?></h1>
                                    <div class="info-orther">
                                        <p id="product_code_<?= $content->id ?>">
                                            <b><?= Yii::t('app', 'Code: #') ?></b>
                                            <span><?= $content->code ?></span></p>
                                        <p><b><?= Yii::t('app', 'Type: ') ?></b><span
                                                    class="in-stock"><?= $content->getTypeName() ?></span>
                                        </p>
                                    </div>
                                    <div class="product-desc">
                                        <?= $content->short_description ? $content->short_description : Yii::t('app', 'Đang cập nhật') ?>
                                    </div>
                                    <div class="form-action">
                                        <div class="button-group">
                                            <?php if($favourite){ ?>
                                                <a class="btn-own-css" href="javascript:void(0)"
                                                   onclick="removeFavourite(<?= $content->id ?>,'<?= Url::to(['subscriber/remove-favourite']) ?>')">
                                                    <?= Yii::t('app', 'Remove favourite') ?></a>
                                            <?php }else{ ?>
                                                <a class="btn-own-css" href="javascript:void(0)"
                                                   onclick="addFavourite(<?= $content->id ?>,'<?= Url::to(['subscriber/add-favourite']) ?>')">
                                                    <?= Yii::t('app', 'Add to my favourite') ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($content->is_series) { ?>
                                <!-- box child chapter -->
                                <?= \frontend\widgets\ProductLike::getEpisode($content->id) ?>
                                <!-- end box child chapter -->
                            <?php } else { ?>
                                <!-- tab product -->
                                <div class="product-tab">
                                    <ul class="nav-tab">
                                        <li class="active">
                                            <a aria-expanded="false" data-toggle="tab"
                                               href="#product-detail"><?= Yii::t('app', 'Content') ?></a>
                                        </li>
                                    </ul>
                                    <div class="tab-container">
                                        <div id="product-detail" class="tab-panel active">
                                            <?= $content->description ? $content->description : Yii::t('app', 'Đang cập nhật') ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./tab product -->
                                <?php if ($content->parent_id) { ?>
                                    <div class="cart_navigation">
                                        <a class="prev-btn btn-own-css"
                                           href="javascript:void(0)"
                                           onclick="preEpisode(<?= $content->id ?>, '<?= Url::to(['content/pre-episode']) ?>')">
                                            <?= Yii::t('app', 'Pre Chapter') ?>
                                        </a>
                                        <a class="next-btn btn-own-css"
                                           onclick="nextEpisode(<?= $content->id ?>, '<?= Url::to(['content/next-episode']) ?>')"
                                           href="javascript:void(0)">
                                            <?= Yii::t('app', 'Next chapter') ?>
                                        </a>
                                    </div><br>
                                <?php } ?>
                            <?php } ?>
                        </div>
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
