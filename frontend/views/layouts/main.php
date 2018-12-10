<?php
use common\assets\ToastAssetFe;
use common\models\InfoPublic;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use frontend\widgets\FooterWidget;
use frontend\widgets\HeaderWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
ToastAssetFe::register($this);
ToastAssetFe::config($this, [
    'positionClass' => ToastAssetFe::POSITION_TOP_LEFT,
    'closeButton' => true
]);
$time = InfoPublic::findOne(InfoPublic::ID_DEFAULT)->time_show_order * 60000;
$orderUrl = Url::to(['shopping-cart/get-order']);
$js = <<<JS
//    setInterval(
//        function(){
//            jQuery.post(
//                '{$orderUrl}'
//                )
//                .done(function(result) {
//                     toastr.info(result);
//                })
//        }, {$time}
//    );
    
JS;
$this->registerJs($js, View::POS_END);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="option5">
<div id="my-chart"></div>
<?php $this->beginBody() ?>

<?= Alert::widget() ?>

<?= HeaderWidget::widget() ?>

<?= $content ?>

<?= FooterWidget::widget() ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
