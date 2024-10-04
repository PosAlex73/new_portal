<?php

namespace App\Enums\Blog;

enum BlogStatuses: string
{
    case ACTIVE = 'A';
    case DISABLED = 'D';
    case CANCELLED = 'C';
    case UNPUBLISHED = 'P';
}
