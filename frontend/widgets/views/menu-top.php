<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/20/2016
 * Time: 5:06 PM
 */
use yii\helpers\Url;

?>
<div id="main-menu" class="col-sm-9 main-menu">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#">MENU</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?= Url::to(['site/index']) ?>">Trang chủ</a></li>
                    <li class="">
                        <a href="#" class="dropdown-toggle" data-toggle="">Giới thiệu</a>
                    </li>
                    <li><a href="#" class="dropdown-toggle" data-toggle="">Tin tức - sự kiện</a></li>
                    <li class="">
                        <a href="#" class="dropdown-toggle" data-toggle="">Hệ thống đại lý</a>
                    </li>
                    <li class="">
                        <a href="#" class="dropdown-toggle" data-toggle="">Đăng ký</a>
                    </li>
                    <li class="">
                        <a href="#" class="dropdown-toggle" data-toggle="">Đăng nhập</a>
                    </li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</div>
