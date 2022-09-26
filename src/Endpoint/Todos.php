<?php


declare(strict_types=1);

namespace ZrinPal\Sdk\Endpoint;

use ZrinPal\Sdk\HttpClient\Message\ResponseMediator;
use ZrinPal\Sdk\ZarinPal;

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