<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 3/24/2017
 * Time: 10:59 PM
 */
?>
<div class="vertical-dropdown-menu">
    <div class="vertical-groups">

        <div class="mega-group col-sm-4">

            <ul class="group-link-default">
                <?php
                if (isset($all_child) && !empty($all_child)) {
                    foreach ($all_child as $item) {
                        /** @var \common\models\Category $item */
                        ?>
                        <li>
                            <a href="<?= \yii\helpers\Url::to(['category/index', 'id' => $item->id]) ?>"><?= $item->display_name ?></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
