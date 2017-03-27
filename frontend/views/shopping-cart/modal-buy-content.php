<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 3/27/2017
 * Time: 8:48 AM
 */
?>
<div class="modal fade" id="modal_show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="box-authentication">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box-authentication">
                            <img id="image_product" src="">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box-authentication">
                            <div class="row">
                                <h3 class="text-center">Đã thêm sản phẩm: <br> <span id="name_product"></span></h3>
                                <p><span id="code_product"></span></p>
                                <p> <?= Yii::t('app','Giá khuyến mãi: ') ?><span id="price_promotion_product"></span></p>
                                <p> <?= Yii::t('app','Giá gốc: ')?><span id="price_product"></span></p>
                                <p> <?= Yii::t('app','Số lượng: ') ?><span id="quality_product"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

