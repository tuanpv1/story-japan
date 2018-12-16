var baseurl = window.location.origin + '/index.php?r=';

$(window).load(function () {
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
    $('#c_validate').hide();
});
$(document).ready(function () {
    $('#bt_tp_show').click(function () {
        $('#bt_tp_show').hide();
        $('#form_login').hide();
        $('#tp_hidden_form_register').show('slow');
        $('#bt_tp_hide').show('slow');
    });
    $('#bt_tp_hide').click(function () {
        $('#bt_tp_show').show();
        $('#form_login').show('slow');
        $('#tp_hidden_form_register').hide();
        $('#bt_tp_hide').hide();
    });
    $('#fullName').focusout(function () {
        if (($(this).val().trim() == null || $(this).val().trim() == "")) {
            $('#name_nhan').show();
            $(this).focus();
        } else {
            $('#name_nhan').hide();
        }
    });
    $('#userEmail').focusout(function () {
        if (($(this).val().trim() == null || $(this).val().trim() == "")) {
            $('#email_nhan').show();
            $('#validate_email_nhan').hide();
            $(this).focus();
        } else {
            $('#email_nhan').hide();
            if (IsEmail($(this).val()) == false) {
                $('#validate_email_nhan').show();
            } else {
                $('#validate_email_nhan').hide();
            }
        }
    });
    $('#userPhone').focusout(function () {
        if (($(this).val().trim() == null || $(this).val().trim() == "")) {
            $('#phone_nhan').show();
            $('#validate_phone_nhan').hide();
            $(this).focus();
        } else {
            $('#phone_nhan').hide();
            if (validatePhone($(this).val()) == false) {
                $('#validate_phone_nhan').show();
            } else {
                $('#validate_phone_nhan').hide();
            }
        }
    });
    $('#userAdress').focusout(function () {
        if (($(this).val().trim() == null || $(this).val().trim() == "")) {
            $('#dc_nhan').show();
            $(this).focus();
        } else {
            $('#dc_nhan').hide();
        }
    });
    $('#full_name').focusout(function () {
        if (($(this).val().trim() == null || $(this).val().trim() == "")) {
            $('#name_mua').show();
            $(this).focus();
        } else {
            $('#name_mua').hide();
        }
    });
    $('#user_email').focusout(function () {
        if (($(this).val().trim() == null || $(this).val().trim() == "")) {
            $('#email_mua').show();
            $('#validate_email_mua').hide();
            $(this).focus();
        } else {
            $('#email_mua').hide();
            if (IsEmail($(this).val()) == false) {
                $('#validate_email_mua').show();
            } else {
                $('#validate_email_mua').hide();
            }
        }
    });
    $('#user_phone').focusout(function () {
        if (($(this).val().trim() == null || $(this).val().trim() == "")) {
            $('#phone_mua').show();
            $('#validate_phone_mua').hide();
            $(this).focus();
        } else {
            $('#phone_mua').hide();
            if (validatePhone($(this).val()) == false) {
                $('#validate_phone_mua').show();
            } else {
                $('#validate_phone_mua').hide();
            }
        }
    });
    $('#user_adress').focusout(function () {
        if (($(this).val().trim() == null || $(this).val().trim() == "")) {
            $('#dc_mua').show();
            $(this).focus();
        } else {
            $('#dc_mua').hide();
        }
    });

    $('#idSearchPrice').click(function () {
        $("#my-chart").addClass("loading");
        var value_min = $('#valueFrom').val()?$('#valueFrom').val():$('.slider-range-price').data('valueMin');
        var value_max = $('#valueTo').val()?$('#valueTo').val():$('.slider-range-price').data('valueMax');
        var category_id = $('#idCategorySearch').val();
        var keyword = $('#keywordSearch').val();
        $.post(
            window.location,
            {
                value_min: value_min,
                value_max: value_max,
                category_id: category_id,
                is_search: true,
                keyword: keyword
            },
            function (data, status) {
                $("#replaceHtmlContents").replaceWith(data);
                $("#my-chart").removeClass("loading");
            }
        );
    });

    $(".check-box-list input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        var category_id = $('#idCategorySearch').val();
        var keyword = $('#keywordSearch').val();
        var price_search = $box.val();
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
            $("#my-chart").addClass("loading");
            price_proccess = price_search.split(',');
            value_min = price_proccess[0];
            value_max = price_proccess[1];
            $.post(
                window.location,
                {
                    value_min: value_min,
                    value_max: value_max,
                    category_id: category_id,
                    is_search: true,
                    keyword: keyword
                },
                function (data, status) {
                    $("#replaceHtmlContents").replaceWith(data);
                    $("#my-chart").removeClass("loading");
                }
            );
        } else {
            $box.prop("checked", false);
            window.location.reload();
        }
    });
});

