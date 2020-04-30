<?php
/**
 * Helper.php
 * 简便方法
 * Created on 2020/4/30 15:27
 * Create by higanbana
 */

/**
 * 格式化字节大小
 * @param number $size 字节数
 * @param string $delimiter 数字和单位分隔符
 * @return string 格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '')
{
    $units = array(
        'B',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB'
    );
    for ($i = 0; $size >= 1024 && $i < 5; $i++)
        $size /= 1024;
    return round($size, 2) . $delimiter . $units [$i];
}


/**
 * 基于数组创建目录和文件
 * @param unknown $files
 */
function create_dir_or_files($files)
{
    foreach ($files as $key => $value) {
        if (substr($value, -1) == '/') {
            mkdir($value);
        } else {
            @file_put_contents($value, '');
        }
    }
}

/**
 *  判断是否是word文档
 * @param unknown $type
 * @return boolean
 */
function isWord($type)
{
    $type = strtolower($type);
    $extArray = array(
        'pdf',
        'doc',
        'docx',
        'wps',
        'wpt',
        'dot',
        'rtf'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 判断是否是PPT
 * @param unknown $type
 * @return boolean
 */
function isPPT($type)
{
    $type = strtolower($type);
    $extArray = array(
        'dps',
        'dpt',
        'ppt',
        'pot',
        'pps',
        'pptx'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 判断是否是微软的PPT格式
 * @param unknown $type
 * @return boolean
 */
function isMicrosoftPPT($type)
{
    $type = strtolower($type);
    $extArray = array(
        'ppt',
        'pptx'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 判断是不是 pdf
 * Enter description here ...
 * @param $type
 */
function isPDF($type)
{
    $type = strtolower($type);
    $extArray = array(
        'pdf',
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 *  是否是excel类型
 * @param unknown $type
 * @return boolean
 */
function isExcel($type)
{
    if (isMicrosoftExcel($type) || isWPSExcel($type)) {
        return true;
    }
    return false;
}

/**
 * 判断是否为微软的office
 * @param unknown $type
 * @return boolean
 */
function isMicrosoftExcel($type)
{
    $type = strtolower($type);
    $extArray = array(
        'xls',
        'xlsx'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 判断是否为wps的excel
 * @param unknown $type
 */
function isWPSExcel($type)
{
    $type = strtolower($type);
    $extArray = array(
        'et',
        'ett',
        'xlt'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 判断是不是 Scratch格式
 * Enter description here ...
 * @param $type
 */
function isScratch($type)
{
    $type = strtolower($type);
    $extArray = array(
        'sb',
        'sb1',
        'sb2',
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 判断是不是思维导图的文件
 * Enter description here ...
 * @param $type
 */
function isMind($type)
{
    $type = strtolower($type);
    $extArray = array(
        'xmind',
        'mmap'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 判断是不是文本类型
 * @param unknown $type
 * @return boolean
 */
function isText($type)
{
    $type = strtolower($type);
    if ($type == "txt" || isCode($type)) {
        return true;
    }
    return false;
}

/**
 * 判断是否是压缩包
 * @param unknown $type
 * @return boolean
 */
function isZip($type)
{
    $type = strtolower($type);
    $extArray = array(
        'rar',
        'zip'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 判断是否为maya的格式
 * @param unknown $type
 * @return boolean
 */
function isMaya($type)
{
    $type = strtolower($type);
    $extArray = array(
        'obj',
        'stl'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 支持文档清洗类型
 * @param unknown $type
 * @return boolean
 */
function isDocument($type)
{
    $type = strtolower($type);
    $extArray = array(
        'dot',
        'doc',
        'docx',
        'wps',
        'wpt',
        'pdf',
        'txt'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    if (isCode($type)) {
        return true;
    }
    return false;
}

/**
 * 判断一个文件，是否是代码文件，可否直接代码预览
 * @param unknown $type
 * @return boolean
 */
function isCode($type)
{
    $type = strtolower($type);
    $extArray = array(
        'c',
        'cpp',
        'cxx',
        'sql',
        'java',
        'css',
        'asm',
        'm',
        'php',
        'js',
        'jsp',
        'h',
        'hpp',
        'py',
        'rb',
        'lua'
    );
    foreach ($extArray as $ext) {
        if (strcmp($ext, $type) == 0) {
            return true;
        }
    }
    return false;
}

/**
 * 去掉所有空白
 */
function trimall($str)
{
    $qian = array(
        " ",
        "　",
        "\t",
        "\n",
        "\r",
        "\r\n",
        "&nbsp;",
    );
    $hou = array(
        "",
        "",
        "",
        "",
        "",
        "",
        ""
    );
    return str_replace($qian, $hou, $str);
}

/**
 * 常见的正则表达式判断
 * @param unknown $value
 * @param unknown $rule
 * @return boolean
 */
function regex($value, $rule)
{
    $validate = array(
        'require' => '/\S+/',
        'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
        'url' => '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
        'currency' => '/^\d+(\.\d+)?$/',
        'number' => '/^\d+$/',
        'zip' => '/^\d{6}$/',
        'integer' => '/^[-\+]?\d+$/',
        'double' => '/^[-\+]?\d+(\.\d+)?$/',
        'english' => '/^[A-Za-z]+$/'
    );
    // 检查是否有内置的正则表达式
    if (isset ($validate [strtolower($rule)]))
        $rule = $validate [strtolower($rule)];
    return preg_match($rule, $value) === 1;
}

/**
 * 从url里面提取 oss所需要的key值
 * Enter description here ...
 * @param $url
 */
function getOssObjectKey($url)
{
    $array = parse_url($url);
    $path = $array['path'];
    $path = ltrim($path, "/");
    return $path;
}

/**
 * 去掉http: 或者 https:这两个标示
 * Enter description here ...
 * @param unknown_type $url
 */
function removeHttp($url)
{
    $newUrl = $url;
    if ($url != null) {
        $protocol = substr($url, 0, 5);
        if ($protocol == "http:") {
            $newUrl = substr($url, 5);
            return $newUrl;
        } else {
            $protocol = substr($url, 0, 6);
            if ($protocol == "https:") {
                $newUrl = substr($url, 6);
                return $newUrl;
            }
        }
    }
    return $newUrl;
}

/**
 * 删除掉无用的一些字符串
 * Enter description here ...
 * @param $str
 * @param $removeStr
 */
function removeLastEmpty($str, $removeStr = '<p><br></p>')
{
    if ($str == null || $str == "") return $str;
    if (strlen($str) >= strlen($removeStr)) {
        $len = strlen($str);
        $substr = substr($str, $len - strlen($removeStr));
        while ($substr == $removeStr) {
            if ($len - strlen($removeStr) < 0) {
                break;
            }
            $str = substr($str, 0, $len - strlen($removeStr));
            if (strlen($str) >= strlen($removeStr)) {
                $len = strlen($str);
                $substr = substr($str, $len - strlen($removeStr));
                if ($substr != $removeStr) {
                    break;
                }
            } else {
                break;
            }
        }
    }
    $qian = array("<br>", "<br/>");
    $hou = array("", "");
    $str = str_replace($qian, $hou, $str);
    return $str;
}

/**
 * 获取分页数
 * Enter description here ...
 * @param $count
 */
function getPages($count)
{
    if ($count % 20 == 0) {
        $pages = (int)($count / 20);
    } else {
        $pages = (int)($count / 20) + 1;
    }
    return $pages;
}

// 去除json中注释部分; json允许注释
// 支持 // 和 /*...*/注释
function json_comment_clear($str)
{
    $result = '';
    $inComment = false;
    $commentType = '//';// /*,//
    $quoteCount = 0;
    $str = str_replace(array('\"', "\r"), array("\\\0", "\n"), $str);

    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];
        if ($inComment) {
            if ($commentType == '//' && $char == "\n") {
                $result .= "\n";
                $inComment = false;
            } else if ($commentType == '/*' && $char == '*' && $str[$i + 1] == '/') {
                $i++;
                $inComment = false;
            }
        } else {
            if ($str[$i] == '/') {
                if ($quoteCount % 2 != 0) {//成对匹配，则当前不在字符串内
                    $result .= $char;
                    continue;
                }
                if ($str[$i + 1] == '*') {
                    $inComment = true;
                    $commentType = '/*';
                    $i++;
                    continue;
                } else if ($str[$i + 1] == '/') {
                    $inComment = true;
                    $commentType = '//';
                    $i++;
                    continue;
                }
            } else if ($str[$i] == '"') {
                $quoteCount++;
            }
            $result .= $char;
        }
    }
    $result = str_replace("\\\0", '\"', $result);
    $result = str_replace("\n\n", "\n", $result);
    return $result;
}

function json_space_clear($str)
{
    $result = '';
    $quoteCount = 0;
    $str = str_replace(array('\"', "\r"), array("\\\0", "\n"), $str);
    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];
        //忽略不在字符串中的空格 tab 和换行
        if ($quoteCount % 2 == 0 &&
            ($char == ' ' || $char == '	' || $char == "\n")) {
            continue;
        }
        if ($char == '"') {
            $quoteCount++;
        }
        $result .= $char;
    }
    $result = str_replace("\\\0", '\"', $result);
    return $result;
}

function json_decode_force($str)
{
    $str = json_comment_clear($str);
    $str = json_space_clear($str);
    //允许最后一个多余逗号(todo:字符串内)
    $str = str_replace(array(',}', ',]', "\n", "\t"), array('}', ']', '', ' '), $str);
    $result = json_decode($str, true);
    if (!$result) {
    }
    return $result;
}

function json_encode_force($json)
{
    if (defined('JSON_PRETTY_PRINT')) {
        $jsonStr = json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        $jsonStr = json_encode($json);
    }
    if ($jsonStr === false) {
        $jsonStr = __json_encode($json);
    }
    return $jsonStr;
}

if (!function_exists('json_encode')) {
    function json_encode($data)
    {
        __json_encode($data);
    }
}
function __json_encode($data)
{
    if (is_array($data) || is_object($data)) {
        $islist = is_array($data) && (empty($data) || array_keys($data) === range(0, count($data) - 1));
        if ($islist) {
            $json = '[' . implode(',', array_map('__json_encode', $data)) . ']';
        } else {
            $items = Array();
            foreach ($data as $key => $value) {
                $items[] = __json_encode("$key") . ':' . __json_encode($value);
            }
            $json = '{' . implode(',', $items) . '}';
        }
    } else if (is_string($data)) {
        $string = addcslashes($data, "\\\"\n\r\t/" . chr(8) . chr(12));
        $json = '';
        $len = strlen($string);
        # Convert UTF-8 to Hexadecimal Codepoints.
        for ($i = 0; $i < $len; $i++) {
            $char = $string[$i];
            $c1 = ord($char);

            # Single byte;
            if ($c1 < 128) {
                $json .= ($c1 > 31) ? $char : sprintf("\\u%04x", $c1);
                continue;
            }

            # Double byte
            $c2 = ord($string[++$i]);
            if (($c1 & 32) === 0) {
                $json .= sprintf("\\u%04x", ($c1 - 192) * 64 + $c2 - 128);
                continue;
            }

            # Triple
            $c3 = ord($string[++$i]);
            if (($c1 & 16) === 0) {
                $json .= sprintf("\\u%04x", (($c1 - 224) << 12) + (($c2 - 128) << 6) + ($c3 - 128));
                continue;
            }

            # Quadruple
            $c4 = ord($string[++$i]);
            if (($c1 & 8) === 0) {
                $u = (($c1 & 15) << 2) + (($c2 >> 4) & 3) - 1;
                $w1 = (54 << 10) + ($u << 6) + (($c2 & 15) << 2) + (($c3 >> 4) & 3);
                $w2 = (55 << 10) + (($c3 & 15) << 6) + ($c4 - 128);
                $json .= sprintf("\\u%04x\\u%04x", $w1, $w2);
            }
        }
        $json = '"' . addcslashes($data, "\"") . '"';
    } else {
        $json = strtolower(var_export($data, true));
    }
    return $json;
}

/**
 * 将字符串变成了数组，有可能本身就是 数组了
 * Enter description here ...
 * @param unknown_type $ids
 */
function getIdsArray($ids,$chart = '|')
{
    if (is_array($ids)) {
        return $ids;
    }
    $idlists = rtrim($ids, $chart);
    $array = explode($chart, $idlists);
    return $array;
}

/**
 * 根据选项序列获取对应字母
 * @param int $number
 *
 * @return int|string
 *
 * @auther higanbana
 * @date   2018/12/13 11:25
 */
function numeber_to_letter($number = 0)
{
    $number = (int)$number;
    $number = ($number < 0) ? 0 : $number;
    $letter = range('A', 'Z');
    if ($number < 26) {
        $string = $letter[$number];
    } elseif ($number < 702) {
        $remainder = $number % 26;
        $number = floor($number / 26);
        $string = $letter[$number - 1] . $letter[$remainder];
    } else {
        $string = $number;
    }
    return $string;
}


// 过滤掉emoji表情
function filter_Emoji($str)
{
    $str = preg_replace_callback(
        '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '【表情】' : $match[0];
        },
        $str);

    return $str;
}


/**
 * 去除两字符串之间的内容
 * @param $content  内容
 * @param $text1    第一个字符串
 * @param $text2    第二个字符串
 * @return string   去除内容之后的字符串
 */
function removeIntermediateContent($content, $text1, $text2)
{
    //第一个字符串出现的位置
    $position1 = strpos($content, $text1);
    //第二个字符串出现的位置，要从第一个字符串出现的位置后面开始查
    $position2 = strpos($content, $text2, $position1 + strlen($text1));

    //只要有一个字符串未出现过，则返回
    if ($position1 == false || $position2 == false) {
        return $content;
    }

    $content1 = $content2 = '';
    //如果第一个字符串不是出现在开头，则截取开头到第一个字符串出现的位置的长度
    if ($position1 != 0) {
        $content1 = substr($content, 0, $position1);
    }

    //截取第二个字符串出现的位置之后的所有字符串
    $content2 = substr($content, $position2 + strlen($text2));

    //拼接截取的两个字符串
    $content = $content1 . $content2;

    //检测只要有一个字符串不存在于内容中，则返回截取后的内容（不能使用位置2大于位置1的判定，有可能会剔除不干净）
    $position1 = strpos($content, $text1);
    if (is_numeric($position1)) {
        $position2 = strpos($content, $text2, $position1 + strlen($text1));
        if (is_numeric($position2)) {
            $content = removeIntermediateContent($content, $text1, $text2);
        }
    }
    return $content;
}

/**
 * 识别换行符并替换为指定字符
 * @param        $content
 * @param string $str       替换为目标字符
 *
 * @return mixed
 *
 * @auther higanbana
 * @date   2020/1/18 17:29
 */
function brmarkReplace($content,$str='<br/>')
{
    $order=["\r\n","\n","\r"];
    return str_replace($order,$str,$content);
}