<?php

/* 
 * Класс ассет для ДжаваСкрипт пользовательский
 */

namespace application\assets;
use ItForFree\SimpleAsset\SimpleAsset;
use application\assets\JqueryAsset;

class AjaxJavascriptAsset extends SimpleAsset {
    
    public $basePath = '/';
    
    public $js = [
        'JS/ShowContent.js',
        'JS/NewContent.js',
        'JS/loaderIdentity.js'
    ];
    
    
    public $needs = [
        JqueryAsset::class];

}
