<?php

namespace Habib\Payout;

use Illuminate\Config\Repository;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class HyperSplitService
{
    protected PendingRequest $http;
    /**
     * @var array{mode:string,email:string,password:string,live:array{url:string},test:array{url:string}}
     */
    protected array $config = [];

    public function __construct(Repository $config)
    {
        $this->config = $config->get('payout.hyper_split');
        $this->http = Http::asJson()->acceptJson()->baseUrl("{$this->getUrl()}/api/v1/");
    }

    public function getUrl()
    {
        return $this->config[$this->getMode()]['url'] ?? $this->config['url'] ?? 'https://splits.sandbox.hyperpay.com';
    }

    public function getMode()
    {
        return $this->config['mode'] ?? 'test';
    }

    /**
     * @param array{merchantTransactionId:string,configId:string,transferOption:string,period:string,beneficiary:array} $data
     * @return array
     */
    public function createOrder(array $data): array
    {
        $data['merchantTransactionId'] ??= uniqid("withdraw-" . date('H-i-s-'));
        $data['configId'] ??= $this->config['hyper_split.config_id'] ?? '';
        $data['transferOption'] = (string)($data['transferOption'] ?? 0);
        $data['period'] ??= date('Y-m-d');

        $email = $this->config['email'] ?? '';
        $password = $this->config['password'] ?? '';

        $token = $this->http->post('login', compact('password', 'email'))->json('data.accessToken');

        return $this->http->withToken($token)->post('orders', $data)->json();
    }
}
