<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/19/2016
 * Time: 9:42 PM
 */
use common\helpers\CUtils;
use common\models\Product;
use yii\helpers\Url;

?>
<div id="tp_id_reload_lmc" class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="#" title="Return to Home"><?= Yii::t('app','Trang chủ') ?></a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page"><?= Yii::t('app','Giỏ hàng') ?></span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading no-line">
            <span class="page-heading-title2"><?= Yii::t('app','Danh sách sản phẩm') ?></span>
        </h2>
        <!-- ../page heading-->
        <div class="page-content page-order">
            <ul class="step">
                <li id="remove_class_1" class="current-step"><span>01. Sản phẩm đã chọn</span></li>
                <li id="add_class_2"><span>02. Thông tin khách hàng</span></li>
                <li id="add_class_3" "><span>03. Hình thức nhận hàng</span></li>
                <li id="add_class_4"><span>04. Xác nhận thông tin và thanh toán</span></li>
                <li id="add_class_5"><span>05. Hoàn thành</span></li>
            </ul>
            <div id="number_total_cart" class="heading-counter warning"><?= Yii::t('app','Tổng số sản phẩm trong giỏ hàng của bạn ') ?>:
                <span><?= $totalAmount?$totalAmount:0 ?> Sản phẩm</span>
            </div>
            <?php if(isset($cart) && !empty($cart)){ ?>
            <div class="order-detail-content">
                <div id="table_list_cart">
                    <table id="list_content" class="table table-bordered table-responsive cart_summary">
                        <thead>
                        <tr>
                            <th class="cart_product"></th>
                            <th>Sản phẩm</th>
                            <th>Tình trạng.</th>
                            <th>Giá tiền</th>
                            <th>Số Lượng</th>
                            <th>Tổng tiền</th>
                            <th  class="action"><i class="fa fa-trash-o"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($cart as $key => $value){ ?>
                            <tr>
                                <td class="cart_product">
                                    <a href="#"><img src="<?= \common\models\Content::getFirstImageLinkFeStatic($value['images']) ?>" alt="<?= $value['display_name'] ?>"></a>
                                </td>
                                <td class="cart_description">
                                    <p class="product-name"><a href="#"><?= $value['display_name'] ?> </a></p>
                                    <small class="cart_ref"><?= Yii::t('app','Mã sản phẩm: #').$value['code']  ?></small><br>
                                    <!--                            <small><a href="#">Color : Beige</a></small><br>-->
                                </td>
                                <td class="cart_avail"><span class="label label-success"><?= \common\models\Content::$listAvailability[$value['availability']] ?></span></td>
                                <td class="price"><span><?= CUtils::formatNumber($value['price_promotion']?$value['price_promotion']:$value['price']) ?> VND</span></td>
                                <td class="qty">
                                    <input id="amount_<?= $key ?>" class="form-control input-sm" type="text" value="<?= $value['amount'] ?>">
                                    <a onclick="addition(<?= $key ?>)" href="javascript:void(0)"><i class="fa fa-caret-up"></i></a>
                                    <a onclick="subtraction(<?= $key ?>)" href="javascript:void(0)"><i class="fa fa-caret-down"></i></a>
                                </td>
                                <td class="price">
                                    <span><?= CUtils::formatNumber(($value['price_promotion']?$value['price_promotion']:$value['price'])*$value['amount']) ?> VND</span>
                                </td>
                                <td class="action">
                                    <a onclick="delCart(<?= $key ?>)" href="javascript:void(0)"><?= Yii::t('app','Xóa') ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2" rowspan="2"></td>
                            <td colspan="3">Tổng tiền trước thuế</td>
                            <td colspan="2"><?= CUtils::formatNumber($total_price?$total_price:0) ?> VND</td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong><?= Yii::t('app','Tổng tiền') ?></strong></td>
                            <td colspan="2"><strong><?= CUtils::formatNumber($total_price?$total_price:0) ?> VND</strong></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div id="info_customer">
                    <h2 class="page-heading"></h2>
                    <h2 class="page-heading"><?= Yii::t('app','Thông tin khách hàng')?></h2>
                    <!-- ../page heading-->
                    <div class="page-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box-authentication">
                                    <h3 class="text-center"><?= Yii::t('app','Thông tin người mua hàng') ?></h3>
                                    <div class="col-md-6 col-sm-12">
                                        <?= Yii::t('app','Họ và tên người mua hàng (*)')?>
                                    </div>
                                    <input class="form-control" type="text" name="full_name" id="full_name" placeholder="Pham Van A" value="<?= !(Yii::$app->user->isGuest)?Yii::$app->user->identity->fullname:"" ?>">
                                    <label id="name_mua" style="color:red;float: right">Không được để trống tên người mua hàng</label><br>

                                    <div class="col-md-6 col-sm-12">
                                        <?= Yii::t('app','Địa chỉ email người mua hàng (*)') ?>
                                    </div>
                                    <input class="form-control" type="email" name="user_email" placeholder="example@gmail.com" id="user_email" value="<?= !(Yii::$app->user->isGuest)?Yii::$app->user->identity->email:"" ?>">
                                    <label style="color:red;float: right">
                                        <span id="email_mua">Không được để trống email người mua hàng</span>
                                        <span id="validate_email_mua">Email người mua hàng không đúng!</span>
                                    </label><br>
                                    <div class="col-md-6 col-sm-12">
                                        <?= Yii::t('app','Số điện thoại người mua hàng (*)') ?>
                                    </div>
                                    <input class="form-control" type="tel" name="user_phone" placeholder="09434xxxxx" id="user_phone" value="<?= !(Yii::$app->user->isGuest)?Yii::$app->user->identity->phone:"" ?>">
                                    <label style="color:red;float: right">
                                        <span id="phone_mua">Không được để trống Số điện thoại người mua hàng</span>
                                        <span id="validate_phone_mua">Số điện thoại bạn nhập không đúng</span>
                                    </label><br>
                                    <div class="col-md-6 col-sm-12">
                                        <?= Yii::t('app','Địa chỉ người mua hàng (*)') ?>
                                    </div>
                                    <input class="form-control" type="text" name="user_adress" placeholder="Số nhà A, Ngõ B, Từ Liêm, Hà Nội" id="user_adress" value="<?= !(Yii::$app->user->isGuest)?Yii::$app->user->identity->address:"" ?>">
                                    <label id="dc_mua" style="color:red;float: right">Không được để trống địa chỉ người mua hàng</label>
                                </div>
                            </div>

                            <div class="col-sm-6 text-center" id="buy_for_friend">
                                <a class="default-btn text-center" onclick="showFormReceiver()" href="javascript:void(0)">
                                    <?= Yii::t('app','Nếu bạn mua hàng tặng người thân click vào đây') ?>
                                </a>
                            </div>

                            <div id="user_receiver_show_clicked" class="col-sm-6">
                                <div class="box-authentication">
                                    <h3 class="text-center"><?= Yii::t('app','Thông tin người nhận hàng')?></h3>
                                    <div class="col-md-6 col-sm-12">
                                        <?= Yii::t('app','Họ và tên người nhận hàng') ?>
                                    </div>
                                    <input class="form-control" type="text" name="fullName" id="fullName" placeholder="Phạm Văn B" value="">
                                    <label id="name_nhan" style="color:red;float: right">Không được để trống tên người nhận hàng</label><br>
                                    <div class="col-md-6 col-sm-12">
                                        <?= Yii::t('app','Địa chỉ Email người nhận hàng') ?>
                                    </div>
                                    <input class="form-control" type="email" name="userEmail" placeholder="exampleb@gmail.com" id="userEmail" value="">
                                    <label style="color:red;float: right">
                                        <span id="email_nhan">Không được để trống email người nhận hàng</span>
                                        <span id="validate_email_nhan">Email người nhận hàng không đúng</span>
                                    </label><br>
                                    <div class="col-md-6 col-sm-12">
                                        <?= Yii::t('app','Số điện thoại người nhận hàng') ?>
                                    </div>
                                    <input class="form-control" type="tel" name="userPhone" placeholder="09134xxxxxx" id="userPhone" value="">
                                    <label style="color:red;float: right">
                                        <span id="phone_nhan">Không được để trống Số điện thoại người nhận hàng</span>
                                        <span id="validate_phone_nhan">Số điện thoại bạn nhập không đúng!</span>
                                    </label><br>
                                    <div class="col-md-6 col-sm-12">
                                        <?= Yii::t('app','Địa chỉ người nhận hàng') ?>
                                    </div>
                                    <input class="form-control" type="text" name="userAdress" placeholder="Số nhà A, Ngõ B, Hồng Bàng, Hải Phòng" id="userAdress" value="">
                                    <label id="dc_nhan" style="color:red;float: right">Không được để trống địa chỉ người nhận hàng</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="option_receiver">
                    <h2 class="page-heading"></h2>
                    <h2 class="page-heading"><?= Yii::t('app','Hình thức nhận hàng') ?></h2>
                    <!-- ../page heading-->
                    <div class="page-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box-authentication">
                                    <h3 class="text-center"><?= Yii::t('app','Nhận hàng tại nhà') ?></h3>
                                    <input class="form-control" type="radio" name="option" value="home" checked>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box-authentication">
                                    <h3 class="text-center"><?= Yii::t('app','Nhận hàng tại cửa hàng') ?></h3>
                                    <input class="form-control" type="radio" name="option" value="store">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <label id="c_validate" style="color:red">Vui lòng nhập đầy đủ các trường có dấu * để gửi yêu cầu đơn hàng</label>
                </div>
                <div class="cart_navigation">
                    <a class="prev-btn" href="<?= Url::to(['site/index']) ?>"><?= Yii::t('app','Tiếp tục mua hàng') ?></a>
                    <a class="next-btn" id="input_info" onclick="onInputInfo()" href="javascript:void(0)"><?= Yii::t('app','Điền thông tin đặt hàng') ?></a>
                    <a class="next-btn" id="chose_receiver" onclick="choseReceiverContent()" href="javascript:void(0)"><?= Yii::t('app','Chọn hình thức nhận hàng') ?></a>
                    <a class="next-btn" id="show_infor_input" onclick="showAllInfo()" href="javascript:void(0)"><?= Yii::t('app','Xem lại thông tin') ?></a>
                    <a class="next-btn" id="checkout" onclick="checkOutInfo()" href="javascript:void(0)"><?= Yii::t('app','Đặt hàng') ?></a>
                </div>
            </div>
            <?php }else{
                ?>
                <div class="cart_navigation">
                    <a class="prev-btn" href="<?= Url::to(['site/index']) ?>"><?= Yii::t('app','Tiếp tục mua hàng') ?></a>
                </div>
                <?php
            } ?>
        </div>
    </div>
</div>