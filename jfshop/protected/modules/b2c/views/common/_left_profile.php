<div class="sidebar col-md-2">
    <ul class="list-group margin-bottom-25 sidebar-menu">
        <?php if (!$this->username):?>
        <li class="list-group-item clearfix"><a href="<?php echo $this->_siteUrl;?>/account/login.html">
                <i class="fa fa-angle-right"></i>登录/注册</a>
        </li>
        <?php endif;?>
        <li class="list-group-item clearfix <?php if ($this->controller=='account' && $this->getAction()->getId() == 'index'):?>active<?php endif;?>">
            <a href="<?php echo $this->_siteUrl;?>/account/index.html"><i class="fa fa-angle-right"></i>我的帐号</a>
        </li>
        <li class="list-group-item clearfix <?php if ($this->controller=='addr'):?>active<?php endif;?>"><a href="<?php echo $this->_siteUrl;?>/addr/index.html"><i class="fa fa-angle-right"></i> 收货地址</a></li>
        <li class="list-group-item clearfix <?php if ($this->controller=='order'):?>active<?php endif;?>"><a href="<?php echo $this->_siteUrl;?>/order/index.html"><i class="fa fa-angle-right"></i> 我的订单</a></li>
        <!--<li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> 个人信息</a></li>-->
        <li class="list-group-item clearfix <?php if ($this->controller=='account' && $this->getAction()->getId() == 'reset'):?>active<?php endif;?>">
            <a href="<?php echo $this->_siteUrl;?>/account/reset.html"><i class="fa fa-angle-right"></i> 重置密码</a></li>
        <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> 评价/咨询</a></li>
    </ul>
</div>