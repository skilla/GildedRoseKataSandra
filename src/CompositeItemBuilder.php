<?php

declare(strict_types=1);

namespace GildedRose;

final class CompositeItemBuilder extends CompositeItem
{
    private function __construct()
    {
        parent::__construct('', 0, 0);
    }

    public static function fromItem(Item $item)
    {
        if ($item->name === AgedBrie::NAME) {
            return AgedBrie::fromItem($item);
        }
        if ($item->name === BackstagePasses::NAME) {
            return BackstagePasses::fromItem($item);
        }
        if ($item->name === DexterityVest::NAME) {
            return DexterityVest::fromItem($item);
        }
        if ($item->name === ElixirMongoose::NAME) {
            return ElixirMongoose::fromItem($item);
        }
        if ($item->name === ManaCake::NAME) {
            return ManaCake::fromItem($item);
        }
        if ($item->name === Sulfuras::NAME) {
            return Sulfuras::fromItem($item);
        }

        $tmp = new CompositeItem('', 0, 0);
        $tmp->item = $item;

        return $tmp;
    }
}
