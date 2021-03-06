<html lang="zh-CN" style="height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>夺宝记录 - 大楚特产</title>
    <meta content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" name="description">
    <meta content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" name="keywords">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta content="telephone=no" name="format-detection">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/common.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/user.css" />
</head>

<body>
<div class="m-user" style="padding-top:0px">
    <div class="m-user-duobaoRecord" id="duobaoRcd_dvWrapper" style="padding-top:0px">
        <div class="m-user-summary m-user-summary-simple">
            <div class="info">
                <div class="m-user-avatar"> <img width="50" height="50"  src="<?php echo JkCms::show_img($this->member['headimgurl']) ?>">
                </div>
                <div class="txt">
                    <div class="name"><?php echo $this->member['name'] ?></div>
                </div>
            </div>
        </div>
        <div id="pro-view-2">
            <div data-pro="loading"></div>
            <ul class="w-goodsList w-goodsList-l m-user-goodsList" data-pro="list">
                <?php
                foreach($goods as $type){
                ?>
                <li class="w-goodsList-item" id="pro-view-4">
                <div class="w-goods w-goods-l w-goods-ing m-user-goods">
                    <div class="w-goods-pic">
                        <a href="">
                            <img alt="<?php echo $type['title']?>" src="<?php echo JkCms::show_img($type['thumb']) ?>"  class="">
                        </a>
                    </div>
                    <div class="w-goods-info">
                        <p class="w-goods-title f-txtabb"><a href=""><?php echo $type['title']?></a></p>
                        <p class="w-goods-price">总需：<?php echo $type['productprice'] ?> 人次</p>
                        <?php if($type['productprice']==$type['ticket_total']) { ?>
                            <div class="m-user-goods-owner m-user-box"><div class="m-user-box-name">获得者：</div><div class="m-user-box-cont"><?php echo $type['ticket_nickname'] ?></div></div>
                            <p class="f-breakword">幸运码:<?php echo $type['ticket'] ?><span class="txt-green" id="province"></span></p>
                            <p id="createtime">揭晓时间：<?php echo date('Y-m-d H:i:s', $type['ticket_time']) ?></p>
                        <?php
                        }
                        ?>
                        <div class="m-user-goods-my">
                            已参与：<span class="txt-impt"><?php echo $type['my_total'] ?></span>人次
                        </div>
                    </div>
                    <div class="w-goods-shortFunc">
                    </div>
                </div>
                </li>
                <?php
                }
                ?>
            </ul>
            <div data-pro="more">
                <div class="w-more" id="pro-view-6">
                    <div data-pro="link" style="display: none;"><a href="javascript:void(0);">上拉加载更多</a></div>
                    <div data-pro="loading" style="display: none;"><b class="ico ico-loading"></b> 努力加载中</div>
                    <div data-pro="disable">已经没有更多</div>
                </div>
            </div>
        </div>
    </div>
</div>
<button class="w-button w-button-round w-button-backToTop" style="display:none" id="pro-view-0">返回顶部</button>
</body>

</html>
