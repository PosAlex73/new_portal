<?php

namespace App\Enums\Http;

enum HttpRequest: string
{
    case GET = 'GET';
    case POST = 'POST';
    case DELETE = 'DELETE';
    case PATCH = 'PATH';
    case PUT = 'PUT';
}
