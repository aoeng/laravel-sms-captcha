<?php


namespace Aoeng\Laravel\SMS\Captcha;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Captcha
{

    protected $codeKeyPfx = 'aoeng.sms.captcha:';
    protected $mobileKeyPfx = 'aoeng.sms.captcha.mobile:';

    protected $sms;

    public function __construct($app)
    {
        $this->sms = new SMS($app);
    }

    public function send($mobile): array
    {
        $captcha = Cache::get($this->codeKeyPfx . $mobile, false);

        if ($captcha && ($second = $captcha['expires'] - time()) > 0) {
            return ['code' => 301, 'data' => ['second' => $second], 'message' => 'Wait!'];
        }

        $code = $this->code();

        try {
            $this->sms->mobile($mobile)->template('captcha')->params(['code' => $code])->send();
        } catch (\Exception $exception) {
            return ['code' => $exception->getCode() ?: 301, 'message' => $exception->getMessage()];
        } finally {
            Cache::put($this->codeKeyPfx . $mobile, [
                'code'    => $code,
                'expires' => now()->addSeconds((int)$this->sms->getConfig('captcha.timeout'))->timestamp,
            ], (int)$this->sms->getConfig('captcha.expires') * 1000);

        }
        return ['code' => 0];
    }

    public function check($mobile, $code): bool
    {
        $captcha = Cache::get($this->codeKeyPfx . $mobile, false);

        if ($captcha && $captcha['code'] == $code) {

            Cache::forget($this->codeKeyPfx . $mobile);

            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function code(): string
    {
        $length = $this->sms->getConfig('captcha.length');

        return rand(pow(10, $length - 1), pow(10, $length) - 1);
    }

    public function token($mobile): string
    {
        $token = Str::random();
        Cache::put($this->mobileKeyPfx . $token, $mobile, 3600 * 24);
        return $token;
    }

    public function mobile($token): string
    {
        return Cache::get($this->mobileKeyPfx . $token, '');
    }
}
