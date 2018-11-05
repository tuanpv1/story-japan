<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 10/29/2018
 * Time: 12:02 PM
 */
use common\models\News;
use yii\helpers\Url;

/** @var $new News */
?>
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="<?= Url::home() ?>" title="Trang chủ">Trang chủ</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a class="home" href="<?= Url::to(['news/index']) ?>"
               title="Tin tức"><?= News::getTypeName($new->type) ?></a>
        </div>
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">
            <!-- Center colunm-->
            <div class="center_column col-xs-12" id="center_column">
                <h1 class="page-heading">
                    <span class="page-heading-title2"><?= News::getTypeName($new->type) ?></span>
                </h1>
                <article class="entry-detail">
                    <div class="entry-meta-data">
                        <span class="author">
                        <i class="fa fa-user"></i>
                        by: <a href="#"><?= $new->getUserCreated() ?></a></span>
                        <span class="cat">
                            <i class="fa fa-folder-o"></i>
                            <a href="<?= Url::to(['news/index']) ?>"><?= News::getTypeName($new->type) ?></a>
                        </span>
                        <span class="date"><i
                                    class="fa fa-calendar"></i> <?= date('d/m/Y H:i:s', $new->created_at) ?></span>
                    </div>
                    <div class="entry-photo">
                        <img src="<?= $new->short_description ?>" alt="<?= $new->display_name ?>">
                    </div>
                    <div class="content-text clearfix">
                        <?= $new->content ?>
                    </div>
                </article>
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>
