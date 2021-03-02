<?php

use Aoeng\Laravel\SMS\Captcha\Http\Controllers\CaptchaController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix(config('sms.route.prefix', '') . 'captcha')
    ->domain(config('sms.route.domain', '*'))
    ->group(function () {
        Route::post('send', [CaptchaController::class, 'send']);
        Route::post('check', [\Aoeng\Laravel\SMS\Captcha\Http\Controllers\CaptchaController::class, 'check']);
    });
