<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 10/28/2018
 * Time: 5:13 PM
 */
use common\models\Category;

?>
<?php
if (isset($category)) {
    foreach ($category as $item) {
        /** @var $item Category */
        ?>
        <div class="category-featured fashion">
            <nav class="navbar nav-menu show-brand">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-brand"><a
                                href="<?= \yii\helpers\Url::to(['category/index', 'id' => $item->id]) ?>">
                            <img alt="fashion" src="<?= $item->getImageLink() ?>"/>
                            <?= $item->display_name ?>
                        </a>
                    </div>
                    <span class="toggle-menu"></span>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse"></div><!-- /.navbar-collapse -->
                </div>
            </nav>
            <div class="product-featured clearfix">
                <div class="row">
                    <div class="col-sm-4 sub-category-wapper">
                        <div class="banner-img">
                            <a href="#"><img src="assets/data/banner-product1.jpg" alt="Banner Product"></a>
                        </div>
                    </div>
                    <?= \frontend\widgets\MenuContentBody::widget(['id' => $item->id]) ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>