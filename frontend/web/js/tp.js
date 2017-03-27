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
    price_promotion = $("#product_price_promotion_"+id).text();
    $("#price_promotion_product").text(price_promotion);
    price = $("#product_price_"+id).text();
    $("#price_product").text(price);
    name = $("#product_name_"+id).text();
    $("#name_product").text(name);
    code = $("#product_code_"+id).text();
    $("#code_product").text(code);
    amount_product = $(".product_amount_"+id).val();
    $("#quality_product").text(amount_product);
    imgSource = $(".product_image_"+id).attr("src");
    $("#image_product").attr({
        "src":imgSource
    });
    $.get(baseurl +'shopping-cart/add-cart',{'id' :id},function(data){
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        $('#modal_show').modal('show');
        $('#tp_id_reload').load(window.location.href  +  ' #tp_id_reload');
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
                    $('#tp_id_reload_lmc').load(window.location.href +  ' #tp_id_reload_lmc');
                    $('#tp_id_reload').load(window.location.href  +  ' #tp_id_reload');
                });
            }
        }else{
            $("#amount").text(val[1]);
            $('#tp_id_reload_lmc').load(window.location.href +  ' #tp_id_reload_lmc');
            $('#tp_id_reload').load(window.location.href  +  ' #tp_id_reload');
        }
    });
}

function delCart(id){
    if(confirm('Bạn chắc chắn muốn xóa sản phẩm này')==true){
        $.get(baseurl +'shopping-cart/del-cart',{'id' :id},function(data){
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            $('#tp_id_reload').load(window.location.href  +  ' #tp_id_reload');
            $('#tp_id_reload_lmc').load(window.location.href +  ' #tp_id_reload_lmc');
        });
    }
}

function subtraction(id){
    amount = $("#amount_" + id).val();
    amount_new = Number(amount)-Number(1);
    if(amount_new != 0){
        $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount_new},function(data){
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            $('#tp_id_reload_lmc').load(window.location.href +  ' #tp_id_reload_lmc');
            $('#tp_id_reload').load(window.location.href  +  ' #tp_id_reload');
        });
    }
}

function addition(id){
    amount = $("#amount_" + id).val();
    amount_new = Number(amount) + Number(1);
    $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount_new},function(data){
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        $('#tp_id_reload_lmc').load(window.location.href +  ' #tp_id_reload_lmc');
        $('#tp_id_reload').load(window.location.href  +  ' #tp_id_reload');
    });
}