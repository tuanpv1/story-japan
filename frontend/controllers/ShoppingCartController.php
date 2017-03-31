<?php
namespace frontend\controllers;

use common\models\Content;
use common\models\Order;
use common\models\OrderDetail;
use frontend\models\Cart;
//use phpDocumentor\Reflection\DocBlock\Tags\Param;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller
 */
class ShoppingCartController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionAddCart($id,$amount){
        $productInfo = Content::findOne($id);
        $cart = new Cart();
        $cart->addCart($id,$amount,$productInfo);
        $session = Yii::$app->session;
        $cartInfo = $session['cart'];
        $totalAmount = $total=0;
        foreach($cartInfo as $key => $value){
            $totalAmount += $value['amount'];
            if($value['price_promotion'] == 0) {
                $total += $value['price'] * $value['amount'];
            }else {
                $total += $value['price_promotion'] * $value['amount'];
            }
        }
        return $this->renderAjax('cart',['cartInfo'=>$totalAmount]);
    }

    public function actionListMyCart($active = 1){
        $session = Yii::$app->session;
        $cart = $session['cart'];
        $totalAmount = $total_price=0;
        if(isset($cart)){
            foreach($cart as $key => $value){
                $totalAmount += $value['amount'];
                if($value['price_promotion'] == 0) {
                    $total_price += $value['price'] * $value['amount'];
                }else {
                    $total_price += $value['price_promotion'] * $value['amount'];
                }
            }
        }
        return $this->render('list-my-cart',[
            'cart'=>$cart,
            'total_price'=>$total_price,
            'totalAmount'=>$totalAmount,
            'active'=>$active
        ]);
    }

    public function actionUpdateCart($id,$amount){
        $cart = new Cart();
        $cart->updateItem($id,$amount);
        $session = Yii::$app->session;
        $cartInfo = $session['cart'];
        $totalAmount = $total=0;
        foreach($cartInfo as $key => $value){
            $totalAmount += $value['amount'];
        }
        return $this->renderAjax('cart',['cartInfo'=>$totalAmount]);
    }

    public function actionDelCart($id){
        $cart = new Cart();
        $cart->deleteItem($id);
        $session = Yii::$app->session;
        $cartInfo = $session['cart'];
        $totalAmount = $total=0;
        foreach($cartInfo as $key => $value){
            $totalAmount += $value['amount'];
        }
        return $this->renderAjax('cart',['cartInfo'=>$totalAmount]);
    }

    public function sendEmail($email,$body){
        Yii::$app->mailer->compose()
            ->setFrom('phptest102@gmail.com')
            ->setTo($email)
            ->setSubject("Thông báo đơn hàng từ E-shopping")
            ->setHtmlBody($body)
            ->send();
    }

    public function actionSaveBuy(){
        $fullName = $_POST['fullName'];
        $userEmail = $_POST['userEmail'];
        $userPhone = $_POST['userPhone'];
        $userAdress = $_POST['userAdress'];
        $full_name = $_POST['full_name'];
        $user_email = $_POST['user_email'];
        $user_adress = $_POST['user_adress'];
        $user_phone = $_POST['user_phone'];

        $session = Yii::$app->session;
        $cart  = $session['cart'];
        $totalAmount = $total=0;
        foreach($cart as $key => $value){
            $totalAmount += $value['amount'];
            if($value['price_promotion'] == 0) {
                $total += $value['price'] * $value['amount'];
            }else {
                $total += $value['price_promotion'] * $value['amount'];
            }
        }

        $order = new Order();
        $order->status = Order::STATUS_ORDERED;
        $order->name_buyer = $full_name;
        $order->address_buyer = $user_adress;
        $order->phone_buyer = $user_phone;
        $order->email_buyer = $user_email;
        $order->name_receiver = $fullName;
        $order->address_receiver = $userAdress;
        $order->phone_receiver = $userPhone;
        $order->email_receiver = $userEmail;
        $order->user_id = Yii::$app->user->id;
        $order->total = $total;
        $order->total_number = $totalAmount;
        if($order->save()){
            $order_id = $order->id;
            $txtTable="Thông tin đơn hàng bạn vừa đặt tại Shop cua chung toi Mã đơn hàng của bạn ".$order_id;
            $txtTable.="<table class=\"table table-condensed\">";
            $txtTable.="<thead>";
            $txtTable.="<tr class=\"cart_menu\">
                    <td width=\"25%\" class=\"image\">Sản phẩm</td>
                    <td width=\"30%\" class=\"description\"></td>
                    <td width=\"15%\" class=\"price\">Giá</td>
                    <td width=\"15%\" class=\"quantity\">Số Lượng</td>
                    <td width=\"15%\" class=\"total\">Tổng tiền</td>
                </tr>
                </thead>
                <tbody>";
            foreach ($cart as $key => $value) {

                $total_one = 0;
                if($value['price_promotion'] == 0){
                    $total_one =  $value['amount']*$value['price'];
                }else{
                    $total_one = $value['price_promotion'] * $value['amount'];
                }
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order_id;
                $order_detail->content_id = $value['id'];
                $order_detail->price = $value["price"];
                $order_detail->number = $value["amount"];
                $order_detail->price_promotion = $value["price_promotion"];
                $order_detail->sale = round (((($value["price"] - $value["price_promotion"])/($value["price"]))*100),1);
                $order_detail->total = $total_one;
                $order_detail->code = $value["code"];
                if($value['price_promotion']==0){
                    $order_detail->price_promotion = null;
                }else{
                    $order_detail->price_promotion = $value['price_promotion'];
                }
                $txtTable.="<td class=\"cart_product\">";
                $txtTable.="<img style=\"width: 150px\" src=\"". Content::getFirstImageLinkFeStatic($value['images']) ."\" alt=\"".$value['display_name']."\">";
                $txtTable.= "</td>
                                <td class=\"cart_description\">";
                $txtTable.= "<p>". $value['display_name'] ."</p>";
                $txtTable.="</td>";
                if($value['price_promotion']==0){
                    $txtTable.="<td class=\"cart_price\">";
                    $txtTable.="<p>". Content::formatNumber($value['price']).' Đ'."</p>";
                    $txtTable.="</td>";
                }else{
                    $txtTable.="<td class=\"cart_price\">";
                    $txtTable.="<p>".Content::formatNumber($value['price_promotion']).' Đ'."</p>
                                            <p style=\"font-size: 12px\">Giá cũ: <span class=\"tp_002\">". Content::formatNumber($value['price']) ."</span> Đ</p>";
                    $txtTable.="</td>";
                }
                $txtTable.="<p>".$value['amount']."</p>";
                $txtTable.="</td>";
                $txtTable.="<td class=\"cart_quantity\">
                                    <div class=\"cart_quantity_button\">";
                $txtTable.=$value['amount'];
                $txtTable.="</div>
                                </td>
                                <td class=\"cart_total\">";
                $txtTable.="<p class=\"cart_total_price\">". Content::formatNumber($total_one).' Đ' ."</p>";

                $txtTable.="</td>";
                $txtTable.="</tr>
                        </tbody>
                    </table>";
                if(!$order_detail->save()){
                    $message = 'Đặt hàng không thành công. không lưu thành công chi tiết đơn hàng!';
                    return Json::encode(['success' => false, 'message' => $message]);
                }
            }
            $txtTable.="Cám ơn bạn đã tin tưởng và sử dụng dịch vụ của shop chúng tôi";
            $this->sendEmail($user_email,$txtTable);
            $message = 'Đã đặt hàng thành công, đơn hàng đã được gửi về địa chỉ email của bạn.';
            $session->remove('cart');
            return Json::encode(['success' => true, 'message' => $message]);
        }else{
            $message = 'Đặt hàng không thành công.';
            return Json::encode(['success' => false, 'message' => $message]);
        }
    }
}