<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 11/7/2018
 * Time: 8:31 AM
 */
?>
<?php
$i = 0;
if ($categories) {
    /** @var \common\models\Category $category */
    foreach ($categories as $category) {
        if ($i == 0) {
            ?>
            <li class="active"><a
                        href="<?= \yii\helpers\Url::to(['category/index', 'id' => $category->id]) ?>"><?= $category->display_name ?></a>
            </li>
            <?php
        } else {
            ?>
            <li>
                <a href="<?= \yii\helpers\Url::to(['category/index', 'id' => $category->id]) ?>"><?= $category->display_name ?></a>
            </li>
            <?php
        }
        $i++;
    }
}
?>
