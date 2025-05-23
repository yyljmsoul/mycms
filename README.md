
![MyCms-logo](public/mycms/common/images/logo-2.png)


[![Php Version](https://img.shields.io/badge/php-%3E=7.3.0-brightgreen.svg?maxAge=2592000&color=yellow)](https://github.com/php/php-src)
[![Mysql Version](https://img.shields.io/badge/mysql-%3E=5.6-brightgreen.svg?maxAge=2592000&color=orange)](https://www.mysql.com/)
[![Laravel Version](https://img.shields.io/badge/laravel-%3E=8.5-brightgreen.svg?maxAge=2592000)](https://github.com/laravel/laravel)
[![Layui Version](https://img.shields.io/badge/layui-=2.5.5-brightgreen.svg?maxAge=2592000&color=critical)](https://github.com/sentsin/layui)
[![Layuimini Version](https://img.shields.io/badge/layuimini-%3E=2.0.4.2-brightgreen.svg?maxAge=2592000&color=ff69b4)](https://github.com/zhongshaofa/layuimini)
[![MyCms Doc](https://img.shields.io/badge/docs-passing-green.svg?maxAge=2592000)](https://www.mycms.net.cn/wendang)
[![MyCms License](https://img.shields.io/badge/license-Apache2.0-green?maxAge=2592000&color=blue)](https://gitee.com/qq386654667/mycms/blob/master/LICENSE)

## 项目介绍

MyCms是一款基于Laravel开发的开源免费的自媒体博客CMS系统，适用于个人自媒体及企业商城开发使用。同时亦可兼容微擎系统开发应用使用。

MyCms基于Apache2.0开源协议发布，**免费且可商业使用**`(需保留前后台版权标识)`，欢迎持续关注我们。


技术交流QQ群：[887522124](https://qm.qq.com/cgi-bin/qm/qr?k=y3Q3pCWJdIRtCzdLMGdqMv3Jx04bib8D&jump_from=webapi) `加群请备注来源：如gitee、github、官网等`。

## 站点地址

* [官方网站](https://www.mycms.net.cn/)
* [使用手册](https://www.mycms.net.cn/shouce)
* [API文档](https://www.mycms.net.cn/api-doc)
* [二次开发](https://www.mycms.net.cn/dev)
* [源码下载](https://gitee.com/qq386654667/mycms)
* [模板下载](https://www.mycms.net.cn/muban)
* [活码二维码](https://www.mycms.net.cn/huoma)
* [演示前台](https://www.mycms.net.cn/) / [演示后台](https://demo.mycms.net.cn/system/login)
* 演示后台：admin / admin

## 优秀案例

* [在线计算网](https://www.zaixianjisuan.com/)
* [程序员导航](https://nav.mycms.net.cn/)
* [编程宝典](https://www.bianchengbaodian.com/)
* [火马活码](https://www.huomahuoma.com)
* [商城小程序](https://www.mycms.net.cn/goods/9)

    
## 系统特性
* 支持多语言
* 简易安装程序
* 快速CURD操作
* 对接微信公众号
* 支持Swoole加速
* 后台一键升级更新
* 简洁优雅、灵活可扩展
* 完善的插件安装/卸载机制
* 对SEO优化友好的URL模式
* 公共函数埋点更好拓展系统
* 更具拓展性的路由监听功能
* 更优雅、符合SEO优化的分页
* 基础缓存功能及数据库索引建立
* 简单易用的模板函数、制作模板更方便

## 快速安装
1. 下载源码 / 上传源码到服务器
2. 将网站运行目录设置为 `/public`
3. 访问 `http://xxx.xxx/install` 根据安装向导进行在线配置
4. 后台地址 `/admin/login` 账号密码 `admin/admin`

## 快速开发
 `php artisan make:curd my_staff(表名) System(模块名) --lang(多语言选项) --alias=别名`  


## 性能提升
* 使用opcache加速性能
* 缓存路由信息 `php artisan route:cache`
* 关闭调试模式 `APP_DEBUG=false`
* 缓存配置信息 `php artisan config:cache`
* 使用 `Swoole` 版本

## 使用 Swoole
目前`v3.3+`以上版本重新编写了对 `Swoole` 的支持，移除了包`swooletw/laravel-swoole`。 
使用新版本的用户直接安装后修改Nginx配置即可。

## Nginx配置

```nginx
map $http_upgrade $connection_upgrade {
    default upgrade;
    ''      close;
}
server {
    listen 80;
    server_name your.domain.com;
    root /path/to/laravel/public;
    index index.php;

    location = /index.php {
        # Ensure that there is no such file named "not_exists"
        # in your "public" directory.
        try_files /not_exists @swoole;
    }
    # any php files must not be accessed
    #location ~* \.php$ {
    #    return 404;
    #}
    location / {
        try_files $uri $uri/ @swoole;
    }

    location @swoole {
        set $suffix "";

        if ($uri = /index.php) {
            set $suffix ?$query_string;
        }

        proxy_http_version 1.1;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header SERVER_PORT $server_port;
        proxy_set_header REMOTE_ADDR $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection $connection_upgrade;

        # IF https
        # proxy_set_header HTTPS "on";

        proxy_pass http://127.0.0.1:1215$suffix;
    }
}

```

## Swoole 命令
`php swoole.php start`

|  命令 | 说明  |
|---|---|
|  start | 开启  |
|  stop | 停止  |
|  restart | 重启  |
|  reload | 重载  |

## 插件支持


| 名称         | 简介 |
|------------|---|
| 系统记录       |后台操作记录|
| 百度推送       |百度资源推送，加速页面收录|
| SEO设置      |自定义设置标题，关键词，描述|
| 友情链接       |友情链接|
| 网站地图       |生成网站XML地图|
| 广告管理       |广告管理|
| 网址导航       |网址导航|
| 后台更新       |后台一键更新升级|
| 织梦插件       |织梦数据导入|
| SEO优化（URL） |SEO优化（URL）|
| 阿里云OSS     |阿里云OSS|
| 阿里云短信      |阿里云短信|
| 七牛云存储      |七牛云存储|
| 阿里云邮件推送    |阿里云邮件推送|

## 版权标识
版权标识保留共3处，前台用户界面需添加 `power by MyCms`，保留后台左上角`Logo 及 MyCms 字样`，以及后台标题中 `MyCms` 字样，如需去掉请联系作者授权

## 模板界面

![blog-demo](https://static.mycms.net.cn/public/demo/blog.png)
![news-demo](https://static.mycms.net.cn/public/demo/news.png)
![gsc-demo](https://static.mycms.net.cn/public/demo/gsc.png)

## 后台界面
![system-demo](https://static.mycms.net.cn/public/demo/new-system-index.png)
## 特别感谢

以下项目排名不分先后

* Laravel：[https://github.com/laravel/laravel](https://github.com/laravel/laravel)

* Layuimini：[https://github.com/zhongshaofa/layuimini](https://github.com/zhongshaofa/layuimini)

## 免责声明

>任何用户在使用`MyCms`内容管理系统前，请您仔细阅读并透彻理解本声明。您可以选择不使用`MyCms`内容管理系统，若您一旦使用`MyCms`内容管理系统，您的使用行为即被视为对本声明全部内容的认可和接受。

* `MyCms`内容管理系统是一款开源免费的后台快速开发框架 ，主要用于更便捷地开发后台管理；其尊重并保护所有用户的个人隐私权，不窃取任何用户计算机中的信息。更不具备用户数据存储等网络传输功能。
* 您承诺秉着合法、合理的原则使用`MyCms`内容管理系统，不利用`MyCms`内容管理系统进行任何违法、侵害他人合法利益等恶意的行为，亦不将`MyCms`内容管理系统运用于任何违反我国法律法规的 Web 平台。
* 任何单位或个人因下载使用`MyCms`内容管理系统而产生的任何意外、疏忽、合约毁坏、诽谤、版权或知识产权侵犯及其造成的损失 (包括但不限于直接、间接、附带或衍生的损失等)，本开源项目不承担任何法律责任。
* 用户明确并同意本声明条款列举的全部内容，对使用`MyCms`内容管理系统可能存在的风险和相关后果将完全由用户自行承担，本开源项目不承担任何法律责任。
* 任何单位或个人在阅读本免责声明后，应在《Apache2.0 开源许可证》所允许的范围内进行合法的发布、传播和使用`MyCms`内容管理系统等行为，若违反本免责声明条款或违反法律法规所造成的法律责任(包括但不限于民事赔偿和刑事责任），由违约者自行承担。
* 如果本声明的任何部分被认为无效或不可执行，其余部分仍具有完全效力。不可执行的部分声明，并不构成我们放弃执行该声明的权利。
* 本开源项目有权随时对本声明条款及附件内容进行单方面的变更，并以消息推送、网页公告等方式予以公布，公布后立即自动生效，无需另行单独通知；若您在本声明内容公告变更后继续使用的，表示您已充分阅读、理解并接受修改后的声明内容。
