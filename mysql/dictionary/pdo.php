<?php
/**
 * mysql_pdo.php
 * pdo操作获取数据字典
 * created by Higanbana
 * created on 2019/4/12 13:37
 * Just do it：参天的金字塔不是一朝一夕就能累计上来的
 */
class Db
{
    // 配置标题
    public static $title = '数据字典';
    // 配置数据库连接参数
    public $_dbConfig = [
        'db' => 'mysql',// 默认支持mysql
        'charset' => 'utf8',
        'host' => '',
        'dbname' => '',
        'user' => '',
        'pass' => '',
    ];
    // 设置全局pdo对象
    private static $_db;
    //设置构建数组 返回数组
    private static $result = [];
    // 配置初始化对象
    public function __construct($parsem)
    {
        $this->_get($parsem);
        // 获取参数
        $this->_setIndb();
        // 初始化对象
        $this->showDb();
        // 获取表数据
        $this->_structure();
        // 获取全部数据
    }

    /**
     * 配置参数
     * 将前台获取的参数进行对号入座
     */
    private function _get($parsem){
        // 验证所有的数据
        if (empty($parsem)) die("数据库连接参数错误");
        if (!isset($parsem['host'])) die("缺少数据库地址");
        if (!isset($parsem['user'])) die("缺少用户名");
        if (!isset($parsem['pass'])) die("缺少密码");
        if (!isset($parsem['dbname'])) die("缺少数据库");
        // 将所有的数据进行写入
        $this->_dbConfig['host'] = $parsem['host'];
        $this->_dbConfig['user'] = $parsem['user'];
        $this->_dbConfig['pass'] = $parsem['pass'];
        $this->_dbConfig['dbname'] = $parsem['dbname'];
        // 接收全部参数 将参数放在 _dbConfig 数组里面
        return ;
    }

    /**
     * 初始化对象
     * 获取pdo连接实例
     */
    private function _setIndb()
    {
        try {
            //方便操作
            $_this = $this->_dbConfig;
            $dsn = "{$_this['db']}:host={$_this['host']};dbname={$_this['dbname']}";
            self::$_db = new PDO($dsn, $_this['user'], $_this['pass']);
            //检查连接
            self::$_db->exec('set names' . $_this['charset']);
        } catch (PDOException $e) {
            die("Error:" . $e->getMessage());
        }
    }

    /**
     * 获取全部表
     */
    private function showDb()
    {
        $sql = "show tables;";
        $array = self::$_db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        for ($x = 0; $x < count($array); $x++){
            self::$result[$x]['TABLE_NAME'] = $array[$x];
        }
        return ;
    }

    /**
     * 主方法
     * 功能对外方法
     */
    public function index()
    {
        // 直接返回数据
        return $this->_html();
        // 渲染页面
    }

    /**
     * 获取数据库内部所有表
     * 对所有表进行数组构建
     * 循环取得所有表的备注及表中列消息
     */
    private function _structure()
    {
        // 大循环 取得所有表中的备注信息和表中列注释
        $table_array = self::$result;//赋值获取全部表
        foreach($table_array as $v => $k){
            $sql = 'SELECT * FROM ';
            $sql .= 'INFORMATION_SCHEMA.TABLES ';
            $sql .= 'WHERE ';
            $sql .= "table_name = '{$table_array[$v]['TABLE_NAME']}'  AND table_schema = '{$this->_dbConfig['dbname']}'";
            $table_result = self::$_db->query($sql)->fetchAll();
            $table_array[$v]['TABLE_COMMENT'] = $table_result[0]['TABLE_COMMENT'];
            // 获取TABLE_COMMENT
            $sql = 'SELECT * FROM ';
            $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
            $sql .= 'WHERE ';
            $sql .= "table_name = '{$table_array[$v]['TABLE_NAME']}' AND table_schema = '{$this->_dbConfig['dbname']}'";
            $table_result = self::$_db->query($sql)->fetchAll();
            $table_array[$v]['COLUMN'] = $table_result;
        }
        self::$result = $table_array;
        return ;
    }

