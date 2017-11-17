<?php

namespace Scarbous\MrGeo\Utility;

class GeoUtility
{

    /**
     * @param string $value
     * @return array
     */
    static function parseGeo($value)
    {
        list($lat, $long) = explode('|', $value);
        return [
            'lat'  => $lat,
            'lng' => $long
        ];
    }

}