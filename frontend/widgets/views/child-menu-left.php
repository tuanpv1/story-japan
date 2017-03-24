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
        <?php
        if(isset($all_child) && !empty($all_child)){
            foreach($all_child as $item){ /** @var \common\models\Category $item */
                ?>
                    <div class="mega-group col-sm-4">
                        <h4 class="mega-group-header">
                            <span>
                                <a href="<?= \yii\helpers\Url::to(['category/index','id'=>$item->id]) ?>">
                                    <?= $item->display_name ?>
                                </a>
                            </span>
                        </h4>
                    </div>
                <?php
            }
        }
        ?>
    </div>
</div>
