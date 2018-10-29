<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 10/29/2018
 * Time: 12:02 PM
 */
use common\helpers\CUtils;
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
            <a class="home" href="<?= Url::to(['news/index']) ?>" title="Tin tức">Tin tức</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span> <?= $new->display_name ?></span>
        </div>
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">
            <!-- Center colunm-->
            <div class="center_column col-xs-12" id="center_column">
                <h1 class="page-heading">
                    <span class="page-heading-title2"><?= $new->display_name ?></span>
                </h1>
                <article class="entry-detail">
                    <div class="entry-meta-data">
                        <span class="author">
                        <i class="fa fa-user"></i>
                        by: <a href="#"><?= $new->getUserCreated() ?></a></span>
                        <span class="cat">
                            <i class="fa fa-folder-o"></i>
                            <a href="<?= Url::to(['news/index']) ?>">News</a>
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
                <!-- Related Posts -->
                <div class="single-box">
                    <h2>Tin tức liên quan</h2>
                    <ul class="related-posts owl-carousel" data-dots="false" data-loop="true" data-nav="true"
                        data-margin="30" data-autoplayTimeout="1000" data-autoplayHoverPause="true"
                        data-responsive='{"0":{"items":1},"600":{"items":2},"1000":{"items":3}}'>
                        <?php if ($relatedNews) {
                            /** @var News $news */
                            foreach ($relatedNews as $news) {
                                ?>
                                <li class="post-item">
                                    <article class="entry">
                                        <div class="entry-thumb image-hover2">
                                            <a href="<?= Url::to(['news/detail', 'id' => $new->id]) ?>">
                                                <img src="<?= $new->getImageDisplayLink() ?>"
                                                     alt="<?= $new->display_name ?>">
                                            </a>
                                        </div>
                                        <div class="entry-ci">
                                            <h3 class="entry-title"><a
                                                        href="#"><?= CUtils::substr($new->display_name, 25) ?></a>
                                            </h3>
                                            <div class="entry-meta-data">
                                                <span class="date">
                                                    <i class="fa fa-calendar"></i> <?= date('d/m/Y H:i:s', $new->created_at) ?>
                                                </span>
                                            </div>
                                            <div class="entry-more">
                                                <a href="<?= Url::to(['news/detail', 'id' => $new->id]) ?>">Chi tiết</a>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>
