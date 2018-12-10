<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 10/28/2018
 * Time: 5:13 PM
 */
use common\models\Category;
use yii\helpers\Url;

?>
<?php
$i = 0;
if (isset($category)) {
    foreach ($category as $item) {
        /** @var $item Category */
        ?>
        <div class="box-products new-arrivals-<?= $i ?>">
            <div class="container">
                <div class="box-product-head">
                    <span class="box-title"><?= $item->display_name ?></span>
                    <ul class="box-tabs nav-tab">
                        <li class="active">
                            <a href="<?= Url::to(['category/index', 'id' => $item->id]) ?>"><?= Yii::t('app', 'More') ?></a>
                        </li>
                    </ul>
                </div>
                <div class="box-product-content">
                    <div class="box-product-list">
                        <div class="tab-container">
                            <div id="tab-<?= $i ?>" class="tab-panel active">
                                <ul class="product-list owl-carousel nav-center" data-dots="false" data-loop="true"
                                    data-nav="true" data-margin="10"
                                    data-responsive='{"0":{"items":2},"600":{"items":4},"1000":{"items":6}}'>
                                    <?= \frontend\widgets\ContentContentBody::widget(['id' => $item->id]) ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    }
}
?>