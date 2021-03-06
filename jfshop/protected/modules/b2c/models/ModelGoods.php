<?php
/**
 * 货品管理.
 *
 * @author        chenfenghua <843958575@qq.com>
 * @copyright     Copyright (c) 2011-2015 shop. All rights reserved.
 * @link          http://www.yiitian.com
 * @package       yiishop.model
 * @license       http://www.yiitian.com/license
 * @version       v1.0.0
 */

class ModelGoods extends B2cModel
{
    public $table = '{{b2c_goods}}';

    /**
     * 货品单条记录
     *
     * @param $goods_id
     * @param string $select
     * @return mixed
     */
    public function row($goods_id,$select='*')
    {

        $row = $this->ModelQueryRow("SELECT {$select} FROM {{b2c_goods}} WHERE goods_id = {$goods_id} and marketable='true' and disabled='false' ");
        
        return $row;
    }

    /**
     * 货品详情
     *
     * @param $goods_id
     * @return mixed
     */
    public function Item($goods_id)
    {
        //商品详情
        $row = $this->ModelQueryRow(
            "SELECT * FROM car_b2c_goods WHERE goods_id = {$goods_id}"
        );
        $result['row']['goods_id'] = $row['goods_id'];
        $result['row']['cat_id'] = $row['cat_id'];
        $result['row']['brand_id'] = $row['brand_id'];
        $result['row']['default_goods_id'] = $row['goods_id'];
        $result['row']['name'] = $row['name'];
        $result['row']['brief'] = $row['brief'];
        $result['row']['unit'] = $row['unit'];
        $result['row']['weight'] = sprintf('%0.2f',$row['weight']);
        $result['row']['intro'] = $row['intro'];
        $result['row']['paytype'] = $row['paytype'];
        $result['row']['price_jifen'] = $row['price_jifen'];
        $result['row']['price'] = sprintf('%0.2f',$row['price']);
        $result['row']['store'] = $row['store'] - $row['freez'];
        $result['row']['cost'] = sprintf('%0.2f',$row['cost']);
        $result['row']['mktprice'] = sprintf('%0.2f',$row['mktprice']);
        $result['row']['disabled'] = $row['disabled'];


        //商品图片
        $imageimage_list = $this->GoodsImage($result['row']['goods_id']);

        $result['image'] = array();
        if ($imageimage_list) {
            $k = 1;
            foreach ($imageimage_list as $v) {
                if ($v['image_id'] == $row['image_default_id']) {
                    $result['image']['m_image'][0] = $v['m_url'];
                    $result['image']['s_image'][0] = $v['s_url'];
                    $result['image']['l_image'][0] = $v['l_url'];
                } else {
                    $result['image']['m_image'][$k] = $v['m_url'];
                    $result['image']['s_image'][$k] = $v['s_url'];
                    $result['image']['l_image'][$k] = $v['l_url'];
                }

                $k++;
            }
            if (isset($result['image']['m_image'])) ksort($result['image']['m_image']);
            if (isset($result['image']['s_image'])) ksort($result['image']['s_image']);
            if (isset($result['image']['l_image'])) ksort($result['image']['l_image']);
        }

        return $result;
    }

    /**
     * 货品数量
     *
     * @param $condition
     * @return mixed
     */
    public function getCount($condition)
    {
        $sql = "SELECT COUNT(*) FROM {{b2c_goods}}";
        if ($condition) $condition .= " AND disabled = 'false'";
        else $condition = "disabled = 'false'";
        $sql .= " WHERE {$condition}";

        return $this->ModelColumn($sql);
    }

