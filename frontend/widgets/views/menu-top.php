<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/20/2016
 * Time: 5:06 PM
 */
use yii\helpers\Url;

?>
<div class="container">
    <div class="row">
    </div>
    <div id="main-menu" class="col-sm-9 main-menu">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="#">MENU</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?= Url::home() ?>">Home</a></li>
                        <li class="dropdown">
                            <a href="category.html" class="dropdown-toggle" data-toggle="dropdown">Độ xe</a>
                            <ul class="dropdown-menu container-fluid">
                                <li class="block-container">
                                    <ul class="block">
                                        <li class="link_container"><a href="#">Mobile</a></li>
                                        <li class="link_container"><a href="#">Tablets</a></li>
                                        <li class="link_container"><a href="#">Laptop</a></li>
                                        <li class="link_container"><a href="#">Memory Cards</a></li>
                                        <li class="link_container"><a href="#">Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <a href="category.html" class="dropdown-toggle" data-toggle="dropdown"></a>
                        <ul class="mega_dropdown dropdown-menu" style="width: 830px;">
                            <li class="block-container col-sm-3">
                                <ul class="block">
                                    <li class="link_container group_header">
                                        <a href="#">Asian</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Vietnamese Pho</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Noodles</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Seafood</a>
                                    </li>
                                    <li class="link_container group_header">
                                        <a href="#">Sausages</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Meat Dishes</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Desserts</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Tops</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Tops</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="block-container col-sm-3">
                                <ul class="block">
                                    <li class="link_container group_header">
                                        <a href="#">European</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Greek Potatoes</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Famous Spaghetti</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Famous Spaghetti</a>
                                    </li>
                                    <li class="link_container group_header">
                                        <a href="#">Chicken</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Italian Pizza</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">French Cakes</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Tops</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Tops</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="block-container col-sm-3">
                                <ul class="block">
                                    <li class="link_container group_header">
                                        <a href="#">FAST</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Hamberger</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Pizza</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Noodles</a>
                                    </li>
                                    <li class="link_container group_header">
                                        <a href="#">Sandwich</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Salad</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Paste</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Tops</a>
                                    </li>
                                    <li class="link_container">
                                        <a href="#">Tops</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="block-container col-sm-3">
                                <ul class="block">
                                    <li class="img_container">
                                        <img src="assets/data/banner-topmenu.jpg" alt="Banner">
                                    </li>
                                </ul>
                            </li>

                        </ul>
                        </li>
                        <li class="dropdown">
                            <a href="category.html" class="dropdown-toggle" data-toggle="dropdown">Giày</a>
                            <ul class="dropdown-menu container-fluid">
                                <li class="block-container">
                                    <ul class="block">
                                        <li class="link_container"><a href="#">Mobile</a></li>
                                        <li class="link_container"><a href="#">Tablets</a></li>
                                        <li class="link_container"><a href="#">Laptop</a></li>
                                        <li class="link_container"><a href="#">Memory Cards</a></li>
                                        <li class="link_container"><a href="#">Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="category.html" class="dropdown-toggle" data-toggle="dropdown">Đồ trang
                                trí</a>
                            <ul class="dropdown-menu container-fluid">
                                <li class="block-container">
                                    <ul class="block">
                                        <li class="link_container"><a href="#">Mobile</a></li>
                                        <li class="link_container"><a href="#">Tablets</a></li>
                                        <li class="link_container"><a href="#">Laptop</a></li>
                                        <li class="link_container"><a href="#">Memory Cards</a></li>
                                        <li class="link_container"><a href="#">Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="category.html" class="dropdown-toggle" data-toggle="dropdown">Quần áo thể
                                thao</a>
                            <ul class="dropdown-menu container-fluid">
                                <li class="block-container">
                                    <ul class="block">
                                        <li class="link_container"><a href="#">Mobile</a></li>
                                        <li class="link_container"><a href="#">Tablets</a></li>
                                        <li class="link_container"><a href="#">Laptop</a></li>
                                        <li class="link_container"><a href="#">Memory Cards</a></li>
                                        <li class="link_container"><a href="#">Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="category.html">Đồ cho thú cưng</a></li>
                        <li><a href="category.html">Tin tức</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
    </div>
</div>