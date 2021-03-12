<?php

use Aoeng\Laravel\SMS\Captcha\Http\Controllers\CaptchaController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix(config('sms.route.prefix', 'api/') . 'captcha')
    ->domain(config('sms.route.domain', '*'))
    ->group(function () {
        Route::post('send', [CaptchaController::class, 'send']);
        Route::post('check', [CaptchaController::class, 'check']);
    });
