<?php
use common\models\InfoPublic;
use yii\helpers\Url;

/** @var  $info InfoPublic */
?>
<footer id="footer">
    <div class="container">
        <!-- introduce-box -->
        <div id="introduce-box" class="row">
            <div class="col-md-3">
                <div id="address-box">
                    <a href="#"><img src="<?= InfoPublic::getImage($info->image_header) ?>"
                                     alt="<?= Yii::$app->name ?>"/></a>
                    <div id="address-list">
                        <div class="tit-name">Địa chỉ:</div>
                        <div class="tit-contain"><?= $info->address ?>.</div>
                        <div class="tit-name">Phone:</div>
                        <div class="tit-contain"><?= $info->phone ?></div>
                        <div class="tit-name">Email:</div>
                        <div class="tit-contain"><?= $info->email ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="introduce-title"><?= Yii::$app->name ?></div>
                        <ul id="introduce-company" class="introduce-list">
                            <li><a href="<?= Url::to(['site/about']) ?>">Giới thiệu</a></li>
                            <li><a href="<?= Url::to(['site/contact']) ?>">Liên hệ</a></li>
                            <li>
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <a data-toggle="modal" data-target="#myModal" href="javascript:void(0)">Thông tin
                                        tài khoản</a>
                                <?php } else { ?>
                                    <a href="<?= Url::to(['subscriber/info']) ?>">Thông
                                        tin <?= Yii::$app->user->identity->username ?></a>
                                <?php } ?>
                            </li>
                            <li>
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <a data-toggle="modal" data-target="#myModal" href="javascript:void(0)">Thông
                                        tin</a>
                                <?php } else { ?>
                                    <a href="<?= Url::to(['subscriber/info']) ?>">Đơn hàng</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="introduce-title">Truy cập nhanh</div>
                        <ul id="introduce-Account" class="introduce-list">
                            <?php
                            iF ($cats) {
                                /** @var \common\models\Category $category */
                                foreach ($cats as $category) {
                                    ?>
                                    <li>
                                        <a href="<?= Url::to(['category/index', 'id' => $category->id]) ?>"><?= $category->display_name ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="contact-box">
                    <div class="introduce-title">Kết nối cùng <?= Yii::$app->name ?></div>
                    <div class="social-link">
                        <a href="<?= $info->link_face ?>"><i class="fa fa-facebook"></i></a>
                        <a href="<?= $info->youtube ?>"><i class="fa fa-youtube-play"></i></a>
                        <a href="<?= $info->twitter ?>"><i class="fa fa-twitter"></i></a>
                        <a href="<?= $info->google ?>"><i class="fa fa-google-plus"></i></a>
                    </div>
                </div>
            </div>
        </div><!-- /#introduce-box -->

        <div id="footer-menu-box">
            <div class="col-sm-12">
                <ul class="footer-menu-list">
                    <li><a href="<?= Url::to(['site/about']) ?>"><?= Yii::$app->name ?></a></li>
                </ul>
            </div>
            <p class="text-center">Copyrights &#169; 2018 - <?= date('Y') . ' ' . Yii::$app->name ?> . All Rights
                Reserved. Designed by TP</p>
        </div><!-- /#footer-menu-box -->
    </div>
</footer>

<a href="#" class="scroll_top" title="Scroll to Top" style="display: inline;">Scroll</a>