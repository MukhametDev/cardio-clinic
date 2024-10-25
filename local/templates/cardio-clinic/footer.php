<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<footer class="footer">
    <div class="container">
        <div class="footer__wrapper">
            <div class="footer__top">
                <div class="footer__logo logo">
                    <a class="logo__link" href="/">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/images/logo--footer.svg" alt="<?= Loc::getMessage('FOOTER_LOGO_ALT'); ?>">
                    </a>
                </div>
                <div class="footer__group">
                    <ul class="info-list">
                        <li class="info-list__item info-list__item--phone">
                            <div class="info-list__item-text">
                                <a class="info-list__item-link" href="tel:+73452562727">
                                    <?= Loc::getMessage('FOOTER_PHONE_ONE'); ?>
                                </a>
                            </div>
                        </li>
                        <li class="info-list__item info-list__item--phone">
                            <div class="info-list__item-text">
                                <a class="info-list__item-link" href="tel:+73452608628">
                                    <?= Loc::getMessage('FOOTER_PHONE_TWO'); ?>
                                </a>
                            </div>
                        </li>
                        <li class="info-list__item info-list__item--email">
                            <div class="info-list__item-text">
                                <a class="info-list__item-link" href="mailto:info@1cardioclinic.ru">
                                    <?= Loc::getMessage('FOOTER_EMAIL'); ?>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <nav class="footer-nav">
                    <? $APPLICATION->IncludeComponent(
                        "mukhamet:menu",
                        "bottom_menu",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "subtop",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "2",
                            "MENU_CACHE_GET_VARS" => array(
                                0 => "",
                            ),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "Y",
                        ),
                        false
                    ); ?>
                </nav>
            </div>
            <div class="footer__watermark">
                <div class="footer__watermark-copyright">© <?= date('Y'); ?> <?= Loc::getMessage('FOOTER_COPYRIGHT'); ?></div>
            </div>
        </div>
    </div>
</footer>
