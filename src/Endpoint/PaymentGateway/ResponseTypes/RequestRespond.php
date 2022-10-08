<?php

namespace ZarinPal\Sdk\Endpoint\PaymentGateway\ResponseTypes;

use ZarinPal\Sdk\Endpoint\Fillable;

class RequestRespond
{

    use Fillable;

    public string $authority;
    public int $code;
    public string $message;
    public string $fee_type;
    public int $fee;

}