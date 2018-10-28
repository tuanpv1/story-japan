<?php
use frontend\widgets\BestSaleNew;
use frontend\widgets\Fashion;
use frontend\widgets\HomeSlide;
use frontend\widgets\LatestDeals;

?>
<!-- Home slideder-->
<?= HomeSlide::widget() ?>
<!-- END Home slideder-->
<!-- servives -->
<?= LatestDeals::widget()?>
<!-- end services -->
<!---->
<div class="content-page">
    <div class="container">
        <!-- featured category fashion -->
            <?= \frontend\widgets\ContentBody::widget()?>
        <!-- end featured category fashion -->

    </div>
</div>

<?= \frontend\widgets\ListNews::widget() ?>

<?= \frontend\widgets\CartBox::getModal() ?>
