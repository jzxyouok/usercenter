

<script type="text/javascript" src="resource/js/lib/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="resource/js/lib/jquery-ui-1.10.3.min.js"></script>
<ul class="nav nav-tabs">
    <li {if $operation == 'post'}class="active"{/if}><a href="{php echo $this->createWebUrl('goods', array('op' => 'post'))}">添加商品</a></li>
    <li {if $operation == 'display'}class="active"{/if}><a href="{php echo $this->createWebUrl('goods', array('op' => 'display'))}">管理商品</a></li>
    <li {if $operation == 'member'}class="active"{/if}><a href="{php echo $this->createWebUrl('member',array('op' => 'member'))}">会员管理</a></li>

</ul>
{if $operation == 'post'}
<link type="text/css" rel="stylesheet" href="../addons/hc_zhongchou/images/uploadify_t.css" />
<style type='text/css'>
    .tab-pane {padding:20px 0 20px 0;}
</style>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
        <div class="panel panel-default">
            <div class="panel-heading">
                {if empty($item['id'])}添加商品{else}编辑商品{/if}
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active" ><a href="#tab_basic">基本信息</a></li>
                    <li><a href="#tab_des">商品描述</a></li>
                    <!--					<li><a href="#tab_param">自定义属性</a></li>
                                        <li><a href="#tab_option">商品规格</a></li>-->
                    <li><a href="#tab_other">其他设置</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane  active" id="tab_basic">{template 'goods_basic'}</div>
                    <div class="tab-pane" id="tab_des">{template 'goods_des'}</div>
                    <!--					<div class="tab-pane" id="tab_param">{template 'goods_param'}</div>
                                        <div class="tab-pane" id="tab_option">{template 'goods_option'}</div>-->
                    <div class="tab-pane" id="tab_other">{template 'goods_other'}</div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
            <input type="hidden" name="token" value="{$_W['token']}" />

            <input type="buttom" value="开奖" class="btn btn-primary col-lg-1 pull-right" />
        </div>
    </form>
</div>

<script type="text/javascript">
    var category = {php echo json_encode($children)};

    $(function () {
        window.optionchanged = false;
        $('#myTab a').click(function (e) {
            e.preventDefault();//阻止a链接的跳转行为
            $(this).tab('show');//显示当前选中的链接及关联的content
        })
    });

    function formcheck(){
        if($("#pcate").val()=='0'){
            Tip.focus("pcate","请选择商品分类!","right");
            return false;
        }
        if($("#goodsname").isEmpty()) {
            $('#myTab a[href="#tab_basic"]').tab('show');
            Tip.focus("goodsname","请输入商品名称!","right");
            return false;
        }
        {if empty($id)}
            if ($.trim($(':file[name="thumb"]').val()) == '') {
                $('#myTab a[href="#tab_basic"]').tab('show');
                $('#myTab a[href="#tab_basic"]').tab('show');
                Tip.focus('thumb_div', '请上传缩略图.', 'right');
                return false;
            }
            {/if}
                if($("#goodsname").isEmpty()) {
                    $('#myTab a[href="#tab_basic"]').tab('show');
                    Tip.focus("goodsname","请输入商品名称!","right");
                    return false;
                }
                var full = checkoption();
                if(!full){return false;}
                if(optionchanged){
                    $('#myTab a[href="#tab_option"]').tab('show');
                    message('规格数据有变动，请重新点击 [刷新规格项目表] 按钮!','','error');
                    return false;
                }
                return true;
            }

            function checkoption(){

                var full = true;
                if( $("#hasoption").get(0).checked){
                    $(".spec_title").each(function(i){
                        if( $(this).isEmpty()) {
                            $('#myTab a[href="#tab_option"]').tab('show');
                            Tip.focus(".spec_title:eq(" + i + ")","请输入规格名称!","top");
                            full =false;
                            return false;
                        }
                    });
                    $(".spec_item_title").each(function(i){
                        if( $(this).isEmpty()) {
                            $('#myTab a[href="#tab_option"]').tab('show');
                            Tip.focus(".spec_item_title:eq(" + i + ")","请输入规格项名称!","top");
                            full =false;
                            return false;
                        }
                    });
                }
                if(!full) { return false; }
                return full;
            }

</script>

{elseif $operation == 'display'}

