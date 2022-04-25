<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\CompositeItem;
use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

/**
 * @covers \GildedRose\GildedRose
 * @covers \GildedRose\Item
 * @covers \GildedRose\CompositeItem
 */
class GildedRoseTest extends TestCase
{
    public function test_item(): void
    {
        $items = [new Item('foo', 1, 1)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
        $this->assertSame(0, $items[0]->sell_in);
        $this->assertSame(0, $items[0]->quality);
    }

    public function test_composite_item(): void
    {
        $items      = [new CompositeItem('foo', 3, 6)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
        $this->assertSame(2, $items[0]->sell_in);
        $this->assertSame(5, $items[0]->quality);
    }

    public function test_gilded_rose_logic()
    {
        ob_start();
        include_once __DIR__ . "/../fixtures/texttest_fixture.php";
        $result = ob_get_clean();

        $expected = file_get_contents(__DIR__ . '/approvals/ApprovalTest.testTestFixture.approved.txt');

        $this->assertSame($expected, $result);
    }
}
