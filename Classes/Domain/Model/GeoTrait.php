<?php

namespace Scarbous\MrGeo\Domain\Model;

use \Scarbous\MrGeo\Utility\GeoUtility;

trait GeoTrait
{

    /**
     * @var string
     */
    protected $geo;

    /**
     * @return string
     */
    public function getGeo(): string
    {
        return $this->geo;
    }

    /**
     * @return string
     */
    public function getLat(): string
    {
        return GeoUtility::geoDecode($this->geo)['lat'];
    }

    /**
     * @return string
     */
    public function getLng(): string
    {
        return GeoUtility::geoDecode($this->geo)['lng'];
    }

    /**
     * @param array|string $geo
     */
    public function setGeo($geo)
    {
        if (is_array($geo)) {
            $geo = GeoUtility::geoEncode($geo);
        }
        $this->geo = $geo;
    }
}