<?php


namespace Aoeng\Laravel\SMS\Captcha\Http\Controllers;


use Aoeng\Laravel\Support\Rules\Mobile;
use Aoeng\Laravel\Support\Traits\ResponseJsonActions;
use Aoeng\Laravel\SMS\Captcha\Facades\Captcha;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * @group 短信验证码 CaptchaController
 * Class CaptchaController
 * @package Aoeng\SMS\Captcha\Http\Controllers
 */
class CaptchaController extends Controller
{
    use ResponseJsonActions;

    /**
     * 发送 CaptchaController_send
     * @bodyParam mobile string required mobile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $request->validate(['mobile' => [new Mobile]]);

        $mobile = $request->input('mobile');
        $result = Captcha::send($mobile);

        if ($result['code'] != 0) {
            return $this->error($result['message'] ?? '', $result['code'], $result['data'] ?? []);
        }

        return $this->success();
    }

    /**
     * 验证 CaptchaController_check
     * @bodyParam mobile string required mobile
     * @bodyParam code string required code
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $request->validate(['mobile' => [new Mobile], 'code' => 'required']);

        $mobile = $request->input('mobile');

        if (app()->isLocal() || Captcha::check($mobile, $request->input('code'))) {
            return $this->success('Success', ['token' => Captcha::token($mobile)]);
        }
        return $this->error('验证码错误');
    }
}
