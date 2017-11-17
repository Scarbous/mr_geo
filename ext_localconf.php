<?php
/**
 * @var string $_EXTKEY
 */
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKEy) {

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1510912345] = [
            'nodeName' => 'mrGeo',
            'priority' => 40,
            'class'    => \Scarbous\MrGeo\Hooks\FormEngine\GeoLocation::class,
        ];
    },
    $_EXTKEY
);