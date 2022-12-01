<?php

declare(strict_types=1);

namespace App\Enum;

enum UserGenderEnum: string
{
    case Male = 'Male';
    case Female = 'Female';
    case Trans = 'Transgender';
    case NonBinary = 'Non-binary';
    case Intersex = 'Intersex';
}
