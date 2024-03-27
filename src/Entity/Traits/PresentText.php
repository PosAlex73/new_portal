<?php

namespace App\Entity\Traits;

trait PresentText
{
    public function getPresentText()
    {
        if (property_exists($this, 'short_description') && !empty($this->short_description) ) {
            return $this->short_description;
        }

        return substr($this->text, 0, 120) . '...';
    }
}
