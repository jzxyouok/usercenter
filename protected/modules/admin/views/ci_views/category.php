<?php $this->load->view('header');?>
<div class='bgf clearfix'>

<div class="center_top">
    <div class="control_nav"> 
        <ul>
            <li class="btn"><span>栏目管理</a></span>  
<!--            <li class="btn_b"><a href="javascript:;" onclick="submitdel_bat('<?php echo admin_url("category/del")?>')"><?php echo lang('del')?></a></li>    -->
            <li class="btn_b"><a href="<?php echo admin_url('category/add')?>"><?php echo lang('add')?></a></li>   
        </ul>
    </div>
  
</div>

     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"></th>
			  <th width="50">id</th>
			  <th>栏目名称</th>
                          <th width="100">别名</th>
                          <th width="100">栏目模型</th>
                          <th width="50">状态</th>
                          <th width="100">导航显示</th>
			  <th width="100">操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40" style='height:38px;background:none;border-bottom:1px solid #e6e6e6'></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['id']?></td>
                          <td style='height:38px;line-height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['fix']?><input name="order[]" ref="<?php echo $item['id']?>" style='width:28px;height:24px;line-height:24px;text-align:center;margin:0 2px 0 0;' value="<?php echo $item['order']?$item['order']:'99'?>"><?php echo $item['name']?>  <a class="add_for_type" href="<?php echo admin_url("category/add/{$item['id']}")?>">添加子类</a></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['alias']?></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['model']?></td>
                        <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['status']?'启用':'禁用';?></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['is_nav']?'启用':'禁用';?></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'>
                              <a class="a_btn a_edit" href="<?php echo admin_url("category/edit/{$item['id']}")?>">编辑</a> 
                              <a class="a_btn a_del" onclick="del('<?php echo admin_url("category/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a>
                          </td>
                        </tr>	
                    <?php } ?>
		</tbody>
	</table>
      
       <div class="center_footer clearfix">
        <ul> 
            <li class="btn_b" ><a href="<?php echo admin_url('category/add')?>"><?php echo lang('add')?></a></li>   
            <li class="btn_b" style='margin:0 0 0 5px;'><a href="javascript:;" onclick="submitorder('<?php echo admin_url("category/order")?>')"><?php echo lang('order')?></a></li>   
        </ul>
    </div>
      
	</form>
</div>
 </div>   
</body>
</html>
