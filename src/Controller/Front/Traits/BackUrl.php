<?php

namespace App\Controller\Front\Traits;

use Symfony\Component\HttpFoundation\Request;

trait BackUrl
{
    public function getBackUrl(Request $request)
    {
        return $request->headers->get('referer');
    }
}
