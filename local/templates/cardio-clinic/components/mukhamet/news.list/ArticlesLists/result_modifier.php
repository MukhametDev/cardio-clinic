<?php

foreach ($arResult['ITEMS'] as $key => $arItem) {
    $arTmpFile = CFile::ResizeImageGet(
        $arItem['PREVIEW_PICTURE']['ID'],
        ["width" => 438, "height" => 233],
        BX_RESIZE_IMAGE_EXACT,
        true,
    );

    $arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $arTmpFile['src'];

}