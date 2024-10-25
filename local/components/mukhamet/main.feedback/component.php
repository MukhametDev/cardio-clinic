<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Loader;

$arResult["PARAMS_HASH"] = md5(serialize($arParams) . $this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"] ?? '');
if ($arParams["EVENT_NAME"] == '')
	$arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"] ?? '');
if ($arParams["EMAIL_TO"] == '')
	$arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"] ?? '');
if ($arParams["OK_TEXT"] == '')
	$arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["submit"]) && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"])) {
	$arResult["ERROR_MESSAGE"] = array();
	if (check_bitrix_sessid()) {
		if (empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"])) {
			if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_name"]) <= 1)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");
			if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && empty($_POST["user_phone"]))
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_PHONE");
			if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_email"]) <= 1)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
			if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["MESSAGE"]) <= 3)
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_MESSAGE");
		}
		if (mb_strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"]))
			$arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");
		if ($arParams["USE_CAPTCHA"] == "Y") {
			$captcha_code = $_POST["captcha_sid"];
			$captcha_word = $_POST["captcha_word"];
			$cpt = new CCaptcha();
			$captchaPass = COption::GetOptionString("main", "captcha_password", "");
			if ($captcha_word <> '' && $captcha_code <> '') {
				if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
					$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
			} else {
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");
			}
		}

		if (empty($arResult["ERROR_MESSAGE"])) {
			$userName = htmlspecialchars($_POST["user_name"]);
			$userEmail = htmlspecialchars($_POST["user_email"]);
			$userPhone = htmlspecialchars($_POST["user_phone"]);
			$message = htmlspecialchars($_POST["MESSAGE"]);
			$feedbackType = htmlspecialchars($_POST["feedback_type"]);

			$arFields = array(
				"AUTHOR" => $userName,
				"AUTHOR_EMAIL" => $userEmail,
				"PHONE" => $userPhone,
				"EMAIL_TO" => $arParams["EMAIL_TO"],
				"TEXT" => $message,
				"FEEDBACK_TYPE" => $feedbackType,
			);

			if (Loader::includeModule('iblock')) {
				$IBLOCK_ID = 10;


				$el = new CIBlockElement;
				$arLoadProductArray = array(
					"IBLOCK_ID" => $IBLOCK_ID,
					"NAME" => $userName,
					"ACTIVE" => "Y",
					"PREVIEW_TEXT" => $message,
					"PROPERTY_VALUES" => array(
						"USER_PHONE" => $userPhone,
						"TYPE_FEEDBACK" => $feedbackType,
					),
				);
				if ($el->Add($arLoadProductArray)) {
					$arResult["OK_MESSAGE"] = GetMessage("MF_OK_MESSAGE");
				} else {
					$arResult["ERROR_MESSAGE"][] = "Ошибка добавления данных";
				}
			}

			if (!empty($arParams["EVENT_MESSAGE_ID"])) {
				foreach ($arParams["EVENT_MESSAGE_ID"] as $v)
					if (intval($v) > 0)
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", intval($v));
			} else {
				CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);
			}

			$_SESSION["MF_NAME"] = htmlspecialcharsbx($userName);
			$_SESSION["MF_EMAIL"] = htmlspecialcharsbx($userEmail);

			LocalRedirect($APPLICATION->GetCurPageParam("success=" . $arResult["PARAMS_HASH"], array("success")));
		}

		$arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
		$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
		$arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
	} else {
		$arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
	}
}

if (empty($arResult["ERROR_MESSAGE"])) {
	if ($USER->IsAuthorized()) {
		$arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
	} else {
		if ($_SESSION["MF_NAME"] <> '')
			$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
		if ($_SESSION["MF_EMAIL"] <> '')
			$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
	}
}

if ($arParams["USE_CAPTCHA"] == "Y")
	$arResult["capCode"] = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$this->IncludeComponentTemplate();
