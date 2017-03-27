<?php
use frontend\widgets\FooterWidget;
use frontend\widgets\HeaderWidget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
<body>

<?php $this->beginBody() ?>

<?= HeaderWidget::widget() ?>

<?= Alert::widget() ?>

<?= $content ?>

<?= FooterWidget::widget()?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<div class="modal fade" id="modal_show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="box-authentication">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box-authentication">
                            <img id="image_product" src="">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box-authentication">
                            <div class="row">
                                <h3 id="name_product" class="text-center"></h3>
                                <p id="price_product"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
