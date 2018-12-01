<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/17/2017
 * Time: 8:26 AM
 */
use yii\helpers\Url;

?>
<div class="col-xs-8 col-sm-8 header-search-box">
    <form class="form-inline" action="<?= Url::to(['content/search']) ?>" method="post">
        <div class="form-group form-category">
            <select name="category_id" class="select-category">
                <option value="0"><?= Yii::t('app', 'Tất cả') ?></option>
                <?php if (isset($category)) { ?>
                    <?php foreach ($category as $item) { ?>
                        <?php /** @var \common\models\Category $item */ ?>
                        <option value="<?= $item->id ?>"><?= $item->display_name ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <div class="form-group input-serach">
            <input autocomplete="off" id="keyword" name="keyword" type="text" value="<?= !empty($keyword)?''.$keyword:'' ?>" placeholder="<?= Yii::t('app', 'Tìm kiếm') ?>...">
        </div>
        <button type="submit" class="pull-right btn-search"></button>
    </form>
</div>