<?php

namespace Aoeng\Laravel\SMS\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static array send($mobile)
 * @method static bool check($mobile, $code)
 * @method static bool token($mobile)
 * @method static bool mobile($token)
 *
 */
class Captcha extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Aoeng\Laravel\SMS\Captcha\Captcha::class;
    }
}
