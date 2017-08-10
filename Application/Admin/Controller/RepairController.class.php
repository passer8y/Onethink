<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/10
 * Time: 15:15
 */

namespace Admin\Controller;


class RepairController extends AdminController
{
    //报修管理
    public function index()
    {
        $name       =   I('name');
        $map['status']  =   array('egt',0);
        if(is_numeric($name)){
            $map['sn|name']=   array(intval($name),array('like','%'.$name.'%'),'_multi'=>true);
        }else{
            $map['name']    =   array('like', '%'.(string)$name.'%');
        }

        $list   = $this->lists('repairs', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '报修管理';
        $this->display();
    }
    //新增报修
    public function add(){
        if(IS_POST){
            $Repair = D('repairs');
            $data = $Repair->create();
            if($data){
                $id = $Repair->add();
                if($id){
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Repair->getError());
            }
        } else {
            $this->meta_title = '新增报修';
            $this->display('add');
        }
    }

    /**
     * 查看编辑报修记录
     */
    public function edit($id = 0){
        if(IS_POST){
            $Repair = D('repairs');
            $data = $Repair->create();
//            var_dump($data);exit;
            if($data){
                if($Repair->save()){
                    //记录行为
                    action_log('update_repairs', 'repairs', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Repair->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('repairs')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $this->assign('info', $info);
            $this->meta_title = '查看编辑';
            $this->display();
        }
    }

    /**
     * 删除报修记录
     */
    public function delete(){
        $id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        $repairModel = M('repairs');
        if($repairModel->where($map)->delete()){
            //记录行为
            action_log('update_repair', 'repair', $id, UID);
            $this->success('删除成功');
        } else {

            $this->error('删除失败！');
        }
    }


}