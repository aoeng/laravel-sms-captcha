短信发送模块
======

## 安装

```bash
composer require  aoeng/laravel-sms-captcha
php artisan vendor:publish --provider="Aoeng\Laravel\SMS\Captcha\CaptchaServiceProvider"
```

发送和验证两个接口

```injectablephp
use Aoeng\Laravel\SMS\Captcha\Facades\Captcha;
//验证短信验证码
Captcha::check('152********','548747');
```

## 参考

[overtrue/easy-sms](https://github.com/overtrue/easy-sms)
