<?php

class MessageController extends AController {

    public function actionIndex() {
        $this->actionLists();
    }
    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $model = new Message();
        $criteria = new CDbCriteria();
        $criteria->condition = "";
      
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $data['pagebar'] = $pages ;
        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
        
            


        $this->render('message', $data);
    }

   

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id = intval(isset($_GET['id'])?$_GET['id']:$_POST['id']);
        $model = Message::model()->findbypk($id);
        if( !empty($_POST) ){
                $model->result  = Tool::getValidParam('result','string');
                $model->updatetime  = time();
                if($model->save()){
                    $target_url = $this->createUrl('/admin/message/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
            }
            $data['fun'] = 'edit';
            
    


            $this->render('message_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Message;
                $res = $model->deleteAll( 'id IN(' . $id_str . ')');
                if ($res) {
                    $mess = '删除成功！';
                    $state = 1;
                } else {
                    $mess = '删除失败！';
                    $state = 0;
                }
            }
        
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

   public function actionOrder() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Tool::getValidParam("id",'string');
        $order_str = Tool::getValidParam("order",'string');
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Message;
            $res = $model->order_bat($id_arr, $order_arr);
            if ($res) {
                $mess = '更新成功！';
                $state = 1;
            } else {
                $mess = '更新失败！';
                $state = 0;
            }
        }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

}
