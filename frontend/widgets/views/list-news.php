<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 2/16/2017
 * Time: 1:46 PM
 */
use common\models\News;
use yii\helpers\Url;

?>

<div id="content-wrap">
    <div class="container">
        <!-- blog list -->
        <div class="blog-list">
            <h2 class="page-heading">
                <span class="page-heading-title">TIN MỚI</span>
            </h2>
            <div class="blog-list-wapper">
                <ul class="owl-carousel" data-dots="false" data-loop="true" data-nav="true" data-margin="30"
                    data-autoplayTimeout="1000" data-autoplayHoverPause="true"
                    data-responsive='{"0":{"items":1},"600":{"items":3},"1000":{"items":4}}'>
                    <?php
                    if ($news) {
                        /** @var News $new */
                        foreach ($news as $new) {
                            ?>
                            <li>
                                <div class="post-thumb image-hover2">
                                    <a href="<?= Url::to(['news/detail', 'id' => $new->id]) ?>">
                                        <img src="<?= $new->getImageDisplayLink() ?>" alt="<?= $new->display_name ?>">
                                    </a>
                                </div>
                                <div class="post-desc">
                                    <h5 class="post-title">
                                        <a href="<?= Url::to(['news/detail', 'id' => $new->id]) ?>"><?= $new->display_name ?></a>
                                    </h5>
                                    <div class="post-meta">
                                        <span class="date"><?= date('d/m/Y H:i:s', $new->created_at) ?></span>
                                    </div>
                                    <div class="readmore">
                                        <a href="<?= Url::to(['news/detail', 'id' => $new->id]) ?>">Xem thêm</a>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        Chưa có nội dung
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- ./blog list -->
    </div> <!-- /.container -->
</div>
