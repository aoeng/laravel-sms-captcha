<?php

namespace Aoeng\Laravel\SMS\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getConfig($name, $notGateway = true)
 * @method static \Aoeng\Laravel\SMS\Captcha\SMS mobile($mobile)
 * @method static \Aoeng\Laravel\SMS\Captcha\SMS params($params)
 * @method static \Aoeng\Laravel\SMS\Captcha\SMS template($template)
 * @method static array send($message = '')
 * @method static string code()
 *
 */
class SMS extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Aoeng\Laravel\SMS\Captcha\SMS::class;
    }
}