    /**
     * 渲染页面
     * 将页面进行板块渲染
     */
    private function _html()
    {
        $array = self::$result;
        $html = '';
        // 获取当前数据 不更改 内部数据
        foreach ($array as $k => $v){
            $html .= '<table  border="1" cellspacing="0" cellpadding="0" align="center">';
            $html .= '<caption>' . $v ['TABLE_NAME'] . '  ' . $v ['TABLE_COMMENT'] . '</caption>';
            $html .= '<tbody><tr>
                        <th>字段名</th>
                        <th>数据类型</th>
                        <th>默认值</th>
                        <th>允许非空</th>
                        <th>自动递增</th>
                        <th>备注</th>
                        </tr>';
            $html .= '';
            foreach ($v['COLUMN'] as $f){
                    $html .= '<tr><td class="c1">' . $f ['COLUMN_NAME'] . '</td>';
                    $html .= '<td class="c2">' . $f ['COLUMN_TYPE'] . '</td>';
                    $html .= '<td class="c3">&nbsp;' . $f ['COLUMN_DEFAULT'] . '</td>';
                    $html .= '<td class="c4">&nbsp;' . $f ['IS_NULLABLE'] . '</td>';
                    $html .= '<td class="c5">' . ($f ['EXTRA'] == 'auto_increment' ? '是' : '&nbsp;') . '</td>';
                    $html .= '<td class="c6">&nbsp;' . $f ['COLUMN_COMMENT'] . '</td>';
                    $html .= '</tr>';
            }
            $html .= '</tbody></table></p>';
        }
        return $html;
    }
}

$html =  '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据字典<higanbana></title>
<style>
body,td,th {font-family:"宋体"; font-size:12px;}
table{border-collapse:collapse;border:1px solid #CCC;background:#6089D4;}
table caption{text-align:left; background-color:#fff; line-height:2em; font-size:14px; font-weight:bold; }
table th{text-align:left; font-weight:bold;height:26px; line-height:25px; font-size:16px; border:3px solid #fff; color:#ffffff; padding:5px;}
table td{height:25px; font-size:12px; border:3px solid #fff; background-color:#f0f0f0; padding:5px;}
.c1{ width: 150px;}
.c2{ width: 130px;}
.c3{ width: 70px;}
.c4{ width: 80px;}
.c5{ width: 80px;}
.c6{ width: 300px;}
</style>
</head>
<body style="text-align:center;">';
if (empty($_POST)){
    // 判断是否存在表单提交
    $html .= '<form action="" method="post">
                   <table>
                        <tr>
                            <th>Please enter your database address:</th>
                            <td><input type="text" placeholder="Enter your database address" name="host"></td>
                        </tr>
                        <tr>
                            <th>Please enter your database account：</th>
                            <td><input type="text" placeholder="Enter your database account" name="user"></td>
                        </tr>
                        <tr>
                            <th>Please enter your database password：</th>
                            <td><input type="text" placeholder="Enter your database password" name="pass"></td>
                        </tr>
                        <tr>
                            <th>Please enter the database name：</th>
                            <td><input type="text" placeholder="Enter the database name" name="dbname"></td>
                        </tr>
                        <tr>
                            <th colspan="2" align="left"><input type="submit"></th>
                        </tr>
                  </table>
              </form>';
    echo $html;
    echo '</body></html>';
}else{
    /**
     * 如果当前监测到 post提交过数据
     * 那么将数据实例到模型中 $parsem
     * 构建$parsem 数组
     */
    $parsem['host'] = $_POST['host'];
    $parsem['user'] = $_POST['user'];
    $parsem['pass'] = $_POST['pass'];
    $parsem['dbname'] = $_POST['dbname'];
    // 构建数组
    $model = new Db($parsem);
    // 获取实例
    echo $html;
    echo '<h1 style="text-align:center;">'.$model->_dbConfig['dbname'].':' . $model::$title . '</h1>';
    echo $model->index();
    echo '</body></html>';
}

