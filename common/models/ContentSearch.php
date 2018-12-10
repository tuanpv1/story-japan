<?php

namespace common\models;

//use api\models\Content;
use common\helpers\CVietnameseTools;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContentSearch represents the model behind the search form about `\common\models\Content`.
 */
class ContentSearch extends Content
{
    public $keyword;
    public $categoryIds;
    public $listCatIds;
    public $cp_id;
    public $site_id;
    public $category_id;
    public $order;
    public $content_id;
    public $pricing_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'version_code', 'view_count', 'download_count', 'like_count', 'dislike_count', 'rating_count', 'comment_count', 'favorite_count', 'status', 'created_at', 'updated_at', 'honor', 'approved_at', 'order'], 'integer'],
            [['display_name', 'ascii_name', 'tags', 'language', 'cp_id', 'short_description', 'categoryIds', 'description', 'content', 'version', 'images', 'keyword'], 'safe'],
            [['site_id', 'category_id', 'order', 'content_id'], 'integer'],
            [['rating'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function filter($params)
    {
        $inactiveCategory = Category::find()
            ->select('id')
            ->andWhere(['status' => Category::STATUS_INACTIVE])
            ->asArray()->all();
        $query = Content::find()
            ->innerJoin('content_category_asm', 'content.id = content_category_asm.content_id')
            ->andWhere(['NOT IN', 'content_category_asm.category_id', $inactiveCategory])
            ->andWhere(['content.parent_id' => null])
            ->andWhere(['<>', 'content.status', Content::STATUS_DELETE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->categoryIds) {
            $categoryIds = explode(',', $this->categoryIds);
            $query->andWhere(['IN', 'content_category_asm.category_id', $categoryIds]);
        }

        $query->andFilterWhere(['like', 'content.display_name', $this->keyword]);
        $query->andFilterWhere(['like', 'content.display_name', $this->display_name]);
        $query->andFilterWhere(['=', 'content.status', $this->status]);
        $query->andFilterWhere(['=', 'content.pricing_id', $this->pricing_id]);
        $query->andFilterWhere(['=', 'content.language', $this->language]);
        if ($this->created_at !== '') {
            $create_at = $this->created_at;
            $create_at_end = $this->created_at + (86400);
            $query->andFilterWhere(['>=', 'content.created_at', $create_at]);
            $query->andFilterWhere(['<=', 'content.created_at', $create_at_end]);
        }
        $query->distinct('id');
        return $dataProvider;
    }

    public function fillContent($type, $params, $sp)
    {
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => Content::findAll(['type' => $type]),
        ]);
    }

    public function filterEpisode($params, $parent_id)
    {
        $query = Content::find();
        $query->andWhere(['parent_id' => $parent_id]);
        $query->andWhere(['!=', 'status', Content::STATUS_DELETE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        Yii::trace($this->getAttributes());
        $fullCat = array_keys(Category::getTreeCategories($this->created_user_id));
        $categoryIds = [];
        if (!$this->categoryIds) {
            //            $this->categoryIds = $fullCat;
            $categoryIds = $fullCat;
        } else {
            $categoryIds = explode(',', $this->categoryIds);
        }
        if (count($categoryIds) != count($fullCat)) {
            $this->listCatIds = $categoryIds;
            $query->distinct();
            $query->innerJoinWith(['contentCategoryAsms' => function ($query) {
                $query->andWhere(['IN', 'category_id', $this->listCatIds]);
            }]);
        }
        $query->andFilterWhere(['like', 'ascii_name', CVietnameseTools::makeSearchableStr($this->keyword)]);
        $query->andFilterWhere(['!=', 'status', Content::STATUS_DELETE]);

        return $dataProvider;
    }

    public static function validateDate($date, $format = "YYYY-MM-DD")
    {
        if (!preg_match("/^[-]+$/", substr($date, 4, 1)) || !preg_match("/^[-]+$/", substr($date, 7, 1))) {
            return false;
        }
        switch ($format) {
            case "YYYY-MM-DD":
                list($y, $m, $d) = preg_split('/[-\.\/ ]/', $date);
                break;
            default:
                return false;
        }
        return checkdate($m, $d, $y);
    }
}
