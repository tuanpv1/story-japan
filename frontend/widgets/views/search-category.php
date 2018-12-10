<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/17/2017
 * Time: 8:26 AM
 */
use yii\helpers\Url;

?>
<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 header-search-box">
    <form class="form-inline" action="<?= Url::to(['content/search']) ?>" method="post">
        <div class="form-group input-serach">
            <input autocomplete="off" id="keyword" name="keyword" type="text" value="<?= !empty($keyword)?''.$keyword:'' ?>" placeholder="<?= Yii::t('app', 'Keyword here ...') ?>">
            <button type="submit" class="pull-right btn-search"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>