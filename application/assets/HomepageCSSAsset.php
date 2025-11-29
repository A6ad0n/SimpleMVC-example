<?php

namespace application\assets;
use ItForFree\SimpleAsset\SimpleAsset;

/* 
 * Класс ассетов для CSS стилей. Пользовательский
 * 
 */

class HomepageCSSAsset extends SimpleAsset {
    
    public $basePath = '/';
    
    public $css = [
        'assets/output.css'
    ];
    
}

