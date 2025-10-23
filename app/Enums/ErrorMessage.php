<?php

namespace App\Enums;

enum ErrorMessage: string
{
    case ServiceUnavailable = "The VodafoneZiggo Developers API is currently not available";
    case NoConnection = "Couldn't make a connection with the VodafoneZiggo Developers API";
}
