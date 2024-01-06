<?php

namespace App\Enums\Task;

enum TaskTypes: string
{
    case THEORY = 'T';
    case TEST = 'R';
    case PRACTICE = 'G';
}
