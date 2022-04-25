<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /** @var CompositeItem[] */
    private array $items;

    public function __construct(array $items)
    {
        foreach ($items as $key => $item) {
            if ($item instanceof CompositeItem) {
                $this->items[$key] = CompositeItemBuilder::fromItem($item->item());
                continue;
            }
            if ($item instanceof Item) {
                $this->items[$key] = CompositeItemBuilder::fromItem($item);
                continue;
            }
            $this->items[$key] = $item;
        }
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item->update();
        }
    }
}
