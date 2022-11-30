<?php

declare(strict_types=1);

namespace App\Enum;

enum CharacterGenderEnum: string
{
    case Male = 'Male';
    case Female = 'Female';
    case Genderless = 'Genderless';
}
