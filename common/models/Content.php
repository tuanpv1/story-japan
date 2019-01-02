<?php

namespace common\models;

use Stichoza\GoogleTranslate\TranslateClient;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

//use yii\swiftmailer\Message;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property string $display_name
 * @property string $code
 * @property string $ascii_name
 * @property string $title_short
 * @property int $type
 * @property string $tags
 * @property string $short_description
 * @property string $description
 * @property string $content
 * @property int $version_code
 * @property string $version
 * @property int $view_count
 * @property int $download_count
 * @property int $like_count
 * @property int $dislike_count
 * @property float $rating
 * @property int $rating_count
 * @property int $comment_count
 * @property int $favorite_count
 * @property string $images
 * @property int $status
 * @property int $is_slide
 * @property int $is_slide_category
 * @property int $created_at
 * @property int $expired_at
 * @property int $updated_at
 * @property int $honor
 * @property string $address
 * @property int $approved_at
 * @property Content $parent
 * @property string $condition
 * @property string $highlight
 * @property int $price_promotion
 * @property int $price
 * @property string $language
 * @property int $order
 * @property int $type_status
 * @property int $availability
 * @property int $is_feature
 * @property int $is_series
 * @property int $parent_id
 * @property int $created_user_id
 * @property int $episode_order
 * @property int $episode_count
 * @property string $link
 * @property string $author
 *
 * @property ContentCategoryAsm[] $contentCategoryAsms
 */
class Content extends \yii\db\ActiveRecord
{
    const IMAGE_TYPE_SLIDECATEGORY = 1;
    const IMAGE_TYPE_THUMBNAIL = 2;
//    const IMAGE_TYPE_SCREENSHOOT = 3;
    const IMAGE_TYPE_SLIDE = 4;
    const IMAGE_TYPE_THUMBNAIL_EPG = 5;

    public $logo;
    public $thumbnail;
    public $slide_category;
    public $slide;
    public $image_tmp;
    public $started_at;
    public $url_thumbnail;
    public $url_slide;
    public $ended_at;
    public $viewAttr = [];

    //type: 1 là bán chạy, 2 là giảm giá, 3 là sản phẩm mới,4 là lasted deal // danh cho phần quản lý seller
    //type_status: tình trạng hàng 1 là hàng mới, 2 là hàng 99%, 3 là hàng đã qua sử dụng
    //honor: thể loại hàng: Sản phẩm hot nhất, Sản phẩm mới nhất, Giá tốt, Danh cho bạn
    //availability là trạng thái hàng: 1 là còn hàng, 0 là hết hàng
    const AVAILABILITY_OK = 1;//con hàng
    const AVAILABILITY_NOK = 0;//hết hàng

    const STATUS_ACTIVE = 10; // Đã duyệt
    const STATUS_INACTIVE = 0; // khóa
    const STATUS_DELETE = 2; // Xóa
    const STATUS_PENDING = 3; // CHỜ DUYỆT
    const STATUS_INVISIBLE = 4; // ẨN

    const ORDER_NEWEST = 1;
    const HONOT_NORMAL = 0;
    const HONOR_HOT = 1;
    const HONOR_NEWEST = 2;
    const HONOR_PRICE = 3;
    const HONOR_FORYOU = 4;

    const TYPE_SELLER = 1;
    const TYPE_PRICEPROMO = 2;
    const TYPE_NEWEST = 3;
    const TYPE_DEAL = 4;
    const TYPE_FORYOU = 5;

    const IS_FEATURE = 1;
    const IS_NO_FEATURE = 0;


    const MAX_SIZE_UPLOAD = 10485760; // 10 * 1024 * 1024

    public static function getListType()
    {
        return [
            self::TYPE_SELLER => Yii::t('app', 'Hot'),
            self::TYPE_NEWEST => Yii::t('app', 'Top favorite'),
            self::TYPE_PRICEPROMO => Yii::t('app', 'New'),
        ];
    }

    public function getTypeName()
    {
        $listStatus = self::getListType();
        if (isset($listStatus[$this->type])) {
            return $listStatus[$this->type];
        }

        return '';
    }

    public static $list_honor = [
        self::HONOR_HOT => 'Sản phẩm hot nhất',
        self::HONOR_NEWEST => 'Sản phẩm mới nhất',
        self::HONOR_PRICE => 'Giá tốt nhất',
        self::HONOR_FORYOU => 'Dành cho bạn',
    ];

