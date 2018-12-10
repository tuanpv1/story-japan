<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Content;
use common\models\InfoPublic;
use common\models\SubscriberFavorite;
use common\models\SubscriberHistory;
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
        $favourite = false;
        $content = Content::findOne(['id' => $id, 'status' => Content::STATUS_ACTIVE]);
        $content->view_count = $content->view_count + 1;
        if ($content->parent_id) {
            $content->parent->view_count = $content->parent->view_count + 1;
            $content->parent->update(false);
        }
        $content->update(false);
        // update history
        if(!Yii::$app->user->isGuest){
            $his = SubscriberHistory::findOne(['content_id' => $id, 'subscriber_id' => Yii::$app->user->id]);
            if(!$his){
                $his = new SubscriberHistory();
                $his->subscriber_id = Yii::$app->user->id;
                $his->content_id = $id;
                $his->time_read = time();
            }
            $his->time_again = time();
            $his->save();

            $checkRecord = SubscriberFavorite::findOne(['content_id' => $id,'subscriber_id' => Yii::$app->user->id]);
            if($checkRecord){
                $favourite = true;
            }
        }
        $link = $content->getImageLinkFE('product-s3-100x122.jpg');
        $info = InfoPublic::findOne(InfoPublic::ID_DEFAULT);
        return $this->render('detail', [
            'content' => $content,
            'link' => $link,
            'info' => $info,
            'favourite' => $favourite,
        ]);
    }

    public function actionPreview($id)
    {
        $content = Content::findOne(['id' => $id]);
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
            $value_max = 0;
            $value_min = 0;
            $is_search = false;
            if (!empty(Yii::$app->request->post('value_max'))) {
                $value_max = Yii::$app->request->post('value_max');
            }
            if (!empty(Yii::$app->request->post('value_min'))) {
                $value_min = Yii::$app->request->post('value_min');
            }
            if (!empty(Yii::$app->request->post('is_search'))) {
                $is_search = Yii::$app->request->post('is_search');
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
                    ->andWhere(['IN', 'content_category_asm.category_id', $listCats]);
            }
            if ($is_search) {
                if ($value_max == 0 && $value_min) {
                    $contents->andWhere(['>=', 'content.price_promotion', $value_min]);
                } else {
                    $contents->andWhere(['BETWEEN', 'content.price_promotion', $value_min, $value_max]);
                }
            }
            $contents->orderBy(['content.created_at' => 'DESC']);

            $countQuery = clone $contents;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $pageSize = 9;
            $pages->setPageSize($pageSize);
            $contents = $contents->offset($pages->offset)
                ->limit(9)->all();
            if ($is_search) {
                return $this->renderPartial('_contents', [
                    'contents' => $contents,
                    'category' => $category,
                    'pages' => $pages,
                    'keyword' => $_POST['keyword']
                ]);
            }
            return $this->render('content-search', [
                'contents' => $contents,
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
                    ->andWhere(['IN', 'content_category_asm.category_id', $listCats]);
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

    public function actionNextEpisode()
    {
        $id = Yii::$app->request->post('id');
        if (empty($id)) {
            return ['success' => false, 'message' => Yii::t('app', 'Id required')];
        }
        $content = Content::findOne($id);
        if (empty($content) || empty($content->parent_id)) {
            return ['success' => false, 'message' => Yii::t('app', 'Error: Not Found Content')];
        }
        $contentNext = Content::find()
            ->andWhere(['status' => Content::STATUS_ACTIVE])
            ->andWhere(['parent_id' => $content->parent_id])
            ->andWhere(['>', 'episode_order', $content->episode_order])
            ->orderBy(['episode_order' => SORT_ASC])
            ->one();
        if(!$contentNext){
            return ['success' => false, 'message' => Yii::t('app', 'Not have any chapter')];
        }
        $contentNext->view_count = $contentNext->view_count + 1;
        if ($contentNext->parent_id) {
            $contentNext->parent->view_count = $contentNext->parent->view_count + 1;
            $contentNext->parent->update(false);
        }
        $contentNext->update(false);
        // update history
        if(!Yii::$app->user->isGuest){
            $his = SubscriberHistory::findOne(['content_id' => $contentNext->id, 'subscriber_id' => Yii::$app->user->id]);
            if(!$his){
                $his = new SubscriberHistory();
                $his->subscriber_id = Yii::$app->user->id;
                $his->content_id = $contentNext->id;
                $his->time_read = time();
            }
            $his->time_again = time();
            $his->save();
        }
        return $this->renderPartial('_content_chapter', [
            'content' => $contentNext,
        ]);
    }

    public function actionPreEpisode()
    {
        $id = Yii::$app->request->post('id');
        if (empty($id)) {
            return ['success' => false, 'message' => Yii::t('app', 'Id required')];
        }
        $content = Content::findOne($id);
        if (empty($content) || empty($content->parent_id)) {
            return ['success' => false, 'message' => Yii::t('app', 'Error: Not Found Content')];
        }
        $contentNext = Content::find()
            ->andWhere(['status' => Content::STATUS_ACTIVE])
            ->andWhere(['parent_id' => $content->parent_id])
            ->andWhere(['<', 'episode_order', $content->episode_order])
            ->orderBy(['episode_order' => SORT_DESC])
            ->one();
        if(!$contentNext){
            return ['success' => false, 'message' => Yii::t('app', 'Not have any chapter')];
        }
        $contentNext->view_count = $contentNext->view_count + 1;
        if ($contentNext->parent_id) {
            $contentNext->parent->view_count = $contentNext->parent->view_count + 1;
            $contentNext->parent->update(false);
        }
        $contentNext->update(false);
        // update history
        if(!Yii::$app->user->isGuest){
            $his = SubscriberHistory::findOne(['content_id' => $contentNext->id, 'subscriber_id' => Yii::$app->user->id]);
            if(!$his){
                $his = new SubscriberHistory();
                $his->subscriber_id = Yii::$app->user->id;
                $his->content_id = $contentNext->id;
                $his->time_read = time();
            }
            $his->time_again = time();
            $his->save();
        }
        return $this->renderPartial('_content_chapter', [
            'content' => $contentNext,
        ]);
    }
}