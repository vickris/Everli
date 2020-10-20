<?php

namespace Everli\Test;

use PHPUnit\Framework\TestCase;
use Everli\HaverSineCoverage;
use Everli\Exceptions\EmptyShoppersListException;
use Everli\Exceptions\EmptyZonesException;
use Everli\Exceptions\MissingKeyException;

class HaversineCoverageTest extends TestCase
{
    protected $zones, $shoppers;

    public function setup()
    {
        $this->zones = [
            ['id' => 1000, 'zip_code' => '37069', 'lat' => 45.35, 'lng' => 10.84],
            ['id' => 1001, 'zip_code' => '37121', 'lat' => 45.44, 'lng' => 10.99],
            ['id' => 1001, 'zip_code' => '37129', 'lat' => 45.44, 'lng' => 11.00],
            ['id' => 1001, 'zip_code' => '37133', 'lat' => 45.43, 'lng' => 11.02],
        ];

        $this->shoppers = [
            ['id' => 'S1', 'lat' => 45.46, 'lng' => 11.03, 'enabled' => true],
            ['id' => 'S2', 'lat' => 45.46, 'lng' => 10.12, 'enabled' => true],
            ['id' => 'S3', 'lat' => 45.34, 'lng' => 10.81, 'enabled' => true],
            ['id' => 'S4', 'lat' => 45.76, 'lng' => 10.57, 'enabled' => true],
            ['id' => 'S5', 'lat' => 45.34, 'lng' => 10.63, 'enabled' => true],
            ['id' => 'S6', 'lat' => 45.42, 'lng' => 10.81, 'enabled' => true],
            ['id' => 'S7', 'lat' => 45.34, 'lng' => 10.94, 'enabled' => true],
        ];
    }

    public function testValidateEmptyShoppersList()
    {
        $this->expectException(EmptyShoppersListException::class);

        new HaverSineCoverage($this->zones, []);
    }

    public function testValidateEmptyZonesList()
    {
        $this->expectException(EmptyZonesException::class);

        new HaverSineCoverage([], $this->shoppers);
    }

    public function testInvalidRowInShoppersList()
    {
        $this->expectException(MissingKeyException::class);

        unset($this->shoppers[0]["lat"]);
        new HaverSineCoverage($this->zones, $this->shoppers);
    }

    public function testInvalidRowInZonesList()
    {
        $this->expectException(MissingKeyException::class);

        unset($this->zones[0]["zip_code"]);
        new HaverSineCoverage($this->zones, $this->shoppers);
    }

    public function testAppropriateZoneCoverageListIsReturned()
    {
        $coverage = new HaverSineCoverage($this->zones, $this->shoppers);

        $expected = [
            ["shopper_id" => "S1", "coverage" => 75],
            ["shopper_id" => "S3", "coverage" => 25],
            ["shopper_id" => "S6", "coverage" => 25],
            ["shopper_id" => "S7", "coverage" => 25],
        ];

        $this->assertEquals($expected, $coverage->percentageCoveredByEnabledShoppers());
        $this->assertCount(4, $coverage->percentageCoveredByEnabledShoppers());
    }

    public function testEmptyListReturnedIfNoShopperFallsWithinAnyZone()
    {
        $index = 0;
        foreach ($this->shoppers as $shopper) {
            $this->shoppers[$index]["enabled"] = false;
            $index++;
        }

        $coverage = new HaverSineCoverage($this->zones, $this->shoppers);
        $this->assertCount(0, $coverage->percentageCoveredByEnabledShoppers());
        $this->assertEmpty($coverage->percentageCoveredByEnabledShoppers());
    }
}
