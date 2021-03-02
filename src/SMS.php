<?php


namespace Aoeng\Laravel\SMS\Captcha;


use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\InvalidArgumentException;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class SMS
{

    protected $app;

    protected $config;

    protected $mobile;

    protected $template;

    protected $params;

    /**
     * SMS constructor.
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        $this->app = $app;

        $this->config = $app['config']['sms'] ?? [];

    }


    protected function getDefaultDriver()
    {
        return $this->app['config']['sms.default.gateways'][0];
    }


    /**
     * @param $name
     * @param bool $notGateway
     * @return mixed
     */
    public function getConfig($name, $notGateway = true)
    {
        if ($notGateway) {
            return $this->app['config']["sms.{$name}"] ?? '';
        }

        $default = $this->getDefaultDriver();

        return $this->app['config']["sms.gateways.{$default}.{$name}"] ?? '';
    }


    /**
     * @param $mobile
     * @return $this
     */
    public function mobile($mobile): SMS
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @param $params
     * @return $this
     */
    public function params($params): SMS
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param $template
     * @return $this
     * @throws \Exception
     */
    public function template($template): SMS
    {
        $this->template = $this->getConfig("templates.{$template}", false);

        return $this;
    }


    /**
     * @param string $message
     * @throws InvalidArgumentException
     * @throws NoGatewayAvailableException
     */
    public function send($message = '')
    {
        $easySms = new EasySms($this->config);

        try {
            $easySms->send($this->mobile, [
                'content'  => $message,
                'template' => $this->template,
                'data'     => $this->params,
            ]);
        } catch (InvalidArgumentException | NoGatewayAvailableException $e) {

            throw $e->getException('aliyun');
        }
    }
}