function checkOutInfo() {
    if ($('#full_name').val().trim() == "" || $('#user_email').val().trim() == "" || $('#user_adress').val().trim() == "" || $('#user_phone').val().trim() == "") {
        $('#c_validate').show();
    } else {
        $("#my-chart").addClass("loading");
        var fullName = $('#fullName').val();
        var userEmail = $('#userEmail').val();
        var userPhone = $('#userPhone').val();
        var userAdress = $('#userAdress').val();
        var full_name = $('#full_name').val();
        var user_email = $('#user_email').val();
        var user_adress = $('#user_adress').val();
        var user_phone = $('#user_phone').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'shopping-cart/save-buy',
            data: {
                fullName: fullName,
                userEmail: userEmail,
                userPhone: userPhone,
                userAdress: userAdress,
                full_name: full_name,
                user_email: user_email,
                user_adress: user_adress,
                user_phone: user_phone
            },
            success: function (data) {
                var rs = JSON.parse(data);
                if (rs['success']) {
                    location.href = baseurl + 'site/index';
                    $("#my-chart").removeClass("loading");
                    alert(rs['message']);
                } else {
                    $("#my-chart").removeClass("loading");
                    alert(rs['message']);
                }
            }
        });
    }
}

function addCart(id) {
    $("#my-chart").addClass("loading");
    price_promotion = $("#product_price_promotion_" + id).text();
    $("#price_promotion_product").text(price_promotion);
    price = $("#product_price_" + id).text();
    $("#price_product").text(price);
    name = $("#product_name_" + id).text();
    $("#name_product").text(name);
    code = $("#product_code_" + id).text();
    $("#code_product").text(code);
    amount_product = $(".product_amount_" + id).val();
    $("#quality_product").text(amount_product);
    imgSource = $(".product_image_" + id).attr("src");
    $("#image_product").attr({
        "src": imgSource
    });
    $.get(baseurl + 'shopping-cart/add-cart', {'id': id, 'amount': amount_product}, function (data) {
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        $("#my-chart").removeClass("loading");
        $('#modal_show').modal('show');
        $('#tp_id_reload').load(window.location.href + ' #tp_id_reload');
    });
}

function onInputInfo() {
    $('#input_info').hide();
    $('#number_total_cart').hide();
    $('#table_list_cart').hide();
    $("#remove_class_1").removeClass("current-step");
    $("#add_class_2").addClass("current-step");
    $('#info_customer').show('slow');
    $('#show_infor_input').show('slow');
}

function showAllInfo() {
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

function showFormReceiver() {
    $('#buy_for_friend').hide();
    $('#user_receiver_show_clicked').show('slow');
}

function updateCart(id) {
    //alert(id);
    amount = $("#amount_" + id).val();
    $.get(baseurl + 'shopping-cart/update-cart', {'id': id, 'amount': amount}, function (data) {
        val = data.split("<pre>");
        if (val[1] != 0) {
            $("#amount").text(val[1]);
            $('#tp_id_reload_lmc').load(window.location.href + ' #tp_id_reload_lmc');
            $('#tp_id_reload').load(window.location.href + ' #tp_id_reload');
        }
    });
}

function delCart(id) {
    if (confirm('Bạn chắc chắn muốn xóa sản phẩm này') == true) {
        $.get(baseurl + 'shopping-cart/del-cart', {'id': id}, function (data) {
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            $('#tp_id_reload').load(window.location.href + ' #tp_id_reload');
            $('#tp_id_reload_lmc').load(window.location.href + ' #tp_id_reload_lmc');
        });
    }
}

function subtraction(id) {
    amount = $("#amount_" + id).val();
    amount_new = Number(amount) - Number(1);
    if (amount > 1) {
        $.get(baseurl + 'shopping-cart/update-cart', {'id': id, 'amount': amount_new}, function (data) {
            val = data.split("<pre>");
            $("#amount").text(val[1]);
            $('#number_total_cart').load(window.location.href + ' #number_total_cart');
            $('#table_list_cart').load(window.location.href + ' #table_list_cart');
            $('#tp_id_reload').load(window.location.href + ' #tp_id_reload');
        });
    }
}

function addition(id) {
    amount = $("#amount_" + id).val();
    amount_new = Number(amount) + Number(1);
    $.get(baseurl + 'shopping-cart/update-cart', {'id': id, 'amount': amount_new}, function (data) {
        val = data.split("<pre>");
        $("#amount").text(val[1]);
        $('#number_total_cart').load(window.location.href + ' #number_total_cart');
        $('#table_list_cart').load(window.location.href + ' #table_list_cart');
        $('#tp_id_reload').load(window.location.href + ' #tp_id_reload');
    });
}

function addition_detail(id) {
    amount = $("#amount_" + id).val();
    amount_new = Number(amount) + Number(1);
    $("#product_amount_" + id).text(amount_new);
}

function subtraction_detail(id) {
    amount = $("#amount_" + id).val();
    amount_new = Number(amount) - Number(1);
    $("#product_amount_" + id).text(amount_new);
}

function validatePhone(txtPhone) {
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (!filter.test(txtPhone)) {
        return false;
    } else {
        return true;
    }
}

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}

