<?php

declare(strict_types=1);

namespace ZarinPal\Sdk\HttpClient\Message;

use Psr\Http\Message\ResponseInterface;

final class ResponseMediator
{
    public static function getContent(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}