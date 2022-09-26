<?php


declare(strict_types=1);

namespace ZarinPal\Sdk\Endpoint\PaymentGateway;

use Exception;
use ZarinPal\Sdk\Endpoint\PaymentGateway\ResponseTypes\Request;
use ZarinPal\Sdk\HttpClient\Exception\PaymentGatewayException;
use ZarinPal\Sdk\HttpClient\Exception\ResponseException;
use ZarinPal\Sdk\HttpClient\Message\ResponseMediator;
use ZarinPal\Sdk\ZarinPal;

final class PaymentGateway
{
    private ZarinPal $sdk;

    public function __construct(ZarinPal $sdk)
    {
        $this->sdk = $sdk;
    }

    public function all(): array
    {
        return ResponseMediator::getContent($this->sdk->getHttpClient()->post('pg/v4/payment/request.json'));
    }


    /**
     * @throws PaymentGatewayException
     * @throws ResponseException
     */
    public function request(RequestTypes\Request $request): Request
    {
        $response = $this->httpHandler('pg/v4/payment/request.json', $request->toString());

        return new Request($response['data']);

    }

    /**
     * @throws PaymentGatewayException
     * @throws ResponseException
     */
    private function httpHandler(string $uri, string $body): array
    {
        try {
            $response = $this->sdk->getHttpClient()
                ->post($uri, [], $body);
            if ($response->getStatusCode() !== 200) {
                throw new ResponseException('Http Error', -99, null);
            }
            $response = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        } catch (Exception $e) {
            throw new ResponseException($e->getMessage(), -99, $e);
        }


        if (!empty($response['errors']) || empty($response['data'])) {
            throw new PaymentGatewayException($response['errors']);
        }
        return $response;
    }

    public function verify(): array
    {
        return ResponseMediator::getContent($this->sdk->getHttpClient()->post('pg/v4/payment/verify.json'));
    }
}