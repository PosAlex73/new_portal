<?php

namespace App\Services\Practice;

class CodeClientService
{
    public const IS_ALIVE_STATUS = 'ok';

    public function __construct(protected CodeClient $codeClient)
    {
    }

    public function isCheckerAlive()
    {
        $response = $this->codeClient->checkAlive();

        return $response['status'] === static::IS_ALIVE_STATUS;
    }
}
