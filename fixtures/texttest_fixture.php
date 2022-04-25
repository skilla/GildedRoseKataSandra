<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use GildedRose\AgedBrie;
use GildedRose\BackstagePasses;
use GildedRose\CompositeItem;
use GildedRose\DexterityVest;
use GildedRose\ElixirMongoose;
use GildedRose\GildedRose;
use GildedRose\Item;
use GildedRose\ManaCake;
use GildedRose\Sulfuras;

echo 'OMGHAI!' . PHP_EOL;

$items = [
    DexterityVest::create(10, 20),
    AgedBrie::create(2, 0),
    ElixirMongoose::create(5, 7),
    Sulfuras::create(0, 80),
    Sulfuras::create(-1, 80),
    new Item(BackstagePasses::NAME, 15, 20),
    new CompositeItem(BackstagePasses::NAME, 10, 49),
    BackstagePasses::create(5, 49),
    // this conjured item does not work properly yet
    ManaCake::create(3, 6),
];

$app = new GildedRose($items);

$days = 31;
//if (count($argv) > 1) {
//    $days = (int) $argv[1];
//}

for ($i = 0; $i < $days; $i++) {
    echo "-------- day ${i} --------" . PHP_EOL;
    echo 'name, sellIn, quality' . PHP_EOL;
    foreach ($items as $item) {
        echo $item . PHP_EOL;
    }
    echo PHP_EOL;
    $app->updateQuality();
}
