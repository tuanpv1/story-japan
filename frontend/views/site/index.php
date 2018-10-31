<?php
use frontend\widgets\HomeSlide;
use frontend\widgets\LatestDeals;

?>
<!-- Home slideder-->
<?= HomeSlide::widget() ?>
<!-- END Home slideder-->
<!-- servives -->
<?= LatestDeals::widget() ?>
<!-- end services -->
<div class="content-page">
    <div class="container">
        <?= \frontend\widgets\ContentBody::widget() ?>
    </div>
</div>

<?= \frontend\widgets\CartBox::getModal() ?>
