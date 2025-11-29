<?php
/**
 * Конфигурационной файл приложения
 */
$config = [
    'core' => [ // подмассив используемый самим ядром фреймворка
        'router' => [ // подсистема маршрутизация
            'class' => \ItForFree\SimpleMVC\Router\WebRouter::class,
	    'alias' => '@router'
        ],
        'mvc' => [ // настройки MVC
            'views' => [
                'base-template-path' => '../application/views/',
                'base-layouts-path' => '../application/views/layouts/',
                'footer-path' => '',
                'header-path' => ''
            ]
        ],
        'handlers' => [ // подсистема перехвата исключений
            'ItForFree\SimpleMVC\Exceptions\SmvcAccessException' 
		=> \application\handlers\UserExceptionHandler::class,
            'ItForFree\SimpleMVC\Exceptions\SmvcRoutingException' 
		=> \application\handlers\UserExceptionHandler::class,
            'PDOException' 
        => \application\handlers\PDOExceptionHandler::class,
        ],
        'user' => [ // подсистема авторизации
            'class' => \application\models\AuthUser::class,
	    'construct' => [
                'session' => '@session',
                'router' => '@router'
             ], 
        ],
        'session' => [ // подсистема работы с сессиями
            'class' => ItForFree\SimpleMVC\Session::class,
            'alias' => '@session'
        ],
        'note' => [
            'class' => \application\models\Note::class,
	    'alias' => '@note'
        ],
        'subcategory' => [
            'class' => \application\models\Subcategory::class,
	    'alias' => '@subcategory'
        ],
        'category' => [
            'class' => \application\models\Category::class,
	    'alias' => '@category'
        ],
    ]    
];

return $config;