function addFavourite(id,url_post) {
    $("#my-chart").addClass("loading");
    $.ajax({
        url: url_post,
        data: {
            'content_id': id,
        },
        type: "POST",
        crossDomain: true,
        dataType: "text",
        success: function (result) {
            $("#my-chart").removeClass("loading");
            result = JSON.parse(result);
            if(result.success){
                toastr.info(result.message);
                $('#tp_id_reload').load(window.location.href + ' #tp_id_reload');
                $('#replaceContentChapter').load(window.location.href + ' #replaceContentChapter');
            }else{
                toastr.error(result.message);
            }
            return;
        },
        error: function (result) {
            $("#my-chart").removeClass("loading");
            toastr.error(result.message);
            return;
        }
    });//end jQuery.ajax
}

function removeFavourite(id,url_post) {
    $("#my-chart").addClass("loading");
    $.ajax({
        url: url_post,
        data: {
            'content_id': id,
        },
        type: "POST",
        crossDomain: true,
        dataType: "text",
        success: function (result) {
            $("#my-chart").removeClass("loading");
            result = JSON.parse(result);
            if(result.success){
                toastr.info(result.message);
                $('#tp_id_reload').load(window.location.href + ' #tp_id_reload');
                $('#replaceContentChapter').load(window.location.href + ' #replaceContentChapter');
            }else{
                toastr.error(result.message);
            }
            return;
        },
        error: function (result) {
            $("#my-chart").removeClass("loading");
            toastr.error(result.message);
            return;
        }
    });//end jQuery.ajax
}

function loadMore(url) {
    $("#my-chart").addClass("loading");

    var page = parseInt($('#page').val()) + 1;
    var total = parseInt(($('#total').val()));
    var numberCount = parseInt($('#numberCount').val()) + 6;

    var value_min = $('#valueFrom').val();
    var value_max = $('#valueTo').val();
    var category_id = $('#idCategorySearch').val();
    var keyword = $('#keywordSearch').val();

    $.ajax({
        url: url,
        data: {
            'page': page,
            'value_min': value_min,
            'value_max': value_max,
            'category_id': category_id,
            'keyword': keyword
        },
        type: "POST",
        crossDomain: true,
        dataType: "text",
        success: function (result) {
            if (null != result && '' != result) {
                $(result).insertBefore('#last-mark');
                document.getElementById("page").value = page + 6;
                document.getElementById("numberCount").value = numberCount;
                if (numberCount > total) {
                    $('#more').css('display', 'none');
                }
                $('#last-mark').html('');
            } else {
                $('#last-mark').html('');
            }
            $("#my-chart").removeClass("loading");
            return;
        },
        error: function (result) {
            $("#my-chart").removeClass("loading");
            alert('Không thành công. Quý khách vui lòng thử lại sau ít phút.');
            $('#last-mark').html('');
            return;
        }
    });//end jQuery.ajax
}

function changeLanguages(id,url) {
    $.ajax({
        url: url,
        data: {
            'language': id
        },
        type: "POST",
        crossDomain: true,
        dataType: "text",
        success: function (result) {
            location.reload();
            return;
        },
        error: function (result) {
            alert('Không thành công. Quý khách vui lòng thử lại sau ít phút.');
            return;
        }
    });//end jQuery.ajax
}
function nextEpisode(id,url) {
    $("#my-chart").addClass("loading");
    $.ajax({
        url: url,
        data: {
            id:id
        },
        type: "POST",
        crossDomain: true,
        dataType: "text",
        success: function (result) {
            $("#my-chart").removeClass("loading");
            $("#replaceContentChapter").replaceWith(result);
            new_url = $('#url_new_chapter').attr('href');
            name = $('#product_name').val();
            window.history.pushState(name, name, new_url);
            return;
        },
        error: function (result) {
            $("#my-chart").removeClass("loading");
            toastr.error('Không thành công. Quý khách vui lòng thử lại sau ít phút.');
            return;
        }
    });//end jQuery.ajax
}

function preEpisode(id,url) {
    $("#my-chart").addClass("loading");
    $.ajax({
        url: url,
        data: {
            id:id
        },
        type: "POST",
        crossDomain: true,
        dataType: "text",
        success: function (result) {
            $("#my-chart").removeClass("loading");
            $("#replaceContentChapter").replaceWith(result);
            new_url = $('#url_new_chapter').attr('href');
            name = $('#product_name').val();
            window.history.pushState(name, name, new_url);
            return;
        },
        error: function (result) {
            $("#my-chart").removeClass("loading");
            toastr.error('Không thành công. Quý khách vui lòng thử lại sau ít phút.');
            return;
        }
    });//end jQuery.ajax
}