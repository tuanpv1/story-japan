<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 12/10/2018
 * Time: 9:31 AM
 */
use yii\helpers\Url;

?>
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
            <h1 class="product-name">
                <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>" id="url_new_chapter">
                    <?= $content->display_name ?>
                </a>
                <input type="hidden" id="product_name" value="<?= $content->display_name ?>">
            </h1>
            <div class="info-orther">
                <p id="product_code_<?= $content->id ?>">
                    <b><?= Yii::t('app', 'Code: #') ?></b>
                    <span><?= $content->code ?></span></p>
                <p><b><?= Yii::t('app', 'Type: ') ?></b><span
                            class="in-stock"><?= $content->getTypeName() ?></span>
                </p>
            </div>
            <div class="product-desc">
                <?= $content->short_description ? $content->short_description : Yii::t('app', 'Updating ...') ?>
            </div>
            <div class="form-action">
                <div class="button-group">
                    <a class="btn-own-css" href="javascript:void(0)"
                       onclick="addFavourite(<?= $content->id ?>,'<?= Url::to(['subscriber/add-favourite']) ?>')"><?= Yii::t('app', 'Add to my favourite') ?></a>
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
                    <?= $content->description ? $content->description : Yii::t('app', 'Updating ...') ?>
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