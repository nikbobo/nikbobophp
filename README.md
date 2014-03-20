Nikbobo PHP Framework
==============================
缘起
------------------------------
想自己用 PHP 开发点东西，为了赶上时髦，必须使用最流行的 MVC 设计架构。

面向对象的 PHP 框架让我感到较为不爽，于是找到了 LazyPHP 这款可以面向过程的轻 PHP 框架。

但是，LazyPHP 由几点让我感到不爽：

1. 参数式路由，对 SEO 不友好；
2. 数据库查询没有使用我喜欢的 PDO MySQL Prepare 方式。

所以决定自己写一个 PHP 框架，于是 Nikbobo PHP Framework 就诞生了。

简介
------------------------------
Nikbobo PHP Framework 是一个轻框架。

Nikbobo PHP Framework 采用函数式接口封装对象，对内通过面向对象实现代码重用，对外则提供简明扼要的操作函数。开发者甚至不用理解面向对象就能很好的使用，这让一些初级程序员很容易就开发出强壮的应用。

Nikbobo PHP Framework 采用 PDO MySQL Prepare 方式操作数据库，妈妈再也不用担心 SQL 注入的问题了。

Nikbobo PHP Framework 一开始就不支持标准“查询字符串”的方法，而是使用基于段的 URL 路由。

Nikbobo PHP Framework 代码中具有丰富的注释，如果你有一个好的 IDE，甚至你不用看文档，使用 IDE 自带的 PHPDoc，效率比慢慢翻文档高 N 倍。

Nikbobo PHP Framework 还有许许多多优秀之处，欢迎您体验。
