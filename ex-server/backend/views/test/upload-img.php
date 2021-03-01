﻿<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = $model->isNewRecord ? '创建' : '编辑';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data'
            ]
        ]); ?>
        <div class="col-sm-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>文章编辑</h5>
                </div>
                <div>
                    <div class="ibox-content">
                        <div class="col-md-12">
                            <?= $form->field($model, 'head_portrait')->widget('backend\widgets\webuploader\Image', [
                                'boxId' => 'head_portrait',
                                'options' => [
                                    'multiple'   => false,
                                ]
                            ])->label('单图上传'); ?>

                            <?= $form->field($model, 'head_portrait[]')->widget('backend\widgets\webuploader\Image', [
                                'boxId' => 'head_portrait_images',
                                'options' => [
                                    'multiple'   => true,
                                ]
                            ])->label('多图上传');?>

                            <?= $form->field($model, 'head_portrait')->widget('backend\widgets\webuploader\Image', [
                                'boxId' => 'qiniu',
                                'pluginOptions' => [
                                    'uploadUrl' => Url::to(['/file/qiniu']),//上传路径
                                ],
                                'options' => [
                                    'multiple'   => false,
                                ]
                            ])->label('七牛上传'); ?>

                            <?= $form->field($model, 'head_portrait')->widget('backend\widgets\webuploader\Image', [
                                'boxId' => 'aliOss',
                                'pluginOptions' => [
                                    'uploadUrl' => Url::to(['/file/ali-oss']),//上传路径
                                ],
                                'options' => [
                                    'multiple'   => false,
                                ]
                            ])->label('阿里云OSS'); ?>

                            <div class="hr-line-dashed"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary" type="submit">保存内容</button>
                                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
