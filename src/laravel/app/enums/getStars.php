<?php

namespace App\enums;

use Filament\Support\Contracts\HasLabel;

enum getStars: int implements HasLabel
{
    case oneStar = 1;
    case twoStars = 2;
    case threeStars = 3;
    case fourStars = 4;
    case fiveStars = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::oneStar => '1 Star',
            self::twoStars => '2 Stars',
            self::threeStars => '3 Stars',
            self::fourStars => '4 Stars',
            self::fiveStars => '5 Stars',
        };
    }
}
