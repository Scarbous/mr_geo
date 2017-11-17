<?php

namespace Scarbous\MrGeo\Utility;

class GeoUtility
{
    const GEO_DELIMITER = '|';

    /**
     * @param array $geo
     * @return string
     */
    static function geoEncode($geo): array
    {
        list($lat, $long) = $geo;
        return floatval($lat) . static::GEO_DELIMITER . floatval($long);
    }

    /**
     * @param string $value
     * @return string[]
     */
    static function geoDecode($value)
    {
        list($lat, $long) = explode(static::GEO_DELIMITER, $value, 2);
        return [
            'lat' => floatval($lat),
            'lng' => floatval($long)
        ];
    }

}