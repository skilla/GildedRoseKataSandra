<?php

declare(strict_types=1);

namespace GildedRose;

final class BackstagePasses extends CompositeItem
{
    public const  NAME                   = 'Backstage passes to a TAFKAL80ETC concert';
    private const SELL_IN_DOUBLE_QUALITY = 10;
    private const SELL_IN_TRIPLE_QUALITY = 5;

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
        $this->incrementQuality();
        if ($this->isDoubleQualityIncrement()) {
            $this->incrementQuality();
        }

        if ($this->isTripleQualityIncrement()) {
            $this->incrementQuality();
        }
        $this->decreaseSellIn();

        if (!$this->isTimedOut()) {
            return;
        }
        $this->quality = self::MINIMUM_QUALITY;
    }

    private function isDoubleQualityIncrement(): bool
    {
        return $this->sell_in <= self::SELL_IN_DOUBLE_QUALITY;
    }

    private function isTripleQualityIncrement(): bool
    {
        return $this->sell_in <= self::SELL_IN_TRIPLE_QUALITY;
    }
}
