<?php
class SiteController extends HouseController{
    protected $_siteUrl;
    public function init(){
        parent::init();
    }
    /**
     * 活动首页
     * author  Fancy
     */
    public function actionIndex(){
        $cityurl = trim(Tool::getValidParam('city','integer'));
        if(empty($cityurl)) {
            $cityurl=1;
        }
        Cookie::set('city', $cityurl);
        $cookie_mod=Cookie::get('city');
        if($cookie_mod){}
        if($cookie_mod!=$cityurl){
            Cookie::remove('city');
        }
        $sql = "SELECT id,title,city,actime,coupon,figue,img FROM {{house_activity}} WHERE status=1 and type=1 and city=$cookie_mod order by createtime desc limit 0,5";
        $houselist=Mod::app()->db->createCommand($sql)->queryAll();
        foreach($houselist as $k=>$v) {
            if($houselist[$k]['city']==1){
                $houselist[$k]['city']="武汉";
            }elseif($houselist[$k]['city']==2){
                $houselist[$k]['city']="郑州";
            }
            $houselist[$k]['actime1']= explode("|",$houselist[$k]['actime'])[0];
            $houselist[$k]['actime2']= explode("|",$houselist[$k]['actime'])[1];
            if($houselist[$k]['actime1']>time()){
                $houselist[$k]['type']= "1";
            }else{
                $houselist[$k]['type']= "2";
            }
            if (mb_strlen($houselist[$k]['title'], 'utf8') > 28){
                $houselist[$k]['title']=mb_substr($houselist[$k]['title'], 0, 28, 'utf8') . '...';
            }
            if($houselist[$k]['actime2']<time()){
                $houselist[$k]['end']= "bg2";
            }else{
                $houselist[$k]['end']= "bg1";
            }
        }
        //var_dump($houselist);
        $data = array(
            'config'=>array(
                'site_title'=> '腾讯●楼盘商城',
                'Keywords'=>'腾讯●楼盘商城',
                'Description'=>'腾讯●楼盘商城',
            ),
            'houseinfo'=>$houselist,
        );
        $this->render("index",$data);
    }


    /**
     * @abstract 上拉加载房产信息
     * @author Fancy
     */
    public function actionGethouse(){
        $page = trim(Tool::getValidParam('page','integer',1));
        $pagesize = trim(Tool::getValidParam('pagesize','integer',5));
        $cookie_mod=Cookie::get('city');
        if($page<=2){$page=2;}
        $start = ($page-1)*$pagesize;
        $sql = "SELECT id,title,actime,coupon,city,figue,img,share_img FROM {{house_activity}} WHERE status=1 and city=$cookie_mod and type=1 order by createtime desc limit $start,$pagesize";
        $houselist=Mod::app()->db->createCommand($sql)->queryAll();
        $sql = "SELECT count(id) as id FROM {{house_activity}}  WHERE status=1 and type=1 ";
        $houtenum=Mod::app()->db->createCommand($sql)->queryRow();
        $page=ceil(intval($houtenum['id'])/5);
        foreach($houselist as $k=>$v) {
            if($houselist[$k]['city']==1){
                $houselist[$k]['city']="武汉";
            }elseif($houselist[$k]['city']==2){
                $houselist[$k]['city']="郑州";
            }
            $houselist[$k]['page'] = $page;
            if (mb_strlen($houselist[$k]['title'], 'utf8') > 28){
                $houselist[$k]['ftitle']=mb_substr($houselist[$k]['title'], 0, 28, 'utf8') . '...';
            }else{
                $houselist[$k]['ftitle']=$houselist[$k]['title'];
            }
            $houselist[$k]['url'] = $this->_siteUrl . '/house/site/detail/id/' . $houselist[$k]['id'];
            $houselist[$k]['img'] = $this->_siteUrl . '/' . $houselist[$k]['img'];
            $houselist[$k]['actime1']= explode("|",$houselist[$k]['actime'])[0];
            $houselist[$k]['actime2']= explode("|",$houselist[$k]['actime'])[1];
            if($houselist[$k]['actime1']>time()){
                $houselist[$k]['ftype']= "1";
            }else{
                $houselist[$k]['ftype']= "2";
            }
            if($houselist[$k]['actime2']<time()){
                $houselist[$k]['end']= "bg2";
            }else{
                $houselist[$k]['end']= "bg1";
            }
        }
        if($houselist){
            echo json_encode($houselist);  //转换为json数据输出
        }else{
            echo json_encode(array(fcode=>0));
        }
    }

