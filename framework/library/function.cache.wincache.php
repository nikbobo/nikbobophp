<?php
/**
 * Project: Nikbobo PHP Framework
 * File: function.cache.wincache.php
 * User: nikbobo
 * Date: 2014-03-20
 * Time: 20:51
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * WinCache 缓存函数
 */

/**
 * 从缓存中读取数据
 *
 * @param string $sKey 对象的键（Key）
 *
 * @return mixed
 */
function np_cache_get($sKey) {
    return wincache_ucache_get($sKey);
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
    return wincache_ucache_set($sKey, $mValue, $iExpire);
}

/**
 * 从缓存中删除数据
 *
 * @param string $sKey 对象的键（Key）
 *
 * @return bool
 */
function np_cache_delete($sKey) {
    return wincache_ucache_delete($sKey);
}

/**
 * 清空缓存
 *
 * @return bool
 */
function np_cache_flush() {
    return wincache_ucache_clear();
}