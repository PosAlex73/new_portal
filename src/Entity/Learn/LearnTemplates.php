<?php

namespace App\Entity\Learn;

enum LearnTemplates: string
{
    case Theory = 'front/learn/tasks/theory.html.twig';
    case Test = 'front/learn/tasks/test.html.twig';
    case Practice = 'front/learn/tasks/practice.html.twig';
}
