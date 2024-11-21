<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$site = ($_REQUEST["site"] <> '' ? $_REQUEST["site"] : ($_REQUEST["src_site"] <> '' ? $_REQUEST["src_site"] : false));
$arFilter = ["TYPE_ID" => "FEEDBACK_FORM", "ACTIVE" => "Y"];
if ($site !== false) {
    $arFilter["LID"] = $site;
}

$arEvent = [];
$dbType = CEventMessage::GetList("id", "desc", $arFilter);
while ($arType = $dbType->GetNext()) {
    $arEvent[$arType["ID"]] = "[" . $arType["ID"] . "] " . $arType["SUBJECT"];
}

$arComponentParameters = [
    "PARAMETERS" => [
        "USE_CAPTCHA" => [
            "NAME" => GetMessage("MFP_CAPTCHA"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "BASE",
        ],
        "OK_TEXT" => [
            "NAME" => GetMessage("MFP_OK_MESSAGE"),
            "TYPE" => "STRING",
            "DEFAULT" => GetMessage("MFP_OK_TEXT"),
            "PARENT" => "BASE",
        ],
        "EMAIL_TO" => [
            "NAME" => GetMessage("MFP_EMAIL_TO"),
            "TYPE" => "STRING",
            "DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")),
            "PARENT" => "BASE",
        ],
        "REQUIRED_FIELDS" => [
            "NAME" => GetMessage("MFP_REQUIRED_FIELDS"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => [
                "NONE" => GetMessage("MFP_ALL_REQ"),
                "NAME" => GetMessage("MFP_NAME"),
                "EMAIL" => "E-mail",
                "MESSAGE" => GetMessage("MFP_MESSAGE"),
            ],
            "DEFAULT" => "",
            "COLS" => 25,
            "PARENT" => "BASE",
        ],

        "EVENT_MESSAGE_ID" => [
            "NAME" => GetMessage("MFP_EMAIL_TEMPLATES"),
            "TYPE" => "LIST",
            "VALUES" => $arEvent,
            "DEFAULT" => "",
            "MULTIPLE" => "Y",
            "COLS" => 25,
            "PARENT" => "BASE",
        ],

    ],
];


?>