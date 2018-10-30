<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 10/28/2018
 * Time: 4:07 PM
 */
use frontend\widgets\FormLogin;
use frontend\widgets\MenuRight;
use frontend\widgets\MenuTop;
use yii\helpers\Url;

/** @var $info \common\models\InfoPublic */
?>
<div id="header" class="header">
    <div class="top-header">
        <div class="container">
            <div class="nav-top-links">
                <a class="first-item" href="#"><img alt="phone" src="/images/phone.png"/><?= $info->phone ?></a>
                <a href="<?= Url::to(['site/contact']) ?>">Liên hệ</a>
            </div>

            <div id="user-info-top" class="user-info pull-right">
                <div class="dropdown">
                    <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       href="#"><span>Tài khoản</span></a>
                    <ul class="dropdown-menu mega_dropdown" role="menu">
                        <?php
                        if (Yii::$app->user->isGuest) {
                            ?>
                            <li><a data-toggle="modal" data-target="#myModal" href="javascript:void(0)">Đăng nhập</a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li><a class="uppercase"
                                   href="<?= Url::to(['subcriber/info']) ?>"><?= Yii::$app->user->identity->fullname ? Yii::$app->user->identity->fullname : Yii::$app->user->identity->username ?></a>
                            </li>
                            <li><a href="<?= Url::to(['#']) ?>">Đơn hàng</a></li>
                            <?php
                        }
                        ?>
                        <li><a href="#">So sánh</a></li>
                        <li><a href="#">Yêu thích</a></li>
                        <?php
                        if (!Yii::$app->user->isGuest) {
                            ?>
                            <li><a href="<?= \yii\helpers\Url::to(['site/logout']) ?>" data-method="post">Đăng xuất</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div class="container main-header">
        <div class="row">
            <div class="col-xs-12 col-sm-3 logo">
                <a href="<?= Url::home() ?>">
                    <img style="height:64px;width:auto" alt="<?= Yii::$app->name ?>"
                         src="<?= \common\models\InfoPublic::getImage($info->image_header) ?>"/></a>
            </div>
            <?= \frontend\widgets\SearchCategory::widget() ?>
            <div id="tp_id_reload">
                <?= \frontend\widgets\CartBox::widget() ?>
            </div>
        </div>

    </div>
    <!-- END MANIN HEADER -->
    <div id="nav-top-menu" class="nav-top-menu">
        <?= MenuTop::widget() ?>
        <!-- userinfo on top-->
        <div id="form-search-opntop">
        </div>
        <!-- userinfo on top-->
        <div id="user-info-opntop">
        </div>
        <!-- CART ICON ON MMENU -->
        <div id="shopping-cart-box-ontop">
            <i class="fa fa-shopping-cart"></i>
            <div class="shopping-cart-box-ontop-content"></div>
        </div>
    </div>
</div>

<!-- Start Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="box-authentication tp_001">
                <?= FormLogin::widget() ?>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->