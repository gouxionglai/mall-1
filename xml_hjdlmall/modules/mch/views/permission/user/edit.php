<?php
defined('YII_ENV') or exit('Access Denied');
$this->title = '编辑员工';
$urlManager = Yii::$app->urlManager;
?>

<div class="panel mb-3">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">
        <form class="auto-form" method="post"
              action="<?= $urlManager->createUrl(['mch/permission/user/update', 'id' => $edit->id]) ?>">
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">昵称</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control cat-name" value="<?= $edit->nickname ?>" name="nickname">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label required">用户名</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control cat-name" value="<?= $edit->username ?>" name="username">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                    <label class="col-form-label">角色</label>
                </div>
                <div class="col-sm-6">
                    <?php foreach ($roleList as $item) : ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="role[]"
                                   value="<?= $item->id ?>" <?= $item->checked ? 'checked' : '' ?>>
                            <span class="label-icon"></span>
                            <span class="label-text"><?= $item->name ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group-label col-sm-2 text-right">
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                </div>
            </div>
        </form>
    </div>
</div>
