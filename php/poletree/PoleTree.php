<?php
/**
 * @Descripttion: 
 * @version: 
 * @Author: clown
 * @Date: 2019-08-07 18:05:57
 * @LastEditors: clown
 * @LastEditTime: 2019-08-07 18:06:43
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