    /**
     * 货品列表
     *
     * @param $select
     * @param $condition
     * @param $order
     * @param $limit
     * @param $pagesize
     * @param bool $is_page
     * @return mixed
     */
    public function getGoods($select,$condition,$order,$limit,$pagesize,$is_page = true)
    {
        $sql = "SELECT {$select} FROM {{b2c_goods}} ";
        if ($condition) $condition .= " AND disabled = 'false'";
        else $condition = "disabled = 'false'";
        $sql .= " WHERE {$condition}";
        if ($order) $sql .= " ORDER BY {$order}";
        if ($is_page) $sql .= " LIMIT {$limit},{$pagesize}";

        $list = $this->ModelQueryAll($sql);
        foreach ($list as $k=>$v) {
            $image_id = $v['image_default_id'];
            $image_row = $this->ImageId($image_id);

            $list[$k]['s_url'] = isset($image_row['s_url'])?$image_row['s_url']:'';
            $list[$k]['m_url'] = isset($image_row['m_url'])?$image_row['m_url']:'';
            $list[$k]['l_url'] = isset($image_row['l_url'])?$image_row['l_url']:'';
        }
        foreach ($list as $k=>$val){
            $sql ="select count(0) con from {{b2c_orders_items}} where goods_id=".$val['goods_id'];
            $arr_con=Mod::app()->db->createCommand($sql)->queryRow();
            $val['con']=$arr_con['con'];
            $list[$k]=$val;
        }
        return $list;
    }

    /**
     * 货品列表
     *
     * @param $select
     * @param $condition
     * @param $order
     * @param $limit
     * @param $pagesize
     * @param bool $is_page
     * @return mixed
     */
    public function getProductsAll($select,$condition,$order)
    {
        $sql = "SELECT {$select} FROM {{b2c_goods}} g LEFT JOIN {{b2c_goods}} p ON g.goods_id = p.goods_id";
        if ($condition) $condition .= " AND g.disabled = 'false'";
        else $condition = "g.disabled = 'false'";
        $sql .= " WHERE {$condition}";
        if ($order) $sql .= " ORDER BY {$order}";

        $list = $this->ModelQueryAll($sql);
        foreach ($list as $k=>$v) {
            $image_id = $v['image_default_id'];
            $image_row = $this->ImageId($image_id);

            $list[$k]['s_url'] = isset($image_row['s_url'])?$image_row['s_url']:'';
            $list[$k]['m_url'] = isset($image_row['m_url'])?$image_row['m_url']:'';
            $list[$k]['l_url'] = isset($image_row['l_url'])?$image_row['l_url']:'';
        }

        return $list;
    }

    /**
     * 购物车商品列表
     */
    public function CartGoods($goods_list)
    {
        if (!$goods_list) return array();
        $goods_list_new = array();
        foreach ($goods_list as $v) {
            $params = unserialize($v['params']);
            $goods_list_new[$params['goods_id']]['obj_ident'] = $v['obj_ident'];
            $goods_list_new[$params['goods_id']]['obj_type'] = $v['obj_type'];
            $goods_list_new[$params['goods_id']]['goods_id'] = $params['goods_id'];
            $goods_list_new[$params['goods_id']]['quantity'] = $v['quantity'];


            $goods_ids[] = $params['goods_id'];
        }
        if (!isset($goods_ids) || isset($goods_ids) && !$goods_ids) return false;

        $goods_ids = implode(',',$goods_ids);

        $result = array();
        if ($goods_ids) {
            $product_sql = "SELECT * FROM {{b2c_goods}} WHERE goods_id IN ({$goods_ids})";
            $product_list = GlobalFunc::ArrayListByKey($this->ModelQueryAll($product_sql),'goods_id');
            $goods_ids = array();
            foreach($product_list as $tp){
                $goods_ids[] = $tp['goods_id'];
            }unset($tp);

            $goods_ids = implode(',',$goods_ids);

            $image_list = $this->GoodsDefaultImage($goods_ids);

//            var_dump($product_list);
            foreach($product_list as $tk=>&$tp){
                $tp['product_name'] = $tp['name'];
                $tp['price'] = sprintf('%.2f',$tp['price']);
                $tp['mktprice'] = sprintf('%.2f',$tp['mktprice']);
                $spec = str_replace(array(' ','、'),' ',$tp['spec_info']);
                $tp['spec'] = explode(' ',$spec);

                $tp['image'] = isset($image_list[$tp['goods_id']])?$image_list[$tp['goods_id']]['s_url']:'';

                $tp['quantity'] =   $goods_list_new[$tp['goods_id']]['quantity'];

            }unset($tp);

        }
        return $product_list;
    }