    /**
     * 点击加载报名记录
     * author  Fancy
     */
    public function actionGetorderinfo(){


    }



    /**
     * 接口测试
     * author  Fancy
     */

    public function actionTt(){
        $nonce = $this->string(32);
        $ticket = Mod::app()->memcache->get('tickets');
        $access_token=Mod::app()->memcache->get('access_token');
        $timestamp=time();
        $version="1.0.0";
        var_dump($nonce,$ticket,$access_token,$timestamp,$version);
    }
    /**
     * 活动详情页
     * author  Fancy
     */
    public function actionDetail(){
        $id=Tool::getValidParam('id','integer');
        $cookie_mod=Cookie::get('city');
        if(!empty($id)){
            $sql = "SELECT a.id,a.phone,a.city,a.financingid,a.actime,a.coupon,a.desc,a.figue,a.img,a.dtitle,a.share_img,m.title,m.earnings FROM {{house_activity}} as a LEFT JOIN {{house_money}} as m on a.financingid=m.id WHERE a.status=1 and a.type=1 and city=$cookie_mod and a.id=$id";
            $houseinfo=Mod::app()->db->createCommand($sql)->queryRow();
            if($houseinfo){
                if($houseinfo['city']==1){
                    $houseinfo['city']="武汉";
                }elseif($houseinfo['city']==2){
                    $houseinfo['city']="郑州";
                }
                $houseinfo['actime']=explode("|",$houseinfo['actime'])[1];
                if($houseinfo['actime']<time()){
                    $houseinfo['end']= "bg2";
                }else{
                    $houseinfo['end']= "bg1";
                }
                if (mb_strlen($houseinfo['dtitle'], 'utf8') > 23){
                    $houseinfo['dtitle']=mb_substr($houseinfo['dtitle'], 0, 23, 'utf8') . '...';
                }
            }else{
                echo "error";
                die();
            }
        }else{
            echo "error";
            die();
        }

        $data = array(
            'config'=>array(
                'site_title'=> $houseinfo['dtitle'],
                'Keywords'=>'产品详细',
                'Description'=>'产品详细'
            ),
            'houseinfo'=>$houseinfo,
        );
        $this->render("detail",$data);
    }

    public function actionTest(){
        $houseid=172631;
        $appId = 10000127;
        $appKey = 'c3a8c431d386516044e80211978aeab6';
        $rand = time();
        $_signatureParamArr = array ($appId, $appKey,$rand );
        sort ( $_signatureParamArr, SORT_STRING );
        $_signature = sha1 ( implode ( ($_signatureParamArr) ) );
        $url="http://api.wii.qq.com/app/access_token?app_id=".$appId."&rand=".$rand."&signature=".$_signature;
        if(empty(Mod::app()->session['facctoken'])){
            $info=$this->http_get($url);
            Mod::app()->session['facctoken'] = $info['data']['access_token'];
        }
        if($info['res']==0){
            $ss=$this->http_post(Mod::app()->session['facctoken'],$houseid);
            echo $ss;
        }else{
            echo $info;
        }
    }



    static function http_get($url){
        $curl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        $aStatus = curl_getinfo($curl);
        curl_close($curl);
        if(intval($aStatus["http_code"])==200){
            return json_decode($data, true);
        }else{
            return json_decode($data, true);
        }
    }

    static function http_post($token,$houseid){
        $url = "http://api.wii.qq.com/s/house/house/house/get_house_info?access_token=".$token;
        $post_data = array ("house_id" => $houseid);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}