<div class="main">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="hc_zhongchou" />
                <input type="hidden" name="do" value="goods" />
                <input type="hidden" name="op" value="display" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
                    <div class="col-xs-12 col-sm-8 col-lg-9">
                        <input class="form-control" name="keyword" id="" type="text" value="{$_GPC['keyword']}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">状态</label>
                    <div class="col-xs-12 col-sm-8 col-lg-9">
                        <select name="status" class='form-control'>
                            <option value="1" {if $_GPC['status'] != '0'} selected{/if}>上架</option>
                            <option value="0" {if $_GPC['status'] == '0'} selected{/if}>下架</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-1 control-label">分类</label>
                    <div class="col-sm-8 col-xs-12">
                        {php echo tpl_form_field_category_2level('category', $parent, $children, $params[':pcate'], $params[':ccate'])}
                    </div>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>

                <div class="form-group">
                </div>
            </form>
        </div>
    </div>
    <style>
        .label{cursor:pointer;}
    </style>
    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:5%;">ID</th>
                    <th style="width:20%;">商品标题</th>
                    <th style="width:25%;">商品属性(点击可修改)</th>
                    <th style="width:10%;">商品编号</th>
                    <th style="width:10%;">商品条码</th>
                    <th style="width:10%;">状态(点击可修改)</th>
                    <th style="text-align:right; width:20%;">操作</th>
                </tr>
                </thead>
                <tbody>
                {loop $list $item}
                <tr>
                    <td>{$item['id']}</td>
                    <td>
                        {if !empty($category[$item['pcate']])}
                        <span class="text-danger">[{$category[$item['pcate']]['name']}]</span>
                        {/if}
                        {if !empty($category[$item['ccate']])}
                        <span class="text-info">[{$category[$item['ccate']]['name']}]</span>
                        {/if}
                        {$item['title']}
                    </td>
                    <td>
                        <label data='{$item['isnew']}' class='label label-default {if $item['isnew']==1}label-info{else}{/if}' onclick="setProperty(this,{$item['id']},'new')">新品</label>
                        <label data='{$item['ishot']}' class='label label-default {if $item['ishot']==1}label-info{/if}' onclick="setProperty(this,{$item['id']},'hot')">热卖</label>
                        <!--
                        <label data='{$item['isrecommand']}' class='label label-default {if $item['isrecommand']==1}label-info{/if}' onclick="setProperty(this,{$item['id']},'recommand')">首页</label>
                        <label data='{$item['isdiscount']}' class='label label-default {if $item['isdiscount']==1}label-info{/if}' onclick="setProperty(this,{$item['id']},'discount')">折扣</label>
                        -->

                    </td>
                    <td>{$item['goodssn']}</td>
                    <td>{$item['productsn']}</td>
                    <td>
                        <label data='{$item['status']}' class='label  label-default {if $item['status']==1}label-info{/if}' onclick="setProperty(this,{$item['id']},'status')">{if $item['status']==1}上架{else}下架{/if}</label>
                        <label data='{$item['type']}' class='label  label-default {if $item['type']==1}label-info{/if}' onclick="setProperty(this,{$item['id']},'type')" >{if $item['type']==1}实体物品{else}虚拟物品{/if}</label>
                    </td>
                    <td style="text-align:right;">

                        <!--<a href="{php echo $this->createWebUrl('goods_cheat', array('id' => $item['id'], 'op' => 'post'))}"class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="作弊"><i class="fa fa-fighter-jet"></i></a>&nbsp;&nbsp;
                        -->
                        <a href="{php echo $this->createWebUrl('goods', array('id' => $item['id'], 'op' => 'post'))}"class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                        <a href="{php echo $this->createWebUrl('goods', array('id' => $item['id'], 'op' => 'delete'))}" onclick="return confirm('此操作不可恢复，确认删除？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                {/loop}
                </tbody>
            </table>
            {$pager}
        </div>
    </div>
</div>
<script type="text/javascript">
    require(['bootstrap'],function($){
        $('.btn').hover(function(){
            $(this).tooltip('show');
        },function(){
            $(this).tooltip('hide');
        });
    });

    var category = {php echo json_encode($children)};
    function setProperty(obj,id,type){
        $(obj).html($(obj).html() + "...");
        $.post("{php echo $this->createWebUrl('setgoodsproperty')}"
            ,{id:id,type:type, data: obj.getAttribute("data")}
            ,function(d){
                console.log(d);
                $(obj).html($(obj).html().replace("...",""));
                if(type=='type'){
                    $(obj).html( d.data=='1'?'实体物品':'虚拟物品');
                }
                if(type=='status'){
                    $(obj).html( d.data=='1'?'上架':'下架');
                }
                $(obj).attr("data",d.data);
                if(d.result==1){
                    $(obj).toggleClass("label-info");
                }
            }
            ,"json"
        );
    }

</script>

{elseif $operation == 'member'}
<div class="panel panel-default" id="member">
    <div class="panel-body table-responsive">
        <table class="table table-hover">
            <thead class="navbar-inner">
            <tr>
                <th style="width:5%;">ID</th>
                <th style="width:20%;">昵称</th>
                <th style="width:10%;">城市</th>
                <th style="width:10%;">真实姓名</th>
                <th style="width:20%;">手机号</th>
                <th style="width:20%">ip</th>
                <th style="width:15%">众筹币</th>
            </tr>
            </thead>
            <tbody>
            {loop $members $item}
            <tr>
                <td>{$item['id']}</td>
                <td>{$item['nickname']}</td>
                <td>{$item['city']}</td>
                <td>{$item['realname']}</td>
                <td>{$item['tel']}</td>
                <td>{$item['ip']}</td>
                <td><input type="number" value="{php echo isset($item['bi']) ? $item['bi'] : '0.00';}" step="0.01" name="member_bi" uis="{php echo $item['id']}"></td>
            </tr>
            {/loop}
            </tbody>
        </table>
        {$pager}
    </div>
</div>

<script type="text/javascript">
    $(function(){

        $("#member table td input").blur(function(){
            var url = "{php echo $this->createWebUrl('member',array('op' => 'post','token'=> $_W['token']));}";
            url += "&member_bi="+$(this).val()+"&uis="+$(this).attr("uis");
            $.ajax({
                "url": url,
                "type": "post",
            });

        });

    });
</script>

{/if}
{template 'common/footer'}
