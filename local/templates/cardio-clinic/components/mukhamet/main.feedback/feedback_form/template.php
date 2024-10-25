<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Localization\Loc;
?>
<? if (!empty($arResult["ERROR_MESSAGE"])): ?>
	<? foreach ($arResult["ERROR_MESSAGE"] as $error): ?>
		<div class="form-error"><?= $error ?></div>
	<? endforeach; ?>
<? endif; ?>

<? if (!empty($arResult["OK_MESSAGE"])): ?>
	<div class="form__ok-text"><?= $arResult["OK_MESSAGE"] ?></div>
<? endif; ?>

<form class="form" action="<?= POST_FORM_ACTION_URI ?>" method="POST">
	<?= bitrix_sessid_post() ?>

	<h3 class="form__title"><?= Loc::getMessage("MFT_TITLE") ?></h3>

	<label class="form__label">
		<input class="form__input form__input-radio" type="radio" name="feedback_type" value="clinic" checked="">
		<span class="form__input-radio-style"></span>
		<div class="form__label-text"><?= Loc::getMessage("MFT_CLINIC") ?></div>
	</label>
	<label class="form__label">
		<input class="form__input form__input-radio" type="radio" name="feedback_type" value="doctor">
		<span class="form__input-radio-style"></span>
		<div class="form__label-text"><?= Loc::getMessage("MFT_DOCTOR") ?></div>
	</label>
	<label class="form__label">
		<input class="form__input form__input-radio" type="radio" name="feedback_type" value="service">
		<span class="form__input-radio-style"></span>
		<div class="form__label-text"><?= Loc::getMessage("MFT_SERVICE") ?></div>
	</label>

	<div class="form__textarea-box decore--message">
		<textarea class="form__textarea" name="MESSAGE" rows="5" placeholder="<?= Loc::getMessage("MFT_TEXT") ?>"
			required=""><?= ($arResult["MESSAGE"] ?? '') ?></textarea>
	</div>

	<div class="form__input-box decore--user">
		<input class="form__input" type="text" name="user_name" value="<?= $arResult["AUTHOR_NAME"] ?>"
			placeholder="<?= Loc::getMessage("MFT_NAME") ?>*" required="">
	</div>

	<div class="form__input-box decore--phone">
		<input class="form__input" type="tel" name="user_phone" value="<?= $arResult["AUTHOR_PHONE"] ?>"
			placeholder="<?= Loc::getMessage("MFT_PHONE") ?>*" required="">
	</div>


	<button class="form__btn btn btn__tertiary" type="submit"
		name="submit" value="<?= Loc::getMessage("MFT_SUBMIT") ?>"><?= Loc::getMessage("MFT_SUBMIT") ?></button>

	<div class="form__agree">
		<p class="form__agree-text">
			<?= Loc::getMessage("MFT_AGREE_ONE") ?><a class="form__agree-link" href="javascript:;">
				<?= Loc::getMessage("MFT_AGREE_TWO") ?></a>
		</p>
	</div>
	<input type="hidden" name="PARAMS_HASH" value="<?= $arResult["PARAMS_HASH"] ?>">
</form>