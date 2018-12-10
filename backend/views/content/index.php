<?php

use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Nội dung');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('UITree.init();');

\common\assets\ToastAsset::register($this);
\common\assets\ToastAsset::config($this, [
    'positionClass' => \common\assets\ToastAsset::POSITION_TOP_RIGHT
]);
$publishStatus = \common\models\Content::STATUS_PENDING;
// $unPublishStatus=\common\models\Content::STATUS_DRAFT;
$unPublishStatus = \common\models\Content::STATUS_INACTIVE;
$showStatus = \common\models\Content::STATUS_ACTIVE;
$deleteStatus = \common\models\Content::STATUS_DELETE;
?>


<?php
$updateLink = \yii\helpers\Url::to(['content/update-status-content']);
$m1 = Yii::t('app', 'Please select less than 1 content.');
$m2 = Yii::t('app', 'Are you sure delete?');
$js = <<<JS
    function updateStatusContent(newStatus){

        feedbacks = $("#content-index-grid").yiiGridView("getSelectedRows");
        if(feedbacks.length <= 0){
            alert('{$m1}');
            return;
        }
        var delConfirm = true;

        if(newStatus == 2){
            delConfirm = confirm('{$m2}');
        }

        if(delConfirm){
            jQuery.post(
                '{$updateLink}',
                { ids:feedbacks ,newStatus:newStatus}
            )
            .done(function(result) {
                if(result.success){
                    toastr.success(result.message);
                    jQuery.pjax.reload({container:'#content-index-grid'});
                }else{
                    toastr.error(result.message);
                }
            })
            .fail(function() {
                toastr.error("server error");
            });
        }

        return;
    }
JS;

