var baseurl = window.location.origin+'/sanitary/frontend/web/index.php?r=';

$(window).load (function(){
    $('#tp_hidden_form_register').hide();
    $('#bt_tp_hide').hide();
});

$(document).ready(function(){
    $('#bt_tp_show').click(function(){
        $('#bt_tp_show').hide();
        $('#form_login').hide();
        $('#tp_hidden_form_register').show('slow');
        $('#bt_tp_hide').show('slow');
    });
    $('#bt_tp_hide').click(function(){
        $('#bt_tp_show').show();
        $('#form_login').show('slow');
        $('#tp_hidden_form_register').hide();
        $('#bt_tp_hide').hide();
    });
});

function addCart(id){
    price = $("#product_price").text();
    $("#price_product").text(price);
    name = $("#product_name").text();
    $("#name_product").text(name);
    imgSource = $("#product_image").attr("src");
    $("#image_product").attr({
        "src":imgSource
    });
    $.get(baseurl +'shopping-cart/add-cart',{'id' :id},function(data){
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        alert('Đã thêm sản phẩm vào giỏ hàng thành công');
        $('#modal_show').modal('show');
    });
}

function updateCart(id){
    //alert(id);
    amount = $("#amount_" + id).val();
    $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount},function(data){
        val = data.split("<pre>");
        if(val[1] == 0){
            if(confirm('Bạn chắc chắn muốn xóa sản phẩm này')==true){
                $.get(baseurl +'shopping-cart/del-cart',{'id' :id},function(data){
                    val = data.split("<pre>");
                    $("#amount").text(val[1]);
                    window.location.href=baseurl+'shopping-cart/list-my-cart';
                });
            }
        }else{
            $("#amount").text(val[1]);
            window.location.href=baseurl+'shopping-cart/list-my-cart';
        }
    });
}

function delCart(id){
    if(confirm('Bạn chắc chắn muốn xóa sản phẩm này')==true){
        $.get(baseurl +'shopping-cart/del-cart',{'id' :id},function(data){
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            window.location.href=baseurl+'shopping-cart/list-my-cart';
        });
    }
}

function subtraction(id){
    amount = $("#amount_" + id).val();
    amount_new = Number(amount)-Number(1);
    if(amount_new == 0){
        if(confirm('Bạn chắc chắn muốn xóa sản phẩm này')==true){
            $.get(baseurl +'shopping-cart/del-cart',{'id' :id},function(data){
                val = data.split("<pre>");
                $("#amount").text(val[1]);
                window.location.href=baseurl+'shopping-cart/list-my-cart';
            });
        }else{
            window.location.href=baseurl+'shopping-cart/list-my-cart';
        }
    }else{
        $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount_new},function(data){
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            window.location.href=baseurl+'shopping-cart/list-my-cart';
        });
    }
}

function addition(id){
    amount = $("#amount_" + id).val();
    amount_new = Number(amount) + Number(1);
    $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount_new},function(data){
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        window.location.href=baseurl+'shopping-cart/list-my-cart';
    });
}