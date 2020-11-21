<?php

namespace app\models;

use app\models\common\admin\log\CommonActionLog;
use Yii;

/**
 * This is the model class for table "{{%in_order_comment}}".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $order_id
 * @property integer $order_detail_id
 * @property integer $goods_id
 * @property integer $user_id
 * @property string $score
 * @property string $content
 * @property string $pic_list
 * @property integer $is_hide
 * @property integer $is_delete
 * @property integer $addtime
 * @property string $reply_content
 * @property integer $is_virtual
 * @property string $virtual_user
 * @property string $virtual_avatar
 */
class InOrderComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%in_order_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'order_id', 'order_detail_id', 'goods_id', 'user_id', 'score'], 'required'],
            [['store_id', 'order_id', 'order_detail_id', 'goods_id', 'user_id', 'is_hide', 'is_delete', 'addtime', 'is_virtual'], 'integer'],
            [['score'], 'number'],
            [['pic_list'], 'string'],
            [['content'], 'string', 'max' => 1000],
            [['reply_content', 'virtual_user', 'virtual_avatar'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'order_id' => 'Order ID',
            'order_detail_id' => 'Order Detail ID',
            'goods_id' => 'Goods ID',
            'user_id' => 'User ID',
            'score' => 'Score',
            'content' => 'Content',
            'pic_list' => 'Pic List',
            'is_hide' => 'Is Hide',
            'is_delete' => 'Is Delete',
            'addtime' => 'Addtime',
            'reply_content' => 'Reply Content',
            'is_virtual' => 'Is Virtual',
            'virtual_user' => 'Virtual User',
            'virtual_avatar' => 'Virtual Avatar',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $data = $insert ? json_encode($this->attributes) : json_encode($changedAttributes);
        CommonActionLog::storeActionLog('', $insert, $this->is_delete, $data, $this->id);
    }
}
