﻿<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '交易对';
$this->params['breadcrumbs'][] = $this->title;
$status2 = [
    '0' => '<sapn style="color:#E33545"><i class="fa fa-fw fa-close"></i>未推荐</span>',
    '1' => '<sapn style="color:#28A745"><i class="fa fa-fw fa-check"></i>已推荐</span>',
];
?>
<!-- 审核模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">交易对</h4>
            </div>

            <div class="modal-body" style="text-align: center;">
                <div id="coin_text_modal" >

                </div>
            </div>
        </div>
    </div>
</div>
<!-- 审核模态框（Modal） end-->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>交易对</h5>
                        <div class="ibox-tools">
                            <a class="btn btn-primary btn-xs" href="<?= Url::to(['edit'])?>">
                                <i class="fa fa-plus"></i>  新增币种
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>交易对</th>

                                <th>交易币种</th>

                                <th>结算币种</th>
                                <th>发布最低值</th>
                                <th>Taker费率</th>
                                <th>Maker费率</th>
                                <th>小数点位数</th>
                                <th>排序</th>
                                <th>状态</th>
                                <th>首页推荐</th>
                                <th>创新区推荐</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data as $model){ ?>
                                <tr>
                                    <td><?= $model->id?></td>
                                    <td><?= $model->stock?>/<?= $model->money?></td>

                                    <td><?= $model->stock?></td>

                                    <td><?= $model->money?></td>
                                    <td><?= $model->limit_amount?></td>
                                    <td><?= $model->taker_fee?></td>
                                    <td><?= $model->maker_fee?></td>
                                    <td><?= $model->decimals?></td>
                                    <td class="col-md-1"><input type="number" date-id="<?= $model->id?>" class="form-control" value="<?= $model['listorder']?>" onblur="orderUpdate(this)"></td>
                                    <td><?= $status[$model->enable] ?></td>
                                    <td><?= $status2[$model->recommend] ?></td>
                                    <td><?= $status2[$model->is_chuangxin] ?></td>
                                    <td>
                                        <a href="<?= Url::to(['edit','id'=>$model->id])?>""><span class="btn btn-info btn-sm">修改</span></a>&nbsp;
                                        <?php if($model->enable == 0){?>
                                            <a href="#" data-id="<?=$model->id?>" class="enable"><span class="btn btn-info btn-sm">启用</span></a>&nbsp;
                                        <?php }else{?>
                                            <a href="#" data-id="<?=$model->id?>" class="disable"><span class="btn btn-danger btn-sm">禁用</span></a>&nbsp;
                                        <?php }?>
                                        <a href="<?= Url::to(['delete','id'=>$model->id])?>"  onclick="rfDelete(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp;
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= LinkPager::widget([
                                    'pagination'        => $Pagination,
                                    'maxButtonCount'    => 5,
                                    'firstPageLabel'    => "首页",
                                    'lastPageLabel'     => "尾页",
                                    'nextPageLabel'     => "下一页",
                                    'prevPageLabel'     => "上一页",
                                ]);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function orderUpdate($data){
            var update_id     = $data.getAttribute('date-id');
            var update_orders =  Number($data.value); 
            // console.log(update_id+'----'+update_orders);
            if (!isNaN(update_orders)){
                $.ajax({
                    type:"post",
                    url:"<?= Url::to(['change-order'])?>",
                    dataType: "json",
                    data: {id:update_id,orders:update_orders},
                    success: function(data){
                        if(data.code == 200) {
                            window.location.reload();
                            // layer.alert('更新排序字段成功!', {icon: 1}, function(){
                            //     window.location.reload();
                            // });
                        }else{
                            layer.alert('更新排序字段失败！', {icon: 2});
                            console.log(data.message);
                        }
                    },
                    error: function(e){
                        layer.alert('更新排序字段失败！', {icon: 2});
                        console.log(e);
                    }
                });

            }else{
                layer.alert('排序字段必须是数字！', {icon: 2});
            }
       }
        $(function () {
            $(".enable").click(function() {
                var id = $(this).attr("data-id");
                swal({
                    title: "确定吗？",
                    text: "真的要启用吗！",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "启用！",
                    closeOnConfirm: false
                },function () {
                    $.ajax({
                        url: "enable",
                        type: "POST",
                        data: {id: id, status: 1},
                        success: function (result) {
                            result = $.parseJSON(result)
                            if (result.code == 200) {
                                rfSuccess('启用', result.message);
                            } else {
                                rfError('启用', result.message);
                            }
                        }
                    });
                });
            });
            $(".disable").click(function(){
                var id = $(this).attr("data-id");
                swal({
                    title: "确定吗？",
                    text: "真的要禁用吗！",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "禁用！",
                    closeOnConfirm: false
                },function () {
                    $.ajax({
                        url:"enable",
                        type:"POST",
                        data:{id:id,status:0},
                        success : function(result) {
                            result = $.parseJSON(result)
                            if(result.code == 200){
                                rfSuccess('禁用', result.message);
                            }else{
                                rfError('禁用', result.message);
                            }
                        }
                    });
                });
            });
        })

    </script>