<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/12/5
 * Time: 15:24
 */

namespace app\modules\mch\controllers\group;

use app\modules\mch\models\group\NoticeForm;

class NoticeController extends Controller
{
    public function actionSetting()
    {
        $form = new NoticeForm();
        $form->store_id = $this->store->id;
        if (\Yii::$app->request->isPost) {
            $form->attributes = \Yii::$app->request->post();
            return $form->save();
        } else {
            return $this->render('setting', [
                'model' => $form->getModel(),
            ]);
        }
    }
}
