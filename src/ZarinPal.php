<?php

declare(strict_types=1);

namespace ZarinPal\Sdk;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\UriFactoryInterface;
use ZarinPal\Sdk\Endpoint\PaymentGateway\PaymentGateway;

final class ZarinPal
{
    private ClientBuilder $clientBuilder;

    public function __construct(ClientBuilder $clientBuilder = null, UriFactoryInterface $uriFactory = null)
    {
        $this->clientBuilder = $clientBuilder ?: new ClientBuilder();
        $uriFactory = $uriFactory ?: Psr17FactoryDiscovery::findUriFactory();

        $this->clientBuilder->addPlugin(
            new BaseUriPlugin($uriFactory->createUri('https://api.zarinpal.com/'))
        );
        $this->clientBuilder->addPlugin(
            new HeaderDefaultsPlugin(
                [
                    'User-Agent' => sprintf('%sSdk/v.0.1 (php %s)', $this->getClassName(),PHP_VERSION),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            )
        );
    }

    public function paymentGateway(): PaymentGateway
    {
        return new PaymentGateway($this);
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->clientBuilder->getHttpClient();
    }

    private function getClassName(): string
    {
        return basename(str_replace('\\', '/', __CLASS__));
    }
}