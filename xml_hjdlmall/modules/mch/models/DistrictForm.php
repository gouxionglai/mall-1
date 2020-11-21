<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 10:53
 */

namespace app\modules\mch\models;

use app\models\District;
use app\models\DistrictArr;

class DistrictForm extends MchModel
{
    public function search()
    {
        $cache_key = md5('district');
        $cache_data = \Yii::$app->cache->get($cache_key);
        if ($cache_data && false) {
            $province_list = $cache_data;
        } else {
            $d = new DistrictArr();
            $arr=  $d->getArr();
            $province_list = $d->getList($arr);
            \Yii::$app->cache->set($cache_key, $province_list, 86400 * 7);
        }
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => $province_list,
        ];
        $cache_key = md5('district');
        $cache_data = \Yii::$app->cache->get($cache_key);
        if ($cache_data) {
            $province_list = $cache_data;
        } else {
            $province_list = District::find()->select('id,name')->where(['level' => 'province'])->asArray()->all();
            foreach ($province_list as $i => $province) {
                $city_list = District::find()->select('id,name')->where(['parent_id' => $province['id']])->asArray()->all();
                foreach ($city_list as $j => $city) {
                    $district_list = District::find()->select('id,name')->where(['parent_id' => $city['id']])->asArray()->all();
                    $city_list[$j]['list'] = $district_list;
                }
                $province_list[$i]['list'] = $city_list;
            }
            \Yii::$app->cache->set($cache_key, $province_list, 86400 * 7);
//            var_dump(11);exit();
        }
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => $province_list,
        ];
    }
}
