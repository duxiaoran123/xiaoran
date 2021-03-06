<?php
/**
 * Created by PhpStorm.
 * User: hawk2fly
 * Date: 2017/9/11
 * Time: 下午5:30
 */

namespace app\admin\model;


class Area extends Admin
{

    public function getList( $request )
    {
        $request = $this->fmtRequest( $request );
        if( $request['offset'] == 0 && $request['limit'] == 0 ){
            return $this->order('create_time desc')->where( $request['map'] )->select();
        }
        return $this->order('create_time desc')->where( $request['map'] )->limit($request['offset'], $request['limit'])->select();
    }

    public function saveData( $data )
    {
        if( isset( $data['id']) && !empty($data['id'])) {
            $data['update_time'] = time();
            return $this->validate(true)->isUpdate(true)->save( $data );
        } else {
            $data['create_time'] = time();
            return $this->validate(true)->save($data);
        }
    }

    public function deleteById($id)
    {
        return Area::destroy($id);
    }

    public function getTotalAreaNumber($where){
        return $this->where($where)->count();
    }

    public function getAreaById($id){
        return $this->where('id',$id)->find();
    }

    public function getAreaInfo($where,$method,$field = ''){
        if( !$field ){
            return $this->where($where)->$method();
        }
        return $this->where($field)->$method();
    }

    public function getAreasById($id, $company_id)
    {
        $ids = explode(',', $id);
        return $this->where('id', 'in', $ids)->where('company_id', $company_id)->select();
    }
}