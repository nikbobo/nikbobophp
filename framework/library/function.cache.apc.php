<?php
/**
 * Project: Nikbobo PHP Framework
 * File: function.cache.apc.php
 * User: nikbobo
 * Date: 2014-03-20
 * Time: 21:03
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * APC 缓存函数
 */
/**
 * 从缓存中读取数据
 *
 * @param string $sKey 对象的键（Key）
 *
 * @return mixed
 */
function np_cache_get($sKey) {
    return apc_fetch($sKey);
}

/**
 * 把数据写入缓存
 *
 * @param string $sKey    对象的键（Key）
 * @param mixed  $mValue  对象的值（Value）
 * @param int    $iExpire 过期时间，以秒（Second）为单位
 *
 * @return bool
 */
function np_cache_set($sKey, $mValue, $iExpire) {
    return apc_store($sKey, $mValue, $iExpire);
}

/**
 * 从缓存中删除数据
 *
 * @param string $sKey 对象的键（Key）
 *
 * @return bool
 */
function np_cache_delete($sKey) {
    return apc_delete($sKey);
}

/**
 * 清空缓存
 *
 * @return bool
 */
function np_cache_flush() {
    return apc_clear_cache('user');
}