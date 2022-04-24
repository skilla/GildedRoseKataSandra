<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    const AGED_BRIE                = 'Aged Brie';
    const BACKSTAGE_PASSES         = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS                 = 'Sulfuras, Hand of Ragnaros';
    const MANA_CAKE                = 'Conjured Mana Cake';
    const MINIMUM_QUALITY          = 0;
    const NORMAL_QUALITY_REDUCER   = 1;
    const MAXIMUM_QUALITY          = 50;
    const NORMAL_QUALITY_AUGMENTER = 1;
    const NORMAL_SELLIN_REDUCER    = 1;
    const MINIMUM_SELLIN           = 0;
    const SELLIN_DOUBLE_QUALITY    = 10;
    const SELLIN_TRIPLE_QUALITY    = 5;
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach (array_keys($this->items) as $key) {
            if ($this->isSulfuras($this->items[$key])) {
                continue;
            }

            if ($this->isAgedBrie($this->items[$key])) {
                $this->incrementQuality($this->items[$key]);
                $this->decreaseSellIn($this->items[$key]);
                if (!$this->isTimedOut($this->items[$key])) {
                    continue;
                }
                $this->incrementQuality($this->items[$key]);
                continue;
            }

            if ($this->isBackstagePasses($this->items[$key])) {
                $this->incrementQuality($this->items[$key]);
                if ($this->isDoubleQualityIncrement($this->items[$key])) {
                    $this->incrementQuality($this->items[$key]);
                }
                if ($this->isTripleQualityIncrement($this->items[$key])) {
                    $this->incrementQuality($this->items[$key]);
                }
                $this->decreaseSellIn($this->items[$key]);

                if (!$this->isTimedOut($this->items[$key])) {
                    continue;
                }
                $this->items[$key]->quality = self::MINIMUM_QUALITY;
                continue;
            }

            if ($this->isConjuredItem($key)) {
                $this->decreaseQuality($this->items[$key]);
            }

            $this->decreaseSellIn($this->items[$key]);
            $this->decreaseQuality($this->items[$key]);

            if (!$this->isTimedOut($this->items[$key])) {
                continue;
            }

            $this->decreaseQuality($this->items[$key]);
        }
    }

    private function isAgedBrie(Item $item): bool
    {
        return $item->name === self::AGED_BRIE;
    }

    private function isBackstagePasses(Item $item): bool
    {
        return $item->name === self::BACKSTAGE_PASSES;
    }

    private function isSulfuras(Item $item): bool
    {
        return $item->name === self::SULFURAS;
    }

    private function isDoubleQualityIncrement(Item $item): bool
    {
        if (!$this->isBackstagePasses($item)) {
            return false;
        }

        return $item->sell_in <= self::SELLIN_DOUBLE_QUALITY;
    }

    private function isTripleQualityIncrement(Item $item): bool
    {
        if (!$this->isBackstagePasses($item)) {
            return false;
        }

        return $item->sell_in <= self::SELLIN_TRIPLE_QUALITY;
    }

    private function isTimedOut(Item $item): bool
    {
        return $item->sell_in < self::MINIMUM_SELLIN;
    }

    private function decreaseQuality(Item &$item): void
    {
        if ($item->quality <= self::MINIMUM_QUALITY) {
            return;
        }

        $item->quality = $item->quality - self::NORMAL_QUALITY_REDUCER;
    }

    private function incrementQuality(Item &$item): void
    {
        if ($item->quality >= self::MAXIMUM_QUALITY) {
            return;
        }

        $item->quality = $item->quality + self::NORMAL_QUALITY_AUGMENTER;
    }

    private function decreaseSellIn(Item &$item): void
    {
        $item->sell_in = $item->sell_in - self::NORMAL_SELLIN_REDUCER;
    }

    private function isConjuredItem($key): bool
    {
        return $this->items[$key]->name === self::MANA_CAKE;
    }
}
