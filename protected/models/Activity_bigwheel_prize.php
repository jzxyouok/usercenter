<?php

class Activity_bigwheel_prize extends CActiveRecord {

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
        return '{{activity_bigwheel_prize}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mid,title,name,count,probability,remainder,img,createtime,updatetime,aid,status', 'safe'),
        );
    }


}
