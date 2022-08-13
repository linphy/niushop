<?php
// +---------------------------------------------------------------------+
// | NiuCloud | [ WE CAN DO IT JUST NiuCloud ]                |
// +---------------------------------------------------------------------+
// | Copy right 2019-2029 www.niucloud.com                          |
// +---------------------------------------------------------------------+
// | Author | NiuCloud <niucloud@outlook.com>                       |
// +---------------------------------------------------------------------+
// | Repository | https://github.com/niucloud/framework.git          |
// +---------------------------------------------------------------------+

namespace addon\wechatpay\model;

use app\model\BaseModel;
use WeChatPay\Builder;
use WeChatPay\Crypto\Rsa;
use WeChatPay\Util\PemUtil;

/**
 * 微信支付配置
 * 版本 1.0.4
 */
class WechatPay extends BaseModel
{
    /**
     * 应用实例
     * @var \WeChatPay\BuilderChainable
     */
    private $app;

    /**
     * @var 平台证书实例
     */
    private $plateform_certificate_instance;

    /**
     * @var 平台证书序列号
     */
    private $plateform_certificate_serial;

    /**
     * 微信支付配置
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config;

        $merchant_certificate_instance = PemUtil::loadCertificate(realpath($config['apiclient_cert']));
        // 证书序列号
        $merchant_certificate_serial = PemUtil::parseCertificateSerialNo($merchant_certificate_instance);
        // 加载平台证书
        $this->plateform_certificate_instance = PemUtil::loadCertificate(realpath($config['plateform_cert']));
        // 平台证书序列号
        $this->plateform_certificate_serial = PemUtil::parseCertificateSerialNo($this->plateform_certificate_instance);

        $this->app = Builder::factory([
            // 商户号
            'mchid' => $config['mch_id'],
            // 商户证书序列号
            'serial' => $merchant_certificate_serial,
            // 商户API私钥
            'privateKey' => PemUtil::loadPrivateKey(realpath($config['apiclient_key'])),
            'certs' => [
                $this->plateform_certificate_serial => $this->plateform_certificate_instance
            ]
        ]);
    }

    /**
     * 转账
     * @param  array  $options
     */
    public function transfer(array $data)
    {
        $this->app->chain('v3/transfer/batches')
            ->postAsync([
                'json' => $data,
                'headers' => [
                    'Wechatpay-Serial' => $this->plateform_certificate_serial
                ]
            ])->then(static function($response) use (&$result) {
                $result = json_decode($response->getBody()->getContents(), true);
                $result = success(0, '', $result);
            })->otherwise(static function ($exception) use (&$result) {
                if ($exception instanceof \GuzzleHttp\Exception\RequestException && $exception->hasResponse()) {
                    $result = json_decode($exception->getResponse()->getBody()->getContents(), true);
                    $result = error(-1, $result['message'], $result);
                } else {
                    $result = error(-1, $exception->getMessage());
                }
            })->wait();
        return $result;
    }

    /**
     *
     * @param  string  $out_batch_no
     * @param  string  $out_detail_no
     * @return array
     */
    public function transferDetail(string $out_batch_no, string $out_detail_no) : array
    {
        try {
            $resp = $this->app->chain("v3/transfer/batches/out-batch-no/{$out_batch_no}/details/out-detail-no/{$out_detail_no}")
                ->get();
            $result = json_decode($resp->getBody()->getContents(), true);
            return $this->success($result);
        } catch (\Exception $e) {
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $result = json_decode($e->getResponse()->getBody()->getContents(), true);
                return $this->error($result, $result['message']);
            } else {
                return $this->error([], $e->getMessage());
            }
        }
    }

    /**
     * 加密数据
     * @param  string  $str
     * @return string
     */
    public function encryptor(string $str){
        $publicKey = $this->plateform_certificate_instance;
        // 加密方法
        $encryptor = function($msg) use ($publicKey) { return Rsa::encrypt($msg, $publicKey); };
        return $encryptor($str);
    }
}