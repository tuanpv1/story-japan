<?php

namespace backend\controllers;

use Yii;
use common\models\News;
use common\models\NewsSearch;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex($type = News::TYPE_ABOUT)
    {
        if ($type == News::TYPE_ABOUT || $type == News::TYPE_CONTACT) {
            $model = News::find()->andWhere(['status' => News::STATUS_ACTIVE])
                ->andWhere(['type' => $type])
                ->orderBy(['id' => SORT_DESC])
                ->one();
            if ($model) {
                return $this->render('view', ['model' => $model]);
            } else {
                return $this->redirect(['create', 'type' => $type]);
            }
        } elseif ($type == News::TYPE_NEWS) {
            $searchModel = new NewsSearch();
            $params = Yii::$app->request->queryParams;

            $params['NewsSearch']['type'] = $type;

            $dataProvider = $searchModel->search($params);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'type' => $type,
            ]);
        }
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new News();
        $model->setScenario('create');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $image_display = UploadedFile::getInstance($model, 'image_display');
            if ($image_display) {
                $file_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $image_display->extension;
                $tmp = Yii::getAlias('@backend') . '/web/' . Yii::getAlias('@image_news') . '/';
                if ($image_display->saveAs($tmp . $file_name)) {
                    $model->image_display = $file_name;
                }
            }

            $model->type = $type;
            if ($type == News::TYPE_ABOUT || $type == News::TYPE_CONTACT) {
                $model->status = News::STATUS_ACTIVE;
            }
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thêm mới thành công!'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Thêm không thành công!'));
                Yii::$app->getErrorHandler();
                return $this->render('create', [
                    'model' => $model,
                    'type' => $type,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'type' => $type,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_image_display = $model->image_display;

        if ($model->load(Yii::$app->request->post())) {
            $image_display = UploadedFile::getInstance($model, 'image_display');
            if ($image_display) {
                $file_name = Yii::$app->user->id . '.' . uniqid() . time() . '.' . $image_display->extension;
                $tmp = Yii::getAlias('@backend') . '/web/' . Yii::getAlias('@image_news') . '/';
                if ($image_display->saveAs($tmp . $file_name)) {
                    $model->image_display = $file_name;
                }
            } else {
                $model->image_display = $old_image_display;
            }
            if ($model->update(false)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Cập nhật thành công!'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Cập nhật không thành công!'));
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $type = $model->type;
        if ($model->status != News::STATUS_ACTIVE) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Xóa tin tức thành công!'));
            $model->delete();
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Không được xóa tin tức đang hoạt động!'));
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->redirect(['index', 'type' => $type]);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
