<?php

use Addons\Qiniu\Expand\Config;

if (!defined('QINIU_FUNCTIONS_VERSION')) {
    define('QINIU_FUNCTIONS_VERSION', Config::SDK_VER);

    /**
     * 计算文件的crc32检验码:
     *
     * @param $file string  待计算校验码的文件路径
     *
     * @return string 文件内容的crc32校验码
     */
    function crc32_file($file)
    {
        $hash = hash_file('crc32b', $file);
        $array = unpack('N', pack('H*', $hash));
        return sprintf('%u', $array[1]);
    }

    /**
     * 计算输入流的crc32检验码
     *
     * @param $data 待计算校验码的字符串
     *
     * @return string 输入字符串的crc32校验码
     */
    function crc32_data($data)
    {
        $hash = hash('crc32b', $data);
        $array = unpack('N', pack('H*', $hash));
        return sprintf('%u', $array[1]);
    }

    /**
     * 对提供的数据进行urlsafe的base64编码。
     *
     * @param string $data 待编码的数据，一般为字符串
     *
     * @return string 编码后的字符串
     * @link http://developer.qiniu.com/docs/v6/api/overview/appendix.html#urlsafe-base64
     */
    function base64_urlSafeEncode($data)
    {
        $find = array('+', '/');
        $replace = array('-', '_');
        return str_replace($find, $replace, base64_encode($data));
    }

    /**
     * 对提供的urlsafe的base64编码的数据进行解码
     *
     * @param string $str 待解码的数据，一般为字符串
     *
     * @return string 解码后的字符串
     */
    function base64_urlSafeDecode($str)
    {
        $find = array('-', '_');
        $replace = array('+', '/');
        return base64_decode(str_replace($find, $replace, $str));
    }

    /**
     * 二维数组根据某个字段排序
     * @param array $array 要排序的数组
     * @param string $key 要排序的键
     * @param string $sort 排序类型 SORT_ASC SORT_DESC
     * return array 排序后的数组
     */
    function arraySort($array, $key, $sort = SORT_ASC)
    {
        $keysValue = array();
        foreach ($array as $k => $v) {
            $keysValue[$k] = $v[$key];
        }
        array_multisort($keysValue, $sort, $array);
        return $array;
    }

    /**
     * 计算七牛API中的数据格式
     *
     * @param string $bucket 待操作的空间名
     * @param string $key 待操作的文件名
     *
     * @return string  符合七牛API规格的数据格式
     * @link http://developer.qiniu.com/docs/v6/api/reference/data-formats.html
     */
    function entry($bucket, $key)
    {
        $en = $bucket;
        if (!empty($key)) {
            $en = $bucket . ':' . $key;
        }
        return base64_urlSafeEncode($en);
    }

    /**
     * array 辅助方法，无值时不set
     *
     * @param array $array 待操作array
     * @param string $key key
     * @param string $value value 为null时 不设置
     *
     * @return array 原来的array，便于连续操作
     */
    function setWithoutEmpty(&$array, $key, $value)
    {
        if (!empty($value)) {
            $array[$key] = $value;
        }
        return $array;
    }

    /**
     * 缩略图链接拼接
     *
     * @param string $url 图片链接
     * @param int $mode 缩略模式
     * @param int $width 宽度
     * @param int $height 长度
     * @param string $format 输出类型
     * @param int $quality 图片质量
     * @param int $interlace 是否支持渐进显示
     * @param int $ignoreError 忽略结果
     * @return string
     * @link http://developer.qiniu.com/code/v6/api/kodo-api/image/imageview2.html
     * @author Sherlock Ren <sherlock_ren@icloud.com>
     */
    function thumbnail(
        $url,
        $mode,
        $width,
        $height,
        $format = null,
        $quality = null,
        $interlace = null,
        $ignoreError = 1
    )
    {

        static $imageUrlBuilder = null;
        if (is_null($imageUrlBuilder)) {
            $imageUrlBuilder = new Processing\ImageUrlBuilder;
        }

        return call_user_func_array(array($imageUrlBuilder, 'thumbnail'), func_get_args());
    }

    /**
     * 图片水印
     *
     * @param string $url 图片链接
     * @param string $image 水印图片链接
     * @param numeric $dissolve 透明度
     * @param string $gravity 水印位置
     * @param numeric $dx 横轴边距
     * @param numeric $dy 纵轴边距
     * @param numeric $watermarkScale 自适应原图的短边比例
     * @return string
     * @link   http://developer.qiniu.com/code/v6/api/kodo-api/image/watermark.html
     * @author Sherlock Ren <sherlock_ren@icloud.com>
     */
    function waterImg(
        $url,
        $image,
        $dissolve = 100,
        $gravity = 'SouthEast',
        $dx = null,
        $dy = null,
        $watermarkScale = null
    )
    {

        static $imageUrlBuilder = null;
        if (is_null($imageUrlBuilder)) {
            $imageUrlBuilder = new Processing\ImageUrlBuilder;
        }

        return call_user_func_array(array($imageUrlBuilder, 'waterImg'), func_get_args());
    }

    /**
     * 文字水印
     *
     * @param string $url 图片链接
     * @param string $text 文字
     * @param string $font 文字字体
     * @param string $fontSize 文字字号
     * @param string $fontColor 文字颜色
     * @param numeric $dissolve 透明度
     * @param string $gravity 水印位置
     * @param numeric $dx 横轴边距
     * @param numeric $dy 纵轴边距
     * @return string
     * @link   http://developer.qiniu.com/code/v6/api/kodo-api/image/watermark.html#text-watermark
     * @author Sherlock Ren <sherlock_ren@icloud.com>
     */
    function waterText(
        $url,
        $text,
        $font = '黑体',
        $fontSize = 0,
        $fontColor = null,
        $dissolve = 100,
        $gravity = 'SouthEast',
        $dx = null,
        $dy = null
    )
    {

        static $imageUrlBuilder = null;
        if (is_null($imageUrlBuilder)) {
            $imageUrlBuilder = new Processing\ImageUrlBuilder;
        }

        return call_user_func_array(array($imageUrlBuilder, 'waterText'), func_get_args());
    }

    /**
     *  从uptoken解析accessKey和bucket
     *
     * @param $upToken
     * @return array(ak,bucket,err=null)
     */
    function explodeUpToken($upToken)
    {
        $items = explode(':', $upToken);
        if (count($items) != 3) {
            return array(null, null, "invalid uptoken");
        }
        $accessKey = $items[0];
        $putPolicy = json_decode(base64_urlSafeDecode($items[2]));
        $scope = $putPolicy->scope;
        $scopeItems = explode(':', $scope);
        $bucket = $scopeItems[0];
        return array($accessKey, $bucket, null);
    }
}
