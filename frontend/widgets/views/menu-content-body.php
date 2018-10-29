<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/23/2016
 * Time: 6:06 PM
 */
?>
<div class="col-sm-2 sub-category-wapper">
    <ul class="sub-category-list">
        <?php
        $i = 0;
        if ($cat) {
            foreach ($cat as $key => $item) {
                /** @var $item \common\models\Category */
                if ($i == 0) {
                    ?>
                    <li class="<?= $i == 0 ? 'active' : '' ?>">
                        <a data-toggle="tab" href="#tab-<?= $i ?>"><?= $item->display_name ?></a>
                    </li>
                    <?php
                }
                $i++;
            }
        }
        ?>
    </ul>
</div>
