<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/6/26
 * Time: 14:37
 */

namespace app\modules\mch\models;


use luweiss\wechat\Wechat;
use Yii;

class Model extends \app\models\Model
{
    /**
     * @return Wechat
     */
    public function getWechat()
    {
        return empty(\Yii::$app->controller->wechat) ? null : \Yii::$app->controller->wechat;
    }

    public function getCurrentStoreId()
    {
        return Yii::$app->controller->store->id;
    }

    public function getCurrentUserId()
    {
        if (!Yii::$app->mchRoleAdmin->isGuest) {
            return Yii::$app->mchRoleAdmin->id;
        }

        if (!Yii::$app->user->isGuest) {
            return Yii::$app->user->id;
        }

        if (!Yii::$app->admin->isGuest) {
            return Yii::$app->admin->id;
        }
    }
}