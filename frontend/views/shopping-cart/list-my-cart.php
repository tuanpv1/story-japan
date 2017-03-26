<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/19/2016
 * Time: 9:42 PM
 */
use common\models\Product;
use yii\helpers\Url;

?>
<section id="cart_items">
    <div class="container"">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?= Url::to(['site/index']) ?>">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                <tr class="cart_menu">
                    <td width="20%" class="image">Sản phẩm</td>
                    <td width="30%" class="description"></td>
                    <td width="15%" class="price">Giá</td>
                    <td width="15%" class="quantity">Số Lượng</td>
                    <td width="15%" class="total">Tổng tiền</td>
                    <td width="5%"></td>
                </tr>
                </thead>
                <tbody>
                <?php
                    if(isset($cart) && $cart != null){
//                        echo "<pre>"; print_r($cart);die();
                        foreach($cart as $key =>$value){
                            $total = 0;
                            if($value['sale'] == 0){
                                $total =  $value['amount']*$value['price'];
                            }else{
                                $sal = ($value['price']*(100-$value['sale']))/100;
                                $total = $sal * $value['amount'];
                            }
                            ?>
                            <tr>
                                <td class="cart_product">
                                    <a href="<?= Url::to(['product/detail','id'=>$value['id']]) ?>"><img style="width: 150px" src="<?= Product::getFirstImageLinkTP($value['image']) ?>" alt="<?= $value['name'] ?>"></a>
                                </td>
                                <td class="cart_description">
                                    <p><a href="<?= Url::to(['product/detail','id'=>$value['id']]) ?>"><?= $value['name'] ?></a></p>
                                </td>
                                <?php
                                    if($value['sale']==0){
                                        ?>
                                        <td class="cart_price">
                                            <p><?= Product::formatNumber($value['price']).' VND'?></p>
                                        </td>
                                        <?php
                                    }else{
                                        ?>
                                        <td class="cart_price">
                                            <p><?= Product::formatNumber(($value['price']*(100-$value['sale']))/100).' VND'?></p>
                                            <p style="font-size: 12px">Giá cũ: <span class="tp_002"><?= Product::formatNumber($value['price']) ?></span> VND</p>
                                        </td>
                                        <?php
                                    }
                                ?>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <a class="cart_quantity_up" onclick="addition(<?= $key ?>)" href="javascript:void(0)"> + </a>
                                        <input class="cart_quantity_input" onkeyup="updateCart(<?= $key ?>)" type="text" name="amount_<?= $key ?>" id="amount_<?= $key ?>" value="<?= $value['amount'] ?>" autocomplete="off" size="2">
                                        <a class="cart_quantity_down" onclick="subtraction(<?= $key ?>)" href="javascript:void(0)"> - </a>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price"><?= Product::formatNumber($total).' VND' ?></p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" onclick="delCart(<?= $key ?>)" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                Hiện giỏ hàng của bạn đang trống
                            </td>
                        </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>Giá trị đơn hàng</h3>
        </div>
        <div class="row">

            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng tiền <span><?=Product::formatNumber($total_all).' VND'?></span></li>
                        <li>Số lượng sản phẩm <span> <?= $totalAmount ?> Sản phẩm</span></li>
                        <li>Phí ship <span>Miễn phí</span></li>
                        <li>Số tiền phải thanh toán <span><?=Product::formatNumber($total_all).' VND'?></span></li>
                    </ul>
                    <?php
                        if($cart){
                            ?>
                            <a class="btn btn-default check_out" onclick="inPutInfo()" href="javascript:void(0)">Tiến hành thanh toán</a>
                            <?php
                        }else{
                            ?>
                            <a class="btn btn-default check_out" href="<?= Url::to(['site/index']) ?>">Tiếp tục mua hàng</a>
                            <?php
                        }
                    ?>
                </div>
            </div>

            <div id="show_tp" class="col-sm-6">
                <div class="shopper-info">
                    <p>Thông tin người mua</p>
                    <form>
                        <input type="text" name="full_name" id="full_name" placeholder="Họ và tên người mua hàng" value="<?= !(Yii::$app->user->isGuest)?Yii::$app->user->identity->fullname:"" ?>">
                        <label id="name_mua" style="color:red">Không được để trống tên người mua hàng</label>
                        <input type="email" name="user_email" placeholder="Địa chỉ email người mua hàng" id="user_email" value="<?= !(Yii::$app->user->isGuest)?Yii::$app->user->identity->email:"" ?>">
                        <label id="email_mua" style="color:red">Không được để trống email người mua hàng</label><br>
                        <label id="validate_email_mua"  style="color: red">Email không đúng! </label>
                        <input type="tel" name="user_phone" placeholder="Số điện thoại người mua hàng" id="user_phone" value="<?= !(Yii::$app->user->isGuest)?Yii::$app->user->identity->phone:"" ?>">
                        <label id="phone_mua" style="color:red">Không được để trống Số điện thoại người mua hàng</label><br>
                        <label id="validate_phone_mua"  style="color: red" >Số điện thoại bạn nhập không đúng </label>
                        <input type="text" name="user_adress" placeholder="Địa chỉ người mua hàng" id="user_adress" value="<?= !(Yii::$app->user->isGuest)?Yii::$app->user->identity->address:"" ?>">
                        <label id="dc_mua" style="color:red">Không được để trống địa chỉ người mua hàng</label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->

<section id="do_action_tp">
    <div class="container">
        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-6 clearfix">
                    <div class="shopper-info">
                        <p>Thông tin người nhận</p>
                            <input type="checkbox" name="checked" id="checked">
                            <label for="checked">Tôi tự mua hàng</label>
                        <form>
                            <input type="text" name="fullName" id="fullName" placeholder="Địa chỉ email người nhận hàng" value="">
                            <label id="name_nhan" style="color:red">Không được để trống tên người nhận hàng</label>
                            <input type="email" name="userEmail" placeholder="Địa chỉ email người nhận hàng" id="userEmail" value="">
                            <label id="email_nhan" style="color:red">Không được để trống email người nhận hàng</label><br>
                            <label id="validate_email_nhan"  style="color: red">Email không đúng! </label>
                            <input type="tel" name="userPhone" placeholder="Số điện thoại người nhận hàng" id="userPhone" value="">
                            <label id="phone_nhan" style="color:red">Không được để trống Số điện thoại người nhận hàng</label><br>
                            <label id="validate_phone_nhan"  style="color: red" >Số điện thoại bạn nhập không đúng </label>
                            <input type="text" name="userAdress" placeholder="Địa chỉ người nhận hàng" id="userAdress" value="">
                            <label id="dc_nhan" style="color:red">Không được để trống địa chỉ người nhận hàng</label>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="order-message">
                        <p>Ghi chú thông tin giao hàng</p>
                        <textarea name="message"  id="message" placeholder="yêu cầu khác khi giao hàng" rows="3"></textarea>
                        <label>Thanh toán khi nhận hàng</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <label id="c_validate" style="color:red">Vui lòng nhập đầy đủ các trường có dấu * để gửi yêu cầu đơn hàng</label>
            </div>
            <div style="margin-bottom: 20px" class="row text-center">
                <a class="btn btn-primary" id="btn" href="javascript:void(0)">Gửi yêu cầu đơn hàng</a>
            </div>
        </div>
    </div>
</section><!--/#do_action-->