<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscriber_history".
 *
 * @property int $id
 * @property int $subscriber_id
 * @property int $content_id
 * @property int $time_read
 * @property int $time_again
 */
class SubscriberHistory extends \yii\db\ActiveRecord
{
    public $code;
    public $display_name;
    public $parent_id;
    public $images;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscriber_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subscriber_id', 'content_id', 'time_read', 'time_again'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subscriber_id' => 'Subscriber ID',
            'content_id' => 'Content ID',
            'time_read' => 'Time start read',
            'time_again' => Yii::t('app','Time read latest'),
        ];
    }
}
