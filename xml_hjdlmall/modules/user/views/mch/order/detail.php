<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/3
 * Time: 15:10
 */
defined('YII_ENV') or exit('Access Denied');


use yii\widgets\LinkPager;

/* @var \app\models\User $user */

$urlManager = Yii::$app->urlManager;
$statics = Yii::$app->request->baseUrl . '/statics';
$this->title = '订单详情';
$order_id = $_GET['order_id'];
?>
<style>
    tr > td:first-child {
        text-align: right;
        width: 100px;
    }
    tr td {
        word-wrap: break-word;
    }

    .orderProcess{
        margin-bottom: 1.5rem;
        width: 100%;
        height: 12rem;
        border: 1px solid #ECEEEF;
        position: relative;
        margin-left: 1.1rem;
        margin-right: 1.1rem;
    }

    table .orderProcess ul{
        padding-left: 1rem;
    }

    .orderWord{
        height: 3rem;
    }
    
    .over{
        color: green;
    }

    .noOver{
        color: #888888;
    }

    .orderProcess ul{
        list-style: none;
        position: absolute;
        top:50%;
        left: 50%;
        margin-top: -4rem;
        margin-left: -28rem;
        padding-left: 0;
    }
    ul li{
        float: left;
        text-align: center;
        width: 8rem;
    }

    .orderIcon .iconfont{
        font-size: 2rem;
    }

    li i{
        height: 3.8rem;
        line-height: 3.8rem;
    }
