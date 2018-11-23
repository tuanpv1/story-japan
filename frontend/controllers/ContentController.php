<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Content;
use common\models\InfoPublic;
use common\models\Slide;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class ContentController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionDetail($id)
    {
        $content = Content::findOne(['id' => $id, 'status' => Content::STATUS_ACTIVE]);
        $link = $content->getImageLinkFE('product-s3-100x122.jpg');
        $info = InfoPublic::findOne(InfoPublic::ID_DEFAULT);
        return $this->render('detail', [
            'content' => $content,
            'link' => $link,
            'info' => $info,
        ]);
    }

    public function actionSearch()
    {
        if (!empty($_POST['keyword'])) {
            $category = '';
            $value_max = null;
            $value_min = 0;
            if (!empty(Yii::$app->request->post('value_max'))) {
                $value_max = Yii::$app->request->post('value_max');
            }
            if (!empty(Yii::$app->request->post('value_min'))) {
                $value_min = Yii::$app->request->post('value_min');
            }
            $banner = Slide::findAll(['status' => Slide::STATUS_ACTIVE, 'type' => Slide::SLIDE_CATEGORY]);
            $contents = Content::find()
                ->select('content.id,content.display_name,content.type,content.short_description,content.price,content.images,content.price_promotion,content.code')
                ->andWhere(['status' => Content::STATUS_ACTIVE])
                ->andWhere(['like', 'display_name', $_POST['keyword']]);

            if (!empty($_POST['category_id'])) {
                $category_id = $_POST['category_id'];
                $category = Category::findOne($category_id);
                if (!$category) {
                    throw new NotFoundHttpException(Yii::t('app', 'Không tìm thấy danh mục'));
                }
                $listCats = Category::allChildCats($category_id);
                $listCats[] = $category->id;
                $contents->innerJoin('content_category_asm', 'content_category_asm.content_id = content.id')
                    ->andWhere(['IN','content_category_asm.category_id',$listCats]);
            }
            if ($value_max) {
                $contents->andWhere(['BETWEEN', 'content.price_promotion', $value_min, $value_max]);
            }
            $contents->orderBy(['content.created_at' => 'DESC']);

            $countQuery = clone $contents;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $pageSize = 9;
            $pages->setPageSize($pageSize);
            $contents = $contents->offset($pages->offset)
                ->limit(9)->all();
            if($value_max){
                return $this->renderPartial('_contents',[
                    'contents' => $contents,
                    'category' => $category,
                    'pages' => $pages,
                    'keyword' => $_POST['keyword']
                ]);
            }
            return $this->render('content-search', [
                'contents' => $contents,
                'banner' => $banner,
                'category' => $category,
                'pages' => $pages,
                'keyword' => $_POST['keyword']
            ]);
        } else {
            return $this->redirect(['site/index']);
        }
    }

    public function actionGetMoreContents()
    {
        if (!empty($_POST['keyword'])) {
            $category = '';
            $value_max = null;
            $value_min = 0;
            if (!empty(Yii::$app->request->post('value_max'))) {
                $value_max = Yii::$app->request->post('value_max');
            }
            if (!empty(Yii::$app->request->post('value_min'))) {
                $value_min = Yii::$app->request->post('value_min');
            }
            $contents = Content::find()
                ->select('content.id,content.display_name,content.type,content.short_description,content.price,content.images,content.price_promotion,content.code')
                ->andWhere(['status' => Content::STATUS_ACTIVE])
                ->andWhere(['like', 'display_name', $_POST['keyword']]);

            if (!empty($_POST['category_id'])) {
                $category_id = $_POST['category_id'];
                $category = Category::findOne($category_id);
                if (!$category) {
                    throw new NotFoundHttpException(Yii::t('app', 'Không tìm thấy danh mục'));
                }
                $listCats = Category::allChildCats($category_id);
                $listCats[] = $category->id;
                $contents->innerJoin('content_category_asm', 'content_category_asm.content_id = content.id')
                    ->andWhere(['IN','content_category_asm.category_id',$listCats]);
            }
            if ($value_max) {
                $contents->andWhere(['BETWEEN', 'content.price_promotion', $value_min, $value_max]);
            }
            $contents->orderBy(['content.created_at' => 'DESC']);
            $page = Yii::$app->request->post('page');
            $contents = $contents->offset($page)
                ->limit(6)->all();
            return $this->renderPartial('_contents_more', [
                'contents' => $contents,
            ]);
        } else {
            return false;
        }
    }
}