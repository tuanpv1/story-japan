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
                            <?= $item->display_name ?>
                        </a>
                    </div>
                    <span class="toggle-menu"></span>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav hidden-lg">
                            <?= \frontend\widgets\MenuContentBody::widget(['id' => $item->id, 'show_phone' => $item->id]) ?>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>
            </nav>
            <div class="product-featured clearfix">
                <div class="row">
                    <div class="col-sm-4 sub-category-wapper">
                        <div class="banner-img">
                            <a href="<?= Url::to(['category/index','id' => $item->id]) ?>"><img  style="height: 570px" src="<?= $item->getImageLinkContentFeature() ?>" alt="<?= $item->display_name ?>"></a>
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