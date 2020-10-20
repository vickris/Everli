<?php

namespace Everli;

use Everli\Exceptions\EmptyShoppersListException;
use Everli\Exceptions\EmptyZonesException;
use Everli\Exceptions\MissingKeyException;

class HaverSineCoverage
{
    // Made these public incase one wants to do inspection down the line
    public $zones;
    public $shoppers;

    public function __construct(array $zones, array $shoppers)
    {
        // validate zones and shoppers. Throw error
        $this->validateZones($zones);
        $this->validateShoppers($shoppers);

        $this->zones = $zones;
        $this->shoppers = $shoppers;
    }

    public function percentageCoveredByEnabledShoppers()
    {
        $return_arr = [];
        $zone_count = count($this->zones);

        foreach ($this->shoppers as $shopper) {
            if(! $shopper["enabled"]) continue;

            $zones_covered = 0;
            foreach ($this->zones as $zone) {
                $distance_shopper_zone = $this->haversine($shopper["lat"], $shopper["lng"], $zone["lat"], $zone["lng"]);

                // Working with strict less than
                if($distance_shopper_zone < 10) {
                    $zones_covered++;
                }
            }

            if($zones_covered) {
                $percentage_coverage = (int) ($zones_covered / $zone_count  * 100);
                $return_arr[] = ["shopper_id" => $shopper["id"], "coverage" => $percentage_coverage];
            }
        }

        usort($return_arr, function ($a, $b) {
            if ($a["coverage"] == $b["coverage"]) {
                return 0;
            }

            return ($a["coverage"] < $b["coverage"]) ? 1 : -1;
        });

        return $return_arr;

    }

    /**
     * Get distance between two locations
     * @param  float $lat1
     * @param  float $lng1
     * @param  float $lat2
     * @param  float $lng2
     * @return float  Distance in Kilometers
     */
    public function haversine(float $lat1, float $lng1, float $lat2, float $lng2)
    {
        if (($lat1 == $lat2) && ($lng1 == $lng2)) {
            return 0;
        } else {
            $theta = $lng1 - $lng2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            return $miles * 1.609344;
          }
    }

    public function validateZones($zones)
    {
        $len = count($zones);

        if($len == 0) {
            throw new EmptyZonesException();
        }

        $line = 0;
        // Basic validation making sure Keys exist
        foreach ($zones as $zone) {
            $line++;
            if(! isset($zone["id"], $zone["zip_code"], $zone["lat"], $zone["lng"])) {
                throw new MissingKeyException("Error in locations array on line $line", 1);
            }
        }
    }

    public function validateShoppers($shoppers)
    {
        $len = count($shoppers);

        if($len == 0) {
            throw new EmptyShoppersListException("Empty List of Shoppers passed", 1);

        }

        $line = 0;
        foreach ($shoppers as $shopper) {
            $line++;
            if(! isset($shopper["id"], $shopper["enabled"], $shopper["lat"], $shopper["lng"])) {
                throw new MissingKeyException("Error in shoppers array on line $line", 1);
            }
        }
    }
}
