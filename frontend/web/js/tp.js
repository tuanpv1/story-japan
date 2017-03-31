var baseurl = window.location.origin+'/sanitary/frontend/web/index.php?r=';

$(window).load (function(){
    $('#tp_hidden_form_register').hide();
    $('#bt_tp_hide').hide();

    $('#name_mua').hide();
    $('#name_nhan').hide();
    $('#phone_mua').hide();
    $('#dc_mua').hide();
    $('#email_nhan').hide();
    $('#email_mua').hide();
    $('#phone_nhan').hide();
    $('#dc_nhan').hide();
    $('#validate_phone_nhan').hide();
    $('#validate_phone_mua').hide();
    $('#validate_email_mua').hide();
    $('#validate_email_nhan').hide();

    $('#info_customer').hide();
    $('#option_receiver').hide();
    $('#chose_receiver').hide();
    $('#show_infor_input').hide();
    $('#checkout').hide();
    $('#user_receiver_show_clicked').hide();
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
    $('#fullName').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#name_nhan').show();
            $(this).focus();
        }else{
            $('#name_nhan').hide();
        }
    });
    $('#userEmail').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#email_nhan').show();
            $('#validate_email_nhan').hide();
            $(this).focus();
        }else{
            $('#email_nhan').hide();
            if(IsEmail($(this).val())==false){
                $('#validate_email_nhan').show();
            }else{
                $('#validate_email_nhan').hide();
            }
        }
    });
    $('#userPhone').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#phone_nhan').show();
            $('#validate_phone_nhan').hide();
            $(this).focus();
        }else{
            $('#phone_nhan').hide();
            if(validatePhone($(this).val())==false){
                $('#validate_phone_nhan').show();
            }else{
                $('#validate_phone_nhan').hide();
            }
        }
    });
    $('#userAdress').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#dc_nhan').show();
            $(this).focus();
        }else{
            $('#dc_nhan').hide();
        }
    });
    $('#full_name').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#name_mua').show();
            $(this).focus();
        }else{
            $('#name_mua').hide();
        }
    });
    $('#user_email').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#email_mua').show();
            $('#validate_email_mua').hide();
            $(this).focus();
        }else{
            $('#email_mua').hide();
            if(IsEmail($(this).val())==false){
                $('#validate_email_mua').show();
            }else{
                $('#validate_email_mua').hide();
            }
        }
    });
    $('#user_phone').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#phone_mua').show();
            $('#validate_phone_mua').hide();
            $(this).focus();
        }else{
            $('#phone_mua').hide();
            if(validatePhone($(this).val())==false){
                $('#validate_phone_mua').show();
            }else{
                $('#validate_phone_mua').hide();
            }
        }
    });
    $('#user_adress').focusout(function(){
        if(($(this).val().trim() == null || $(this).val().trim() == "")){
            $('#dc_mua').show();
            $(this).focus();
        }else{
            $('#dc_mua').hide();
        }
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
    $.get(baseurl +'shopping-cart/add-cart',{'id' :id,'amount': amount_product},function(data){
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        $('#modal_show').modal('show');
        $('#tp_id_reload').load(window.location.href  +  ' #tp_id_reload');
    });
}

function onInputInfo(){
    $('#input_info').hide();
    $('#number_total_cart').hide();
    $('#table_list_cart').hide();
    $("#remove_class_1").removeClass("current-step");
    $("#add_class_2").addClass("current-step");
    $('#info_customer').show('slow');
    $('#chose_receiver').show('slow');
}

function choseReceiverContent(){
    full_name = $('#full_name').val();
    user_email = $('#user_email').val();
    user_phone = $('#user_phone').val();
    user_adress = $('#user_adress').val();
    if(full_name == '') {
        $('#name_mua').show();
    }else if(user_email == ''){
        $('#email_mua').show();
    }else if(user_phone == '') {
        $('#phone_mua').show();
    }else if(user_adress == '') {
        $('#dc_mua').show();
    }else{
        $('#input_info').hide();
        $('#number_total_cart').hide();
        $('#table_list_cart').hide();
        $('#info_customer').hide();
        $('#chose_receiver').hide();
        $("#remove_class_1").removeClass("current-step");
        $("#add_class_2").removeClass("current-step");
        $("#add_class_3").addClass("current-step");
        $('#option_receiver').show('slow');
        $('#show_infor_input').show('slow');
    }
}

function showAllInfo(){
    $('#input_info').hide();
    $('#number_total_cart').show();
    $('#table_list_cart').show();
    $('#info_customer').show();
    $('#chose_receiver').hide();
    $('#show_infor_input').hide();
    $("#remove_class_1").removeClass("current-step");
    $("#add_class_2").removeClass("current-step");
    $("#add_class_3").removeClass("current-step");
    $("#add_class_4").addClass("current-step");
    $('#option_receiver').show();
    $('#checkout').show('slow');
}

function showFormReceiver(){
    $('#buy_for_friend').hide();
    $('#user_receiver_show_clicked').show('slow');
}

function updateCart(id){
    //alert(id);
    amount = $("#amount_" + id).val();
    $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount},function(data){
        val = data.split("<pre>");
        if(val[1] != 0){
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
    if(amount > 1){
        $.get(baseurl +'shopping-cart/update-cart',{'id' :id,'amount' :amount_new},function(data){
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            $('#number_total_cart').load(window.location.href +  ' #number_total_cart');
            $('#table_list_cart').load(window.location.href +  ' #table_list_cart');
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
        $('#number_total_cart').load(window.location.href +  ' #number_total_cart');
        $('#table_list_cart').load(window.location.href +  ' #table_list_cart');
        $('#tp_id_reload').load(window.location.href  +  ' #tp_id_reload');
    });
}

function addition_detail(id){
    amount = $("#amount_" + id).val();
    amount_new = Number(amount) + Number(1);
    $("#product_amount_"+id).text(amount_new);
}

function subtraction_detail(id){
    amount = $("#amount_" + id).val();
    amount_new = Number(amount)-Number(1);
    $("#product_amount_"+id).text(amount_new);
}

function validatePhone(txtPhone) {
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (!filter.test(txtPhone)) {
        return false;
    }else {
        return true;
    }
}

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }
}