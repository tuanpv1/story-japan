<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 1/5/2017
 * Time: 8:27 AM
 */
use common\helpers\CUtils;
use common\models\Content;
use yii\helpers\Url;

?>
<?php
if ($contents) {
    /** @var Content $content */
    foreach ($contents as $content) {
        ?>
        <li>
            <div class="left-block">
                <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                    <img style="height: 200px" class="img-responsive" alt="product"
                         src="<?= $content->getFirstImageLinkFE('p14.jpg') ?>"/></a>
                <div class="add-to-cart">
                    <a title="Add to Cart" href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                        <?= Yii::t('app', 'Read more ') ?>
                    </a>
                </div>
            </div>
            <div class="right-block">
                <h5 class="product-name">
                    <a href="<?= Url::to(['content/detail', 'id' => $content->id]) ?>">
                        <?= ucfirst(CUtils::substr($content->display_name, 15)) ?>
                    </a>
                </h5>
                <div class="content_price">
                    <span class="price product-price"><?= Yii::t('app', 'Author: ') ?><?= $content->author ? $content->author : Yii::t('app', 'Updating...') ?></span>
                </div>
            </div>
            <div class="price-percent-reduction2">
                <?= $content->getTypeName() ?>
            </div>
            <div class="group-price">
                <span class="product-sale"><?= $content->view_count ? $content->view_count : 0 ?> <i
                            class="glyphicon glyphicon-eye-open"></i></span>
            </div>
        </li>
        <?php
    }
} else {
    echo Yii::t('app', 'Not content to show');
}
?>
