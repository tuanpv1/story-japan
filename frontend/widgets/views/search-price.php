<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 11/2/2018
 * Time: 8:06 AM
 */
use common\helpers\CUtils;

?>
<div class="block left-module">
    <p class="title_block">Lọc theo khoảng giá</p>
    <div class="block_content">
        <!-- layered -->
        <div class="layered layered-filter-price">
            <!-- filter price -->
            <div class="layered_subtitle">Tìm kiếm theo giá</div>
            <div class="layered-content slider-range">
                <div data-label-reasult="Khoảng:" data-min="0" data-max="<?= $info->max_price_search ?>" data-unit=" Đ"
                     class="slider-range-price" data-value-min="500000" data-value-max="1000000"></div>
                <div class="amount-range-price">Khoảng: 500,000 - 1,000,000 Đ</div>
                <a href="#" id="idSearchPrice" >Lọc theo giá đã chọn: <i class="glyphicon glyphicon-play"></i></a>
            </div>
            <!-- ./filter price -->
        </div>
        <!-- ./layered -->
    </div>
</div>