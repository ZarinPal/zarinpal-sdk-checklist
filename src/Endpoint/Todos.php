<?php


declare(strict_types=1);

namespace ZarinPal\Sdk\Endpoint;

use ZarinPal\Sdk\HttpClient\Message\ResponseMediator;
use ZarinPal\Sdk\ZarinPal;

final class Todos
{
    private ZarinPal $sdk;

    public function __construct(ZarinPal $sdk)
    {
        $this->sdk = $sdk;
    }

    public function all(): array
    {
        return ResponseMediator::getContent($this->sdk->getHttpClient()->get('/todos'));
    }
}