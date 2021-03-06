<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 9:41
 */

class Activity_signup extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Wx the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        //用户报名表
        return '{{activity_signup}}';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid,title,status,desc,img,start_time,end_time,create_time,update_time', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'member'=>array(self::BELONGS_TO, 'Member','', 'on'=>'mid=member.id'),
        );
    }
    //活动列表带分页
    public function getActivityListPager($pid){
        $as_list = array();
        $list = null;
        $asModel = new Activity_signup;
        $criteria = new CDbCriteria();
        $criteria->order = 'create_time DESC';
        $criteria->condition ='pid='.$pid;
        $count = $asModel->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $as_list['count'] = $count;
        $as_list['pagebar'] = $pages;
        $as_list['criteria'] = $asModel->findAll($criteria);
        return $as_list;
    }
    
    /**
     * 根据活动开始时间和结束时间判断活动状态
     * @param type $starTime
     * @param type $endTime
     * @param type $status
     * @return string
     */
    public static function activityStatus($starTime,$endTime){
        $returnCode = array('status'=>0,'message'=>'');
        $nowTime = time();
        if($endTime <= $nowTime){
            $returnCode['status'] = 0;
            $returnCode['message'] = '已结束';
        }else{
            if($starTime > $nowTime){
                $returnCode['status'] = -1;
                $returnCode['message'] = '未开始';
            }else{
                $returnCode['status'] = 1;
                $returnCode['message'] = '进行中';
            }
        }
        if($status==1){
            return $returnCode['message'];
        }else{
            return $returnCode;
        }
    }
    /**
     * 根据用户的openid查找用户的个人信息
     * @param type $starTime
     * @param type $endTime
     * @param type $status
     * @return string
     */
    public static function getuserinfo($openid,$pid){
        //查询一条数据  
        $sql = "SELECT * FROM dym_member_project WHERE openid='".$openid."' and pid=$pid";  
        $user=Mod::app()->db->createCommand($sql)->queryRow();
        if($user){
            $userid = $user['mid'];
            $sql = "SELECT * FROM dym_member WHERE id=$userid";
            $userinfo=Mod::app()->db->createCommand($sql)->queryRow();
            return $userinfo;
        }else{
            return false;
        }
    }
}