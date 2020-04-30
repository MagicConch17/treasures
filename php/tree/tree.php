<?php
/**
 * tree.php
 * 文件描述
 * Created on 2020/4/30 15:23
 * Create by higanbana
 */

/**
 * Notes: 无限极返回子集数据
 * @despart 数据库 平面扩展设计 要求 无限极展示 不能改数据库结构，进行PHP 返回
 * @param $data
 * @param string $parentid
 * @param bool $is_first_time
 * @return array
 * @date: 2020/4/10 7:26 下午
 * @author: higanbana
 */
function getTree($data, $parentid = '0',$is_first_time = true)
{
    static $arr = [];
    if ($is_first_time) {
        $arr = [];
    }
    foreach ($data as $key => $val) {
        if ($val['replyid'] == $parentid) {
            $arr[]           = $val;
            getTree($data, $val['id'], false);
        }
    }
    return $arr;
}


/**
 * 对查询结果集进行排序
 *
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型 asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc')
{
    if (is_array($list)) {
        $refer = $resultSet = array();
        foreach ($list as $i => $data)
            $refer [$i] = &$data [$field];
        switch ($sortby) {
            case 'asc' : // 正向排序
                asort($refer);
                break;
            case 'desc' : // 逆向排序
                arsort($refer);
                break;
            case 'nat' : // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ($refer as $key => $val)
            $resultSet [] = &$list [$key];
        return $resultSet;
    }
    return false;
}

/**
 * 列表数据转换成Tree结构
 *
 * @param        $list  列表数据
 * @param string $pk 主键id
 * @param string $pid 父级主键id
 * @param string $child 子孙节点名称
 * @param int $root 第一级节点id
 *
 * @return array
 *
 * @date   2020/1/11 0011 16:01
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer [$data [$pk]] = &$list [$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data [$pid];
            if ($root == $parentId) {
                $tree [] = &$list [$key];
            } else {
                if (isset ($refer [$parentId])) {
                    $parent = &$refer [$parentId];
                    $parent [$child] [] = &$list [$key];
                }
            }
        }
    }
    return $tree;
}

/**
 *  单层树
 *
 * @param        $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param int $root
 *
 * @return array|mixed
 *
 * @auther liang
 * @date   2019/8/19 15:40
 */
function one_list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer [$data [$pk]] = &$list [$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data [$pid];
            if ($root == $parentId) {
                $tree = &$list [$key];
            } else {
                if (isset ($refer [$parentId])) {
                    $parent = &$refer [$parentId];
                    $parent [$child] = &$list [$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 替换键名的代码
 * @param array $array 原来的值
 * @param array $keyArray 原来的key
 * @param array $keyNewArray 新key
 * @return array 替换过的
 */
function changeKeys($array, $keyArray, $keyNewArray)
{
    if (!is_array($array)) return $array;
    $tempArray = array();
    foreach ($array as $key => $value) {
        // 处理数组的键
        $key = array_search($key, $keyArray, true) === false ? $key : $keyNewArray[array_search($key, $keyArray)];
        if (is_array($value)) {

            $value = changeKeys($value, $keyArray, $keyNewArray);

        }
        $tempArray[$key] = $value;
    }
    return $tempArray;
}

/**
 * 将list_to_tree的树还原成列表
 * @param array $tree 原来的树
 * @param string $child 孩子节点的键
 * @param string $order 排序显示的键，一般是主键 升序排列
 * @param array $list 过渡用的中间数组，
 * @return array 返回排过序的列表数组
 */
function tree_to_list($tree, $child = '_child', $order = 'id', &$list = array())
{
    if (is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if (isset ($reffer [$child])) {
                unset ($reffer [$child]);
                tree_to_list($value [$child], $child, $order, $list);
            }
            $list [] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby = 'asc');
    }
    return $list;
}


