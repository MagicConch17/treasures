<?php
/**
 * @description: 根据数组生成树形结构
 * @param {array} $array
 * @return: array
 */ 
function generateTree($array)
{
    //第一步 构造数据
    $items = array();
    foreach($array as $value){
        $items[$value['id']] = $value;
    }
    //第二部 遍历数据 生成树状结构
    $tree = array();
    foreach($items as $key => $value){
        if(isset($items[$value['parent_id']])){
            $items[$value['parent_id']]['son'][] = &$items[$key];
        }else{
            $tree[] = &$items[$key];
        }
    }
    return $tree;
}

/**
 * @description: 根据对象生成树形结构
 * @param {obj} $permissions 需要生成的对象
 * @param {int} $id 父级
 * @param {int} $count 层级
 * @return: obj 排序后级别
 */
function getTree($permissions, $id = 0, $count = 0)
{
    static $res = array();
    foreach ($permissions as $permission) {
        if ($permission->parent_id == $id) {
            $permission->count = $count;
            $res[] = $permission;
            $this->getTree($permissions, $permission->id, $count+1);
        }
    }
    return $res;
}