<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Content;
use common\models\Slide;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class CategoryController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $value_max = null;
        $value_min = 0;
        $id = Yii::$app->request->get('id');
        $banner = Slide::findAll(['status' => Slide::STATUS_ACTIVE, 'type' => Slide::SLIDE_CATEGORY]);
        $cat = Category::findOne($id);
        if (!$cat) {
            throw new NotFoundHttpException(Yii::t('app', 'Không tìm thấy danh mục'));
        }
        if (!empty(Yii::$app->request->post('value_max'))) {
            $value_max = Yii::$app->request->post('value_max');
        }
        if (!empty(Yii::$app->request->post('value_min'))) {
            $value_min = Yii::$app->request->post('value_min');
        }

        $listCats = Category::allChildCats($cat->id);
        $listCats[] = $cat->id;
        $contents = Content::find()
            ->select('content.id,content.display_name,content.type,content.short_description,content.price,content.images,content.price_promotion,content.code')
            ->innerJoin('content_category_asm', 'content_category_asm.content_id = content.id')
            ->andWhere(['content.status' => Content::STATUS_ACTIVE])
            ->andWhere(['IN', 'content_category_asm.category_id', $listCats]);
        if (!empty($keyword)) {
            $contents->andWhere(['like', 'content.display_name', $keyword]);
        }
        if (!empty($value_max)) {
            $contents->andWhere(['BETWEEN', 'content.price_promotion', $value_min, $value_max]);
        }
        $contents->orderBy(['content.created_at' => 'DESC']);

        $countQuery = clone $contents;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pageSize = 9;
        $pages->setPageSize($pageSize);
        $contents = $contents->offset($pages->offset)
            ->limit(9)->all();

        if ($value_max) {
            return $this->renderPartial('_contents', [
                'contents' => $contents,
                'cat' => $cat,
                'pages' => $pages,
            ]);
        }
        return $this->render('index', [
            'contents' => $contents,
            'banner' => $banner,
            'cat' => $cat,
            'pages' => $pages,
        ]);
    }

    public function actionGetMoreContents()
    {
        $value_max = null;
        $value_min = 0;
        $id = Yii::$app->request->post('category_id');
        $cat = Category::findOne($id);
        if (!$cat) {
            throw new NotFoundHttpException(Yii::t('app', 'Không tìm thấy danh mục'));
        }
        if (!empty(Yii::$app->request->post('value_max'))) {
            $value_max = Yii::$app->request->post('value_max');
        }
        if (!empty(Yii::$app->request->post('value_min'))) {
            $value_min = Yii::$app->request->post('value_min');
        }

        $listCats = Category::allChildCats($cat->id);
        $listCats[] = $cat->id;
        $contents = Content::find()
            ->select('content.id,content.display_name,content.type,content.short_description,content.price,content.images,content.price_promotion,content.code')
            ->innerJoin('content_category_asm', 'content_category_asm.content_id = content.id')
            ->andWhere(['content.status' => Content::STATUS_ACTIVE])
            ->andWhere(['IN', 'content_category_asm.category_id', $listCats]);
        if (!empty($keyword)) {
            $contents->andWhere(['like', 'content.display_name', $keyword]);
        }
        if (!empty($value_max)) {
            $contents->andWhere(['BETWEEN', 'content.price_promotion', $value_min, $value_max]);
        }
        $contents->orderBy(['content.created_at' => 'DESC']);

        $page = Yii::$app->request->post('page');
        $contents = $contents->offset($page)
            ->limit(6)->all();
        return $this->renderPartial('_contents_more', [
            'contents' => $contents,
        ]);
    }
}