    /**
     * 购物车商品列表
     */
    public function CartGoodsCache($goods_list)
    {
        if (!$goods_list) return array();
        $goods_list_new = array();
        foreach ($goods_list as $v) {
            if($v['goods_id']){
                $goods_list_new[$v['goods_id']] = $v;
                $goods_ids[] = $v['goods_id'];
            }
        }
        if (!isset($goods_ids) || isset($goods_ids) && !$goods_ids) return false;

        $goods_ids = implode(',',$goods_ids);


        $result = array();
        if ($goods_ids) {
            $product_sql = "SELECT * FROM {{b2c_goods}} WHERE goods_id IN ({$goods_ids})";
            $product_list = GlobalFunc::ArrayListByKey($this->ModelQueryAll($product_sql),'goods_id');

            $goods_ids = array();
            foreach($product_list as $tp){
                $goods_ids[] = $tp['goods_id'];
            }unset($tp);
            $goods_ids = implode(',',$goods_ids);
            $image_list = $this->GoodsDefaultImage($goods_ids);

            foreach($product_list as $tk=>&$tp){

                $tp['product_name'] = $tp['name'];
                $tp['price'] = sprintf('%.2f',$tp['price']);
                $tp['mktprice'] = sprintf('%.2f',$tp['mktprice']);
                $spec = str_replace(array(' ','、'),' ',$tp['spec_info']);
                $tp['spec'] = explode(' ',$spec);

                $tp['image'] = isset($image_list[$tp['goods_id']])?$image_list[$tp['goods_id']]['s_url']:'';

                $tp['quantity'] =   $goods_list_new[$tp['goods_id']]['quantity'];
            }unset($tp);

        }
        return $product_list;


    }

    /**
     * 根据image_id 获取图片
     *
     * @param $image_id
     * @return mixed
     */
    public function ImageId($image_id)
    {
        $row = $this->ModelQueryRow("SELECT * FROM car_image_image WHERE image_id = '{$image_id}'");
        return $row;
    }

    /**
     * 根据image_ids 获取图片
     *
     * @param $image_id
     * @return mixed
     */
    public function ImageIds($image_id)
    {
        foreach ($image_id as $v) {
            $image_id_Arr[] = "'".$v."'";
        }

        $image_ids = implode(',',$image_id_Arr);

        return $this->ModelQueryAll("SELECT * FROM car_image_image WHERE image_id IN ({$image_ids})");
    }

    /**
     * 根据goods_id获取商品图片
     *
     * @param $goods_id
     * @return mixed
     */
    public function GoodsImage($goods_id)
    {
        $attach = $this->ModelQueryAll("SELECT * FROM car_image_image_attach WHERE target_id IN ('{$goods_id}')");

        $image_id = array();
        foreach ($attach as $v) {
            $image_id[] = $v['image_id'];
        }

        $image = array();
        if (!empty($image_id)) $image = $this->ImageIds($image_id);

        return $image;
    }

    /**
     * 根据商品ID获取默认图片
     *
     * @param $goods_id
     * @return bool
     */
    public function GoodsDefaultImage($goods_id)
    {
        if (!$goods_id) return false;
        $sql = "SELECT goods_id,image_default_id FROM {{b2c_goods}} WHERE goods_id IN ($goods_id)";
        $goods_list = $this->ModelQueryAll($sql);

        $goods_id_image_list = array();
        foreach ($goods_list as $v) {
            $image_goods_list[$v['image_default_id']] = $v['goods_id'];
            $goods_id_image_list[] = "'".$v['image_default_id']."'";
        }

        $item_list = array();
        if ($goods_id_image_list) {
            $goods_id_images = implode(',',$goods_id_image_list);

            $image_sql = "SELECT * FROM {{image_image}} WHERE image_id IN ($goods_id_images)";
            $image_list = $this->ModelQueryAll($image_sql);
            foreach ($image_list as $v) {
                $goods_id = $image_goods_list[$v['image_id']];

                $item_list[$goods_id] = $v;
            }
        }

        return $item_list;
    }
}