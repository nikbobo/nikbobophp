<?php
/**
 * Project: Nikbobo PHP Framework
 * File: function.cache.memcache.php
 * User: nikbobo
 * Date: 2014-03-20
 * Time: 20:34
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * memcache 缓存函数
 */
/**
 * 初始化 memcache
 *
 * @return Memcache 返回 memcache 对象
 */
function np_memcache_init() {
    if (function_exists('memcache_init')) {
        return memcache_init();
    } else {
        $oMemcache = new Memcache();
        $oMemcache->addserver('localhost', 11211);
        return $oMemcache;
    }
}

/**
 * 从缓存中读取数据
 *
 * @param string $sKey 对象的键（Key）
 *
 * @return mixed
 */
function np_cache_get($sKey) {
    return np_memcache_init()->get($sKey);
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
    return np_memcache_init()->set($sKey, $mValue, 0, $iExpire);
}

/**
 * 从缓存中删除数据
 *
 * @param string $sKey 对象的键（Key）
 *
 * @return bool
 */
function np_cache_delete($sKey) {
    return np_memcache_init()->delete($sKey);
}

/**
 * 清空缓存
 *
 * @return bool
 */
function np_cache_flush() {
    return np_memcache_init()->flush();
}