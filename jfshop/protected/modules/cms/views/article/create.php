<?php
$this->breadcrumbs=array(
    '内容管理',
    '栏目管理'=>array('index'),
    '新增栏目'
);
?>
<?php
$this->renderPartial('_form',array('action'=>'create','model'=>$model));
?>