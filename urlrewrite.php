<?php

$arUrlRewrite = [
    3 =>
        [
            'CONDITION' => '#^/specialists/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/specialists/index.php',
            'SORT' => 100,
        ],
    4 =>
        [
            'CONDITION' => '#^/articles/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/articles/index.php',
            'SORT' => 100,
        ],
    0 =>
        [
            'CONDITION' => '#^/services/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog',
            'PATH' => '/services/index.php',
            'SORT' => 300,
        ],
    1 =>
        [
            'CONDITION' => '#^/products/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog',
            'PATH' => '/products/index.php',
            'SORT' => 400,
        ],
    2 =>
        [
            'CONDITION' => '#^/news/#',
            'RULE' => '',
            'ID' => 'bitrix:news',
            'PATH' => '/news/index.php',
            'SORT' => 500,
        ],
];
