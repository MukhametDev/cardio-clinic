<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */

/** @var CBitrixComponent $component */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$this->setFrameMode(true);
?>

<section class="doctors">
    <div class="container">
        <h2 class="section__title"><?= $arResult["NAME"] ?></h2>
        <?
        if ($arResult["ITEMS"]) : ?>
            <ul class="doctors-list">

                <li class="doctors-list__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <?
                    foreach ($arResult["ITEMS"] as $arItem): ?>
                    <?php
                    $this->AddEditAction(
                        $arItem['ID'],
                        $arItem['EDIT_LINK'],
                        CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"),
                    );
                    $this->AddDeleteAction(
                        $arItem['ID'],
                        $arItem['DELETE_LINK'],
                        CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                        ["CONFIRM" => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')],
                    );
                    ?>
                <li class="doctors-list__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <a class="doctors-list__item-link" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                        <div class="doctors-list__item-img-box">
                            <img class="doctors-list__item-img" width="302" height="218"
                                 src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>`">
                        </div>
                        <div class="doctors-list__item-content">
                            <h3 class="doctors-list__item-title"><?= $arItem["NAME"] ?></h3>
                            <div class="doctors-list__item-degree"><?= $arItem["PREVIEW_TEXT"] ?></div>
                            <div class="doctors-list__item-experience"><?= $arItem["PROPERTIES"]["EXPIRIENCE"]["VALUE"] ?></div>
                            <div class="doctors-list__item-btn-more btn btn__more"><?= Loc::getMessage(
                                    "DETAIL"
                                ) ?></div>
                        </div>
                    </a>
                </li>
                <?
                endforeach; ?>
            </ul>
        <?
        endif; ?>
        <a class="doctors__btn btn btn__primary" href="javascript:;"><?= Loc::getMessage("VIEW_ALL") ?>
            (<?= $arResult['SPECIALISTS_COUNT'] ?>)</a>
    </div>
</section>
