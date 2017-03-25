<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/23/2016
 * Time: 3:38 PM
 */
use common\models\Category;

?>
<?php
if (isset($category)) {
    foreach ($category as $item) {
        /** @var $item Category */
        ?>
        <div class="category-featured">
            <nav class="navbar nav-menu nav-menu-red show-brand">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-brand">
                        <a href="<?= \yii\helpers\Url::to(['category/index', 'id' => $item->id]) ?>">
                            <?= $item->display_name ?>
                        </a>
                    </div>
                    <span class="toggle-menu"></span>
                    <?= \frontend\widgets\MenuContentBody::widget(['id' => $item->id]) ?>
                </div><!-- /.container-fluid -->
                <div id="elevator-1" class="floor-elevator">
                    <a href="#" class="btn-elevator up disabled fa fa-angle-up"></a>
                    <a href="#elevator-2" class="btn-elevator down fa fa-angle-down"></a>
                </div>
            </nav>

            <div class="product-featured clearfix">
                <?= \frontend\widgets\FeatureContent::widget(['id' => $item->id]) ?>
                <div class="product-featured-content">
                    <div class="product-featured-list">
                        <div class="tab-container" style="padding-left: 20px;">
                            <?= \frontend\widgets\ContentContentBody::widget(['id' => $item->id]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

