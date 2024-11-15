<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

<ul class="articles-list">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <li class="articles-list__item">
            <div class="articles-list__img-box">
                <a class="articles-list__img-link" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                    <img class="articles-list__img" width="166" height="111" loading="lazy" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="Наш дневной стационар">
                </a>
            </div>
            <div class="articles-list__content">
                <a class="articles-list__content-title-link" href="javascript:;">
                    <h3 class="articles-list__content-title"><?= $arItem["NAME"] ?></h3>
                </a>
                <div class="articles-list__content-description">
                    <p><?= $arItem["PREVIEW_TEXT"] ?>⠀</p>
                </div>
                <a class="articles-list__content-btn-link btn btn__more" href="javascript:;"><?= Loc::getMessage("DETAIL") ?></a>
            </div>
        </li>
    <? endforeach; ?>
</ul>
