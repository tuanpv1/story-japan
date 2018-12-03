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
                <button id="idSearchPrice"  class="btn btn-danger">Lọc theo giá đã chọn</button>
            </div>
            <!-- ./filter price -->
            <div class="amount-range-price">Hoặc chọn</div>
            <ul class="check-box-list">
                <li>
                    <input type="checkbox" id="p1" name="cc" value="0,2000000"/>
                    <label for="p1">
                        <span class="button"></span>
                        Dưới 2 triệu
                    </label>
                </li>
                <li>
                    <input type="checkbox" id="p2" name="cc" value="2000000,4000000"/>
                    <label for="p2">
                        <span class="button"></span>
                        Từ 2 triệu - 4 triệu
                    </label>
                </li>
                <li>
                    <input type="checkbox" id="p3" name="cc" value="4000000,7000000"/>
                    <label for="p3">
                        <span class="button"></span>
                        Từ 4 triệu - 7 triệu
                    </label>
                </li>
                <li>
                    <input type="checkbox" id="p4" name="cc" value="7000000,13000000"/>
                    <label for="p4">
                        <span class="button"></span>
                        Từ 7 triệu - 13 triệu
                    </label>
                </li>
                <li>
                    <input type="checkbox" id="p5" name="cc" value="13000000,0"/>
                    <label for="p5">
                        <span class="button"></span>
                        Trên 13 triệu
                    </label>
                </li>
            </ul>
        </div>
        <!-- ./layered -->
    </div>
</div>