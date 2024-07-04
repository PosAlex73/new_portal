<?php

namespace App\Enums\Courses;

enum BugStatus: string
{
    case NEW = 'N';
    case CLOSE = 'C';
    case IN_PROGRESS = 'P';
    case REJECT = 'R';
    case FIXED = 'F';
}
