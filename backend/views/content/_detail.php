<?php
use common\models\Content;
use kartik\detail\DetailView;

/**
 * @var \common\models\Content $model
 */
?>
<?php
$grid = [
    'display_name',
    'title_short',
    [
        'attribute' => 'status',
        'format' => 'html',
        'value' => "<span class='" . $model->getCssStatus() . "'>" . $model->getStatusName() . "</span>"
    ],
    'tags',
    [
        'attribute' => 'type',
        'format' => 'html',
        'value' => "<span class='label label-primary'>" . $model->getTypeName() . "</span>"
    ],
    [
        'attribute' => 'language',
        'value' => Yii::$app->params['languages'][$model->language]
    ],
    'order',
    [
        'attribute' => 'episode_count',
        'visible' => $model->is_series?true:false,
    ],
    [
        'attribute' => 'episode_order',
        'visible' => $model->parent_id?true:false,
    ],
    'author',
    [
        'attribute' => 'created_at',
        'value' => date('d-m-Y H:i:s', $model->created_at)
    ],
    [
        'attribute' => 'updated_at',
        'value' => date('d-m-Y H:i:s', $model->updated_at)
    ],
    [
        'attribute' => 'approved_at',
        'value' => $model->approved_at ? date('d-m-Y H:i:s', $model->approved_at) : ''
    ],
    'short_description:html',
    'description:html'
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
