<?php
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

?>
<div id="replaceHtmlContents">
    <div id="view-product-list" class="view-product-list">
        <!-- PRODUCT LIST -->
        <ul class="row product-list grid">
            <?php
            if (!empty($contents)) { ?>
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
                            <div class="group-price">
                                <span class="product-sale"><?= $item->getTypeName() ?></span>
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
                            </div>
                        </div>
                    </li>
                <?php } ?>
            <?php } else {
                echo "<br>Not found result";
            } ?>
        </ul>
        <!-- ./PRODUCT LIST -->
    </div>
    <!-- ./view-product-list-->
    <div class="sortPagiBar">
        <div class="bottom-pagination">
            
        </div>
    </div>
</div>