    public static $list_honorDetail = [
        self::HONOT_NORMAL => 'Sản phẩm bình thường',
        self::HONOR_HOT => 'Sản phẩm hot nhất',
        self::HONOR_NEWEST => 'Sản phẩm mới nhất',
        self::HONOR_PRICE => 'Giá tốt nhất',
        self::HONOR_FORYOU => 'Dành cho bạn',
    ];

    public static $listAvailability = [
        self::AVAILABILITY_OK => 'Không sẵn hàng',
        self::AVAILABILITY_NOK => 'Hết hàng'
    ];

    public $list_cat_id;
    public $assignment_sites;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    public static function translateLanguage($text, $language)
    {
        $tr = new TranslateClient();
        $tr->setSource($language);
        $tr->setTarget('vi');
        return $tr->translate($text);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge([
            [['display_name', 'code', 'status', 'list_cat_id', 'price'], 'required', 'on' => 'adminModify', 'message' => '{attribute} không được để trống'],
            [['started_at', 'ended_at'], 'required', 'message' => Yii::t('app', '{attribute} không được để trống'), 'on' => 'adminModifyLiveContent'],
            [['ended_at'], 'validEnded', 'on' => 'adminModifyLiveContent'],
            [['display_name', 'code'], 'required', 'message' => Yii::t('app', '{attribute} không được để trống')],
            [
                [
                    'type',
                    'price',
                    'is_slide',
                    'is_slide_category',
                    'price_promotion',
                    'version_code',
                    'view_count',
                    'download_count',
                    'like_count',
                    'dislike_count',
                    'rating_count',
                    'comment_count',
                    'favorite_count',
                    'status',
                    'created_at',
                    'updated_at',
                    'honor',
                    'order',
                    'type_status',
                    'availability',
                    'is_feature',
                    'created_user_id',
                    'parent_id',
                    'episode_order',
                    'episode_count',
                    'is_series'
                ], 'integer',
            ],
            [['description', 'url_thumbnail', 'url_slide', 'content', 'condition', 'images', 'short_description', 'images', 'highlight', 'title_short'], 'string'],
            [['rating'], 'number'],
            [['display_name', 'ascii_name', 'country'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 20],
            [['tags', 'address','author'], 'string', 'max' => 500],
            [['version'], 'string', 'max' => 64],
            [['language'], 'string', 'max' => 10],
            [['code'], 'unique', 'message' => Yii::t('app', '{attribute} đã tồn tại trên hệ thống. Vui lòng thử lại')],
            [['thumbnail', 'slide', 'slide_category'],
                'file',
                'tooBig' => Yii::t('app', '{attribute} vượt quá dung lượng cho phép. Vui lòng thử lại'),
                'wrongExtension' => Yii::t('app', '{attribute} không đúng định dạng'),
                'extensions' => 'png, jpg, jpeg, gif',
                'maxSize' => self::MAX_SIZE_UPLOAD],
            [['thumbnail', 'slide_category'], 'validateThumb', 'on' => ['adminModify', 'adminModifyLiveContent']],
            [['thumbnail', 'slide', 'slide_category'], 'image', 'extensions' => 'png,jpg,jpeg,gif',
                'maxSize' => 1024 * 1024 * 10, 'tooBig' => Yii::t('app', 'Ảnh show  vượt quá dung lượng cho phép. Vui lòng thử lại'),
            ],
            [['image_tmp', 'list_cat_id'], 'safe'],
            ['link', 'string']
        ], $this->getValidAttr());
    }

    public function validEnded($attribute, $params)
    {
        if (strtotime($this->ended_at) < strtotime($this->started_at)) {
            $this->addError($attribute, $this->attributeLabels()[$attribute] . ' phải lớn hơn ' . $this->attributeLabels()['started_at']);
            return false;
        }
    }

    public function validateThumb($attribute, $params)
    {
        if (empty($this->images)) {
            $this->addError($attribute, str_replace('(*)', '', $this->attributeLabels()[$attribute]) . ' không được để trống');
            return false;
        }
        $images = $this->convertJsonToArray($this->images, true);

        $thumb = array_filter($images, function ($v) {
            return $v['type'] == self::IMAGE_TYPE_THUMBNAIL;
        });

        if (count($thumb) === 0) {
            $this->addError($attribute, str_replace('(*)', '', $this->attributeLabels()[$attribute]) . ' không được để trống');
            return false;
        }
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->status == self::STATUS_ACTIVE) {
                $this->approved_at = time();
            }

            return true;
        } else {
            return false;
        }
    }

    public function getValidAttr()
    {
        return [];

        // $this->getContentAttr();
        // // var_dump($this->validAttr);die;
        // return $this->validAttr;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'display_name' => Yii::t('app', 'Title'),
            'code' => Yii::t('app', 'Code'),
            'ascii_name' => Yii::t('app', 'Ascii Name'),
            'title_short' => Yii::t('app', 'Short name'),
            'type' => Yii::t('app', 'Kiểu hàng sắp xếp'),
            'tags' => Yii::t('app', 'Tags'),
//            'type_status' => Yii::t('app', 'Tình trạng hàng'),
//            'availability' => Yii::t('app', 'Trạng thái hàng'),
            'short_description' => Yii::t('app', 'Short description'),
//            'highlight' => Yii::t('app', 'Điểm nổi bật'),
//            'condition' => Yii::t('app', 'Điều kiện sử dụng'),
//            'price_promotion' => Yii::t('app', 'Giá khuyến mãi'),
//            'price' => Yii::t('app', 'Giá gốc'),
            'description' => Yii::t('app', 'Description'),
            'urls' => Yii::t('app', 'Urls'),
            'version_code' => Yii::t('app', 'Phiên bản code'),
            'version' => Yii::t('app', 'Phiên bản'),
            'view_count' => Yii::t('app', 'View total'),
//            'download_count' => Yii::t('app', 'Download Count'),
            'like_count' => Yii::t('app', 'Like total'),
//            'dislike_count' => Yii::t('app', 'Tổng lượt ko thích'),
            'rating' => Yii::t('app', 'Rating'),
            'rating_count' => Yii::t('app', 'Rating total'),
            'expired_at' => Yii::t('app', 'expire'),
//            'comment_count' => Yii::t('app', 'Tổng số nhận xét'),
            'favorite_count' => Yii::t('app', 'Favorite total'),
            'images' => Yii::t('app', 'Images'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created date'),
            'updated_at' => Yii::t('app', 'Updated date'),
//            'honor' => Yii::t('app', 'Loại nội dung'),
//            'address' => Yii::t('app', 'Địa chỉ'),
            'approved_at' => Yii::t('app', 'Approve date'),
            'country' => Yii::t('app', 'Country'),
            'language' => Yii::t('app', 'Language'),
            'thumbnail' => Yii::t('app', 'Thumnail(*)'),
            'slide' => Yii::t('app', 'Home slide image'),
            'list_cat_id' => Yii::t('app', 'Categories'),
//            'started_at' => Yii::t('app', 'Thời gian bắt đầu'),
//            'ended_at' => Yii::t('app', 'Thời gian kết thúc'),
            'order' => Yii::t('app', 'Order'),
            'slide_category' => Yii::t('app', 'Categories slide'),
            'is_feature' => Yii::t('app', 'Feature'),
            'parent_id' => Yii::t('app', 'Parent'),
            'is_series' => Yii::t('app', 'Series'),
            'created_user_id' => Yii::t('app', 'User created'),
            'episode_order' => Yii::t('app', 'Order Episode'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Content::className(), ['id' => 'parent_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentCategoryAsms()
    {
        return $this->hasMany(ContentCategoryAsm::className(), ['content_id' => 'id']);
    }


    /**
     * @author *
     * @return $this
     */
    public function getRelatedContent()
    {
        /** return a query hasMany */
        return $this->hasMany(Content::className(), ['id' => 'content_related_id'])->viaTable('{{%content_related_asm}}', ['content_id' => 'id']);
    }


    public static function getListStatus($type = 'all')
    {
        return ['all' => [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_PENDING => Yii::t('app', 'Waiting approve'),
            self::STATUS_INACTIVE => Yii::t('app', 'Block'),
            self::STATUS_INVISIBLE => Yii::t('app', 'hidden'),
        ],
            'filter' => [
                self::STATUS_ACTIVE => Yii::t('app', 'Active'),
                self::STATUS_PENDING => Yii::t('app', 'Waiting approve'),
                self::STATUS_INACTIVE => Yii::t('app', 'Block'),
                self::STATUS_INVISIBLE => Yii::t('app', 'hidden'),
            ],
        ][$type];
    }

    public function getStatusName()
    {
        $listStatus = self::getListStatus();
        if (isset($listStatus[$this->status])) {
            return $listStatus[$this->status];
        }

        return '';
    }


    public function createCategoryAsm()
    {
        ContentCategoryAsm::deleteAll(['content_id' => $this->id]);
        if ($this->list_cat_id) {
            $listCatIds = explode(',', $this->list_cat_id);
            if (is_array($listCatIds) && count($listCatIds) > 0) {
                foreach ($listCatIds as $catId) {
                    $catAsm = new ContentCategoryAsm();
                    $catAsm->content_id = $this->id;
                    $catAsm->category_id = $catId;
                    $catAsm->save();
                }
            }

            return true;
        }

        return true;
    }

    public static function convertJsonToArray($input)
    {
        $listImage = json_decode($input, true);
        // var_dump($listImage);die;
        $result = [];
        if (is_array($listImage)) {
            foreach ($listImage as $item) {
                $item = is_array($item) ? $item : json_decode($item, true);

                $row['name'] = $item['name'];
                $row['type'] = $item['type'];
                $row['size'] = $item['size'];
                $result[] = $row;
            }
        }

        return $result;
    }

    public static function getListImageType()
    {
        return [
            self::IMAGE_TYPE_SLIDECATEGORY => 'Slide Category',
            self::IMAGE_TYPE_THUMBNAIL => 'Thumbnail',
            self::IMAGE_TYPE_SLIDE => 'Slide',
            self::IMAGE_TYPE_THUMBNAIL_EPG => 'Thumbnail_epg',
        ];
    }

    public function getImages()
    {
        try {
            $res = [];
            $images = $this->convertJsonToArray($this->images);
            $maxThumb = 0;
            if ($images) {
                for ($i = 0; $i < count($images); ++$i) {
                    $item = $images[$i];
                    if ($item['type'] == self::IMAGE_TYPE_THUMBNAIL) {
                        $maxThumb = $i;
                    }
                    if ($item['type'] == self::IMAGE_TYPE_THUMBNAIL_EPG) {
                        $maxThumb = $i;
                    }
                    $image = new \backend\models\Image();
                    $image->type = $item['type'];
                    $image->name = $item['name'];
                    $image->size = $item['size'];
                    array_push($res, $image);
                }

                return $res;
            }
        } catch (InvalidParamException $ex) {
            $images = null;
        }

        return $images;
    }

    public function getListCatIds()
    {
        $listCat = $this->contentCategoryAsms;
        $listCatId = [];
        foreach ($listCat as $catAsm) {
            $listCatId[] = $catAsm->category_id;
        }

        return $listCatId;
    }


    /**
     * @param $sp_id
     * @param $id
     *
     * @return ActiveDataProvider
     */
    public static function getDetail($sp_id, $id)
    {
        $content = ContentSearch::find()
            ->andWhere(['created_user_id' => $sp_id])
            ->andWhere(['id' => $id])
            ->andWhere(['status' => self::STATUS_ACTIVE]);
        $dataProvider = new ActiveDataProvider([
            'query' => $content,
            'sort' => [],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }

    public static function getRelated($sp_id, $content_id)
    {
        /** @var  $content_category_asm ContentCategoryAsm */
        $content_category_asm = ContentCategoryAsm::findOne(['content_id' => $content_id]);
        if ($content_category_asm) {
            $category_id = $content_category_asm->category_id;
        } else {
            $category_id = -1;
        }
//        $query = ListContent::find()->andWhere(['created_user_id' => $sp_id]);
        $query = ListContent::find()->andWhere(['created_user_id' => $sp_id]);

        $query->joinWith('contentCategoryAsms');
        $query->andWhere(['category_id' => $category_id]);

        $query->andWhere(['status' => self::STATUS_ACTIVE]);
        $query->andwhere('`content`.`id` <> :query')
            ->addParams([':query' => $content_id]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'defaultPageSize' => 10,
            ],
        ]);

        return $provider;
    }

    /**
     * @return null|string
     */
    public function getFirstImageLink()
    {
        // var_dump(Url::base());die;
        $link = '';
        if (!$this->images) {
            return;
        }
        $listImages = self::convertJsonToArray($this->images);
        foreach ($listImages as $key => $row) {
            if ($row['type'] == self::IMAGE_TYPE_THUMBNAIL) {
                $link = Url::to(Url::base() . DIRECTORY_SEPARATOR . Yii::getAlias('@content_images') . DIRECTORY_SEPARATOR . $row['name'], true);
            }
            if ($row['type'] == self::IMAGE_TYPE_THUMBNAIL_EPG) {
                $link = Url::to(Url::base() . DIRECTORY_SEPARATOR . Yii::getAlias('@content_images') . DIRECTORY_SEPARATOR . $row['name'], true);
            }
        }

        return $link;
    }

    public function getFirstImageLinkFE($image_default = null)
    {
        $link = '';
        if (!$this->images) {
            return;
        }
        $listImages = self::convertJsonToArray($this->images);
        foreach ($listImages as $key => $row) {
            if ($row['type'] == self::IMAGE_TYPE_THUMBNAIL) {
                $link = Url::to(Url::base() . '/' . Yii::getAlias('@content_images') . '/' . $row['name'], true);
            }
            if ($row['type'] == self::IMAGE_TYPE_THUMBNAIL_EPG) {
                $link = Url::to(Url::base() . '/' . Yii::getAlias('@content_images') . '/' . $row['name'], true);
            }
        }
        return $link;

//        if (file_exists($link)) {
//        } else {
//            return Url::to(Url::base() . '/' . Yii::getAlias('data/option4/') . '/' . $image_default, true);
//        }
    }

    public static function getFirstImageLinkFeStatic($image, $image_default = '')
    {
        // var_dump(Url::base());die;
        $link = '';
        if (!$image) {
            return;
        }
        $listImages = self::convertJsonToArray($image);
        foreach ($listImages as $key => $row) {
            if ($row['type'] == self::IMAGE_TYPE_THUMBNAIL) {
                $link = Url::to(Url::base() . '/' . Yii::getAlias('@content_images') . '/' . $row['name'], true);
            }
        }
        if (!file_exists($link)) {
            $link = Url::to(Url::base() . '/' . Yii::getAlias('data/option4/') . '/' . $image_default, true);
        }

        return $link;
    }

    public function getImageLinkFE($image_default)
    {
        // var_dump(Url::base());die;
        $link = [];
        if (!$this->images) {
            return;
        }
        $listImages = self::convertJsonToArray($this->images);
        foreach ($listImages as $key => $row) {
            if ($row['type'] == self::IMAGE_TYPE_THUMBNAIL) {
                $link1 = Url::to(Url::base() . '/' . Yii::getAlias('@content_images') . '/' . $row['name'], true);
                if (!file_exists($link1)) {
                    $link1 = Url::to(Url::base() . '/' . Yii::getAlias('data/option4/') . '/' . $image_default, true);
                }
                $link[] = $link1;
            }
        }
        return $link;
    }

    /**
     * @param $site_id
     * @return int
     */

    public function spUpdateStatus($newStatus, $sp_id)
    {
        $this->status = $newStatus;
        $this->updated_at = time();
        return $this->update(false);
    }

    public function getCssStatus()
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                return 'label label-primary';
            case self::STATUS_INACTIVE:
                return 'label label-warning';
            case self::STATUS_DELETE:
                return 'label label-danger';
            case self::STATUS_PENDING:
                return 'label label-info';
            default:
                return 'label label-primary';
        }
    }

    public function getPercentSale()
    {
        if (!$this->price_promotion) {
            return 0;
        }
        $percent = ($this->price - $this->price_promotion) * 100 / $this->price;
        $percent = round($percent);
        return $percent;
    }

    public function processPrice($price)
    {
        $price = trim($price);
        // Xử lý nếu là khoảng giá
        if (strpos($price, '-')) {
            $priceArray = explode('-', $price);
            $price1 = round(trim($priceArray[0]));
            $price2 = round(trim($priceArray[1]));
            $price = $price1 > $price2 ? $price1 : $price2;
        } else {
            $price = round($price);
        }
        $info = InfoPublic::findOne(InfoPublic::ID_DEFAULT);
        $convert_price = $info->convert_price_vnd;
        $this->price_promotion = $price * $convert_price;
        $this->price = $price * $convert_price;
    }

    public function beforeValidate()
    {
        foreach (array_keys($this->getAttributes()) as $attr) {
            if (!empty($this->$attr)) {
                $this->$attr = \yii\helpers\HtmlPurifier::process($this->$attr);
            }
        }
        return parent::beforeValidate();// to keep parent validator available
    }

    public function updateEpisodeCount()
    {
        $this->parent->episode_count = Content::find()
            ->andWhere(['parent_id' => $this->parent_id,'status' => self::STATUS_ACTIVE])
            ->count();
        $this->parent->update(false);
    }


    public function updateEpisodeOrder()
    {
        $max = self::find()->andWhere(['parent_id' => $this->parent_id])
            ->orderBy(['episode_order' => SORT_DESC])->one();
        if($max){
            $this->episode_order = $max->episode_order + 1;
        }else{
            $this->episode_order = 0;
        }
        $this->update(false);
    }
}
