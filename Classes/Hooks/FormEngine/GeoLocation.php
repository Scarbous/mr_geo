<?php

namespace Scarbous\MrGeo\Hooks\FormEngine;


use Scarbous\MrGeo\Utility\GeoUtility;
use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * Class GeoLocation
 */
class GeoLocation extends AbstractNode
{
    /**
     * @return array
     */
    public function render()
    {
        $resultArray = $this->initializeResultArray();

        $row = $this->data['databaseRow'];
        $name = $this->data['parameterArray']['itemFormElName'];
        $fieldName = $this->data['fieldName'];
        $geo = GeoUtility::geoDecode($row[$fieldName]);
        $id = StringUtility::getUniqueId('mr-geo-');

        ob_start();
        ?>
        <div class="mr-geo" id="<?= $id ?>" style="max-width: 800px;">
            <div class="form-group">
                <input class="form-control" data-geo-search/>
            </div>
            <input type="hidden" name="<?= htmlspecialchars($name) ?>" value="<?= $row[$fieldName] ?>" data-geo-result/>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6"><label>Lat</label><input class="form-control" data-geo-lat disabled></div>
                    <div class="col-xs-6"><label>Lng</label><input class="form-control" data-geo-lng disabled></div>
                </div>
            </div>
            <div class="mr-geo-map" style="padding-top: 50%;"
                 data-lat="<?= $geo['lat'] ?>" data-lng="<?= $geo['lng'] ?>"></div>
        </div>
        <?php
        $resultArray['html'] = ob_get_clean();
        $resultArray['requireJsModules'][] = [
            'TYPO3/CMS/MrGeo/GoogleMaps' =>
                'function(gm){gm.initialize(' . GeneralUtility::quoteJSvalue('#' . $id) . ')}'
        ];
        return $resultArray;
    }
}