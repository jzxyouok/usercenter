<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加用户组</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/admin.css')?>" />
        <script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
        <script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
 </head>
 <body>
   
<div class='bgf clearfix'>
       
<div class="center_top clearfix">
<ul>
    <li class="btn"><a  href="javascript:;">权限设置</a></span>  
</ul>

</div>
    
     
<div class="clearfix"></div>
<div class="list">                     
<form name="list_frm" id="ListFrm" action="<?php echo admin_url('membergroup/permission');?>" method="post">
<input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"></th>
			  <th  width="140">功能</th>
                          <th  width="350">内部操作</th>
                          <!--<th>子栏目</th>-->
                          <th></th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>"     >
                          <td class="first_td"  width="80" style="height:38px;background:none;border-bottom:1px solid #e6e6e6">
                              <?php  if($item['fid']){?>
                              <input type="checkbox" name="" value="<?php echo $item['id']?>"  <?php  if(isset($view['permission'][$item['class']])){ echo 'checked=checked'; } ?>  >
                     <?php }else{echo '<b>大分类:</b>';} ?>
                          </td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php echo $item['fix']?><?php echo lang($item['class']).lang('model')?></td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6">
                                <?php if(!empty($item['fun_arr'])){?>
                                    <input type="checkbox" onclick='checkall2(this,"<?php echo $item['class'].'[]'?>")' name=""><?php echo lang('all') ?>
                                    <?php foreach ($item['fun_arr'] as $fun): ?>
                                    <input type="checkbox" value="<?php echo $fun?>"  <?php  if(isset($view['permission'][$item['class']])&&in_array($fun,$view['permission'][$item['class']])){ echo 'checked';}?>  name="<?php echo $item['class'].'[]'?>"><?php echo lang($fun) ?>
                                    <?php endforeach; ?>
                                <?php } ?>
                          </td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" >
                            
                          </td>
                          </tr>	
                    <?php  } ?>
                            
                            <tr>	
                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" ></td>
                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" ></td>
                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" >
                            <input type="submit" value='提交' class="btn">
                            </td>
                            </tr>	
		</tbody>
	</table>
<!--      <div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"><?php echo lang('all') ?></li>
        </ul>
    </div>-->
   </form>
</div>


</div>

 </div>   
</body>
</html>