$this->registerJs($js, \yii\web\View::POS_HEAD);
?>
<div class="row">
    <div class="col-md-3 col-sm-12">
        <?php
        $form = ActiveForm::begin([
            'method' => 'get',
            'id' => 'Form_Grid_Content',
            'type' => ActiveForm::TYPE_VERTICAL,
            'fullSpan' => 12,
            'formConfig' => [
                'showLabels' => false,
                'labelSpan' => 2,
                'deviceSize' => ActiveForm::SIZE_SMALL,
            ],
        ]);
        $formId = $form->id;
        echo $form->field($searchModel, 'categoryIds')->hiddenInput(['id' => 'categoryIds'])->label(false);
        ?>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i><?= Yii::t('app', "Search") ?>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body clearfix">
                <?= $form->field($searchModel, 'keyword')->textInput(['placeholder' => Yii::t('app', 'Search by keyword'), 'class' => 'input-circle']); ?>
            </div>
        </div>

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"><?= Yii::t('app', 'Categories') ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>


            <div class="portlet-body">
                <?= \common\widgets\Jstree::widget([
                    'clientOptions' => [
                        "checkbox" => ["keep_selected_style" => false],
                        "plugins" => ["checkbox"]
                    ],
                    'data' => $selectedCats,
                    'eventHandles' => [
                        'changed.jstree' => "function(e,data) {
                            jQuery(\"[name^='VideoSearch[categoryIds][]']\").attr('checked',null);
                            var i, j, r = [];
                            var catIds='';
                            for(i = 0, j = data.selected.length; i < j; i++) {
                                var item = $(\"#\" + data.selected[i]);
                                var value = item.attr(\"id\");
                                if(i==j-1){
                                    catIds += value;
                                } else{
                                    catIds += value +',';

                                }
                            }
                            jQuery(\"#categoryIds\").val(catIds);
                            jQuery(\"#" . $formId . "\").submit();
                         }"
                    ]
                ]) ?>
            </div>
        </div>
        <?php
        $form->end();
        ?>
    </div>
    <div class="col-md-9 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span
                            class="caption-subject font-green-sharp bold uppercase"><?= Yii::t('app', 'Manga list') ?> </span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <p>
                    <?php echo Html::a(Yii::t('app', 'Create'), Yii::$app->urlManager->createUrl(['content/create']), ['class' => 'btn btn-success']) ?>
                </p>
                <?php
                $gridColumn = [
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'format' => 'raw',
                        'attribute' => 'images',
                        'value' => function ($model, $key, $index, $widget) {
                            /** @var $model \common\models\Content */

                            $link = $model->getFirstImageLink();
                            return $link ? Html::img($link, ['alt' => 'Thumbnail', 'width' => '50', 'height' => '50']) : '';

                        },
                    ],
                    [
                        'format' => 'raw',
                        'class' => '\kartik\grid\DataColumn',
                        'label' => 'Quick view',
                        'value' => function ($model, $key, $index) {
                            return "<a target='_blank' href='" . Yii::$app->params['preview_link'] . 'content/preview&id=' . $model->id . "'>link frontend</a>";
                        },
                    ],
                    [
                        'format' => 'raw',
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'display_name',
                        'value' => function ($model, $key, $index) {
                            return Html::a($model->display_name, ['view', 'id' => $model->id], ['class' => 'label label-primary']);
                        },
                    ],
                    [
                        'format' => 'raw',
                        'class' => '\kartik\grid\DataColumn',
                        'width' => '15%',
                        'filterType' => GridView::FILTER_DATE,
                        'attribute' => 'created_at',
                        'value' => function ($model) {
                            return date('d-m-Y H:i:s', $model->created_at);
                        }
                    ],
                    [
                        'class' => 'kartik\grid\EditableColumn',
                        'attribute' => 'status',
                        'width' => '200px',
                        'refreshGrid' => true,
                        'editableOptions' => function ($model, $key, $index) {
                            return [
                                'header' => Yii::t('app', 'Trạng thái'),
                                'size' => 'md',
                                'displayValueConfig' => \common\models\Content::getListStatus('filter'),
                                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                                'data' => \common\models\Content::getListStatus('filter'),
                                'placement' => \kartik\popover\PopoverX::ALIGN_LEFT,
                                'formOptions' => [
                                    'action' => ['content/update-status', 'id' => $model->id]
                                ],
                            ];
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \common\models\Content::getListStatus('filter'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],

                        'filterInputOptions' => ['placeholder' => Yii::t('app', 'Tất cả')],
                    ],

                ];


                $gridColumn[] = [
                    'class' => 'kartik\grid\ActionColumn',
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                Yii::$app->urlManager->createUrl(['content/delete', 'id' => $model->id]), [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('app','Are you sure delete?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]);
                        }
                    ],
                ];
                $gridColumn[] = [
                    'class' => 'kartik\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                ];
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'content-index-grid',
                    'filterModel' => $searchModel,
                    'responsive' => true,
                    'pjax' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => Yii::t('app', 'Manga list')
                    ],
                    'toolbar' => [
                        [
                            'content' =>
                                Html::button('<i class="glyphicon glyphicon-ok"></i> Publish', [
                                    'type' => 'button',
                                    'title' => 'Publish',
                                    'class' => 'btn btn-success',
                                    'onclick' => 'updateStatusContent("' . $showStatus . '");'
                                ])

                        ],
                        [
                            'content' =>
                                Html::button('<i class="glyphicon glyphicon-minus"></i> Unpublish', [
                                    'type' => 'button',
                                    'title' => 'Unpublish',
                                    'class' => 'btn btn-danger',
                                    'onclick' => 'updateStatusContent("' . $unPublishStatus . '");'
                                ])

                        ],
                        [
                            'content' =>
                                Html::button('<i class="glyphicon glyphicon-trash"></i> Delete', [
                                    'type' => 'button',
                                    'title' => 'Delete',
                                    'class' => 'btn btn-danger',
                                    'onclick' => 'updateStatusContent("' . $deleteStatus . '");'
                                ])

                        ],

                    ],
                    'columns' => $gridColumn
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<<JS
function submitForm(){
jQuery("#Form_Grid_Content").submit();
}
JS;
$this->registerJs($js, \yii\web\View::POS_HEAD);
?>
