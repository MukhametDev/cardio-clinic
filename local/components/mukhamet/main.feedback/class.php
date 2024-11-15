<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Engine\CurrentUser;

class FeedbackFormComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$GLOBALS['USER']->IsAuthorized()) ? "Y" : "N");
        $arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"] ?? 'FEEDBACK_FORM');
        $arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"] ?? Option::get("main", "email_from"));
        $arParams["OK_TEXT"] = trim($arParams["OK_TEXT"] ?? Loc::getMessage("MF_OK_MESSAGE"));

        return $arParams;
    }

    public function executeComponent(): void
    {
        $this->arResult["PARAMS_HASH"] = md5(serialize($this->arParams) . $this->GetTemplateName());

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["submit"]) && (!isset($_POST["PARAMS_HASH"]) || $this->arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"])) {
            $this->arResult["ERROR_MESSAGE"] = [];

            if (check_bitrix_sessid()) {
                $this->checkFormFields();

                if (empty($this->arResult["ERROR_MESSAGE"])) {
                    $this->workingForm();
                }

                $this->setFormValues();
            } else {
                $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("MF_SESS_EXP");
            }
        }

        $this->initFields();
        $this->includeComponentTemplate();
    }

    private function checkFormFields(): void
    {
        if (empty($this->arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $this->arParams["REQUIRED_FIELDS"])) {
            if ((empty($this->arParams["REQUIRED_FIELDS"]) || in_array("NAME", $this->arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_name"]) <= 1) {
                $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("MF_REQ_NAME");
            }
            if ((empty($this->arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $this->arParams["REQUIRED_FIELDS"])) && empty($_POST["user_phone"])) {
                $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("MF_REQ_PHONE");
            }
            if ((empty($this->arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $this->arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_email"]) <= 1) {
                $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("MF_REQ_EMAIL");
            }
            if ((empty($this->arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $this->arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["MESSAGE"]) <= 3) {
                $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("MF_REQ_MESSAGE");
            }
        }
        if (mb_strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"])) {
            $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("MF_EMAIL_NOT_VALID");
        }
    }

    private function sendFieldsForm(array $arFields): void
    {
        if (!empty($this->arParams["EVENT_MESSAGE_ID"])) {
            foreach ($this->arParams["EVENT_MESSAGE_ID"] as $v) {
                if (intval($v) > 0) {
                    Event::send([
                        "EVENT_NAME" => $this->arParams["EVENT_NAME"],
                        "LID" => SITE_ID,
                        "C_FIELDS" => $arFields,
                        "N",
                        "MESSAGE_ID" => intval($v),
                    ]);
                }
            }
        } else {
            Event::send([
                "EVENT_NAME" => $this->arParams["EVENT_NAME"],
                "LID" => SITE_ID,
                "C_FIELDS" => $arFields,
            ]);
        }
    }

    private function workingForm(): void
    {
        global $APPLICATION;


        $userName = htmlspecialchars($_POST["user_name"]);
        $userEmail = htmlspecialchars($_POST["user_email"]);
        $userPhone = htmlspecialchars($_POST["user_phone"]);
        $message = htmlspecialchars($_POST["MESSAGE"]);
        $feedbackType = htmlspecialchars($_POST["feedback_type"]);
        $arFields = [
            "AUTHOR" => $userName,
            "AUTHOR_EMAIL" => $userEmail,
            "PHONE" => $userPhone,
            "EMAIL_TO" => $this->arParams["EMAIL_TO"],
            "TEXT" => $message,
            "FEEDBACK_TYPE" => $feedbackType,
        ];

        if (Loader::includeModule('iblock')) {
            $IBLOCK_ID = $this->arParams["IBLOCK_ID"];
            $el = new CIBlockElement;
            $arLoadProductArray = [
                "IBLOCK_ID" => $IBLOCK_ID,
                "NAME" => $userName,
                "ACTIVE" => "Y",
                "PREVIEW_TEXT" => $message,
                "PROPERTY_VALUES" => [
                    "USER_PHONE" => $userPhone,
                    "TYPE_FEEDBACK" => $feedbackType,
                ],
            ];

            if ($el->Add($arLoadProductArray)) {
                $this->arResult["OK_MESSAGE"] = Loc::getMessage("MF_OK_MESSAGE");
            } else {
                $this->arResult["ERROR_MESSAGE"][] = "Ошибка добавления данных";
            }
        }

        $this->sendFieldsForm($arFields);
        $this->storeSessionData($userName, $userEmail);
        LocalRedirect($APPLICATION->getCurPageParam("success=" . $this->arResult["PARAMS_HASH"], ["success"]));
    }

    private function storeSessionData(string $userName, string $userEmail): void
    {
        $_SESSION["MF_NAME"] = htmlspecialcharsbx($userName);
        $_SESSION["MF_EMAIL"] = htmlspecialcharsbx($userEmail);
    }

    private function setFormValues(): void
    {
        $this->arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
        $this->arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
        $this->arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
        $this->arResult["AUTHOR_PHONE"] = htmlspecialcharsbx($_POST["user_phone"]);
    }

    private function initFields(): void
    {
        if (empty($this->arResult["ERROR_MESSAGE"])) {
            if ($GLOBALS['USER']->IsAuthorized()) {
                $this->arResult["AUTHOR_NAME"] = CurrentUser::get()->getFormattedName(false);
                $this->arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx(CurrentUser::get()->getEmail());
            } else {
                if ($_SESSION["MF_NAME"] !== '') {
                    $this->arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
                }
                if ($_SESSION["MF_EMAIL"] !== '') {
                    $this->arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
                }
            }
        }
    }
}
