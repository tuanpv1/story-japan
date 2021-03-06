<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/19/2016
 * Time: 9:09 PM
 */

namespace frontend\widgets;

use common\models\Content;
use common\models\ContentCategoryAsm;
use yii\base\Widget;

class ProductLike extends Widget
{

    public $message;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
    }

    public static function getProductLike($id)
    {
        $cat = ContentCategoryAsm::findOne(['content_id' => $id]);
        if($cat){
            $content = Content::find()
                ->select('content.id,content.display_name,content.type,content.short_description,content.price,content.images,content.price_promotion')
                ->innerJoin('content_category_asm', 'content_category_asm.content_id = content.id')
                ->innerJoin('category', 'content_category_asm.category_id = category.id')
                ->andWhere('content.id <> :id_cc', ['id_cc' => $id])
                ->andWhere(['category.id' => $cat->category_id])
                ->andWhere(['content.status' => Content::STATUS_ACTIVE])
                ->orderBy(['content.created_at' => 'DESC'])
                ->limit(6)
                ->all();
            $t = new ProductLike();
            return $t->render('product-like', [
                'content' => $content,
            ]);
        }
    }

    public static function getEpisode($id)
    {
        $content = Content::findAll(['parent_id' => $id, 'status' => Content::STATUS_ACTIVE]);
        $t = new ProductLike();
        return $t->render('episode-content', [
            'content' => $content,
        ]);
    }
}
