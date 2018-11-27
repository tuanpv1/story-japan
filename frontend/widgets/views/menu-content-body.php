<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/23/2016
 * Time: 6:06 PM
 */
use common\models\Category;
use frontend\widgets\ContentContentBody;
use yii\helpers\Url;

?>
<div class="col-sm-1 sub-category-wapper">
    <ul class="sub-category-list">
        <?php
        $i = 1;
        if ($categories) {
            $n = count($categories);
            $height = 566/$n;
            /** @var Category $category */
            foreach ($categories as $category) {
                ?>
                <li class="<?= $i == 1 ? 'active' : '' ?>" style="line-height: <?= $height ?>px">
                    <a href="<?= Url::to(['category/index','id' => $category->id]) ?>"><?= $category->display_name ?></a>
                </li>
                <?php
                $i++;
            }
        }
        ?>
    </ul>
</div>
<div class="col-sm-7 col-right-tab">
    <div class="product-featured-tab-content">
        <div class="tab-container">
            <?php
            $i = 1;
            if ($categories) {
                /** @var Category $category */
                foreach ($categories as $category) {
                    ?>
                    <div class="tab-panel <?= $i == 1 ? 'active' : '' ?>" id="tab-<?= $category->id ?>">
                        <?= ContentContentBody::widget(['id' => $category->id]) ?>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>
