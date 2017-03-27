<?php
namespace frontend\models;
use yii\base\Model;
use yii\web\Session;
use Yii;

class Cart
{
    public  function addCart($id,$arrayData){
        $session = Yii::$app->session;
        if(!isset($session['cart'])){
            $cart[$id] = [
                'id'=>$arrayData['id'],
                'display_name'=> $arrayData['display_name'],
                'price'=> $arrayData['price'],
                'price_promotion'=> $arrayData['price_promotion'],
                'images'=> $arrayData['images'],
                'availability'=> $arrayData['availability'],
                'code'=> $arrayData['code'],
                'amount'=> 1,
            ];
        }else{
            $cart = $session['cart'];
            if(array_key_exists($id, $cart)){
                $cart[$id] = [
                    'id'=>$arrayData['id'],
                    'display_name'=> $arrayData['display_name'],
                    'price'=> $arrayData['price'],
                    'price_promotion'=> $arrayData['price_promotion'],
                    'images'=> $arrayData['images'],
                    'availability'=> $arrayData['availability'],
                    'code'=> $arrayData['code'],
                    'amount'=>$cart[$id]['amount']+1,
                ];
            }else{
                $cart[$id] = [
                    'id'=>$arrayData['id'],
                    'display_name'=> $arrayData['display_name'],
                    'price'=> $arrayData['price'],
                    'price_promotion'=> $arrayData['price_promotion'],
                    'images'=> $arrayData['images'],
                    'availability'=> $arrayData['availability'],
                    'code'=> $arrayData['code'],
                    'amount'=> 1,
                ];
            }
        }
        $session['cart'] = $cart;
    }

    public function updateItem($id,$amount){
        $session = Yii::$app->session;
        $cart = $session['cart'];
        if(array_key_exists($id, $cart)){
            $cart[$id] = [
                'id'=>$cart[$id]['id'],
                'display_name'=> $cart[$id]['display_name'],
                'price'=> $cart[$id]['price'],
                'price_promotion'=> $cart[$id]['price_promotion'],
                'images'=> $cart[$id]['images'],
                'availability'=> $cart[$id]['availability'],
                'code'=> $cart[$id]['code'],
                'amount'=>$amount,
            ];
        }
        $session['cart'] = $cart;
    }

    public function deleteItem($id){
        $session = Yii::$app->session;
        if(isset($session['cart'])){
            $cart = $session['cart'];
            unset($cart[$id]);
            $session['cart'] = $cart;
        }
    }
}