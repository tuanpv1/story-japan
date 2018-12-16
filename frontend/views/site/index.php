<?php
use frontend\widgets\HomeSlide;
use yii\web\View;
if(!empty($message)){
    if($success){
        $show = 'true';
    }else{
        $show = 'false';
    }
}else{
    $message = '';
    $show = '';
}

if(empty($show_login)){
    $show_login = '';
}
$js_toastr = <<<JS
    var show_login = '{$show_login}';
    if(show_login == 'show'){
        $("#my-chart").addClass("loading");
        $('#myModal').modal('show');
        $("#my-chart").removeClass("loading");
    }
    var show ='{$show}';
    if(show == 'true'){
        toastr.success('{$message}');
    }
    if(show == 'false'){
        toastr.warning('{$message}');
    }
JS;
$this->registerJs($js_toastr, View::POS_READY);
?>
<!-- Home slideder-->
<?= HomeSlide::widget() ?>
<!-- END Home slideder-->
<?= \frontend\widgets\LatestDeals::widget() ?>
<!-- end services -->
<?= \frontend\widgets\ContentBody::widget() ?>
<!--modal-->
