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
$this->setFrameMode(true);
?>


<? if ($arResult["ITEMS"]) : ?>
	<ul class="doctors-list">
		<? foreach ($arResult["ITEMS"] as $arItem): ?>
			<li class="doctors-list__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
				<a class="doctors-list__item-link" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
					<div class="doctors-list__item-img-box">
						<img class="doctors-list__item-img" width="302" height="218" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>`">
					</div>
					<div class="doctors-list__item-content">
						<h3 class="doctors-list__item-title"><?= $arItem["NAME"] ?></h3>
						<div class="doctors-list__item-degree"><?= $arItem["PREVIEW_TEXT"] ?></div>
						<div class="doctors-list__item-experience"><?= $arItem["PROPERTIES"]["EXPERIENCE"]["VALUE"] ?></div>
						<div class="doctors-list__item-btn-more btn btn__more"><?= GetMessage("DETAIL") ?></div>
					</div>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>