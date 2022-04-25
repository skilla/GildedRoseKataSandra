<?php

declare(strict_types=1);

namespace GildedRose;

final class ManaCake extends CompositeItem
{
    public const NAME = 'Conjured Mana Cake';

    private function __construct(int $sellIn, int $quality)
    {
        parent::__construct(self::NAME, $sellIn, $quality);
    }

    public static function create(int $sellIn, int $quality): self
    {
        return new self($sellIn, $quality);
    }

    public function update(): void
    {
        $this->decreaseQuality();
        $this->decreaseQuality();
        $this->decreaseSellIn();

        if (!$this->isTimedOut()) {
            return;
        }

        $this->decreaseQuality();
    }
}
