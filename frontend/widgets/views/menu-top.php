<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/20/2016
 * Time: 5:06 PM
 */
use common\models\Category;
use yii\helpers\Url;

?>
<div class="container">
    <div class="row">
        <div id="main-menu" class="main-menu col-sm-9">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="#"><?= Yii::t('app','MENU') ?></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="<?= Url::home() ?>"><?= Yii::t('app','Home') ?></a></li>
                            <?php
                            if ($categories) {
                                /** @var Category $category */
                                foreach ($categories as $category) {
                                    ?>
                                    <li class="<?= !empty($category->child_count) ? 'dropdown' : '' ?>">
                                        <a href="<?= Url::to(['category/index', 'id' => $category->id]) ?>"
                                            <?php if(!empty($category->child_count)){ ?> class="dropdown-toggle" data-toggle="dropdown" <?php } ?>>
                                            <?= $category->display_name ?>
                                        </a>
                                        <?php if(!empty($category->child_count)){ \frontend\widgets\MenuTop::getChildlevel1NoImage($category->id); } ?>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>
        </div>
    </div>
</div>