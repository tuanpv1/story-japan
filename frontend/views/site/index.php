<?php
use frontend\widgets\BestSaleNew;
use frontend\widgets\Fashion;
use frontend\widgets\HomeSlide;
use frontend\widgets\ProgramerSuppostFe;

?>
<!-- Home slideder-->
<?= HomeSlide::widget() ?>
<!-- END Home slideder-->
<!-- servives -->
<?= ProgramerSuppostFe::widget()?>
<!-- end services -->
<?= BestSaleNew::widget() ?>
<!---->
<div class="content-page">
    <div class="container">
        <!-- featured category fashion -->
            <?= \frontend\widgets\ContentBody::widget()?>
        <!-- end featured category fashion -->

    </div>
</div>


<?= \frontend\widgets\CartBox::getModal() ?>
