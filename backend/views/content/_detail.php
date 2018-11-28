<?php
use common\models\Content;
use kartik\detail\DetailView;

/**
 * @var \common\models\Content $model
 */
?>
<?php
$grid = [
    [
        'attribute' => 'display_name',
    ],
    'title_short',
    'short_description:html',
    'description:html',
    'content:html',
    [
        'attribute' => 'status',
        'format' => 'html',
        'value' => "<span class='" . $model->getCssStatus() . "'>" . $model->getStatusName() . "</span>"
    ],
    [
        'attribute' => 'link',
        'format' => 'html',
        'value' => "<a href='" . $model->link . "'>Xem nguồn hàng</a>"
    ],
    'tags',
    [
        'attribute' => 'created_at',
        'value' => date('d-m-Y H:i:s', $model->created_at)
    ],
    [
        'attribute' => 'updated_at',
        'value' => date('d-m-Y H:i:s', $model->updated_at)
    ],
    [
        'attribute' => 'honor',
        'format' => 'html',
        'value' => "<span class='label label-primary'>" . Content::$list_honorDetail[$model->honor] . "</span>"
    ],
    [
        'attribute' => 'type',
        'format' => 'html',
        'value' => "<span class='label label-primary'>" . Content::$list_type[$model->type] . "</span>"
    ],
    [
        'attribute' => 'availability',
        'format' => 'html',
        'value' => "<span class='label label-primary'>" . Content::$listAvailability[$model->availability] . "</span>"
    ],
    'order',
    [
        'label' => Yii::t('app', 'Ngày phê duyệt'),
        'value' => $model->approved_at ? date('d-m-Y H:i:s', $model->approved_at) : ''
    ],
];


$grid = array_merge($grid, $model->viewAttr);

?>
<?= DetailView::widget([
    'model' => $model,
    'condensed' => true,
    'hover' => true,
    'mode' => DetailView::MODE_VIEW,
    'labelColOptions' => ['style' => 'width: 20%'],
    'attributes' => $grid
]) ?>
