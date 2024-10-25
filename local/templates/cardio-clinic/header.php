<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$asset = Asset::getInstance();
$asset->addCss(SITE_TEMPLATE_PATH . '/assets/css/style.css');
$asset->addJs(SITE_TEMPLATE_PATH . '/js/main.js');
$asset->addString("<meta name='viewport' content='width=device-width, initial-scale=1.0'>");
$asset->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge">');
?>
<!DOCTYPE html>
<html lang='ru'>

<head>
    <link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/images/favicon.svg" type="image/svg+xml">
    <title><?php $APPLICATION->ShowTitle() ?></title>
    <?php $APPLICATION->ShowHead(); ?>
</head>

<body>
<?php $APPLICATION->ShowPanel(); ?>
<div class='page'>
    <header class='header header--fixed'>
        <div class='container'>
            <div class='header__bottom'>
                <div class='header__logo logo'>
                    <a class='logo__link' href='/'>
                        <img src='<?= SITE_TEMPLATE_PATH ?>/images/logo.gif' alt='<?= Loc::getMessage('LOGO_ALT'); ?>'>
                    </a>
                </div>

                <div class='header__group-btn'>
                    <div class='header__exclamation modal__btn' data-target='<?= Loc::getMessage('DATA_ATTR') ?>' title='<?= Loc::getMessage('ATTR_TITLE'); ?>'>
                        <div class='header__exclamation-icon'>
                            <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                <path d='M12 9V12.75M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM12 15.75H12.0075V15.7575H12V15.75Z' stroke='#8D8D8D' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' />
                            </svg>
                        </div>
                        <div class='header__exclamation-text'><?= Loc::getMessage('CONSULTATION'); ?></div>
                    </div>
                    <button class='header__btn btn__primary menu nav-menu__toggler' title='<?= Loc::getMessage('ATTR_TITLE_MENU'); ?>'>
                        <div class='menu__wrapper'>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class='header__btn-text'><?= Loc::getMessage('MENU'); ?></div>
                    </button>
                </div>

                <nav class='header__nav nav'>
                    <div class='container'>
                        <div class='header__nav-wrapper'>
                            <div class='header__nav-top-content'></div>
                            <?php
                            $APPLICATION->IncludeComponent(
                                'mukhamet:menu',
                                'top_menu',
                                array(
                                    'ALLOW_MULTI_SELECT' => 'N',    // Разрешить несколько активных пунктов одновременно
                                    'CHILD_MENU_TYPE' => 'subtop',    // Тип меню для остальных уровней
                                    'DELAY' => 'N',    // Откладывать выполнение шаблона меню
                                    'MAX_LEVEL' => '2',    // Уровень вложенности меню
                                    'MENU_CACHE_GET_VARS' => array(    // Значимые переменные запроса
                                        0 => '',
                                    ),
                                    'MENU_CACHE_TIME' => '3600',    // Время кеширования (сек.)
                                    'MENU_CACHE_TYPE' => 'N',    // Тип кеширования
                                    'MENU_CACHE_USE_GROUPS' => 'N',    // Учитывать права доступа
                                    'ROOT_MENU_TYPE' => 'top',    // Тип меню для первого уровня
                                    'USE_EXT' => 'Y',    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                                ),
                                false
                            );
                            ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main class='main'>
