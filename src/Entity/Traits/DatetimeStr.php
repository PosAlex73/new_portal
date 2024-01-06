<?php

namespace App\Entity\Traits;

trait DatetimeStr
{
    public function createdStr()
    {
        return $this->created->format('Y-m-d H:i:s');
    }

    public function updatedStr()
    {
        return $this->updated->format('Y-m-d H:i:s');
    }
}
