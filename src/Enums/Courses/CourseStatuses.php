<?php

namespace App\Enums\Courses;

enum CourseStatuses: string
{
    case ACTIVE = 'A';
    case DISABLED = 'D';
    case ARCHIVED = 'E';
    case IN_DEVELOPMENT = 'I';
    case PROJECT = 'P';
}
