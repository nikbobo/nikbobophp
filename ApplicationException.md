ApplicationException 类错误代码信息一览表
===================================

| 错误代码 | 错误信息 | 所属类方法（函数） |
| :-----: | :------ | :--------------- |
| 101     | Class not register（类未在自动类装载器中注册） | `Autoloader::load` `Autoloader::unRegister` |
| 102     | Class file isn't readable（类文件不可读） | `Autoloader::load` |
| 103     | Class already register（类已经在自动类装载器中注册，如需替换自动类装载器中的类，请使用 `Autoloader::replace`） | `Autoloader::register` |
| 104     | Error log file path（错误的错误日志文件路径） | `Application::setErrorLog`