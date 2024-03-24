<?php

namespace App\Entity\Traits;

use App\Enums\DateTimeFormatEnum;

trait DatetimeStr
{
    public function createdStr(DateTimeFormatEnum $format = DateTimeFormatEnum::FULL_FORMAT)
    {
        return $this->created->format($format->value);
    }

    public function updatedStr(DateTimeFormatEnum $format = DateTimeFormatEnum::FULL_FORMAT)
    {
        return $this->updated->format($format->value);
    }
}
