<?php
/**
 * 扩展属性管理
 *
 * @author     chenfenghua<843958575@qq.com>
 * @copyright  Copyright 2008-2013 shop.feipin0512.com
 * @version    1.0
 */
class PropsController extends BaseController
{
    public function init()
    {
        $this->registerJs(array('oct/goods/props'));
    }
    /**
     * 列表
     */
    public function actionIndex()
    {
        $pageIndex =  Tool::getValidParam('page')? Tool::getValidParam('page'):1;
        $goodTypeProps = new GoodsTypeProps();
        $result = $goodTypeProps->lists($goodTypeProps,$pageIndex,$this->pagesize,'props_id DESC','');

        //分页
        $pages = new CPagination($result['count']);

        $this->render('index',array(
            'dataProvider'=>$result['item'],
            'pages' => $pages,
            'pageIndex'=>$pageIndex-1
        ));
    }

    /**
     * 编辑
     */
    public function actionUpdate()
    {
        $props_id = Tool::getValidParam('props_id','int');

        $model['props_value_items'] = GoodsTypePropsValue::model()->findAll('props_id = :props_id',array(':props_id'=>$props_id));
        if ($_POST) {
            $props_attributes = Tool::getValidParam('Props');
            $props_value_attributes = Tool::getValidParam('PropsValue');
            $props_attributes['lastmodify'] = time();
            $result = GoodsTypeProps::model()->updatebypk($props_id,$props_attributes);
            if (!$result) {
                $GoodsTypeProps = new GoodsTypeProps();
                $this->message('error',CHtml::errorSummary($GoodsTypeProps),$this->createUrl('index'));
            }

            $GoodsTypePropsValue = new GoodsTypePropsValue();
            if($props_value_attributes){
                $result = $GoodsTypePropsValue->PropsValuesEdit($props_id,$props_value_attributes,$model['props_value_items']);
            }else{
                $props_value = GoodsTypePropsValue::model()->findAll('props_id = :props_id',array(':props_id'=>$props_id));
                if($props_value) {
                    $sql = '';
                    foreach ($props_value as $v) {
                        $sql .= "DELETE FROM {{b2c_goods_type_props_value}} WHERE props_id=$props_id  AND props_value_id = {$v['props_value_id']};";
                    }
                    $result = Mod::app()->db->createCommand($sql)->execute();
                }
            }
            if ($result) {
                $this->message('success','编辑成功',$this->createUrl('index'));
            } else {
                $this->message('error',CHtml::errorSummary($GoodsTypePropsValue),$this->createUrl('index'));
            }
        }
        $model['props_item'] = GoodsTypeProps::model()->find("props_id = :props_id",array(':props_id'=>$props_id));


        $this->render('update',array('model'=>$model));
    }

    /**
     * 创建
     */
    public function actionCreate()
    {
        if ($_POST) {
            $GoodsTypeProps = new GoodsTypeProps();
            $GoodsTypePropsValue = new GoodsTypePropsValue();

            $props_attributes = Tool::getValidParam('Props');
            $props_attributes['type'] = 'select';
            $props_attributes['search'] = 'nav';
            $props_attributes['show'] = 'on';

            $GoodsTypeProps->attributes = $props_attributes;
            $props_value_attributes = Tool::getValidParam('PropsValue');
            if (!$GoodsTypeProps->save()) $this->message('error',CHtml::errorSummary($GoodsTypeProps),$this->createUrl('index'));
            $props_id = Mod::app()->db->getLastInsertID();

            $result = $GoodsTypePropsValue->PropsValuesAdd($props_id,$props_value_attributes);
            if ($result) {
                $this->message('success','新增成功',$this->createUrl('index'));
            } else {
                $this->message('error',CHtml::errorSummary($GoodsTypePropsValue),$this->createUrl('index'));
            }
        }
        $this->render('create');
    }

    /**
     * 删除
     */
    public function actionDelete()
    {
        $props_id = Tool::getValidParam('props_id','int');

        $result = GoodsTypeProps::model()->deleteAll('props_id = :props_id',array(':props_id'=>$props_id));
//        if (!$result) {
//            $GoodsTypePropsValue = new GoodsTypePropsValue();
//            $this->message('error',CHtml::errorSummary($GoodsTypePropsValue),$this->createUrl('index'));
//        }

        GoodsTypePropsRelation::model()->deleteAll('props_id = :props_id',array(':props_id'=>$props_id));

        $result = GoodsTypePropsValue::model()->deleteAll('props_id = :props_id',array(':props_id'=>$props_id));
        if ($result) {
            $this->message('success','删除成功',$this->createUrl('index'));
        } else {
            $GoodsTypePropsValue = new GoodsTypePropsValue();
            $this->message('error',CHtml::errorSummary($GoodsTypePropsValue),$this->createUrl('index'));
        }
    }

    /**
     * Ajax获取扩展属性列表
     */
    public function actionAjaxlist()
    {
        $pageIndex = Tool::getValidParam('page','int')?Tool::getValidParam('page','int'):1;
        $goodTypeProps = new GoodsTypeProps();
        $result = $goodTypeProps->PropsValueList($pageIndex,$this->pagesize);

        //分页
        $pages = new CPagination($result['count']);

        echo $this->renderPartial('ajaxlist',array(
            'dataProvider'=>$result['item'],
            'pages' => $pages,
            'pageIndex'=>$pageIndex-1,
            'propsValue'=>$result['propsValue']
        ));
    }
}