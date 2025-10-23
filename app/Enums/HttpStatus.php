<?php

namespace App\Enums;

enum HttpStatus: int
{
    case ServiceUnavailable = 503;
    case GatewayTimeOut = 504;
}
