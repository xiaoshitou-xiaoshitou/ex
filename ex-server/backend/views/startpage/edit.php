﻿<?php
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => 'Banner图', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>信息修改</h5>
                </div>
                <div class="ibox-content">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'title')->textInput() ?>
                        <?= $form->field($model, 'img')->widget('backend\widgets\webuploader\Image', [
                            'boxId' => 'icon',
                            'options' => [
                                'multiple'   => false,
                            ]
                        ])?>
                        <?= $form->field($model, 'type')->dropDownList(['1' => 'APP Banner','2' => 'PC Banner']) ?>
                        <?= $form->field($model, 'url')->textInput() ?>
                        <?= $form->field($model, 'status')->dropDownList(['1' => '启用','0' => '禁用']) ?>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
