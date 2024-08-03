<?php

namespace App\Message;

final class NewCourseAdded
{
     public function __construct(
         public readonly string $courseName,
     ) {
     }
}
