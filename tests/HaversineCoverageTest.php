<?php

namespace Everli\Test;

use PHPUnit\Framework\TestCase;
use Everli\HaverSineCoverage;
use Everli\Exceptions\EmptyShoppersListException;

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

    }

    public function testValidateInvalidRowInShoppersList()
    {

    }

    public function testValidateInvalidRowInZonesList()
    {

    }

    public function testAppropriateZoneCoverageListIsReturned()
    {

    }

    public function testEmptyListReturnedIfNoShopperFallsWithinAnyZone()
    {

    }
}
