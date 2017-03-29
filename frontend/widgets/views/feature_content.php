<?php
use common\models\Content;

if (isset($content)) {
    /** @var $content Content */
    ?>
    <div class="banner-featured">
        <div class="featured-text"><span>featured</span></div>
        <div class="banner-img text-center">
            <a href="<?= \yii\helpers\Url::to(['content/detail', 'id' => $content->id]) ?>"><img
                    style="height: 300px" alt="<?= $content->display_name ?>"
                    src="<?= $content->getFirstImageLinkFE() ?>"/></a>
        </div>
    </div>
<?php }
?>