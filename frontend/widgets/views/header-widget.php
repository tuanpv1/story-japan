<?php
use frontend\widgets\FormLogin;
use frontend\widgets\MenuRight;
use frontend\widgets\MenuTop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div id="header" class="header">
    <div class="top-header">
        <div class="container">
            <div class="nav-top-links">
                <a class="first-item" href="tel:841688929947"><img alt="phone" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/phone.png" />(84) 1688 929 947</a>
                <a href="<?= Url::to(['site/index']) ?>"><img alt="email" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/email.png" />Liên hệ với chúng tôi ngay bây giờ!</a>
            </div>
            <div class="currency ">
                <div class="dropdown">
                    <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Mạng xã hội</a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a target="_blank" href="https://www.facebook.com/hung.chelsea.12">Facebook</a></li>
                        <li><a target="_blank" href="https://www.facebook.com/hung.chelsea.12">Google+</a></li>
                    </ul>
                </div>
            </div>

            <div class="support-link">
                <a href="#">Dịch vụ</a>
                <a href="#">Hỗ trợ</a>
            </div>

            <div id="user-info-top" class="user-info pull-right">
                <div class="dropdown">
                    <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><span>Tài khoản</span></a>
                    <ul class="dropdown-menu mega_dropdown" role="menu">
                        <?php
                        if(Yii::$app->user->isGuest){
                            ?>
                            <li><a data-toggle="modal" data-target="#myModal" href="javascript:void(0)">Đăng nhập</a></li>
                            <?php
                        }else{
                            ?>
                            <li><a class="uppercase" href="<?= Url::to(['subcriber/info']) ?>"><?= Yii::$app->user->identity->fullname?Yii::$app->user->identity->fullname:Yii::$app->user->identity->username ?></a></li>
                            <li><a href="<?= Url::to(['#']) ?>">Đơn hàng</a></li>
                            <?php
                        }
                        ?>
                        <li><a href="#">So sánh</a></li>
                        <li><a href="#">Yêu thích</a></li>
                        <?php
                        if(!Yii::$app->user->isGuest){
                            ?>
                            <li><a href="<?= \yii\helpers\Url::to(['site/logout']) ?>" data-method="post">Đăng xuất</a></li>
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
                <a href="<?= Url::to(['site/index']) ?>"><img alt="Kute shop - GFXFree.Net" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/logo.png" /></a>
            </div>
            <?= \frontend\widgets\SearchCategory::widget() ?>
            <div id="tp_id_reload">
                <?= \frontend\widgets\CartBox::widget() ?>
            </div>
        </div>

    </div>
    <!-- END MANIN HEADER -->
    <div id="nav-top-menu" class="nav-top-menu">
        <div class="container">
            <div class="row">
                <?= \frontend\widgets\MenuLeft::widget()?>
                <?= MenuTop::widget() ?>
            </div>
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
</div>
<!-- end header -->


<!-- Start Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="box-authentication tp_001">
                <?= FormLogin::widget()?>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->