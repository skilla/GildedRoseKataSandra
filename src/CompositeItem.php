<?php

declare(strict_types=1);

namespace GildedRose;

class CompositeItem
{
    protected const MINIMUM_SELL_IN = 0;
    protected const MINIMUM_QUALITY = 0;
    protected const MAXIMUM_QUALITY = 50;
    protected const QUALITY_STEP    = 1;
    protected const SELL_IN_STEP    = 1;

    protected Item $item;

    public function __construct(string $name, int $sellIn, int $quality)
    {
        $this->item = new Item($name, $sellIn, $quality);
    }

    public function __get($name)
    {
        return $this->item->{$name};
    }

    public function __set($name, $value)
    {
        return $this->item->{$name} = $value;
    }

    public function __toString(): string
    {
        return (string) $this->item;
    }

    public function item(): Item
    {
        return $this->item;
    }

    public function isTimedOut(): bool
    {
        return $this->item->sell_in < self::MINIMUM_SELL_IN;
    }

    public function decreaseQuality(): void
    {
        if ($this->item->quality <= self::MINIMUM_QUALITY) {
            return;
        }

        $this->item->quality = $this->item->quality - self::QUALITY_STEP;
    }

    public function incrementQuality(): void
    {
        if ($this->item->quality >= self::MAXIMUM_QUALITY) {
            return;
        }

        $this->item->quality = $this->item->quality + self::QUALITY_STEP;
    }

    public function decreaseSellIn(): void
    {
        $this->item->sell_in = $this->item->sell_in - self::SELL_IN_STEP;
    }

    public function update(): void
    {
        $this->decreaseSellIn();
        $this->decreaseQuality();

        if (!$this->isTimedOut()) {
            return;
        }

        $this->decreaseQuality();
    }

    protected static function fromItem(Item $item)
    {
        $element =  static::create(0, 0);
        $element->item = $item;

        return $element;
    }
}
