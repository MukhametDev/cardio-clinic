<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementSpecialistsTable as Specialists;
use Bitrix\Main\Data\Cache;

Loader::includeModule('iblock');

$aMenuLinksExt = [];
$cacheTime = 3600;
$cacheId = 'specialist_menu';
$cacheDir = '/bitrix/cache/specialists_menu';
$cache = Cache::createInstance();

if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
    $aMenuLinksExt = $cache->getVars();
} elseif ($cache->startDataCache()) {
    $elements = Specialists::getList([
        'select' => ['CODE', 'NAME'],
        'filter' => ['ACTIVE' => 'Y'],
    ])->fetchAll();

    foreach ($elements as $element) {
        $aMenuLinksExt[] = [
            $element['NAME'],
            '/specialists/' . $element['CODE'] . "/",
            [],
            [],
            '',
        ];
    }

    if (!empty($aMenuLinksExt)) {
        $cache->endDataCache($aMenuLinksExt);
    } else {
        $cache->abortDataCache();
    }
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
