ApplicationException 类错误代码信息一览表
===================================

| 错误代码 | 错误信息 | 所属类方法（函数） |
| :-----: | :------ | :--------------- |
| 101     | Class not register（类未在自动类装载器中注册） | `Autoloader::loadClass` `Autoloader::deleteClass` |
| 102     | Class file isn't readable（类文件不可读） | `Autoloader::loadClass` |
| 103     | Class already register（类已经在自动类装载器中注册，如需替换自动类装载器中的类，请使用 `Autoloader::replaceClass`） | `Autoloader::addClass` |