</style>
<div class="panel mb-3">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">
        <div class="mb-3 clearfix">
            <div style="overflow-x: hidden">
                <div class="row">
                    <div class="orderProcess">
                        <ul>
                            <li>
                                <div>
                                    <div class="orderIcon"><i class="iconfont icon-xiadan over"></i></div>
                                    <div class="over">已下单</div>
                                </div>
                                <div class="orderWord over">
                                    <?= date('Y-m-d H:i:s', $order['addtime']) ?>
                                </div>                                          
                            </li>
                            <?php if ($order['is_delete'] == 1 || $order['is_cancel'] == 1) : ?>
                            <li class="orderWord over">
                                <i class="iconfont icon-dian"></i>
                                <i class="iconfont icon-dian"></i>
                                <i class="iconfont icon-dian"></i>
                                <i class="iconfont icon-dian"></i>
                                <i class="iconfont icon-jiantouyou"></i>
                            </li>
                            <li class="over">
                                <div class="orderIcon">
                                    <i class="iconfont icon-iconfontzhizuobiaozhun0262"></i>
                                </div>
                                <div>已取消</div>
                            </li>
                            <?php else : ?>
                                <?php if ($order['pay_time'] < $order['send_time']) : ?>
                                <li></li>
                                <?php if ($order['is_pay'] == 1): ?>
                                <li class="orderWord over">
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-jiantouyou"></i>
                                </li>
                                <?php elseif ($order['is_pay'] == 0 && $order['is_send'] == 1) : ?>
                                <li></li>
                                <?php else : ?>
                                <li class="orderWord over">
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-jiantouyou noOver"></i>
                                </li>    
                                <?php endif; ?>
                                <li>
                                    <div>
                                    <?php if ($order['is_pay'] == 1) : ?>
                                        <div class="orderIcon">
                                            <i class="iconfont icon-shouye over"></i>
                                        </div>
                                        <div class="over">已付款</div> 
                                        <?php if ($order['pay_time'] > $order['addtime']) : ?>
                                        <div class="orderWord over">
                                            <?= date('Y-m-d H:i:s', $order['pay_time']) ?>
                                        </div> 
                                        <?php endif; ?>
                                    <?php elseif ($order['is_pay'] == 0 && $order['is_send'] == 1) : ?>
                                    <div></div>   
                                    <?php else : ?>
                                        <div class="orderIcon">
                                            <i class="iconfont icon-shouye noOver"></i>
                                        </div>
                                        <div class="noOver">未付款</div>
                                    <?php endif; ?> 
                                    </div>                                  
                                </li>
                            <?php endif; ?>
                                <?php if ($order['is_send'] == 1) : ?>
                                <li class="orderWord over">
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-jiantouyou"></i>
                                </li>
                                <?php elseif ($order['is_pay'] == 1) : ?>
                                <li class="orderWord over">
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-jiantouyou noOver"></i>
                                </li>  
                                <?php else : ?>
                                <li class="orderWord over">
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-jiantouyou noOver"></i>
                                </li>    
                                <?php endif; ?>
                                <li>
                                    <div>
                                    <?php if ($order['is_send'] == 1) : ?>
                                        <div class="orderIcon">
                                            <i class="iconfont icon-fahuo over"></i>
                                        </div>
                                        <div class="over">已发货</div>
                                        <div class="orderWord over"><?= date('Y-m-d H:i:s', $order['send_time']) ?></div>
                                    <?php else : ?>
                                        <div class="orderIcon">
                                            <i class="iconfont icon-fahuo noOver"></i>                             
                                        </div>    
                                        <div class="noOver">未发货</div>         
                                    <?php endif; ?>
                                    </div>                              
                                </li>
                                <?php if ($order['is_confirm'] == 1) : ?>
                                <li class="orderWord over">
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-jiantouyou"></i>
                                </li>
                                <?php elseif ($order['is_send'] == 1) : ?>
                                <li class="orderWord over">
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-jiantouyou noOver"></i>
                                </li>  
                                <?php else : ?>
                                <li class="orderWord over">
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-dian noOver"></i>
                                    <i class="iconfont icon-jiantouyou noOver"></i>
                                </li>    
                                <?php endif; ?>
                                <li>
                                    <div>
                                    <?php if ($order['is_confirm'] == 1) : ?>
                                        <div class="orderIcon">
                                            <i class="iconfont icon-icon-receive over"></i>
                                        </div>
                                        <?php if ($order['pay_time'] > $order['send_time']) : ?>
                                        <div class="over">已确认收货并付款</div>
                                        <?php else : ?>
                                        <div class="over"><?= $order['clerk_id'] > 0 ? "已核销" : "已收货" ?></div>
                                        <?php endif; ?>
                                        <div class="orderWord over"><?= date('Y-m-d H:i:s', $order['confirm_time']) ?></div>
                                    <?php else : ?>
                                        <div class="orderIcon">
                                            <i class="iconfont icon-icon-receive noOver"></i>
                                        </div>
                                        <div class="noOver">未收货</div>
                                    <?php endif; ?>
                                    </div>                            
                                </li>
                            <?php endif; ?>    
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 mb-4">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" style="text-align: center">订单状态</td>
                            </tr>
                            <tr>
                                <td>订单号</td>
                                <td><?= $order['order_no'] ?></td>
                            </tr>
                            <tr>
                                <td>下单时间</td>
                                <td><?= date('Y-m-d H:i', $order['addtime']) ?></td>
                            </tr>
                            <tr>
                                <td>用户</td>
                                <td><?= $user['nickname'] ?></td>
                            </tr>
                            <tr>
                                <td>支付方式</td>
                                <td>
                                    <?php if ($order['pay_type'] == 2) : ?>
                                        <span class="badge badge-success">货到付款</span>
                                    <?php elseif ($order['pay_type'] == 3) : ?>
                                        <span class="badge badge-success">余额支付</span>
                                    <?php else : ?>
                                        <span class="badge badge-success">线上支付</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>收货信息</td>
                                <td>
                                    <div>
                                        <span>收货人：<?= $order['name'] ?></span>
                                    </div>
                                    <div>
                                        <span>电话：<?= $order['mobile'] ?></span>
                                    </div>
                                    <?php if ($order['address']) : ?>
                                        <div>
                                            <span>收货地址：<?= $order['address'] ?></span>
                                        </div>
                                    <?php else : ?>
                                        <div>
                                            <span>收货方式：<span class="badge badge-warning mt-1">到店自提</span></span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if ($order['express']) : ?>
                                <tr>
                                    <td>快递信息</td>
                                    <td>
                                        <div>
                                            <span>快递公司：<span class=" badge badge-default"><?= $order['express'] ?></span></span>
                                        </div>
                                        <div>
                                            <span>快递单号：<?= $order['express_no'] ?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($order['refund']) : ?>
                                <tr>
                                    <td>售后状态</td>
                                    <td>
                                        <?php if ($order['refund'] == 0) : ?>
                                            <span>待商家处理</span>
                                        <?php elseif ($order['refund'] == 1) : ?>
                                            <span>同意并已退款</span>
                                        <?php elseif ($order['refund'] == 2) : ?>
                                            <span>已同意换货</span>
                                        <?php elseif ($order['refund'] == 3) : ?>
                                            <span>已拒绝退换货</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="2" style="text-align: center">订单金额</td>
                            </tr>
                            <tr>
                                <td>总金额<br>（含运费）</td>
                                <td><?= $order['total_price'] ?>元</td>
                            </tr>
                            <tr>
                                <td>运费</td>
                                <td>
                                    <?php if ($order['express_price_1']) : ?>
                                        <div><?= $order['express_price_1'] ?>元</div>
                                        <div class="text-danger">包邮，运费减免</div>
                                    <?php else : ?>
                                        <?= $order['express_price'] ?>元
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if ($order['use_coupon_id'] == 1) : ?>
                                <tr>
                                    <td>优惠券优惠</td>
                                    <td><?= $order['coupon_sub_price'] ?>元</td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($order['integral_arr'] && $order['integral_arr']['forehead_integral']) : ?>
                                <tr>
                                    <td>积分情况</td>
                                    <td>
                                        <div>积分使用：<?= $order['integral_arr']['forehead_integral'] ?></div>
                                        <div>积分抵扣：<?= $order['integral_arr']['forehead'] ?>元</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($order['discount'] && $order['discount'] != 10) : ?>
                                <tr>
                                    <td>会员折扣</td>
                                    <td><?= $order['discount'] ?>折</td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($order['before_update_price']) : ?>
                                <tr>
                                    <td>下单金额</td>
                                    <td><?= $order['before_update_price'] ?>元</td>
                                </tr>
                                <tr>
                                    <td>后台改价</td>
                                    <?php $money = $order['pay_price'] - $order['before_update_price']; ?>
                                    <td><?= $money < 0 ? "优惠：" . -$money . "元" : "加价：{$money}元" ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td>实付金额</td>
                                <td><?= $order['pay_price'] ?>元</td>
                            </tr>
                            <?php if ($order['get_integral']) : ?>
                                <tr>
                                    <td>可获得积分</td>
                                    <td><?= $order['get_integral'] ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <div class="col-12 col-md-6 mb-4">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="3" style="text-align: center">商品信息</td>
                            </tr>
                            <?php foreach ($goods_list as $index => $value) : ?>
                                <tr>
                                    <td rowspan="4">商品<?= $index + 1 ?></td>
                                    <td class="text-right">商品名</td>
                                    <td><?= $value['name'] ?></td>
                                </tr>
                                <tr>
                                    <td>规格</td>
                                    <td>
                                        <div>
                                        <span class="text-danger">
                                            <?php $attr_list = json_decode($value['attr']); ?>
                                            <?php if (is_array($attr_list)) :
                                                foreach ($attr_list as $attr) : ?>
                                                <span class="mr-3"><?= $attr->attr_group_name ?>
                                                    :<?= $attr->attr_name ?></span>
                                                <?php endforeach;
                                                ;
                                            endif; ?>
                                        </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>数量</td>
                                    <td><?= $value['num'] . $value['unit'] ?></td>
                                </tr>
                                <tr>
                                    <td>小计</td>
                                    <td><?= $value['total_price'] ?>元</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td>买家留言</td>
                                <td colspan="2"><?= $order['content'] ?></td>
                            </tr>
                            <?php if ($order['words']) : ?>
                                <tr>
                                    <td>商家留言</td>
                                    <td colspan="2"><?= $order['words'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td>商家备注</td>
                                <td colspan="2"><textarea id="seller_comments" name="seller_comments" cols="90" rows="5"
                                                          style="resize: none;width: 100%;"><?= $order['seller_comments'] ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center">
                                    <button type="button" class="btn btn-success">确定</button>
                                    <input type="button" class="btn btn-default ml-4" 
                                           name="Submit" onclick="javascript:history.back(-1);" value="返回">
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $('.btn-success').on('click', function () {
        var seller_comments = $("#seller_comments").val();
        var btn = $(this);
        btn.btnLoading("正在提交");
        var url = "<?=$urlManager->createUrl(['user/mch/order/seller-comments', 'order_id' => $order_id])?>";
        $.ajax({
            url: url,
            type: "get",
            data: {
                seller_comments: seller_comments,
            },
            dataType: "json",
            success: function (res) {
                if (res.code == 0) {
                    btn.text(res.msg);
                    window.location.href = "<?=$urlManager->createUrl(['user/mch/order/index'])?>";
                }
                if (res.code == 1) {
                    btn.text(res.msg);
                    btn.btnReset();
                }
            }
        });
    });

</script>
