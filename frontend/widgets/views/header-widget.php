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
                <a href="<?= Url::to(['site/contact']) ?>"><?= Yii::t('app', 'Contact') ?></a>
            </div>
            <div class="language ">
                <div class="dropdown">
                    <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                        <img alt="email" src="/images/en.jpg"/>English

                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#"><img alt="email" src="/images/en.jpg"/>English</a></li>
                        <li><a href="#"><img alt="email" src="/images/fr.jpg"/>Japan</a></li>
                    </ul>
                </div>
            </div>
            <div class="support-link">
                <a href="#"><?= Yii::t('app', 'About Us') ?></a>
                <a href="#"><?= Yii::t('app', 'Support') ?></a>
            </div>
            <div id="user-info-top" class="user-info pull-right">
                <div class="dropdown">
                    <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       href="#"><span><?= Yii::t('app', 'Account') ?></span></a>
                    <ul class="dropdown-menu mega_dropdown" role="menu">
                        <?php
                        if (Yii::$app->user->isGuest) {
                            ?>
                            <li><a data-toggle="modal" data-target="#myModal"
                                   href="javascript:void(0)"><?= Yii::t('app', 'Login') ?></a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li>
                                <a href="<?= Url::to(['subscriber/info']) ?>">
                                    <?= Yii::$app->user->identity->full_name ? Yii::$app->user->identity->full_name : Yii::$app->user->identity->username ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['subscriber/favourite']) ?>">
                                    <?= Yii::t('app', 'Favourite') ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (!Yii::$app->user->isGuest) {
                            ?>
                            <li><a class="uppercase" href="<?= Url::to(['site/logout']) ?>"
                                   data-method="post"><?= Yii::t('app', 'Logout') ?></a>
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
            <?= \frontend\widgets\SearchCategory::widget() ?>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 logo">
                <a href="<?= Url::home() ?>">
                    <img id="fix-logo-header" alt="<?= Yii::$app->name ?>"
                         src="<?= \common\models\InfoPublic::getImageFe($info->image_header) ?>"/></a>
            </div>
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