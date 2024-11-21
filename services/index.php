<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Услуги");
?>
<?
$APPLICATION->IncludeComponent(
    "bitrix:catalog",
    ".default",
    [
        "IBLOCK_TYPE" => "products",
        "IBLOCK_ID" => "3",
        "BASKET_URL" => "",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/services/",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "DISPLAY_PANEL" => "N",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "Y",
        "USE_FILTER" => "N",
        "USE_COMPARE" => "N",
        "PRICE_CODE" => [
        ],
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRICE_VAT_SHOW_VALUE" => "N",
        "SHOW_TOP_ELEMENTS" => "N",
        "PAGE_ELEMENT_COUNT" => "30",
        "LINE_ELEMENT_COUNT" => "1",
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_ORDER" => "asc",
        "LIST_PROPERTY_CODE" => [
            0 => "",
            1 => "",
        ],
        "INCLUDE_SUBSECTIONS" => "Y",
        "LIST_META_KEYWORDS" => "-",
        "LIST_META_DESCRIPTION" => "-",
        "LIST_BROWSER_TITLE" => "-",
        "DETAIL_PROPERTY_CODE" => [
            0 => "",
            1 => "",
        ],
        "DETAIL_META_KEYWORDS" => "-",
        "DETAIL_META_DESCRIPTION" => "-",
        "DETAIL_BROWSER_TITLE" => "NAME",
        "DETAIL_SHOW_PICTURE" => "N",
        "LINK_IBLOCK_TYPE" => "",
        "LINK_IBLOCK_ID" => "",
        "LINK_PROPERTY_SID" => "",
        "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Услуги",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
        "PAGER_SHOW_ALL" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "SEF_URL_TEMPLATES" => [
            "sections" => "",
            "section" => "",
            "element" => "#ELEMENT_ID#/",
            "compare" => "compare.php?action=#ACTION_CODE#",
        ],
        "VARIABLE_ALIASES" => [
            "compare" => [
                "ACTION_CODE" => "action",
            ],
        ],
    ],
    false
); ?><?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>