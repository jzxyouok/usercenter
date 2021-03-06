<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>

<div class='bgf clearfix'>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th style="width: 30px;text-align: center">ID</th>
                    <th style="width: 80px;text-align: center">活动名称</th>
                    <th style="width: 100px;text-align: center">报名人数</th>
                    <th style="width: 100px;text-align: center">核销人数</th>
                    <th style="width: 120px;text-align: center">创建时间</th>
                    <th style="width: 120px;text-align: center">创建人</th>
                    <th style="width: 50px;text-align: center">操作管理</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($houslist)){
                    foreach ($houslist as $k => $item) { ?>
                        <tr id="list_<?php echo $item['id'] ?>">
                            <td style="text-align: center"><?php echo $item['id']; ?></td>
                            <td style="text-align: center"><?php echo $item['title'] ?></td>
                            <td style="text-align: center"><?php echo $item['sign'] ?></td>
                            <td style="text-align: center"><?php echo $item['pay'] ?></td>
                            <td style="text-align: center"><?php echo date('Y-m-d H:i:s',$item['createtime']); ?></td>
                            <td style="text-align: center"><?php echo $item['author']; ?></td>
                            <td style="text-align: center">
                                <a class='delete' href="<?php echo $this->createUrl('usermanage',array('id'=>$item['id']));?>">参与用户数据</a>
                            </td>
                        </tr>
                    <?php }}?>
                </tbody>
            </table>

            <div class="pages clearfix">
                <?php
                $this->widget('CLinkPager', array('pages' => $pages,
                        'cssFile' => false,
                        'header'=>'',
                        'firstPageLabel' => '首页', //定义首页按钮的显示文字
                        'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                        'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                        'prevPageLabel' => '前一页',
                    )
                );
                ?></div>
        </form>
    </div>
</div>