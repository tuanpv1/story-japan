<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/23/2016
 * Time: 6:06 PM
 */
use common\models\Category;
use frontend\widgets\ContentContentBody;

?>
<div class="col-sm-2 sub-category-wapper">
    <ul class="sub-category-list">
        <?php
        $i = 0;
        if ($categories) {
            /** @var Category $category */
            foreach ($categories as $category) {
                ?>
                <li class="<?= $i == 0 ? 'active' : '' ?>">
                    <a data-toggle="tab" href="#tab-<?= $i ?>"><?= $category->display_name ?></a>
                </li>
                <?php
                $i++;
            }
        }
        ?>
    </ul>
</div>
<div class="col-sm-6 col-right-tab">
    <div class="product-featured-tab-content">
        <div class="tab-container">
            <?php
            $i = 0;
            if ($categories) {
                /** @var Category $category */
                foreach ($categories as $category) {
                    ?>
                    <div class="tab-panel active" id="tab-<?= $i ?>">
                        <?php
                        $widget = new ContentContentBody();
                        $widget->id = $category->id;
                        $widget::widget();
                        ?>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>
