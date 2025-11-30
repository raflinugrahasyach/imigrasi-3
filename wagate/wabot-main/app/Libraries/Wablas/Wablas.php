<?php

namespace App\Libraries\Wablas;

use App\Libraries\Wablas\Exceptions\FailedToSendNotification;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class Wablas
{
    protected HttpClient $http;
    protected $url;
    protected $token;
    protected $server;

    public function __construct(HttpClient $httpClient = null)
    {
        $this->http = $httpClient ?? new HttpClient();
        $this->token = config('wablas.token');
        $this->server = config('wablas.server');
    }

    public function httpClient() : HttpClient
    {
        return $this->http;
    }

    public function setHttpClient(HttpClient $http) : self
    {
        $this->http = $http;

        return $this;
    }

    public function setToken(string $token) : self
    {
        $this->token = $token;

        return $this;
    }

    public function getToken() : string
    {
        if (empty($this->token)) {
            throw FailedToSendNotification::tokenIsEmpty();
        }

        return $this->token;
    }

    public function host() : string
    {
        if (empty($this->server)) {
            throw FailedToSendNotification::urlIsEmpty();
        }

        return "https://" . rtrim(trim($this->server), ".") . ".wablas.com";
    }

    public function api(): string
    {
        if (empty($this->server)) {
            throw FailedToSendNotification::urlIsEmpty();
        }

        return "https://" . rtrim(trim($this->server), ".") . ".wablas.com/api/";
    }

    public function getInfo()
    {
        $url = $this->api() . "device/info?token=" . $this->token;
        $response = $this->http->get($url);

        return $response->getBody();
    }

    public function getInfoWhatsApp() : ?array
    {
        $data = json_decode($this->getInfo());

        return [
            'project_id' => $data->data->project_id,
            'quota' => $data->data->whatsapp->quota,
            'expired' => $data->data->whatsapp->expired,
            'status' => $data->data->whatsapp->status,
        ];
    }

    public function restartDevice()
    {
        $url = $this->api() . "device/device/reconnect?token=" . $this->token;
        $response = $this->http->get($url);

        return $response->getBody();
    }

    /**
     * @throws GuzzleException
     * @throws FailedToSendNotification
     */
    public function sendMessage(array $params) : ?ResponseInterface
    {
        return $this->sendRequest($params);
    }

    /**
     * @throws GuzzleException
     * @throws FailedToSendNotification
     */
    protected function sendRequest(array $params, $endpoint = 'send-message') : ?ResponseInterface
    {
        if (blank($this->token)) {
            throw FailedToSendNotification::tokenIsEmpty();
        }

        if (empty($this->api())) {
            throw FailedToSendNotification::urlIsEmpty();
        }

        try {
            return $this->http->post($this->api() . $endpoint, [
                'headers' => [
                    'Authorization' => $this->token,
                    'Content-Type' => 'application/json',
                ],
                'json' => $params,
            ]);
        } catch (ClientException $e) {
            Log::error($e->getMessage());
            throw FailedToSendNotification::wablasRespondedWithAnError($e);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw FailedToSendNotification::couldNotCommunicateWithWablas();
        }
    }
}
