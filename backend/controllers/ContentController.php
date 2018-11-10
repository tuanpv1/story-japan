<?php

namespace backend\controllers;

use backend\models\HtmlDom;
use common\components\ActionLogTracking;
use common\helpers\CVietnameseTools;
use common\models\Content;
use common\models\ContentSearch;
use common\models\User;
use kartik\form\ActiveForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ContentController implements the CRUD actions for Content model.
 */
class ContentController extends BaseBEController
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'update-status-content' => ['post'],
                    'process' => ['post'],
                ],
            ],
            [
                'class' => ActionLogTracking::className(),
                'user' => Yii::$app->user,
            ],
        ]);
    }

    /**
     * Lists all Content models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (isset($_POST['hasEditable'])) {
            // read your posted model attributes
            $post = Yii::$app->request->post();
            if ($post['editableKey']) {
                // read or convert your posted information
                $cat = Content::findOne($post['editableKey']);
                $index = $post['editableIndex'];
                if ($cat) {
                    $cat->load($post['Content'][$index], '');
                    if ($cat->update()) {
                        echo \yii\helpers\Json::encode(['output' => '', 'message' => '']);
                    } else {
                        echo \yii\helpers\Json::encode(['output' => '', 'message' => Yii::t('app', 'Dữ liệu không hợp lệ')]);
                    }
                } else {
                    echo \yii\helpers\Json::encode(['output' => '', 'message' => Yii::t('app', 'Danh mục không tồn tại')]);
                }
            } // else if nothing to do always return an empty JSON encoded output
            else {
                echo \yii\helpers\Json::encode(['output' => '', 'message' => '']);
            }
            return;
        }
        $searchModel = new ContentSearch();
        $params = Yii::$app->request->queryParams;
        Yii::trace($params);
        $params['ContentSearch']['created_at'] = isset($params['ContentSearch']['created_at']) && $params['ContentSearch']['created_at'] !== '' ? strtotime($params['ContentSearch']['created_at']) : '';
        $dataProvider = $searchModel->filter($params);
        // $dataProvider->query->andFilterWhere(['in', 'content.status', [Content::STATUS_WAIT_TRANSCODE, Content::STATUS_ACTIVE, Content::STATUS_DRAFT, Content::STATUS_INVISIBLE]]);
        $searchModel->keyword = isset($params['ContentSearch']['keyword']) ? $params['ContentSearch']['keyword'] : '';
        /* @var  $userAccessed User */
        $selectedCats = isset($params['ContentSearch']['categoryIds']) ? explode(',', $params['ContentSearch']['categoryIds']) : [];
        // var_dump($dataProvider);die;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'selectedCats' => $selectedCats,
        ]);
    }

    /**
     * Displays a single Content model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id, $active = 1)
    {
        ini_set('memory_limit', '-1');
        if (isset($_POST['hasEditable'])) {
            // read your posted model attributes
            $post = Yii::$app->request->post();
            if ($post['editableKey']) {
                // read or convert your posted information
                $index = $post['editableIndex'];
            } // else if nothing to do always return an empty JSON encoded output
            else {
                echo \yii\helpers\Json::encode(['output' => '', 'message' => '']);
            }

            return;
        }
        $model = $this->findModel($id);
        //Images
        $imageModel = new \backend\models\Image();
        $images = $model->getImages();
        $imageProvider = new ArrayDataProvider([
            'key' => 'name',
            'allModels' => $images,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('view', [
            'model' => $model,
            'id' => $id,
            'imageModel' => $imageModel,
            'imageProvider' => $imageProvider,
            'active' => $active,
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate($model = null)
    {
        if (!$model) {
            $model = new Content();
        }
        $model->loadDefaultValues();
        $model->code = rand(10000, 99999);
        $model->setScenario('adminModify');

        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && isset($post['ajax']) && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if (isset(Yii::$app->request->post()['Content']['list_cat_id'])) {
                $model->list_cat_id = Yii::$app->request->post()['Content']['list_cat_id'];
            }
            $model->expired_at = strtotime($model->expired_at);
            $model->ascii_name = CVietnameseTools::makeSearchableStr($model->display_name);
            $tags = $model->tags;
            if (is_array($tags)) {
                $model->tags = implode(';', $tags);
            }
            $model->created_at = time();
            $model->updated_at = time();
            if (!$model->honor) {
                $model->honor = 0;
            }
            if (empty($model->price_promotion)) {
                $model->price_promotion = $model->price;
            }
            if ($model->save()) {
                $model->createCategoryAsm();

                // lÆ°u loáº¡i is_slide Ä‘á»ƒ lá»c bÃªn quáº£n lÃ½ slide
                $image_slide = Content::convertJsonToArray($model->images);
                foreach ($image_slide as $key => $row) {
                    if ($row['type'] == Content::IMAGE_TYPE_SLIDE) {
                        $model->is_slide = 1;
                    }
                    if ($row['type'] == Content::IMAGE_TYPE_SLIDECATEGORY) {
                        $model->is_slide_category = 1;
                    }
                    //end screenshoot
                }
                $model->save(false);
                // tao log
                \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Lưu nội dung thành công'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::info($model->getErrors());
                \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Lưu nội dung không thành công'));
            }
        }
        $selectedCats = explode(',', $model->list_cat_id);
        // get screenshoot
        $logoInit = [];
        $thumbnail_epgInit = [];
        $thumbnailInit = [];
        $screenshootInit = [];
        $slideInit = [];
        $logoPreview = [];
        $thumbnail_epgPreview = [];
        $thumbnailPreview = [];
        $screenshootPreview = [];
        $slidePreview = [];
        $tags = explode(';', $model->tags);
        $thumb_epg = [];
        $thumb = [];
        $slide = [];
        $screenshoot = [];
        $images = Content::convertJsonToArray($model->images);
        foreach ($images as $key => $row) {
            $key = $key + 1;
            $urlDelete = Yii::$app->urlManager->createAbsoluteUrl(['/content/delete-image', 'name' => $row['name'], 'type' => $row['type'], 'content_id' => $model->id]);
            $name = $row['name'];
            $type = $row['type'];
            $value = ['caption' => $name, 'width' => '120px', 'url' => $urlDelete, 'key' => $key];
            $host_file = ((strpos($row['name'], 'http') !== false) || (strpos($row['name'], 'https') !== false)) ? $row['name'] : Yii::getAlias('@web') . DIRECTORY_SEPARATOR . Yii::getAlias('@content_images') . DIRECTORY_SEPARATOR . $row['name'];
            $preview = Html::img($host_file, ['class' => 'file-preview-image']);
            switch ($row['type']) {
                case Content::IMAGE_TYPE_SLIDECATEGORY:
                    $logoPreview[] = $preview;
                    $logoInit[] = $value;
                    break;
                case Content::IMAGE_TYPE_THUMBNAIL_EPG:
                    $thumbnail_epgInit[] = $value;
                    $thumbnail_epgPreview[] = $preview;
                    $thumb_epg[] = $name;
                    break;
                case Content::IMAGE_TYPE_SCREENSHOOT:
                    $screenshootPreview[] = $preview;
                    $screenshootInit[] = $value;
                    $screenshoot[] = $name;
                    break;
                case Content::IMAGE_TYPE_THUMBNAIL:
                    $thumbnailPreview[] = $preview;
                    $thumbnailInit[] = $value;
                    $thumb[] = $name;
                    break;
                case Content::IMAGE_TYPE_SLIDE:
                    $slidePreview[] = $preview;
                    $slideInit[] = $value;
                    $slide[] = $name;
                    break;
            }
            //end screenshoot
        }
        $model->thumbnail = $thumb;
        $model->slide = $slide;
        $model->screenshoot = $screenshoot;
        return $this->render('create', [
            'model' => $model,
            'logoInit' => $logoInit,
            'logoPreview' => $logoPreview,
            'thumbnail_epgPreview' => $thumbnail_epgPreview,
            'thumbnail_epgInit' => $thumbnail_epgInit,
            'thumbnailInit' => $thumbnailInit,
            'thumbnailPreview' => $thumbnailPreview,
            'screenshootInit' => $screenshootInit,
            'screenshootPreview' => $screenshootPreview,
            'slideInit' => $slideInit,
            'slidePreview' => $slidePreview,
            'selectedCats' => $selectedCats,
            'tags' => $tags,
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('adminModify');

        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && isset($post['ajax']) && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->expired_at = Yii::$app->formatter->asDate($model->expired_at, "dd-M-yyyy");
        if ($model->load(Yii::$app->request->post())) {

            $model->ascii_name = CVietnameseTools::makeSearchableStr($model->display_name);
            if (isset(Yii::$app->request->post()['Content']['list_cat_id'])) {
                $model->list_cat_id = Yii::$app->request->post()['Content']['list_cat_id'];
            }

            $model->expired_at = strtotime($model->expired_at);
            if (!$model->honor) {
                $model->honor = 0;
            }
            $model->updated_at = time();
            if (empty($model->price_promotion)) {
                $model->price_promotion = $model->price;
            }
            if ($model->save()) {
                $model->createCategoryAsm();
                $image_slide = Content::convertJsonToArray($model->images);
                foreach ($image_slide as $key => $row) {
                    if ($row['type'] == Content::IMAGE_TYPE_SLIDE) {
                        $model->is_slide = 1;
                    }
                    if ($row['type'] == Content::IMAGE_TYPE_SLIDECATEGORY) {
                        $model->is_slide_category = 1;
                    }
                }
                $model->save(false);
                \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Cập nhật nội dung thành công'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::error($model->getErrors());
                \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Cập nhật nội dung không thành công') . json_encode($model->getErrors()));
            }
        }
        // get screenshoot
        $images = Content::convertJsonToArray($model->images);

        $logoInit = [];
        $thumbnail_epgInit = [];
        $thumbnailInit = [];
        $screenshootInit = [];
        $slideInit = [];

        $logoPreview = [];
        $thumbnail_epgPreview = [];
        $thumbnailPreview = [];
        $screenshootPreview = [];
        $slidePreview = [];

        $thumb_epg = [];
        $thumb = [];
        $slide = [];
        $screenshoot = [];

        foreach ($images as $key => $row) {
            $key = $key + 1;
            $urlDelete = Yii::$app->urlManager->createAbsoluteUrl(['/content/delete-image', 'name' => $row['name'], 'type' => $row['type'], 'content_id' => $model->id]);
            $name = $row['name'];
            $type = $row['type'];
            $value = ['caption' => $name, 'width' => '120px', 'url' => $urlDelete, 'key' => $key];
            $host_file = ((strpos($row['name'], 'http') !== false) || (strpos($row['name'], 'https') !== false)) ? $row['name'] : Yii::getAlias('@web') . DIRECTORY_SEPARATOR . Yii::getAlias('@content_images') . DIRECTORY_SEPARATOR . $row['name'];
            $preview = Html::img($host_file, ['class' => 'file-preview-image']);
            switch ($row['type']) {
                case Content::IMAGE_TYPE_SLIDECATEGORY:
                    $logoPreview[] = $preview;
                    $logoInit[] = $value;
                    break;
                case Content::IMAGE_TYPE_THUMBNAIL_EPG:
                    $thumbnail_epgInit[] = $value;
                    $thumbnail_epgPreview[] = $preview;
                    $thumb_epg[] = $name;
                    break;
                case Content::IMAGE_TYPE_SCREENSHOOT:
                    $screenshootPreview[] = $preview;
                    $screenshootInit[] = $value;
                    $screenshoot[] = $name;
                    break;
                case Content::IMAGE_TYPE_THUMBNAIL:
                    $thumbnailPreview[] = $preview;
                    $thumbnailInit[] = $value;
                    $thumb[] = $name;
                    break;
                case Content::IMAGE_TYPE_SLIDE:
                    $slidePreview[] = $preview;
                    $slideInit[] = $value;
                    $slide[] = $name;
                    break;
            }

            //end screenshoot
        }
        $model->thumbnail = $thumb;
        $model->slide = $slide;
        $model->screenshoot = $screenshoot;

        $selectedCats = $model->getListCatIds();
        $model->list_cat_id = implode(',', $selectedCats);

        Yii::trace($selectedCats);
//        var_dump($screenshootInit);
        //        var_dump($screenshootPreview);exit;
        return $this->render('update', [
            'model' => $model,
            'logoInit' => $logoInit,
            'logoPreview' => $logoPreview,
            'thumbnail_epgPreview' => $thumbnail_epgPreview,
            'thumbnail_epgInit' => $thumbnail_epgInit,
            'thumbnailInit' => $thumbnailInit,
            'slideInit' => $slideInit,
            'slidePreview' => $slidePreview,
            'thumbnailPreview' => $thumbnailPreview,
            'screenshootInit' => $screenshootInit,
            'screenshootPreview' => $screenshootPreview,
            'selectedCats' => $selectedCats,
        ]);
    }


    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Content::STATUS_DELETE;
        /** cuongvm 20160725 - pháº£i insert created_at, updated_at báº±ng tay, khÃ´ng dÃ¹ng behaviors - begin */
        $model->updated_at = time();
        /** cuongvm 20160725 - pháº£i insert created_at, updated_at báº±ng tay, khÃ´ng dÃ¹ng behaviors - end */
        $model->save();

        return $this->redirect(['index', 'type' => $model->type]);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Content the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'Không tìm thấy trang'));
        }
    }

    public function actionUploadFile($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Content();
        $type = Yii::$app->request->post('type');
        $allowExt = ['png', 'jpg', 'jpeg', 'gif'];
        if ($type == Content::IMAGE_TYPE_THUMBNAIL) {
            $old_value = Yii::$app->request->post('thumbnail_old');
            $attribute = 'thumbnail';
        } elseif ($type == Content::IMAGE_TYPE_SCREENSHOOT) {
            $old_value = Yii::$app->request->post('screenshots_old');
            $attribute = 'screenshoot';
        } elseif ($type == Content::IMAGE_TYPE_SLIDE) {
            $old_value = Yii::$app->request->post('slide_old');
            $attribute = 'slide';
        } elseif ($type == Content::IMAGE_TYPE_SLIDECATEGORY) {
            $old_value = Yii::$app->request->post('slide_category_old');
            $attribute = 'slide_category';
        } else {
            return ['success' => false, 'message' => Yii::t('app', 'Không thể xác định loại ảnh')];
        }
        $model->load(Yii::$app->request->post());

        $files = null;

        if (empty($_FILES['Content'])) {
            return []; // or process or throw an exception
        }

        $files = $_FILES['Content'];
        Yii::trace($type . '  ' . $attribute);
        $file_type = '';
        list($width, $height, $file_type, $attr) = getimagesize($files['tmp_name']["$attribute"][0]);
        Yii::info($width . 'xxx' . $height);

        Yii::info($files);
        $new_file = [];
        $size = $files['size']["$attribute"][0];
        $ext = explode('.', basename($files['name']["$attribute"][0]));
        $checkExt = $ext[max(array_keys($ext))];
        $file_name = uniqid() . time() . '.' . array_pop($ext);
        $uploadPath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . Yii::getAlias('@content_images');
        $target = $uploadPath . DIRECTORY_SEPARATOR . $file_name;
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777);
        }

        if (!in_array($checkExt, $allowExt)) {
            return ['success' => false, 'error' => Yii::t('app', "Ảnh không đúng định dạng")];
        }

        if ($size > Content::MAX_SIZE_UPLOAD) {
            return ['success' => false, 'error' => Yii::t('app', "Ảnh vượt quá dung lượng cho phép")];
        }

        if (move_uploaded_file($files['tmp_name']["$attribute"][0], $target)) {
            $success = true;
            $new_file['name'] = $file_name;
            $new_file['type'] = $type;
            $new_file['size'] = $size;
        } else {
            $success = false;
        }
        // neu tao file thanh cong. tra ve danh sach file moi
        if ($success) {
            Yii::error($id);
            if ($id === null) {
                $output = ['success' => $success, 'output' => json_encode($new_file)];

                return $output;
            }

            $oldImages = Content::findOne($id);

            Yii::error($oldImages);
            // var_dump(json_decode($oldImages->images, true));die;

            if ($type == Content::IMAGE_TYPE_THUMBNAIL) {
                $imgs = Content::convertJsonToArray($oldImages->images, true) !== null ? Content::convertJsonToArray($oldImages->images, true) : [];
                $imgs = array_filter($imgs, function ($v) {
                    return $v['type'] != Content::IMAGE_TYPE_THUMBNAIL;
                });

                $oldImages->images = json_encode(array_merge($imgs, [$new_file]));
            } else {
                $oldImages->images = json_encode(array_merge(Content::convertJsonToArray($oldImages->images, true) !== null ? Content::convertJsonToArray($oldImages->images, true) : [], [$new_file]));
            }

            Yii::error($oldImages->images);

            $success = $oldImages->update();

            $old_value = Content::convertJsonToArray($old_value);
            $old_value[] = $new_file;
        }
        $output = ['success' => $success, 'output' => $oldImages->images];

        return $output;
    }

    public function actionApprove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $cp = Yii::$app->user->id;
        $sp_id = Yii::$app->user->id;
        $newStatus = Content::STATUS_ACTIVE;
        if (isset($post['ids'])) {
            $ids = $post['ids'];
            $contents = Content::findAll($ids);
            $count = 0;
            foreach ($contents as $content) {
                if ($content->spUpdateStatus($newStatus, $sp_id)) {
                    ++$count;
                }
            }

            return [
                'success' => true,
                'message' => Yii::t('app', 'Duyệt ' . $count . ' nội dung thành công!'),
            ];
        } else {
            return [
                'success' => false,
                'message' => Yii::t('app', 'Không duyệt nội dung thành công!'),
            ];
        }
    }


    public function actionUpdateStatusContent()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $cp = Yii::$app->user->id;

        if (isset($post['ids']) && isset($post['newStatus'])) {
            $ids = $post['ids'];
            $newStatus = $post['newStatus'];
            $contents = Content::findAll($ids);
            $count = 0;

            foreach ($contents as $content) {
                if ($content->spUpdateStatus($newStatus, $cp)) {
                    ++$count;
                }
            }

            $successMess = $newStatus == Content::STATUS_DELETE ? Yii::t('app', 'Xoá') : Yii::t('app', 'Cập nhật');

            return [
                'success' => true,
                'message' => $successMess . ' ' . $count . Yii::t('app', ' nội dung thành công!'),
            ];
        } else {
            return [
                'success' => false,
                'message' => Yii::t('app', 'Không thành công vui lòng thử lại'),
            ];
        }
    }

    public function actionDeleteImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $content_id = Yii::$app->request->get('content_id');
        $name = Yii::$app->request->get('name');

        if (!$content_id || !$name) {
            return [
                'success' => false,
                'message' => 'Thiếu tham số!',
                'error' => 'Thiếu tham số!',
            ];
        }
        $content = $this->findModel($content_id);
        if (!$content) {
            return [
                'success' => false,
                'message' => 'Không tìm thấy nội dung!',
                'error' => 'Không tìm thấy nội dung!',
            ];
        } else {
            $index = -1;
            $images = Content::convertJsonToArray($content->images);
            Yii::trace($images);
            foreach ($images as $key => $row) {
                if ($row['name'] == $name) {
                    $index = $key;
                }
            }
            if ($index == -1) {
                return [
                    'success' => false,
                    'message' => 'KhÃ´ng tháº¥y áº£nh!',
                    'error' => 'KhÃ´ng tháº¥y áº£nh!',
                ];
            } else {
                array_splice($images, $index, 1);
                Yii::trace($images);
                $content->images = Json::encode($images);
                if ($content->save(false)) {
                    return [
                        'success' => true,
                        'message' => 'Xoá thành công',
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $content->getErrors(),
                    ];
                }
            }
        }
    }

    public function actionProcess()
    {
        require_once __DIR__ . '/../models/simple_html_dom.php';
        if (!empty($_POST['linkProcess']) && !empty($_POST['sourceProcess'])) {
            $display_name = null;
            if ($_POST['sourceProcess'] == Content::TYPE_CRAWL_TAOBAO) {
                $html = file_get_html($_POST['linkProcess']);
                $display_name = $html->find('.tb-main-title', 0);
                $image = $html->find('#J_ImgBooth', 0);
                $price = $html->find('.tb-rmb-num', 0);
            } else if ($_POST['sourceProcess'] == Content::TYPE_CRAWL_TMALL) {
                $context = stream_context_create(array(
                    'https' => array(
                        'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
                    ),
                ));
                $url = explode('&', $_POST['linkProcess'])[0];

                $html = file_get_html($url, false, $context);
                $display_name = $html->find('.tb-detail-hd >h1', 0);
                $image = $html->find('#J_ImgBooth', 0);
                $price = $html->find('#J_StrPriceModBox >.tm-price', 0);
            } else {
                $url = $_POST['linkProcess'];
                $context = stream_context_create(array(
                    'http' => array(
                        'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
                    ),
                ));
                $html = file_get_html($url, false, $context);
                $display_name = $html->find('#mod-detail-title >h1', 0);
                $image = $html->find('.box-img >img', 0);
                $price = $html->find('.obj-content >.value', 0);
            }
            if (!empty($display_name)) {
                $display_name = $display_name->innertext;
            } else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Rất tiếc chúng tôi không thể phân tích được tên sản phẩm'));
            }
            $display_name = iconv('gb2312', 'utf-8', $display_name);

            if (!empty($image)) {
                $image = $image->src;
            } else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Rất tiếc chúng tôi không thể phân tích được hình ảnh sản phẩm'));
            }

            if (!empty($price)) {
                $price = $price->innertext;
            } else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Rất tiếc chúng tôi không thể phân tích giá sản phẩm'));
            }

            if (empty($display_name) && empty($image) && empty($price)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Không phân tích sản phẩm thành công'));
                return $this->redirect(['create']);
            }

            $model = new Content();
            $model->processPrice($price);
            $display_name = Content::translateLanguage($display_name, 'zh');
            $model->display_name = $display_name;
            $model->processImage($image, $_POST['sourceProcess']);
            return Yii::$app->runAction('content/create', ['model' => $model]);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Không thể phân tích sản phẩm, Vui lòng thử lại!'));
            return $this->redirect(['create']);
        }
    }
}
