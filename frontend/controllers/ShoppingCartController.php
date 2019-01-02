<?php

namespace frontend\controllers;

use common\helpers\CUtils;
use common\models\Content;
use common\models\Order;
use common\models\OrderDetail;
use frontend\models\Cart;
use Yii;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

//use phpDocumentor\Reflection\DocBlock\Tags\Param;

/**
 * Site controller
 */
class ShoppingCartController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionAddCart($id, $amount)
    {
        $productInfo = Content::findOne($id);
        $cart = new Cart();
        $cart->addCart($id, $amount, $productInfo);
        $session = Yii::$app->session;
        $cartInfo = $session['cart'];
        $totalAmount = $total = 0;
        foreach ($cartInfo as $key => $value) {
            $content = Content::findOne($value['id']);
            $totalAmount += $value['amount'];
            if ($content->price_promotion == 0) {
                $total += $content->price * $value['amount'];
            } else {
                $total += $content->price_promotion * $value['amount'];
            }
        }
        return $this->renderAjax('cart', ['cartInfo' => $totalAmount]);
    }

    public function actionListMyCart($active = 1)
    {
        $session = Yii::$app->session;
        $cart = $session['cart'];
        $totalAmount = $total_price = 0;
        if (isset($cart)) {
            foreach ($cart as $key => $value) {
                $content = Content::findOne($value['id']);
                $totalAmount += $value['amount'];
                if ($content->price_promotion == 0) {
                    $total_price += $content->price * $value['amount'];
                } else {
                    $total_price += $content->price_promotion * $value['amount'];
                }
            }
        }
        return $this->render('list-my-cart', [
            'cart' => $cart,
            'total_price' => $total_price,
            'totalAmount' => $totalAmount,
            'active' => $active
        ]);
    }

    public function actionUpdateCart($id, $amount)
    {
        $cart = new Cart();
        $cart->updateItem($id, $amount);
        $session = Yii::$app->session;
        $cartInfo = $session['cart'];
        $totalAmount = $total = 0;
        foreach ($cartInfo as $key => $value) {
            $totalAmount += $value['amount'];
        }
        return $this->renderAjax('cart', ['cartInfo' => $totalAmount]);
    }

    public function actionDelCart($id)
    {
        $cart = new Cart();
        $cart->deleteItem($id);
        $session = Yii::$app->session;
        $cartInfo = $session['cart'];
        $totalAmount = $total = 0;
        foreach ($cartInfo as $key => $value) {
            $totalAmount += $value['amount'];
        }
        return $this->renderAjax('cart', ['cartInfo' => $totalAmount]);
    }

    public function sendEmail($email, $body)
    {
        Yii::$app->mailer->compose()
            ->setFrom('Đơn từ Hanghieuorder.com')
            ->setTo($email)
            ->setSubject("Đơn hàng từ Hanghieuorder.com")
            ->setHtmlBody($body)
            ->send();
        Yii::$app->mailer->compose()
            ->setFrom('Đơn từ Hanghieuorder.com')
            ->setTo(Yii::$app->params['email_want_send_order'])
            ->setSubject("Có đơn hàng từ Hanghieuorder.com")
            ->setHtmlBody($body)
            ->send();
    }

    public function actionSaveBuy()
    {
        $fullName = $_POST['fullName'];
        $userEmail = $_POST['userEmail'];
        $userPhone = $_POST['userPhone'];
        $userAdress = $_POST['userAdress'];
        $full_name = $_POST['full_name'];
        $user_email = $_POST['user_email'];
        $user_address = $_POST['user_adress'];
        $user_phone = $_POST['user_phone'];

        $session = Yii::$app->session;
        $cart = $session['cart'];
        $totalAmount = $total = 0;
        foreach ($cart as $key => $value) {
            $totalAmount += $value['amount'];
            $content = Content::findOne($value['id']);
            if ($content->price_promotion == 0) {
                $total += $content->price * $value['amount'];
            } else {
                $total += $content->price_promotion * $value['amount'];
            }
        }

        $order = new Order();
        $order->status = Order::STATUS_ORDERED;
        $order->name_buyer = $full_name;
        $order->address_buyer = $user_address;
        $order->phone_buyer = $user_phone;
        $order->email_buyer = $user_email;
        $order->name_receiver = $fullName;
        $order->address_receiver = $userAdress;
        $order->phone_receiver = $userPhone;
        $order->email_receiver = $userEmail;
        $order->user_id = Yii::$app->user->id;
        $order->total = $total;
        $order->total_number = $totalAmount;
        if ($order->save()) {
            $order_id = $order->id;
            $txtTable = "
            <i>Kính chào Quý khách</i><br><br>
            Cảm ơn Quý khách đã quan tâm đến sản phẩm của chúng tôi. Chúng tôi sẽ liên hệ qua điện 
            thoại để chốt đơn hàng trong thời gian gần nhất
            <br><br>
            <b>HÓA ĐƠN MUA HÀNG</b>
            <br><br>
            
            <table style='border: 1px solid #ddd;'>
              <tbody>
                <tr>
                  <td style='border: 1px solid #ddd;'><b>Mã đơn hàng: </b></td>
                  <td style='border: 1px solid #ddd;'>#" . $order_id . "</td>
                </tr>
                <tr>
                  <td style='border: 1px solid #ddd;'><b>Tên khách hàng: </b></td>
                  <td style='border: 1px solid #ddd;'>" . $full_name . "</td>
                </tr>
                <tr>
                  <td style='border: 1px solid #ddd;'><b>Email: </b></td>
                  <td style='border: 1px solid #ddd;'>" . $user_email . "</td>
                </tr>
                <tr>
                  <td style='border: 1px solid #ddd;'><b>Tel: </b></td>
                  <td style='border: 1px solid #ddd;'>" . $user_phone . "</td>
                </tr>
                <tr>
                  <td style='border: 1px solid #ddd;'><b>Adress: </b></td>
                  <td style='border: 1px solid #ddd;'>" . $user_address . "</td>
                </tr>
              </tbody>
            </table>

            <br><br>    
            Thông tin đơn hàng tại " . Yii::$app->name . " Mã đơn hàng: #" . $order_id;
            $txtTable .= "<br>
                <table style=\"border: 1px solid #ddd;\" class=\"table table-condensed\">";
            $txtTable .= "<thead>";
            $txtTable .= "<tr class=\"cart_menu\">
                    <td style='border: 1px solid #ddd;' width=\"5%\" class=\"description\"><b>STT</b></td>
                    <td style='border: 1px solid #ddd;' width=\"35%\" class=\"description\"><b>Sản phẩm</b></td>
                    <td style='border: 1px solid #ddd;' width=\"20%\" class=\"price\"><b>Giá</b></td>
                    <td style='border: 1px solid #ddd;' width=\"20%\" class=\"quantity\"><b>Số Lượng</b></td>
                    <td style='border: 1px solid #ddd;' width=\"20%\" class=\"total\"><b>Tổng tiền</b></td>
                </tr>
                </thead>
                <tbody>";
            $i = 1;
            foreach ($cart as $key => $value) {
                $txtTable .= "<tr>";
                $content = Content::findOne($value['id']);
                $total_one = 0;
                if ($content->price_promotion == 0) {
                    $total_one = $value['amount'] * $content->price;
                } else {
                    $total_one = $content->price_promotion * $value['amount'];
                }
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order_id;
                $order_detail->content_id = $value['id'];
                $order_detail->price = $content->price;
                $order_detail->number = $value["amount"];
                $order_detail->price_promotion = $content->price_promotion;
                $order_detail->sale = $content->getPercentSale();
                $order_detail->total = $total_one;
                $order_detail->code = $content->code;
                if ($content->price_promotion == 0) {
                    $order_detail->price_promotion = null;
                } else {
                    $order_detail->price_promotion = $content->price_promotion;
                }
                $txtTable .= "
                        <td style='border: 1px solid #ddd;' width=\"5%\"> " . $i . "</td>
                        <td style='border: 1px solid #ddd;' class=\"cart_description\" width=\"35%\">";
                $txtTable .= "<a href=" . Url::base('http') . Url::to(['content/detail', 'id' => $content->id]) . ">" . $value['display_name'] . "</a>";
                $txtTable .= "</td>";
                if ($content->price_promotion == 0 || $content->price_promotion == $content->price) {
                    $txtTable .= "<td style='border: 1px solid #ddd;' class=\"cart_price\">";
                    $txtTable .= "<p>" . CUtils::formatNumber($content->price) . ' Đ' . "</p>";
                    $txtTable .= "</td>";
                } else {
                    $txtTable .= "<td style='border: 1px solid #ddd;' class=\"cart_price\">";
                    $txtTable .= "<p>" . CUtils::formatNumber($content->price_promotion) . ' Đ' . "</p>
                                            <p style=\"font-size: 12px\">Giá cũ: <span class=\"tp_002\">" . CUtils::formatNumber($content->price) . "</span> Đ</p>";
                    $txtTable .= "</td>";
                }
                $txtTable .= "<td style='border: 1px solid #ddd;' class=\"cart_quantity\">
                                    <div class=\"cart_quantity_button\">";
                $txtTable .= $value['amount'];
                $txtTable .= "      </div>
                              </td>
                              <td style='border: 1px solid #ddd;' class=\"cart_total\">";
                $txtTable .= "     <p class=\"cart_total_price\">" . CUtils::formatNumber($total_one) . ' Đ' . "</p>";

                $txtTable .= "</td>";
                $txtTable .= "</tr>";
                if (!$order_detail->save()) {
                    $message = 'Đặt hàng không thành công. không lưu thành công chi tiết đơn hàng!';
                    return Json::encode(['success' => false, 'message' => $message]);
                }
                $i++;
            }
            $txtTable .= "
                        <tr>
                              <td style='border: 1px solid #ddd;' colspan='5'>
                                Tổng tiền thanh toán: <span style='color: red'>" . CUtils::formatNumber($order->total) . " VND</span><br>
                                <span style='color: red'>Quý khách chú ý: Giá trên là giá khi về kho hàng ở Hà Nội chưa bao gồm tiền 
                                Ship</span>
                              </td>
                            </tr>
                        </tbody>
                    </table>";
            $txtTable .= "
                <br><br>
                PHƯƠNG THỨC THANH TOÁN 
                <br><br>
                -	Quý khách vui lòng chuyển tiền cọc theo thông tin người nhận dưới đây. 
                Sau khi nhận được thông báo nhận tiền từ ngân hàng, chúng tôi sẽ tiến hàng đặt 
                hàng theo yêu cầu của Quý khách. <br>
                -	Khi chuyển tiền quý khách vui lòng ghi rõ nội dung như sau: <span style='color: red'>\"Trần văn A thanh toán đơn hàng mã #56832\". </span></span> <br>
                Có vấn đề cần giải đáp, Quý khách có thể liên hệ theo số hotline: 0865.115.558 <br><br>
                    
            TÀI KHOẢN NGÂN HÀNG:
            <br><br>
            <table style='border: 1px solid #ddd;'>
              <tbody>
                <tr>
                  <td style='border: 1px solid #ddd;'>
                    <b>Ngân hàng Vietcombank – CN Thăng Long</b><br>
                    Họ tên: Cao Thị Huyền Trang<br>
                    STK: 00491000069627	
                  </td>
                  <td style='border: 1px solid #ddd;'>
                   <b>Ngân hàng Sacombank – CN mùng 8 tháng 3</b><br>
                    Họ tên: Cao Thị Huyền Trang<br>
                    STK: 020039833965
                    </td>
                </tr>
              </tbody>
            </table>
            ";
            $this->sendEmail($user_email, $txtTable);
            $message = 'Đã đặt hàng thành công, đơn hàng đã được gửi về địa chỉ email của bạn.';
            $session->remove('cart');
            return Json::encode(['success' => true, 'message' => $message]);
        } else {
            $message = 'Đặt hàng không thành công.';
            return Json::encode(['success' => false, 'message' => $message]);
        }
    }

    public function actionGetOrder()
    {
        $order = Order::find()
            ->andWhere(['status' => Order::STATUS_ORDERED])
            ->orderBy(new Expression('rand()'))
            ->one();
        if ($order) {
            $message = Yii::t('app', 'Khách hàng ' . $order->name_buyer . ' địa chỉ Email ') . substr_replace($order->email_buyer, 'xx', 2, 2)
                . Yii::t('app', ' Đã đặt hàng tại ') . Yii::$app->name . $this->getHour($order->created_at);
            return $message;
        }
    }

    public function getHour($time)
    {
        $new_time = time() - $time;
        if ($new_time < 86400) {
            $result = round($new_time / 3600) . ' giờ trước';
        } else {
            $result = round($new_time / 86400) . ' ngày trước';
        }

        return $result;
    }
}