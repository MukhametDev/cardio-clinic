<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

</main>

<footer class="footer">
    <div class="container">
        <div class="footer__wrapper">
            <div class="footer__top">
                <div class="footer__logo logo">
                    <a class="logo__link" href="<?=$APPLICATION->GetCurPage() === "/" ? "#" : "/"?>">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo--footer.svg" alt="<?= Loc::getMessage('FOOTER_LOGO_ALT'); ?>">
                    </a>
                </div>
                <div class="footer__group">
                    <ul class="info-list">
                        <li class="info-list__item info-list__item--phone">
                            <div class="info-list__item-text">
                                <a class="info-list__item-link" href="tel:+73452562727">
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        [
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH . "/includes/footer_phone-one.html"
                                        ]
                                    ); ?>
                                </a>
                            </div>
                        </li>
                        <li class="info-list__item info-list__item--phone">
                            <div class="info-list__item-text">
                                <a class="info-list__item-link" href="tel:+73452608628">
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        [
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH . "/includes/footer_phone-two.html"
                                        ]
                                    ); ?>
                                </a>
                            </div>
                        </li>
                        <li class="info-list__item info-list__item--email">
                            <div class="info-list__item-text">
                                <a class="info-list__item-link"
                                   href="mailto:info@1cardioclinic.ru">
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        [
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH . "/includes/footer_email.html"
                                        ]
                                    ); ?>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <nav class="footer-nav">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom_menu",
                        [
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "subtop",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "2",
                            "MENU_CACHE_GET_VARS" => [
                                0 => "",
                            ],
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "Y",
                        ],
                        false
                    ); ?>
                </nav>
            </div>
            <div class="footer__watermark">
                <div class="footer__watermark-copyright">© <? echo date('Y'); ?> <?= Loc::getMessage('FOOTER_COPYRIGHT'); ?></div>
                <a class="footer__watermark-dev-link" href="javascript:;">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/dev-logo.svg" alt="Наш надежный digital-партнер: SunWeb">
                </a>
            </div>
        </div>
    </div>
</footer>

<dialog class="modal modal--top-images" id="consultation">
    <div class="container">
        <div class="modal__content modal__search">
            <div class="modal__close">
                <div class="modal_close close nav_toggler active">
                    <div class="close__wrapper">
                    </div>
                </div>
            </div>
            <div class="modal__content-img-box">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_TEMPLATE_PATH . "/includes/popup_image.html"
                    ]
                ); ?>
            </div>
            <div class="modal__content-wrapper">
                <div class="modal__content-text">
                    <p>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_TEMPLATE_PATH . "/includes/popup_text.html"
                            ]
                        ); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</dialog>
</div>
</body>

</html>