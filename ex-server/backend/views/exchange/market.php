<?php
use yii\helpers\Url;
use api\models\ExchangeCoins;

$this->title = '成交记录';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];

$market_list = ExchangeCoins::getMarketName();
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>筛选条件</h5>
                </div>
                <div class="ibox-content">
                    <form action="<?= Url::to(['market'])?>" method="get" class="form-inline" role="form" id="form">
                        <div class="form-group">
                            <label for="" class="control-label">交易区</label>
                            <select class="form-control tpl-category-parent" name="market">
                                <option value="">请选择</option>
                                <?php foreach ($market_list as $key => $value) { ?>
                                    <option value="<?= $value?>" <?= $market == $value ? "selected":'' ?>><?= $value?></option>

                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group" style="height: 34px">
                            <label for="" class="control-label" style="margin-left: 15px">用户ID</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="user_id" value="<?= $user_id?>">

                            </div>
                        </div>
                        
                        <div class="form-group" style="height: 34px">
                            <label for="" class="control-label" style="margin-left: 15px">起始记录条数</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="offset" value="<?= $offset?>">

                            </div>
                        </div>
                        
                        <div class="form-group" style="height: 34px">
                            <label for="" class="control-label" style="margin-left: 15px">总量</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="limit" value="<?= $limit?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--  list begin  -->
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>历史成交记录</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>撮合订单ID</th>
                                <th>订单ID</th>
                                <th>用户ID</th>
                                <th>交易市场</th>
                                <th>类型</th>
                                <th>角色</th>
                                <th>数量</th>
                                <th>价格</th>
                                <th>成交量</th>
                                <th>手续费</th>
                                <th>时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($code==1){ ?>
                                <?php if(count($data)){ ?>
                                    <?php foreach($data as $key => $value){ ?>
                                        <tr>
                                            <td><?= $value['id'] ?></td>
                                            <td><?=  $value['deal_order_id'] ?></td>
                                            <td><?=  $value['user'] ?></td>
                                            <td><?=  $market ?></td>
                                            <td><?= $value['side'] == '1' ? '卖出('.$value['amount'].')' : '买入('.$value['amount'].')' ?></td>
                                            <td><?= $value['role'] == '1' ? '挂单成交(Maker)' : '吃单成交(Taker)' ?></td>
                                            <td><?= $value['amount'] ?></td>
                                            <td><?= $value['price'] ?></td>
                                            <td><?= $value['deal'] ?></td>
                                            <td><?= $value['fee'] ?></td>
                                            <td><?= date('Y-m-d H:i:s', $value['time']) ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <div class="alert alert-warning" role="alert">
                                        暂时没有数据！
                                    </div>
                                <?php } ?>
                                    
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if($code==0){ ?>
                        <div class="alert alert-danger" role="alert">
                            数据获取失败：<?= $msg ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!--  list end  -->
</div>