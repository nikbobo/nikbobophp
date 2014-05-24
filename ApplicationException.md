ApplicationException 类错误代码信息一览表
===================================

| 错误代码 | 错误信息 | 所属类方法（函数） |
| :-----: | :------ | :--------------- |
| 101     | Class not register（类未在自动类装载器中注册） | `Autoloader::load` `Autoloader::unRegister` |
| 102     | Class file isn't readable（类文件不可读） | `Autoloader::load` |
| 103     | Class already registered（类已经在自动类装载器中注册，如需替换自动类装载器中的类，请使用 `Autoloader::replace`） | `Autoloader::register` |
| 104     | Path isn't a valid path（不是有效的路径） | `Application::setErrorLog` `Router::setControllerClassDir` |
| 105     | Router rule already exists（路由规则已存在，如需替换此路由规则，请使用 `Router::replace`） | `Router::add` |
| 106     | Controller path is not set（控制器路径未设置） | `Router::add` `Router::replace` |
| 107     | Autoloader class is not set（`Autoloader` 类未配置） | `Router::add` `Router::replace` |
| 108     | Unknown http status code（未知 HTTP 状态码） | `Respond::setStatusCode` |