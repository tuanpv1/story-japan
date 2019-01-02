<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/19/2016
 * Time: 9:09 PM
 */
namespace frontend\widgets;

use common\models\Category;
use common\models\Content;
use common\models\ContentCategoryAsm;
use DateTime;
use yii\base\Widget;
use Yii;

class FindBreadcrumb extends Widget{

    public $message;

    public  function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public  function run()
    {
    }

    public static function getBreadcrumbCate($id){
        $cat_parent = FindBreadcrumb::getCateParent($id);
        if(isset($cat_parent) && !empty($cat_parent)) {
            $st = new FindBreadcrumb();
            return $st->render('find-breadcrumb', [
                'cat_parent' => $cat_parent,
                'id_cate_old'=>$id
            ]);
        }
    }

    public static function getBreadcrumb($id){
        $cat = ContentCategoryAsm::findOne(['content_id'=>$id]);
        $cat_parent = FindBreadcrumb::getCateParent($cat->category_id);
        if(isset($cat_parent) && !empty($cat_parent)) {
            $st = new FindBreadcrumb();
            return $st->render('find-breadcrumb', [
                'cat_parent' => $cat_parent,
                'id_content'=>$id,
            ]);
        }
    }

    public static function getCateParent($id_cat){
        $cat = Category::findOne(['id'=>$id_cat]);
        if($cat){
            if($cat->parent_id != null){
                return FindBreadcrumb::getCateParent($cat->parent_id);
            }else{
                return $cat;
            }
        }
    }

    public static function getBreadcrumbChild($id_cat,$id_content){
        $cat = ContentCategoryAsm::findOne(['content_id'=>$id_content]);
        $cat1 = Category::find()->andWhere(['id'=>$cat->category_id])->andWhere(['status'=>Category::STATUS_ACTIVE])->one();
        if($cat1->parent_id){
            $cat2 = Category::find()->andWhere(['id'=>$cat1->parent_id])->andWhere(['status'=>Category::STATUS_ACTIVE])->one();
        }
        $cat3 = Category::find()->andWhere(['parent_id'=>$id_cat])->andWhere(['status'=>Category::STATUS_ACTIVE])->all();
        if($cat3 && !empty($cat2)){
            foreach($cat3 as $item){
                if($item->id == $cat2->id){
//                echo "<pre>";print_r($cat2);die();
                    $st = new FindBreadcrumb();
                    return $st->render('find-breadcrumb-child', [
                        'cat_parent' => $cat2,
                        'id_content'=>$id_content,
                    ]);
                }
            }
        }
    }

    public static function getBreadcrumbChild1($id_content){
        $content_parent = null;
        $cat = ContentCategoryAsm::findOne(['content_id'=>$id_content]);
        $cat1 = Category::find()->andWhere(['id'=>$cat->category_id])->andWhere(['status'=>Category::STATUS_ACTIVE])->one();
        $content = Content::findOne(['id'=>$id_content,'status'=>Content::STATUS_ACTIVE]);
        if($content->parent_id){
            $content_parent = $content->parent;
        }
        $st = new FindBreadcrumb();
        return $st->render('find-breadcrumb-child', [
            'cat_parent' => $cat1,
            'content'=>$content,
            'content_parent'=>$content_parent,
        ]);
    }

    public static function getCateChild($id,$id_cate_old){
        $cat = Category::findAll(['status'=>Category::STATUS_ACTIVE,'parent_id'=>$id]); // cat to nhat
        if($cat){
            foreach($cat as $item){
                if($item->id == $id_cate_old){
                    $st = new FindBreadcrumb();
                    return $st->render('find-breadcrumb-child', [
                        'cat_parent' => $item,
                    ]);
                }else{
                    $cat1 = Category::findAll(['status'=>Category::STATUS_ACTIVE,'parent_id'=>$item->id]);
                    if($cat1){
                        foreach($cat1 as $item1){
                            if($item1->id == $id_cate_old){
                                $st = new FindBreadcrumb();
                                return $st->render('find-breadcrumb-child', [
                                    'cat_parent' => $item1,
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }


}
