<?php
/**
 * Project: Nikbobo PHP Framework
 * File: function.db.pdo.mysql.php
 * User: nikbobo
 * Date: 2014-03-19
 * Time: 18:38
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * PDO MySQL 数据库函数
 */
/**
 * 使用配置文件中的参数连接 MySQL 主库
 *
 * @return PDO 返回一个 PDO 对象
 */
function np_mysql_connect_master() {
    try {
        $oPdo = new PDO('mysql:host=' . NP_MYSQL_DB_HOST_MASTER . ';port=' . NP_MYSQL_DB_PORT . ';dbname=' . NP_MYSQL_DB_NAME, NP_MYSQL_DB_USER, NP_MYSQL_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . NP_MYSQL_DB_CHARSET));
        $oPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $oPdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        return $oPdo;
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_WARNING);
        exit('Can\'t Connect Database');
    }
}

/**
 * 使用配置文件中的参数连接 MySQL 从库
 * 如检测不到从库（注释语句），则不使用读写分离，自动连接 MySQL 主库
 *
 * @return PDO 返回一个 PDO 对象
 */
function np_mysql_connect_slave() {
    try {
        defined('NP_MYSQL_DB_HOST_SLAVE') ? $oPdo = new PDO('mysql:host=' . NP_MYSQL_DB_HOST_SLAVE . ';port=' . NP_MYSQL_DB_PORT . ';dbname=' . NP_MYSQL_DB_NAME, NP_MYSQL_DB_USER, NP_MYSQL_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . NP_MYSQL_DB_CHARSET)) : $oPdo = new PDO('mysql:host=' . NP_MYSQL_DB_HOST_MASTER . ';port=' . NP_MYSQL_DB_PORT . ';dbname=' . NP_MYSQL_DB_NAME, NP_MYSQL_DB_USER, NP_MYSQL_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . NP_MYSQL_DB_CHARSET));
        $oPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $oPdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        return $oPdo;
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_WARNING);
        exit('Can\'t Connect Database');
    }
}

/**
 * 获取数据表名称，自动包含反单引号（`）
 *
 * @param string $sTable 数据表名称
 *
 * @return string 数据表名称，自动包含反单引号（`）
 */
function np_mysql_get_table_name($sTable) {
    return defined('NP_MYSQL_DB_PREFIX') ? '`' . NP_MYSQL_DB_PREFIX . $sTable . '`' : '`' . $sTable . '`';
}

/**
 * 安全地查询数据库取得数据，以二维数组返回
 *
 * 示例：
 * np_mysql_safe_get_data('SELECT * FROM ' . np_mysql_get_table_name('user') . ' WHERE `username` = :username AND `id` = :id LIMIT 1', array(':id' => array('Type' => 'int', 'Vaule' => intval(1))));
 *
 * @param string      $sSql       PDO Prepare 风格的 SQL 语句
 * @param array       $aParameter 包含参数绑定的数组，详见示例
 * @param null|object $oPdo       PDO 对象（可选，不指定则自动连接）
 *
 * @return array|bool 返回查询到的数据，或返回假（false）
 */
function np_mysql_safe_get_data($sSql, array $aParameter = array(), $oPdo = null) {
    $oPdo == null and $oPdo = np_mysql_connect_slave();
    $aData = array();
    $i = 0;
    try {
        $oStatement = $oPdo->prepare($sSql);
        foreach ($aParameter as $sKey => $aValue) {
            $sParameter = $sKey;
            $sValue = $aValue['Value'];
            switch ($aValue['Type']) {
                case 'str':
                    $iDataType = PDO::PARAM_STR;
                    break;
                case 'int':
                    $iDataType = PDO::PARAM_INT;
                    break;
                case 'bool':
                    $iDataType = PDO::PARAM_BOOL;
                    break;
                default:
                    $iDataType = PDO::PARAM_STR;
            }
            $oStatement->bindValue($sParameter, $sValue, $iDataType);
        }
        $oStatement->execute();
        while ($aFetch = $oStatement->fetchAll(PDO::FETCH_ASSOC)) {
            $aData[$i++] = $aFetch;
        }
        $oStatement->closeCursor();
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_NOTICE);
        return false;
    }
    return count($aData) > 0 ? $aData : false;
}

/**
 * 安全地查询数据库取得数据，以一维数组返回
 *
 * 示例请参考 np_mysql_safe_get_data()
 *
 * @param string      $sSql       PDO Prepare 风格的 SQL 语句
 * @param array       $aParameter 包含参数绑定的数组，详见示例
 * @param null|object $oPdo       PDO 对象（可选，不指定则自动连接）
 *
 * @return array|bool 返回查询到的数据，或返回假（false）
 */
function np_mysql_safe_get_line($sSql, array $aParameter = array(), $oPdo = null) {
    $abData = np_mysql_safe_get_data($sSql, $aParameter, $oPdo);
    return is_array($abData) ? reset($abData) : false;
}

