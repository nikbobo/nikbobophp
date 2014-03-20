<?php
/**
 * Project: Nikbobo PHP Framework
 * File: config.php
 * User: nikbobo
 * Date: 14-3-16
 * Time: 下午8:35
 */
/**
 * 配置文件
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * 基本配置
 */
/**
 * 以下配置必须存在且正确，否则会导致不可意料的结果
 */
/**
 * 站点名称
 */
define('SITE_NAME', 'Nikbobo PHP Framework');
/**
 * 站点 URL
 */
define('BASE_URL', 'http://php.nikbobo.net');
/**
 * 网站字符编码
 *
 * 主要用于 HTTP 头部信息发送
 */
define('SITE_CHARSET', 'UTF-8');
/**
 * 路由配置文件
 */
define('NP_ROUTER_CONFIG_FILE', NP_APP_DIR . '/router.php');
/**
 * 默认前端控制器（FrontController）
 */
define('NP_DEFAULT_CONTROLLER', 'Default');
/**
 * 默认前端行为（FrontAction）
 */
define('NP_DEFAULT_ACTION', 'Index');
/**
 * 使用默认路由
 *
 * 开启此选项，当在路由表匹配不到时，会使用默认规则分配
 * 默认规则：http://www.domain.com/controller/action/parameter1/.../parameter(n)
 */
define('NP_ROUTER_DEFAULT', true);
/**
 * 开启 Session
 */
define('NP_SESSION_AUTO_START', true);
/**
 * 时区
 */
define('NP_TIMEZONE', 'Asia/Shanghai');
/**
 * 以上配置必须存在且正确，否则会导致不可意料的结果
 */
/**
 * 数据库配置
 */
/**
 * 使用数据库
 */
define('NP_USE_DATABASE', true);
/**
 * 使用的数据库类型，根据此调用相应数据库函数
 *
 * 由于涉嫌文件处理，请确认参数为小写字母
 * 不小写也无所谓，会自动转换
 * 系统自带 pdo.mysql
 */
define('NP_DATABASE_TYPE', 'pdo.mysql');
/**
 * 以下是 MySQL 专属常量
 */
/**
 * MySQL 数据库名称
 *
 * 无缝迁移 SAE，迁移无需改配置，自动支持
 */
defined('SAE_APPNAME') ? define('NP_MYSQL_DB_NAME', SAE_MYSQL_DB) : define('NP_MYSQL_DB_NAME', 'database_name_here');
/**
 * MySQL 数据库用户名
 *
 * 无缝迁移 SAE，迁移无需改配置，自动支持
 */
defined('SAE_APPNAME') ? define('NP_MYSQL_DB_USER', SAE_MYSQL_USER) : define('NP_MYSQL_DB_USER', 'username_here');
/**
 * MySQL 数据库密码
 *
 * 无缝迁移 SAE，迁移无需改配置，自动支持
 */
defined('SAE_APPNAME') ? define('NP_MYSQL_DB_PASSWORD', SAE_MYSQL_PASS) : define('NP_MYSQL_DB_PASSWORD', 'password_here');
/**
 * MySQL 主数据库地址
 *
 * 主要用于 MySQL 主从复制和读写分离，主库一般用于写（Write）操作
 * 如果不懂相关概念，就直接当成数据库地址并注释下面的从库常量即可
 * 无缝迁移 SAE，迁移无需改配置，自动支持
 */
defined('SAE_APPNAME') ? define('NP_MYSQL_DB_HOST_MASTER', SAE_MYSQL_HOST_M) : define('NP_MYSQL_DB_HOST_MASTER', 'localhost');
/**
 * MySQL 从数据库地址
 *
 * 主要用于 MySQL 主从复制和读写分离，从库一般用于读（Read）操作
 * 如需禁用读写分离，注释此常量即可
 * 无缝迁移 SAE，迁移无需改配置，自动支持
 */
defined('SAE_APPNAME') ? define('NP_MYSQL_DB_HOST_SLAVE', SAE_MYSQL_HOST_S) : define('NP_MYSQL_DB_HOST_SLAVE', 'localhost');
/**
 * MySQL 数据库端口
 *
 * 如果不懂相关概念，就直接保持默认即可
 * 无缝迁移 SAE，迁移无需改配置，自动支持
 */
defined('SAE_APPNAME') ? define('NP_MYSQL_DB_PORT', SAE_MYSQL_PORT) : define('NP_MYSQL_DB_PORT', 3306);
/**
 * MySQL 数据库字符编码
 */
define('NP_MYSQL_DB_CHARSET', 'utf8');
/**
 * 以上是 MySQL 专属常量
 */