<?php

declare(strict_types=1);

namespace GildedRose;

final class ElixirMongoose extends CompositeItem
{
    public const NAME = 'Elixir of the Mongoose';

    private function __construct(int $sellIn, int $quality)
    {
        parent::__construct(self::NAME, $sellIn, $quality);
    }

    public static function create(int $sellIn, int $quality): self
    {
        return new self($sellIn, $quality);
    }
}
