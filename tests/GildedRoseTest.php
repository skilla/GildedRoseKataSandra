<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }

    public function test_global()
    {
        ob_start();
        include_once __DIR__ . "/../fixtures/texttest_fixture.php";
        $result = ob_get_clean();

        $expected = file_get_contents(__DIR__ . '/approvals/ApprovalTest.testTestFixture.approved.txt');

        $this->assertSame($expected, $result);
    }
}
