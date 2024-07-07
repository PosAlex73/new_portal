<?php

namespace App\Controller\Front\Traits;

use Symfony\Component\HttpFoundation\Request;

trait BackUrl
{
    public function getBackUrl(Request $request)
    {
        if (!$request->headers->get('referer')) {
            return '/';
        }
        return $request->headers->get('referer');
    }
}
