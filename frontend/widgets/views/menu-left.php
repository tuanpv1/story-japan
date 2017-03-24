<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/21/2016
 * Time: 12:44 PM
 */
use frontend\widgets\MenuRight;

?>
<div class="col-sm-3" id="box-vertical-megamenus">
    <div class="box-vertical-megamenus">
        <h4 class="title active">
            <span class="title-menu">Danh Mục</span>
            <span class="btn-open-mobile pull-right"><i class="fa fa-bars"></i></span>
        </h4>
        <div class="vertical-menu-content is-home">
            <ul class="vertical-menu-list">
                <?php
                if(isset($menu) && !empty($menu)){
                    foreach($menu as $item){
                        /** @var \common\models\Category $item */
                        ?>
                        <li>
                            <a href="<?= \yii\helpers\Url::to(['category/index','id'=>$item->id]) ?>">
                                <?= $item->display_name ?>
                            </a>
                            <?= \frontend\widgets\MenuLeft::getChildMenuLeft($item->id) ?>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <div class="all-category"><span class="open-cate">All Categories</span></div>
        </div>
    </div>
</div>
