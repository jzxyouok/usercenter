<?php

class CityLife extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Wx the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{citylife}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,cateid ,url,icon,position','required', 'on'=>'create,edit'),
            array('name,cateid,url,icon', 'safe'),
        );
    }

    function order_bat($ids,$res){
        $num = count($ids);
        $data = array();
        for($i=0;$i<$num;$i++){
                $data[] = array('id'=>$ids[$i],'order'=>$res[$i]);
                $count =$this->updateByPk($ids[$i],array('order'=>$res[$i])); 
        }
 
        return true;
    }

    function getCateName($id)
    {
        $cate = CityLifeCategory::model()->findByPk($id);
        return $cate->name;
    }
        
    
         

}
