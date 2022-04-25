<?php

declare(strict_types=1);

namespace GildedRose;

final class Sulfuras extends CompositeItem
{
    public const NAME = 'Sulfuras, Hand of Ragnaros';

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
        // do nothing
    }
}