/**
 * 安全地查询数据库取得数据，以变量的方式返回一个数值
 *
 * 示例请参考 np_mysql_safe_get_data()
 *
 * @param string      $sSql       PDO Prepare 风格的 SQL 语句
 * @param array       $aParameter 包含参数绑定的数组，详见示例
 * @param null|object $oPdo       PDO 对象（可选，不指定则自动连接）
 *
 * @return string|bool 返回查询到的数据，或返回假（false）
 */
function np_mysql_safe_get_var($sSql, array $aParameter = array(), $oPdo = null) {
    $abData = np_mysql_safe_get_data($sSql, $aParameter, $oPdo);
    return is_array($abData) ? $abData[reset(array_keys($abData))] : false;
}

/**
 * 安全地执行 SQL 语句
 *
 * 示例请参考 np_mysql_safe_get_data()
 *
 * @param string      $sSql       PDO Prepare 风格的 SQL 语句
 * @param array       $aParameter 包含参数绑定的数组，详见示例
 * @param null|object $oPdo       PDO 对象（可选，不指定则自动连接）
 *
 * @return bool 成功返回真（true），失败返回假（false）
 */
function np_mysql_safe_run($sSql, array $aParameter = array(), $oPdo = null) {
    $oPdo == null and $oPdo = np_mysql_connect_master();
    try {
        $oStatement = $oPdo->prepare($sSql);
        foreach ($aParameter as $sKey => $aValue) {
            $sParameter = $sKey;
            $sValue = $aValue['Value'];
            switch ($aValue['Type']) {
                case 'str':
                    $iDataType = PDO::PARAM_STR;
                    break;
                case 'int':
                    $iDataType = PDO::PARAM_INT;
                    break;
                case 'bool':
                    $iDataType = PDO::PARAM_BOOL;
                    break;
                default:
                    $iDataType = PDO::PARAM_STR;
            }
            $oStatement->bindValue($sParameter, $sValue, $iDataType);
        }
        $bResult = $oStatement->execute();
        $oStatement->closeCursor();
        return $bResult;
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_NOTICE);
        return false;
    }
}

/**
 * 查询数据库取得数据，以二维数组返回
 *
 * 建议在此执行不接受用户输入的“安全”的 SQL 语句
 * 不安全的 SQL 语句使用 np_mysql_safe_get_data() 查询
 *
 * @param string      $sSql PDO Prepare 风格的 SQL 语句
 * @param null|object $oPdo PDO 对象（可选，不指定则自动连接）
 *
 * @return array|bool 返回查询到的数据，或返回假（false）
 */
function np_mysql_get_data($sSql, $oPdo = null) {
    $oPdo == null and $oPdo = np_mysql_connect_slave();
    $aData = array();
    $i = 0;
    try {
        $oStatement = $oPdo->query($sSql);
        while ($aFetch = $oStatement->fetchAll(PDO::FETCH_ASSOC)) {
            $aData[$i++] = $aFetch;
        }
        $oStatement->closeCursor();
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_NOTICE);
        return false;
    }
    return count($aData) > 0 ? $aData : false;
}

/**
 * 查询数据库取得数据，以一维数组返回
 *
 * 建议在此执行不接受用户输入的“安全”的 SQL 语句
 * 不安全的 SQL 语句使用 np_mysql_safe_get_line() 查询
 *
 * @param string      $sSql SQL 语句
 * @param null|object $oPdo PDO 对象（可选，不指定则自动连接）
 *
 * @return array|bool 返回查询到的数据，或返回假（false）
 */
function np_mysql_get_line($sSql, $oPdo = null) {
    $abData = np_mysql_get_data($sSql, $oPdo);
    return is_array($abData) ? reset($abData) : false;
}

/**
 * 查询数据库取得数据，以变量的方式返回一个数值
 *
 * 建议在此执行不接受用户输入的“安全”的 SQL 语句
 * 不安全的 SQL 语句使用 np_mysql_safe_get_var() 查询
 *
 * @param string      $sSql SQL 语句
 * @param null|object $oPdo PDO 对象（可选，不指定则自动连接）
 *
 * @return string|bool 返回查询到的数据，或返回假（false）
 */
function np_mysql_get_var($sSql, $oPdo = null) {
    $abData = np_mysql_get_data($sSql, $oPdo);
    return is_array($abData) ? $abData[reset(array_keys($abData))] : false;
}

/**
 * 安全地执行 SQL 语句
 *
 * 建议在此执行不接受用户输入的“安全”的 SQL 语句
 * 不安全的 SQL 语句使用 np_mysql_safe_run() 执行
 *
 * @param string      $sSql SQL 语句
 * @param null|object $oPdo PDO 对象（可选，不指定则自动连接）
 *
 * @return bool 成功返回真（true），失败返回假（false）
 */
function np_mysql_run($sSql, $oPdo = null) {
    $oPdo == null and $oPdo = np_mysql_connect_master();
    try {
        $bResult = $oPdo->query($sSql);
        $bResult->closeCursor();
        return $bResult;
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_NOTICE);
        return false;
    }
}