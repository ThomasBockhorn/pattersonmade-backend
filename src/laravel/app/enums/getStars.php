<?php

namespace App\enums;

use Filament\Support\Contracts\HasLabel;

enum getStars: string implements HasLabel
{
    case oneStar = 'one Star';
    case twoStars = 'two Stars';
    case threeStars = 'three Stars';
    case fourStars = 'four Stars';
    case fiveStars = 'five Stars';

    public function getLabel(): ?string
    {
       return $this->value;
    }
}
