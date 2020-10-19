<?php


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
            throw new \Exception("Empty List of Zones passed", 1);
        }

        $line = 0;
        // Basic validation making sure Keys exist
        foreach ($zones as $zone) {
            $line++;
            if(! isset($zone["id"], $zone["zip_code"], $zone["lat"], $zone["lng"])) {
                throw new \Exception("Error in locations array on line $line", 1);
            }
        }
    }

    public function validateShoppers($shoppers)
    {
        $len = count($shoppers);

        if($len == 0) {
            throw new \Exception("Empty List of Shoppers passed", 1);

        }

        $line = 0;
        foreach ($shoppers as $shopper) {
            $line++;
            if(! isset($shopper["id"], $shopper["enabled"], $shopper["lat"], $shopper["lng"])) {
                throw new \Exception("Error in shoppers array on line $line", 1);
            }
        }
    }
}

$locations = [
    ['id' => 1000, 'zip_code' => '37069', 'lat' => 45.35, 'lng' => 10.84],
    ['id' => 1001, 'zip_code' => '37121', 'lat' => 45.44, 'lng' => 10.99],
    ['id' => 1001, 'zip_code' => '37129', 'lat' => 45.44, 'lng' => 11.00],
    ['id' => 1001, 'zip_code' => '37133', 'lat' => 45.43, 'lng' => 11.02],
];

$shoppers = [
    ['id' => 'S1', 'lat' => 45.46, 'lng' => 11.03, 'enabled' => true],
    ['id' => 'S2', 'lat' => 45.46, 'lng' => 10.12, 'enabled' => true],
    ['id' => 'S3', 'lat' => 45.34, 'lng' => 10.81, 'enabled' => true],
    ['id' => 'S4', 'lat' => 45.76, 'lng' => 10.57, 'enabled' => true],
    ['id' => 'S5', 'lat' => 45.34, 'lng' => 10.63, 'enabled' => true],
    ['id' => 'S6', 'lat' => 45.42, 'lng' => 10.81, 'enabled' => true],
    ['id' => 'S7', 'lat' => 45.34, 'lng' => 10.94, 'enabled' => true],
];


$w = new HaverSineCoverage($locations, $shoppers);
var_dump($w->percentageCoveredByEnabledShoppers());
