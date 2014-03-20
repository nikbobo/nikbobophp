<?php
/**
 * Project: Nikbobo PHP Framework
 * File: 404.tpl.php
 * User: nikbobo
 * Date: 2014-03-20
 * Time: 21:37
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * 系统 404 页面模板
 */
?>
<!DOCTYPE html>
<!-- IE bug fix: always pad the error page with enough characters such that it is greater than 512 bytes, even after gzip compression abcdefghijklmnopqrstuvwxyz1234567890aabbccddeeffgghhiijjkkllmmnnooppqqrrssttuuvvwwxxyyzz11223344556677889900abacbcbdcdcededfefegfgfhghgihihjijikjkjlklkmlmlnmnmononpopoqpqprqrqsrsrtstsubcbcdcdedefefgfabcadefbghicjkldmnoepqrfstugvwxhyz1i234j567k890laabmbccnddeoeffpgghqhiirjjksklltmmnunoovppqwqrrxsstytuuzvvw0wxx1yyz2z113223434455666777889890091abc2def3ghi4jkl5mno6pqr7stu8vwx9yz11aab2bcc3dd4ee5ff6gg7hh8ii9j0jk1kl2lmm3nnoo4p5pq6qrr7ss8tt9uuvv0wwx1x2yyzz13aba4cbcb5dcdc6dedfef8egf9gfh0ghg1ihi2hji3jik4jkj5lkl6kml7mln8mnm9ono-->
<html lang="zh-CN">
<head>
<meta charset="<?php echo SITE_CHARSET; ?>">
<title>404 Not Found - <?php echo SITE_NAME; ?></title>
<style>
    html {
        background : #4786B3;
    }

    body {
        margin           : 0;
        padding          : 60px;
        font             : 14px/18px Arial, Helvetica, sans-serif;
        color            : #FFFFFF;
        background-color : transparent;
    }

    h1, p {
        text-align : center;
    }

    h1 {
        margin      : 30px 0 0;
        font        : bold 40px/40px Arial, Helvetica, sans-serif;
        text-shadow : 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    p {
        margin : 10px 0 20px;
        font   : 300 18px/25px Arial, Helvetica, sans-serif;
        color  : #E0EFF6;
    }
</style>
</head>
<body>
<h1>找不到该页</h1>

<p>您正在访问的网址 —— <strong><?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></strong> 不存在与此服务器。</p>
</body>
</html>